<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!-- add_course.php -->
<?php
// 引入資料庫連線檔案
require_once("../db_connect.php");

// 檢查是否有 POST 請求
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 取得表單資料
    $name = $_POST['name'];
    $info = $_POST['info'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $status = 1;
    $is_visible = 1;

    // 處理圖片上傳
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $image_name = time() . '_' . $image['name'];
        $image_tmp = $image['tmp_name'];
        $image_path = "../course_images/teacher/" . $image_name;

        // 移動上傳的圖片到指定路徑
        if (move_uploaded_file($image_tmp, $image_path)) {
            // 插入講師資料
            $sql = "INSERT INTO teacher (name, info, email, phone, is_visible) VALUES (?, ?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssssi", $name, $info, $email, $phone, $is_visible);

                if ($stmt->execute()) {
                    // 取得剛插入的講師 ID
                    $teacher_id = $conn->insert_id;

                    // 插入圖片資料
                    $sql_image = "INSERT INTO course_image (name) VALUES (?)";
                    if ($stmt_image = $conn->prepare($sql_image)) {
                        $stmt_image->bind_param("s", $image_name);

                        if ($stmt_image->execute()) {
                            // 取得剛插入的圖片 ID
                            $image_id = $conn->insert_id;

                            // 更新講師資料表，關聯圖片
                            $sql_update = "UPDATE teacher SET course_image_id = ? WHERE id = ?";
                            if ($stmt_update = $conn->prepare($sql_update)) {
                                $stmt_update->bind_param("ii", $image_id, $teacher_id);
                                if ($stmt_update->execute()) {
                                    header("Location: teacher.php?message=success");
                                    exit();
                                } else {
                                    echo "<script>alert('更新圖片關聯失敗！');</script>";
                                }
                            } else {
                                echo "<script>alert('準備更新圖片關聯失敗！');</script>";
                            }
                        } else {
                            echo "<script>alert('插入圖片資料失敗！');</script>";
                        }
                    } else {
                        echo "<script>alert('準備插入圖片資料失敗！');</script>";
                    }
                } else {
                    echo "<script>alert('新增講師資料失敗！');</script>";
                }

                // 關閉 statement
                $stmt->close();
            } else {
                echo "<script>alert('準備插入講師資料失敗！');</script>";
            }
        } else {
            echo "<script>alert('圖片上傳失敗！');</script>";
        }
    } else {
        echo "<script>alert('未選擇圖片或圖片上傳錯誤！');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link
        rel="apple-touch-icon"
        sizes="76x76"
        href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <title>新增師資</title>
    <!--     Fonts and icons     -->
    <link
        rel="stylesheet"
        type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script
        src="https://kit.fontawesome.com/42d5adcbca.js"
        crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link
        id="pagestyle"
        href="../assets/css/material-dashboard.css"
        rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="teacher.css">
</head>

<body class="g-sidenav-show bg-gray-100">
    <!-- 側邊欄 -->
    <?php $page = 'teacher'; ?>
    <?php include 'sidebar.php'; ?>
    <!-- 側邊欄 -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <?php
        // 設定麵包屑的層級
        $breadcrumbs = [
            'teacher' => '師資管理',
            'teacher_list' => '師資列表',
            'teacher_add' => '新增講師',
        ];

        $page = 'teacher_add';

        // 設定麵包屑的連結
        $breadcrumbLinks = [
            'teacher' => 'teacher.php',           // 第一層的連結
            'teacher_list' => 'teacher.php',      // 第二層的連結
            'teacher_add' => 'teacher_add.php',   // 第三層的連結
        ];

        include 'navbar.php';
        ?>


        <div class="container mt-4">
            <!-- <h2>新增課程</h2> -->

            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="teacher_add.php" method="POST" enctype="multipart/form-data">
                <div class="form-container">
                    <!-- 左邊預覽區 -->
                    <div class="form-column">
                        <h4>圖片預覽</h4>
                        <img id="image-preview" class="preview-img" src="" alt="" />
                    </div>

                    <!-- 右邊表單區 -->
                    <div class="form-column">
                        <div class="mb-3">
                            <label for="name" class="form-label">講師姓名</label>
                            <input type="text" class="form-control px-2" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">信箱</label>
                            <input type="text" class="form-control px-2" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">電話</label>
                            <input type="text" class="form-control px-2" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="info" class="form-label">講師簡介</label>
                            <textarea class="form-control px-2" id="info" name="info" rows="7" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="custom-form-label">講師照片</label>
                            <input type="file" class="custom-form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                        </div>

                        <button type="submit" class="btn btn-secondary mt-2">提交</button>
                        <a href="teacher.php" class="btn btn-outline-secondary mt-2">取消</a>
                    </div>
                </div>
            </form>
        </div>

        <script>
            function previewImage(event) {
                const reader = new FileReader();
                reader.onload = function() {
                    const output = document.getElementById('image-preview');
                    output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>

        </div>




        <!--   Core JS Files   -->
        <script src="../assets/js/core/popper.min.js"></script>
        <script src="../assets/js/core/bootstrap.min.js"></script>
        <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
        <script>
            var win = navigator.platform.indexOf("Win") > -1;
            if (win && document.querySelector("#sidenav-scrollbar")) {
                var options = {
                    damping: "0.5",
                };
                Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>
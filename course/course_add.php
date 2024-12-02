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


// 處理新增課程的邏輯
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 取得表單資料
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $apply_start = $_POST['apply_start'];
    $apply_end = $_POST['apply_end'];
    $course_start = $_POST['course_start'];
    $course_end = $_POST['course_end'];
    $description = $_POST['description']; // 新增簡介
    $is_primary = isset($_POST['is_primary']) ? 1 : 0;
    $status = 1;
    $is_visible = 1;
    $teacher_name = $_POST['teacher_name'];
    $teacher_id = $_POST['teacher_id'];

    // 如果沒有選擇講師 ID，且有輸入講師名稱，則插入新的講師資料
    if (empty($teacher_id) && !empty($teacher_name)) {
        $sql_teacher = "INSERT INTO teacher (name) VALUES (?)";
        $stmt_teacher = $conn->prepare($sql_teacher);
        $stmt_teacher->bind_param("s", $teacher_name);
        if ($stmt_teacher->execute()) {
            $teacher_id = $stmt_teacher->insert_id;
        } else {
            echo "Error: " . $stmt_teacher->error;
            exit();
        }
    }

    // 處理圖片上傳
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];
        if ($image['error'] == 0) {
            $image_name = time() . '_' . $image['name'];
            $image_tmp = $image['tmp_name'];
            $image_path = "../course_images/course_cover/" . $image_name;
            if (move_uploaded_file($image_tmp, $image_path)) {
                // 插入課程資料
                $sql = "INSERT INTO course (title, category_id, price, teacher_id, apply_start, apply_end, course_start, course_end, is_visible, status, description) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("siissssiiis", $title, $category_id, $price, $teacher_id, $apply_start, $apply_end, $course_start, $course_end, $is_visible, $status, $description);

                if ($stmt->execute()) {
                    // 插入圖片資料
                    $course_id = $stmt->insert_id;
                    $sql_image = "INSERT INTO course_image (course_id, name, is_primary) VALUES (?, ?, ?)";
                    $stmt_image = $conn->prepare($sql_image);
                    $stmt_image->bind_param("isi", $course_id, $image_name, $is_primary);

                    if ($stmt_image->execute()) {
                        $image_id = $stmt_image->insert_id;
                        $sql_update = "UPDATE course SET course_image_id = ? WHERE id = ?";
                        $stmt_update = $conn->prepare($sql_update);
                        $stmt_update->bind_param("ii", $image_id, $course_id);
                        $stmt_update->execute();

                        header("Location: course_info.php?id=$course_id&message=更新成功");
                        exit();
                        exit();
                    } else {
                        $error = "圖片儲存失敗！";
                    }
                } else {
                    $error = "新增課程失敗！";
                }
            } else {
                $error = "圖片上傳失敗！";
            }
        } else {
            $error = "請選擇有效的圖片檔案。";
        }
    } else {
        $error = "請上傳圖片。";
    }
}

// 獲取分類列表
$sql = "SELECT * FROM course_category";
$result = $conn->query($sql);
$categories = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
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
    <title>新增課程</title>
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
    <link rel="stylesheet" href="course.css">
</head>

<body class="g-sidenav-show bg-gray-100">
    <!-- 側邊欄 -->
    <?php $page = 'course'; ?>
    <?php include '../sidebar.php'; ?>
    <!-- 側邊欄 -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <?php
        $breadcrumbs = [
            'users' => '首頁',
            'course' => '課程管理',
            'course_add' => '新增課程',
        ];

        $page = 'course_add';

        $breadcrumbLinks = [
            'users' => '../users/users.php',
            'course' => 'course.php',
            'course_add' => 'course_add.php',
        ];

        include '../navbar.php';
        ?>

        <!-- Navbar -->


        <div class="container mt-4">
            <!-- <h2>新增課程</h2> -->

            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="course_add.php" method="POST" enctype="multipart/form-data">
                <div class="form-container">
                    <!-- 左邊預覽區 -->
                    <div class="form-column">
                        <h4>圖片預覽</h4>
                        <img id="image-preview" class="preview-img" src="#" alt="" />
                    </div>

                    <!-- 右邊表單區 -->
                    <div class="form-column">
                        <div class="mb-3">
                            <label for="title" class="form-label">課程名稱</label>
                            <input type="text" class="form-control px-2" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">分類</label>
                            <select class="form-control px-2" id="category_id" name="category_id" required>
                                <option value="" selected disabled>請選擇分類</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">價格</label>
                            <input type="number" class="form-control px-2" id="price" name="price" required>
                        </div>
                        <div class="mb-2">
                            <label for="teacher_id" class="form-label">講師</label>
                            <select class="form-control px-2" id="teacher_id" name="teacher_id" required>
                                <option value="" disabled selected>請選擇講師</option>
                                <?php
                                // 從資料庫取得所有講師
                                $sql_teachers = "SELECT * FROM teacher";
                                $result_teachers = $conn->query($sql_teachers);
                                if ($result_teachers->num_rows > 0) {
                                    while ($teacher = $result_teachers->fetch_assoc()) {
                                        echo "<option value='" . $teacher['id'] . "'>" . $teacher['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="row">
                            <!-- 報名開始時間 -->
                            <div class="col-md-6 mb-3">
                                <label for="apply_start" class="form-label">報名開始時間</label>
                                <input type="datetime-local" class="form-control px-2" id="apply_start" name="apply_start" required>
                            </div>

                            <!-- 報名結束時間 -->
                            <div class="col-md-6 mb-3">
                                <label for="apply_end" class="form-label">報名結束時間</label>
                                <input type="datetime-local" class="form-control px-2" id="apply_end" name="apply_end" required>
                            </div>
                        </div>

                        <div class="row">
                            <!-- 課程開始時間 -->
                            <div class="col-md-6 mb-3">
                                <label for="course_start" class="form-label">課程開始時間</label>
                                <input type="datetime-local" class="form-control px-2" id="course_start" name="course_start" required>
                            </div>

                            <!-- 課程結束時間 -->
                            <div class="col-md-6 mb-3">
                                <label for="course_end" class="form-label">課程結束時間</label>
                                <input type="datetime-local" class="form-control px-2" id="course_end" name="course_end" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">課程簡介</label>
                            <textarea class="form-control px-2" id="description" name="description" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="custom-form-label">課程圖片</label>
                            <input type="file" class="custom-form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                        </div>


                        <!-- <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_primary" name="is_primary">
                        <label class="form-check-label" for="is_primary">設為主圖</label>
                    </div> -->

                        <button type="submit" class="btn btn-secondary mt-2">提交</button>
                        <a href="course.php" class="btn btn-outline-secondary mt-2">取消</a>
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
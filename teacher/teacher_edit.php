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
require_once("../db_connect.php");

$title = "編輯講師";

// 驗證是否有傳入 ID
if (!isset($_GET['id'])) {
    die("未指定講師 ID");
}

$teacher_id = $_GET['id'];

// 查詢講師資料
$sql = "SELECT teacher.*, course_image.name AS image_name
        FROM teacher
        LEFT JOIN course_image ON teacher.course_image_id = course_image.id
        WHERE teacher.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("講師不存在");
}

$teacher = $result->fetch_assoc();

// 處理更新邏輯
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $info = $_POST['info'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // 更新圖片
    if ($_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $image_name = time() . '_' . $image['name'];
        $image_tmp = $image['tmp_name'];
        $image_path = "../course_images/teacher/" . $image_name;

        if (move_uploaded_file($image_tmp, $image_path)) {
            $sql_update_image = "UPDATE course_image SET name = ? WHERE id = ?";
            $stmt_image = $conn->prepare($sql_update_image);
            $stmt_image->bind_param("si", $image_name, $teacher['course_image_id']);
            $stmt_image->execute();
        }
    }


    $sql_update = "UPDATE teacher 
                   SET name = ?, info = ?, email = ?, phone = ?
                   WHERE id = ?";


    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssi", $name, $info, $email, $phone, $teacher_id);

    if ($stmt_update->execute()) {
        header("Location: teacher.php?message=更新成功");
        exit();
    } else {
        echo "更新失敗: " . $conn->error;
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
    <title>編輯講師資訊</title>
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
        <?php $page = 'teacher'; ?>
        <?php $page = 'teacher'; ?>
        <?php
        // 設定麵包屑的層級
        $breadcrumbs = [
            'teacher' => '師資管理',
            'teacher_list' => '師資列表',
            'teacher_edit' => '編輯講師資訊',
        ];

        //當前頁面
        $page = 'teacher_edit';

        // 設定麵包屑的連結
        $breadcrumbLinks = [
            'teacher' => 'teacher.php',
            'teacher_list' => 'teacher.php',
            'teacher_edit' => 'teacher_edit.php',
        ];

        include 'navbar.php';
        ?>
        <!-- Navbar -->

        <div class="container mt-5" style="margin-left: auto">
            <h1 class="mb-4">編輯師資</h1>
            <form action="teacher_edit.php?id=<?php echo $teacher_id; ?>" method="POST" enctype="multipart/form-data">
                <div class="row">

                    <div class="form-container">
                        <!-- 圖片預覽區 -->
                        <div class="form-column">
                            <h4>圖片預覽</h4>
                            <img id="image-preview" class="preview-img" src="../course_images/teacher/<?php echo $teacher['image_name']; ?>" alt="目前圖片">
                            <div class="mb-3">
                                <label for="image" class="custom-form-label mt-3">更換圖片</label>
                                <input type="file" class="custom-form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                            </div>
                        </div>

                        <!-- 課程資料表單 -->
                        <div class="form-column">
                            <div class="mb-3">
                                <label for="name" class="form-label mt-5">講師姓名</label>
                                <input type="text" class="form-control px-2" id="name" name="name" value="<?php echo htmlspecialchars($teacher['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">信箱</label>
                                <input type="text" class="form-control px-2" id="email" name="email" value="<?php echo htmlspecialchars($teacher['email']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">電話</label>
                                <input type="text" class="form-control px-2" id="phone" name="phone" value="<?php echo htmlspecialchars($teacher['phone']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="info" class="form-label">講師簡介</label>
                                <textarea class="form-control px-2" id="info" name="info" rows="7" required><?php echo htmlspecialchars($teacher['info']); ?></textarea>
                            </div>


                            <button type="submit" class="btn btn-secondary">儲存變更</button>
                            <a href="teacher.php" class="btn btn-outline-secondary">取消</a>
                        </div>
                    </div>

                </div>
            </form>
        </div>

        <script>
            function previewImage(event) {
                const reader = new FileReader();
                reader.onload = function() {
                    document.getElementById('image-preview').src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>

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
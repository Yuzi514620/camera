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
// 引入資料庫連線
require_once("../db_connect.php");

$title = "講師資訊";

// 檢查是否有傳入 course_id
if (!isset($_GET['id'])) {
    echo "未指定講師！";
    exit;
}

$teacher_id = intval($_GET['id']);

// 查詢課程詳細資料
$sql = "SELECT 
            teacher.*, 
            course_image.name AS image_name,
            teacher.name AS teacher_name
        FROM teacher
        LEFT JOIN course_image ON teacher.course_image_id = course_image.id
        WHERE teacher.id = ? AND teacher.is_visible = 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "找不到講師！";
    exit;
}

$teacher = $result->fetch_assoc();
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
    <title>講師資訊</title>
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
        <?php
        // 設定麵包屑的層級
        $breadcrumbs = [
            'teacher' => '師資管理',
            'teacher_list' => '師資列表',
            'teacher_info' => '講師資訊',
        ];

        //當前頁面
        $page = 'teacher_info';

        $pageTitle = isset($breadcrumbs[$page]) ? $breadcrumbs[$page] : '';
        $list = isset($breadcrumbs['teacher_list']) ? $breadcrumbs['teacher_list'] : '';

        // 設定麵包屑的連結
        $breadcrumbLinks = [
            'teacher' => 'teacher.php',
            'teacher_list' => 'teacher.php',
            'teacher_info' => 'teacher_info.php',
        ];

        include 'navbar.php';
        ?>
        <!-- Navbar -->


        <div class="container mt-5">
            <div class="row">
                <!-- 圖片欄位 -->
                <div class="col-md-6 d-flex justify-content-center">
                    <img src="../course_images/teacher/<?php echo $teacher['image_name']; ?>" alt="講師照片" class="img-fluid teacher-info-img">
                </div>

                <!-- 文字欄位 -->
                <div class="col-md-6">
                    <h2><?php echo $teacher['name']; ?></h2>
                    <p class="mt-4"><strong>信箱：</strong> <?php echo $teacher['email']; ?></p>
                    <p><strong>電話：</strong> <?php echo $teacher['phone']; ?></p>
                    <p><?php echo nl2br($teacher['info']); ?></p>


                    <div>
                        <a href="teacher.php" class="btn btn-secondary mt-3">回到師資列表</a>
                        <a href="teacher_edit.php?id=<?php echo $teacher['id']; ?>" class="btn btn-secondary mt-3">編輯</a>
                    </div>
                </div>
            </div>
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
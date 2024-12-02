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


if (!isset($_GET['id'])) {
    die("未指定課程 ID");
}

$course_id = $_GET['id'];
$sql = "SELECT course.*, teacher.name AS teacher_name, course_image.name AS image_name, course_category.name AS category_name
        FROM course
        LEFT JOIN course_image ON course.course_image_id = course_image.id
        LEFT JOIN teacher ON course.teacher_id = teacher.id
        LEFT JOIN course_category ON course.category_id = course_category.id
        WHERE course.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("課程不存在");
}

$course = $result->fetch_assoc();

// 處理更新邏輯
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $teacher_id = $_POST['teacher_id'];
    $category_id = $_POST['category_id'];
    $apply_start = $_POST['apply_start'];
    $apply_end = $_POST['apply_end'];
    $course_start = $_POST['course_start'];
    $course_end = $_POST['course_end'];
    $description = $_POST['description'];

    // 更新圖片
    if ($_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $image_name = time() . '_' . $image['name'];
        $image_tmp = $image['tmp_name'];
        $image_path = "../course_images/course_cover/" . $image_name;

        if (move_uploaded_file($image_tmp, $image_path)) {
            $sql_update_image = "UPDATE course_image SET name = ? WHERE id = ?";
            $stmt_image = $conn->prepare($sql_update_image);
            $stmt_image->bind_param("si", $image_name, $course['course_image_id']);
            $stmt_image->execute();
        }
    }

    // 更新課程資料
    $sql_update = "UPDATE course 
    SET title = ?, price = ?, teacher_id = ?, category_id = ?, apply_start = ?, apply_end = ?, course_start = ?, course_end = ?, description = ? 
    WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("siiisssssi", $title, $price, $teacher_id, $category_id, $apply_start, $apply_end, $course_start, $course_end, $description, $course_id);

    if ($stmt_update->execute()) {
        header("Location: course_info.php?id=$course_id&message=更新成功");
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
    <title>編輯課程</title>
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
        <?php $page = 'course'; ?>
        <?php
        $breadcrumbs = [
            'users' => '首頁',
            'course' => '課程管理',
            'course_edit' => '編輯課程',
        ];

        $page = 'course_edit';

        $breadcrumbLinks = [
            'users' => '../users/users.php',
            'course' => 'course.php',
            'course_edit' => 'course_edit.php',
        ];

        include '../navbar.php';
        ?>
        <!-- Navbar -->

        <div class="container mt-5" style="margin-left: auto">
            <h1 class="mb-4">編輯課程</h1>
            <form action="course_edit.php?id=<?php echo $course_id; ?>" method="POST" enctype="multipart/form-data">
                <div class="row">

                    <div class="form-container">
                        <!-- 圖片預覽區 -->
                        <div class="form-column">
                            <h4>圖片預覽</h4>
                            <img id="image-preview" class="preview-img" src="../course_images/course_cover/<?php echo $course['image_name']; ?>" alt="目前圖片">
                            <div class="mb-3">
                                <label for="image" class="custom-form-label mt-3">更換圖片</label>
                                <input type="file" class="custom-form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                            </div>
                        </div>

                        <!-- 課程資料表單 -->
                        <div class="form-column">
                            <div class="mb-3">
                                <label for="title" class="form-label">課程名稱</label>
                                <input type="text" class="form-control px-2" id="title" name="title" value="<?php echo htmlspecialchars($course['title']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">價格</label>
                                <input type="number" class="form-control px-2" id="price" name="price" value="<?php echo htmlspecialchars($course['price']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="teacher_id" class="form-label">講師</label>
                                <select class="form-control px-2" id="teacher_id" name="teacher_id" required>
                                    <option value="<?php echo htmlspecialchars($course['teacher_id']); ?>" selected>
                                        <?php echo htmlspecialchars($course['teacher_name']); ?>
                                    </option>
                                    <?php
                                    $teacher_sql = "SELECT id, name FROM teacher";
                                    $teacher_result = $conn->query($teacher_sql);
                                    while ($teacher = $teacher_result->fetch_assoc()) {
                                        echo '<option value="' . $teacher['id'] . '">' . htmlspecialchars($teacher['name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="course_category" class="form-label">課程分類</label>
                                <select class="form-control px-2" id="course_category" name="category_id" required>
                                    <option value="">選擇分類</option>
                                    <?php

                                    $sql_categories = "SELECT id, name FROM course_category";
                                    $result_categories = $conn->query($sql_categories);


                                    while ($category = $result_categories->fetch_assoc()) {

                                        $selected = ($course['category_id'] == $category['id']) ? 'selected' : '';
                                        echo "<option value='" . $category['id'] . "' $selected>" . htmlspecialchars($category['name']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="apply_start" class="form-label">報名開始時間</label>
                                    <input type="datetime-local" class="form-control px-2" id="apply_start" name="apply_start" value="<?php echo htmlspecialchars($course['apply_start']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="apply_end" class="form-label">報名結束時間</label>
                                    <input type="datetime-local" class="form-control px-2" id="apply_end" name="apply_end" value="<?php echo htmlspecialchars($course['apply_end']); ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="course_start" class="form-label">課程開始時間</label>
                                    <input type="datetime-local" class="form-control px-2" id="course_start" name="course_start" value="<?php echo htmlspecialchars($course['course_start']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="course_end" class="form-label">課程結束時間</label>
                                    <input type="datetime-local" class="form-control px-2" id="course_end" name="course_end" value="<?php echo htmlspecialchars($course['course_end']); ?>" required>
                                </div>
                            </div>

                            <!-- 課程簡介 -->
                            <div class="mb-3">
                                <label for="description" class="form-label">課程簡介</label>
                                <textarea class="form-control px-2" id="description" name="description" rows="4" required><?php echo htmlspecialchars($course['description']); ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-secondary">儲存變更</button>
                            <a href="course.php" class="btn btn-outline-secondary">取消</a>
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
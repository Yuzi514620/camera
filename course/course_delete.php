<?php
// 引入資料庫連線檔案
require_once("../db_connect.php");

// 獲取課程 ID
$course_id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($course_id > 0) {
    // 更新該筆資料的 is_visible 欄位為 0
    $sql = "UPDATE course SET is_visible = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);

    if ($stmt->execute()) {
        // 成功更新後重定向回課程頁面
        // echo "<script>alert('資料已隱藏！'); window.location.href='course.php';</script>";
    } else {
        echo "<script>alert('更新失敗！請稍後再試。'); window.location.href='course.php';</script>";
    }
} else {
    echo "<script>alert('無效的課程 ID。'); window.location.href='course.php';</script>";
}
header("Location: course.php");
exit;

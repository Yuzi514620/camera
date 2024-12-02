<?php
// 引入資料庫連線檔案
require_once("../db_connect.php");

// 獲取講師 ID
$teacher_id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($teacher_id > 0) {
    // 更新該筆資料的 is_visible 欄位為 0
    $sql = "UPDATE teacher SET is_visible = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $teacher_id);

    if ($stmt->execute()) {
        // 更新成功，跳轉回列表頁
        header("Location: teacher.php?message=刪除成功");
        exit;
    } else {
        echo "<script>alert('更新失敗！請稍後再試。'); window.location.href='teacher.php';</script>";
    }
} else {
    echo "<script>alert('無效的講師 ID。'); window.location.href='teacher.php';</script>";
}

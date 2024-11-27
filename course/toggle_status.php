<?php
// 資料庫連線
require_once("../db_connect.php");

// 檢查是否有課程ID傳來
if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // 取得當前課程的狀態
    $sql = "SELECT status FROM course WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // 切換狀態
        $new_status = $row['status'] == 1 ? 0 : 1;
        // 更新課程的狀態
        $update_sql = "UPDATE course SET status = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $new_status, $course_id);
        $update_stmt->execute();
    }
}

// 重定向回到課程管理頁面
header("Location: course.php");
exit;

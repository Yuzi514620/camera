<?php
require_once("../db_connect.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // 測試是否成功收到ID
    echo "Received ID: " . $id . "<br>";
    
    // 使用預備語句來防止 SQL 注入
    $sql = "UPDATE camera SET is_deleted = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param('i', $id);
        
        // 測試預備語句是否綁定成功
        if ($stmt->execute()) {
            // 測試是否有行受到影響
            if ($stmt->affected_rows > 0) {
                echo "<p>刪除成功</p>";
                // 如果刪除成功，重定向回相機列表
                header("Location: camera_list.php?is_deleted=1");
                exit;
            } else {
                echo "<p>刪除失敗：沒有行被更新。請檢查ID是否有效。</p>";
            }
        } else {
            echo "<p>刪除失敗: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p>預備語句失敗: " . $conn->error . "</p>";
    }
} else {
    echo "<p>無效的請求: 沒有提供 ID</p>";
}

$conn->close();

?>
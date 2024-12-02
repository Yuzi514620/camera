<?php
require_once("../db_connect.php");  // 資料庫連接

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageId = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($imageId > 0) {
        // 查詢圖片路徑
        $sql = "SELECT image_url FROM image WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $imageId);
        $stmt->execute();
        $stmt->bind_result($imageUrl);
        $stmt->fetch();
        $stmt->close();

        if (!empty($imageUrl)) {
            // 將圖片移動到回收桶
            $uploadPath = "../album/upload/" . $imageUrl;
            $trashPath = "../album/trash/" . $imageUrl;

            if (file_exists($uploadPath)) {
                // 移動圖片到 trash 目錄
                rename($uploadPath, $trashPath);
            }

            // 刪除資料庫中的記錄
            $deleteSql = "DELETE FROM image WHERE id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $imageId);
            $deleteStmt->execute();
            $deleteStmt->close();

            echo "success";
        } else {
            echo "圖片不存在";
        }
    } else {
        echo "無效的圖片 ID";
    }
} else {
    echo "無效的請求方法";
}

$conn->close();
?>


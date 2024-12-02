<?php
require_once("db_connect.php");
$upload_dir = "../uploads/"; // 圖片上傳目錄
$image = $row['image']; // 如果沒有新圖片，保持原圖片

// 檢查是否有新圖片上傳
if (!empty($_FILES['image']['name'])) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_type = mime_content_type($_FILES['image']['tmp_name']);

    if (in_array($file_type, $allowed_types)) {
        $image_name = uniqid() . "-" . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // 刪除舊圖片（如果有）
            if (!empty($row['image']) && file_exists($upload_dir . $row['image'])) {
                unlink($upload_dir . $row['image']);
            }
            $image = $image_name; // 更新圖片名稱
        } else {
            echo "圖片上傳失敗";
        }
    } else {
        echo "不支援的圖片格式";
    }
}

// 更新資料庫
$sql = "UPDATE product 
        SET name = ?, price = ?, brand_id = ?, category_id = ?, spec = ?, stock = ?, state = ?, image = ?
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "siiissssi",
    $_POST['name'],
    $_POST['price'],
    $_POST['brand_id'],
    $_POST['category_id'],
    $_POST['spec'],
    $_POST['stock'],
    $_POST['state'],
    $image,
    $_POST['id']
);

if ($stmt->execute()) {
    echo "商品更新成功";
    header("Location: product.php");
    exit;
} else {
    echo "更新失敗：" . $stmt->error;
}


$conn->close();

<?php
require_once("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $brand_id = $_POST["brand_id"];
    $category_id = $_POST["category_id"];
    $stock = $_POST["stock"];
    $spec = $_POST["spec"];
    $state = $_POST["state"];
    $updated_at = date("Y-m-d H:i:s");

    // 舊圖片的路徑
    $upload_dir = "../album/upload/";
    $image_url = null;

    // 檢查是否有新圖片上傳
    if (!empty($_FILES["image"]["name"])) {
        // 檢查圖片格式
        $allowed_types = ["image/jpeg", "image/png", "image/gif", "image/webp"];
        $file_type = mime_content_type($_FILES["image"]["tmp_name"]);

        if (in_array($file_type, $allowed_types)) {
            // 生成新的唯一圖片名稱
            $image_name = uniqid() . "-" . basename($_FILES["image"]["name"]);
            $target_file = $upload_dir . $image_name;

            // 移動新圖片到上傳目錄
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_url = $image_name; // 更新圖片路徑

                // 更新 `image` 表中對應的記錄
                $sql_update_image = "UPDATE image SET image_url = ? WHERE name = ?";
                $stmt_image = $conn->prepare($sql_update_image);
                $stmt_image->bind_param("ss", $image_url, $name);
                if (!$stmt_image->execute()) {
                    echo "圖片更新失敗：" . $stmt_image->error;
                    exit;
                }
            } else {
                echo "圖片上傳失敗";
                exit;
            }
        } else {
            echo "圖片格式不支援";
            exit;
        }
    }

    // 更新 `product` 表中的其他欄位
    $sql_update_product = "UPDATE product 
                           SET name = ?, price = ?, brand_id = ?, category_id = ?, stock = ?, spec = ?, state = ?, updated_at = ? 
                           WHERE id = ?";
    $stmt_product = $conn->prepare($sql_update_product);
    $stmt_product->bind_param("siiissssi", $name, $price, $brand_id, $category_id, $stock, $spec, $state, $updated_at, $id);

    if ($stmt_product->execute()) {
        echo "商品更新成功";
        header("Location: product.php"); // 更新成功後跳轉
        exit;
    } else {
        echo "商品更新失敗：" . $stmt_product->error;
    }
}
?>

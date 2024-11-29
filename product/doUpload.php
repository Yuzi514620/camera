<?php
require_once("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $description = $_POST['description'];
    $name = $_POST['name'];
    $uploadDir = "../album/upload/";
    $uploadedFiles = [];

    foreach ($_FILES['myFile']['tmp_name'] as $key => $tmpName) {
        $fileName = basename($_FILES['myFile']['name'][$key]);
        $uploadPath = $uploadDir . $fileName;

        // 移動上傳檔案到指定目錄
        if (move_uploaded_file($tmpName, $uploadPath)) {
            $uploadedFiles[] = $fileName;

            // 新增資料到資料庫
            $sql = "INSERT INTO image (name, type, description, image_url, created_at) 
                    VALUES ('$name', '$type', '$description', '$fileName', NOW())";
            $conn->query($sql);
        } else {
            echo "檔案上傳失敗：$fileName<br>";
        }
    }

    if (count($uploadedFiles) > 0) {
        // echo "成功上傳圖片：" . implode(", ", $uploadedFiles);
        header("Location: addProduct.php");
    } else {
        echo "沒有成功上傳圖片。";
    }
}
?>
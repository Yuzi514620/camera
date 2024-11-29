<?php
require_once("db_connect.php");

if (!isset($_POST["name"])) {
    exit("請循正常管道進入此頁");
}

$id = $_POST["id"];
$name = $_POST['name'];
$price = $_POST['price'];
$brand_id = $_POST['brand_id'];
$category_id = $_POST['category_id'];
$stock = $_POST['stock'];
$spec = $_POST['spec'];
$state = $_POST["state"];   // 默認下架
$updated_at = date("Y-m-d H:i:s");

// 更新商品資料
$sql = "UPDATE product 
        SET name = '$name', 
            price = $price, 
            brand_id = $brand_id, 
            category_id = $category_id, 
            stock = $stock, 
            spec = '$spec', 
            state = '$state',
            updated_at = '$updated_at' 
        WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: product.php"); // 成功後返回商品列表
    exit;
} else {
    echo "更新失敗：" . $conn->error;
}

$conn->close();

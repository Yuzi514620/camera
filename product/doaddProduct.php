<?php
require_once("db_connect.php");

if (!isset($_POST["name"])) {
    exit("請循正常管道進入此頁");
}

$name = $_POST["name"];
// $image_id = $_POST["image_id"];
$price = floatval($_POST["price"]);
$brand_id = $_POST["brand_id"];
$category_id = $_POST["category_id"];
$stock = intval($_POST["stock"]);
$created_at = date("Y-m-d H:i:s");
$updated_at = date("Y-m-d H:i:s");
$spec = $_POST["spec"];
$stare = $_POST["state"];

$sql = "INSERT INTO `product`(`name`, `price`,`brand_id`, `category_id`,`stock`, `created_at`, `updated_at`,`spec`,`state`)  
VALUES ('$name', $price, $brand_id, $category_id, $stock, '$created_at', '$updated_at', '$spec', '$state')";
// echo $sql; // 在執行 SQL 前輸出語句，檢查是否正確
// exit;

if ($conn->query($sql) === TRUE) {
    header("Location: product.php");
    exit;
} else {
    echo "更新資料錯誤：" . $conn->error;
}
$conn->close();

?>
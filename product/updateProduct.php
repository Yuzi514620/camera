<?php
require_once("db_connect.php");

if (!isset($_POST["name"])) {
    exit("請循正常管道進入此頁");
}

$id = $_POST["id"];
$name = $_POST["name"];
$price = $_POST["price"];
$brand_id = $_POST["brand_id"];
$category_id = $_POST["category_id"];
$updated_at = date("Y-m-d H:i:s");
$spec = $_POST["spec"];

$sql = "UPDATE product SET name = '$name', price = '$price', brand_id = '$brand_id', category_id = '$category_id', updated_at = '$updated_at', spec = '$spec'
WHERE id = $id";
// echo $sql;


if ($conn->query($sql) === TRUE) {
    header("Location: product.php");
    exit;
} else {
    echo "更新資料錯誤：" . $conn->error;
}
$conn->close();

?>
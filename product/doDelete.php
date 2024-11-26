<?php
require_once("db_connect.php");


$id = $_GET["id"];
$sql = "UPDATE product SET is_deleted = 1 WHERE id = $id";


// var_dump($_GET);
// exit;


if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
} else {
    echo "刪除資料錯誤:" . $conn->error;
}

$conn->close();

header("location: product.php");
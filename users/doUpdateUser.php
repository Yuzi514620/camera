<?php
require_once("../db_connect.php");

if(!isset($_POST["name"])){
    exit("請從正常管道進入此頁面");
}
$img=$_POST["img"];
$id=$_POST["id"];
$account=$_POST["account"];
$password=$_POST["password"];
$name=$_POST["name"];
$gender=$_POST["gender"];
$email=$_POST["email"];
$birthday=$_POST["birthday"];
$phone=$_POST["phone"];
$address=$_POST["address"];

$sql="UPDATE users SET img='$img', account='$account', password='$password', name='$name', email='$email', birthday='$birthday', phone='$phone', address='$address' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    	echo "更新成功";
} else {
    	echo "更新資料錯誤: " . $conn->error;
}

$conn->close();

header("location: user.php?id=$id");
?>



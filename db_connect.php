<?php

$servername = "localhost";
$username = "admin";
$password = "12345";
$dbname = "camera";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// 檢查連線
if ($conn->connect_error) {
<<<<<<< HEAD
  	die("連線失敗: " . $conn->connect_error);
}
// else{
//     echo "連線成功";
// }
// exit;
=======
    die("連線失敗: " . $conn->connect_error);
} else {
    // echo "連線成功";
}
// exit;

>>>>>>> 70fd918c4917c2073b1a7ddf411e6c6e921ce225
session_start();

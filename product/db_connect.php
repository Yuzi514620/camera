<?php
//  這是一個連線資料庫的範例
$servername = "localhost"; // 資料庫位置
$username = "admin"; // 資料庫帳號
$password = "12345"; // 資料庫密碼
$dbname = "camera"; // 資料庫名稱

// Create connection
// 建立連線
$conn = new mysqli($servername, $username, $password, $dbname);
// 檢查連線
if ($conn->connect_error) {
  	die("連線失敗: " . $conn->connect_error);
}else {
    // echo "連線成功";
}
// exit;
session_start();
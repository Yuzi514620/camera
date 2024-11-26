<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "camera_school";

try {
    // 使用 utf8mb4 編碼以支持更多字符
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,            // 啟用異常模式
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // 設定預設抓取模式為關聯陣列
        PDO::ATTR_EMULATE_PREPARES => false,                    // 禁用模擬預處理語句
    );

    $pdo = new PDO($dsn, $username, $password, $options);       // 建立 PDO 連線
    session_start();                                           // 啟動會話
} catch (PDOException $e) {
    die("連線失敗: " . $e->getMessage());                    // 錯誤處理
}
?>
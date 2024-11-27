<?php
    $servername = "localhost";
    $username = "admin";
    $password = "12345";
    $dbname = "camera";

    try{
        $db_host = new PDO(
            "mysql:host={$servername};dbname={$dbname};charset=utf8",$username,$password
        );
    }catch(PDOException $e){
        echo "資料庫連線錯誤<br>";
        echo $e->getMessage();
        exit;
    }
?>
<?php
require_once("../db_connect.php");

$title = "租借列表";

// 初始化 WHERE 條件
$whereClause = "1=1";

// 搜尋條件處理
if (isset($_GET["search"])) {
    $search = $conn->real_escape_string($_GET["search"]); // 防止 SQL 注入
    $whereClause .= " AND (images.name LIKE '%$search%' OR images.description LIKE '%$search%')";
    $title = "搜尋結果：$search";
} elseif (isset($_GET["min"]) && isset($_GET["max"]) && is_numeric($_GET["min"]) && is_numeric($_GET["max"])) {
    $min = (int) $_GET["min"];
    $max = (int) $_GET["max"];
    $whereClause .= " AND camera.fee BETWEEN $min AND $max"; // 根據需求篩選租金範圍
} elseif (isset($_GET["image"])) {
    $image_id = (int) $_GET["image"];
    $whereClause .= " AND images.id = $image_id";
    $title = "Kind : Image $image_id"; // 可根據 image_id 更新標題
}

// 查詢資料
$sql = "SELECT * 
        FROM camera 
        JOIN images ON camera.image_id = images.id 
        WHERE $whereClause";

$result = $conn->query($sql);

// 檢查查詢結果
if ($result) {
    $cameraList = $result->fetch_all(MYSQLI_ASSOC);
    $rentalsCount = count($cameraList);
} else {
    $cameraList = [];
    $rentalsCount = 0;
    echo "查詢失敗：" . $conn->error;
}
?>
<?php
require_once("../db_connect.php");

// 大標
$title = "租借列表";

// 撈
$imgSql = "SELECT * FROM images";
$resultImg = $conn->query($imgSql);
$images = $resultImg->fetch_all(MYSQLI_ASSOC);

// 重組
$imageArr = [];
foreach ($images as $image) {
    $imageArr[$image["id"]] = $image["name"];

}

$whereClause = "1=1";

// 可用 name 或 description 搜尋
if (isset($_GET["search"])) {
    $search = $conn->real_escape_string($_GET["search"]); // 防止 SQL 注入
    $whereClause .= " AND (images.name LIKE '%$search%' OR images.description LIKE '%$search%')";
    $title = "搜尋結果：$search";
} elseif (isset($_GET["min"]) && isset($_GET["max"]) && is_numeric($_GET["min"]) && is_numeric($_GET["max"])) {
    $min = (int) $_GET["min"];
    $max = (int) $_GET["max"];
    $whereClause .= " AND .id BETWEEN $min AND $max"; // 根據你的需求修改這條件
} elseif (isset($_GET["image"])) {
    $image_id = (int) $_GET["image"];
    if (isset($imageArr[$image_id])) { // 檢查 image_id 是否有效
        $title = "Kind : " . $imageArr[$image_id];
        $whereClause .= " AND images.id = $image_id";
    } else {
        $title = "Unknown Image";
    }
}

// 搜尋
$sql = "SELECT rental.*, images.name AS image_name, images.description AS image_description 
        FROM rental
        JOIN images ON rental.camera_id = images.id
        WHERE $whereClause";

$result = $conn->query($sql);
$rentalsCount = $result->num_rows;
$rentals = $result->fetch_all(MYSQLI_ASSOC);

?>

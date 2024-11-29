<?php
require_once("../db_connect.php"); // 引入資料庫連線檔案

// 圖片資料（不再需要 name 欄位，只需要檔案名稱）
$images = [
    'course_1_1',
    'course_2_1',
    'course_3_1',
    'course_4_1',
    'course_5_1',
    'course_6_1',
    'course_7_1',
    'course_8_1',
    'course_9_1',
    'course_10_1',
    'course_11_1',
    'course_12_1',
    'course_13_1',
    'course_14_1',
    'course_15_1'
];

$directory = 'C:\\xampp\\htdocs\\camera_img'; // 圖片目錄

foreach ($images as $image_name) {
    // 根據圖片名稱來生成圖片 URL
    $url = 'http://example.com/camera_img/' . $image_name;  // 使用該路徑來顯示圖片
    
    // 插入資料到資料庫
    $stmt = $conn->prepare("INSERT INTO Course_image (image_url, is_primary, created_at, updated_at) 
                            VALUES (?, ?, NOW(), NOW())");

    // 假設設定為主圖片 (is_primary = 1)
    $is_primary = 1;

    // 綁定參數並執行插入
    $stmt->bind_param('si', $url, $is_primary);
    $stmt->execute();
}

echo "圖片路徑匯入完成！";
?>
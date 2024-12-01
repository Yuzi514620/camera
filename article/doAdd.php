<?php  
session_start();
require_once("./pdo_connect_camera.php");  
$result = [];  

// 取得標題和內容  
$category_id = $_POST['category_id'] ?? null;  
$title = $_POST['title'] ?? null;   
$content = $_POST['content'] ?? null;   

// 初始化錯誤陣列
$errors = [];

// 基本資料驗證
if (empty($category_id)) {
    $errors['category_id'] = "文章類別必須選擇。";
}
if (empty($title)) {
    $errors['title'] = "標題必須填寫。";
}
if (empty($content)) {
    $errors['content'] = "內容必須填寫。";
}

if (!empty($errors)) {
    // 將錯誤訊息和之前輸入的數據存入 Session
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $_POST;
    header('Location: articleAdd.php');
    exit;
}

try {
    // 準備 SQL 語句，使用 ? 作為佔位符
    $sql = "INSERT INTO article (category_id, title, content) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // 綁定參數並執行語句
    if ($stmt->execute([$category_id, $title, $content])) {
        $_SESSION['status'] = "success";
        $_SESSION['message'] = "文章已成功新增。";
        
        // 新增成功後重定向到文章列表頁面  
        header('Location: article.php');  
        exit;  
    } else {  
        $_SESSION['errors'] = ['general' => "新增文章時發生錯誤。"];
        $_SESSION['old'] = $_POST;
        header('Location: articleAdd.php');  
        exit;
    }  
} catch (PDOException $e) {  
    $_SESSION['errors'] = ['general' => "資料庫操作失敗: " . $e->getMessage()];
    $_SESSION['old'] = $_POST;
    header('Location: articleAdd.php');  
    exit;
}  
?>
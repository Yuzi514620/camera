<?php  
require_once 'pdo_connect_camera.php';  

// 獲取 JSON 請求  
$input = json_decode(file_get_contents('php://input'), true);  

if (!isset($input['id']) || !isset($input['is_deleted'])) {  
  echo json_encode(['success' => false, 'message' => '參數不足']);  
  exit;  
}  

$id = (int)$input['id'];  
$is_deleted = (int)$input['is_deleted'];  

// 更新資料庫  
try {  
  $stmt = $pdo->prepare("UPDATE article SET is_deleted = :is_deleted WHERE id = :id");  
  $stmt->bindParam(':is_deleted', $is_deleted, PDO::PARAM_INT);  
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);  

  if ($stmt->execute()) {  
    echo json_encode(['success' => true]);  
  } else {  
    echo json_encode(['success' => false, 'message' => '資料庫更新失敗']);  
  }  
} catch (PDOException $e) {  
  error_log("資料庫錯誤: " . $e->getMessage());  
  echo json_encode(['success' => false, 'message' => '伺服器錯誤']);  
}  
?>  
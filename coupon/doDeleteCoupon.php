<?php
    require_once("pdo_connect.php");
    if(!isset($_POST["id"])){
        echo "請循正常管道進入";
        exit;
    }

    $id = $_POST["id"];
    
   
    $pdoSql = "DELETE FROM `coupon` WHERE `coupon`.`id` = ?";
    $stmt = $db_host->prepare($pdoSql);
    try{
        $stmt->execute([$id]);
        echo json_encode("刪除資料成功");
    }catch(PDOException $e){
        echo json_encode("預處理陳述式執行失敗！ <br/>");
        echo json_encode("Error: " . $e->getMessage() . "<br/>");
        $db_host = NULL;
        exit;
    }
?>
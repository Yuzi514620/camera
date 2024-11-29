<?php
    require_once("pdo_connect.php");
    if(!isset($_POST["id"])){
        echo "請循正常管道進入";
        exit;
    }

    $status = $_POST["status"];
    $id = $_POST["id"];
    
    if($status == 0){
        $pdoSql = "UPDATE `coupon` SET `is_deleted` = 0 WHERE `coupon`.`id` = ?";
        echo json_encode(0);
    }else{
        $pdoSql = "UPDATE `coupon` SET `is_deleted` = 1 WHERE `coupon`.`id` = ?";
        echo json_encode(1);
    }
    $stmt = $db_host->prepare($pdoSql);
    try{
        $stmt->execute([$id]);
    }catch(PDOException $e){
        echo json_encode("預處理陳述式執行失敗！ <br/>");
        echo json_encode("Error: " . $e->getMessage() . "<br/>");
        $db_host = NULL;
        exit;
    }
?>
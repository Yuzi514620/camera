<?php
    require_once("../pdo_connect.php");
    // if(!isset($_POST["id"])){
    //     echo "請循正常管道進入";
    //     exit;
    // }

    
    $id = $_POST["id"];
    $name = $_POST["name"];
    $discount = $_POST["discount"];
    $lower_purchase = $_POST["lower_purchase"];
    $quantity = $_POST["quantity"];

    $pdoSql = "UPDATE `coupon` SET `name` = ?,`discount` = ?,`lower_purchase` = ?,`quantity` = ?  WHERE `coupon`.`id` = ?";
 
    $stmt = $db_host->prepare($pdoSql);
    try{
        $stmt->execute([$name,$discount,$lower_purchase,$quantity,$id]);
    }catch(PDOException $e){
        $data = [
            'message' => '預處理陳述式執行失敗！ <br/>',
            'code' =>   "Error: " . $e->getMessage() . "<br/>"
        ];
        echo json_encode($data);
        $db_host = NULL;
        session_destroy();
        exit;
    }
?>
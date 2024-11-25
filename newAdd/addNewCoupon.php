<?php
require_once("../../pdo_connect.php");
$timeNow = date("Y-m-d H:i:s");
$timeEnd = date("Y-m-d H:i:s",strtotime("+30 day"));


$pdoSql = "INSERT INTO `coupon`(`name`, `coupon_code`, `start_date`, `end_date`, `discount`, `lower_purchase`, `quantity`, `is_deleted`) VALUES ('全館打9折','test001','$timeNow','$timeEnd','0.9','20000','1000','1')";
$stmt = $db_host->prepare($pdoSql);
try{
    $stmt->execute();
    echo "新增優惠券成功";
}catch(PDOException $e){
    echo "預處理陳述式執行失敗！ <br/>";
    echo "Error: " . $e->getMessage() . "<br/>";
    $db_host = NULL;
    exit;
}

?>
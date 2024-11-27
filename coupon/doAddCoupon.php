<?php
require_once("pdo_connect.php");

$name = $_POST["name"];
$discount = $_POST["discount"];
$lower_purchase = $_POST["lower_purchase"];
$quantity = $_POST["quantity"];
$days = $_POST["days"];
$timeNow = date("Y-m-d H:i:s");
$timeEnd = date("Y-m-d H:i:s",strtotime("+$days day"));

$pdoSql = "INSERT INTO `coupon`(`name`, `coupon_code`, `start_date`, `end_date`, `discount`, `lower_purchase`, `quantity`, `is_deleted`) VALUES (?,?,?,?,?,?,?,?)";
$stmt = $db_host->prepare($pdoSql);
try{
    $stmt->execute([$name,'test001',$timeNow,$timeEnd,$discount,$lower_purchase,$quantity,0]);
}catch(PDOException $e){
    echo json_encode("預處理陳述式執行失敗！ <br/>");
    echo json_encode("Error: " . $e->getMessage() . "<br/>");
    $db_host = NULL;
    exit;
}

?>
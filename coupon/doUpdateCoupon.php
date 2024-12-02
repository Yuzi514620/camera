<?php
require_once("pdo_connect.php");

$id = (empty($_REQUEST['id'])) ? exit("請循正常管道進入此頁面") : $_REQUEST['id'];

$name = (empty($_REQUEST['name'])) ? "" : $_REQUEST['name'];
$discount = (empty($_REQUEST['discount'])) ? "" : $_REQUEST['discount'];
$lower_purchase = (empty($_REQUEST['lower_purchase'])) ? "" : $_REQUEST['lower_purchase'];
$quantity = (empty($_REQUEST['quantity'])) ? "" : $_REQUEST['quantity'];
$days = (empty($_REQUEST['days'])) ? "" : $_REQUEST['days'];
$brand = (empty($_REQUEST['brand'])) ? 0 : $_REQUEST['brand'];
$accessories = (empty($_REQUEST['accessories'])) ? 0 : $_REQUEST['accessories'];
$brandText = (empty($_REQUEST['brandText'])) ? "" : $_REQUEST['brandText'];
$accessoriesText = (empty($_REQUEST['accessoriesText'])) ? "" : $_REQUEST['accessoriesText'];
$concatStr = '';

$pdoDate = "SELECT `start_date` FROM coupon where id = ?";
$stmt = $db_host->prepare($pdoDate);
$stmt->execute([$id]);
$time = $stmt->fetch(PDO::FETCH_ASSOC);
$startTime = strtotime($time['start_date']);

$newTimeEnd = date("Y-m-d H:i:s", strtotime("+$days day", $startTime));
if ($_FILES["file"]["error"] == 0) {
    $imageName = time();
    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $imageName = $imageName . ".$extension";
    if (move_uploaded_file($_FILES['file']['tmp_name'], './images/' . $imageName)) {
        echo 'Upload success.<br>';
    } else {
        echo 'Upload fail.<br>';
    }
} else {
    var_dump($_FILES['file']['error']);
    exit;
}
$uploadImg = $_FILES['file']['name'];

if ($brand == 'null' || $brand == 0) {
    $brandText = '全館';
}
if ($accessories == 'null' || $accessories == 0) {
    $accessoriesText = '全館';
}

if($brand == 'null' && $accessories == 'null'){
    $concatStr .= $name;
}
else {
    if($brandText != $accessoriesText){
        $str = strrchr($name, (string)($discount * 100));
        $concatStr .= $brandText.$accessoriesText.$str;
    }
    else{
        $str = strrchr($name, (string)($discount * 100));
        $concatStr .= $brandText.$str;
    }  
}

$pdoSql = "UPDATE `coupon`
            SET `name` = ?, `end_date` = ?, `discount` = ?, `lower_purchase` = ?, `quantity` = ?, `img` = ?, `brand` = ?, `accessories`=?
            WHERE `coupon`.`id` = ?";


$stmt = $db_host->prepare($pdoSql);
try{
    $stmt->execute([$concatStr,$newTimeEnd,$discount,$lower_purchase,$quantity,$uploadImg,$brand,$accessories,$id]);
}catch(PDOException $e){
    $data = [
        'message' => '預處理陳述式執行失敗！ <br/>',
        'code' =>   "Error: " . $e->getMessage() . "<br/>"
    ];
    echo json_encode($data);
    $db_host = NULL;
    exit;
}

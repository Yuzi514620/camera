<?php
require_once("pdo_connect.php");

$name = (empty($_REQUEST['name']))?"":$_REQUEST['name']; 
$discount = (empty($_REQUEST['discount']))?"":$_REQUEST['discount'];
$lower_purchase = (empty($_REQUEST['lower_purchase']))?"":$_REQUEST['lower_purchase'];
$quantity = (empty($_REQUEST['quantity']))?"":$_REQUEST['quantity'];
$days = (empty($_REQUEST['days']))?"":$_REQUEST['days'];
$brand = (empty($_REQUEST['brand']))?"":$_REQUEST['brand'];
$accessories = (empty($_REQUEST['accessories']))?"":$_REQUEST['accessories'];


if($_FILES["file"]["error"] == 0){

    $imageName = time();
    $extension = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
    $imageName = $imageName.".$extension";
    if(move_uploaded_file($_FILES['file']['tmp_name'], './images/'.$imageName)){
        echo 'Upload success.<br>';
    }else{
        echo 'Upload fail.<br>';
    }
}else{
    var_dump($_FILES['file']['error']);
    exit;
}
$uploadImg = $_FILES['file']['name'];

$timeNow = date("Y-m-d H:i:s");
$timeEnd = date("Y-m-d H:i:s",strtotime("+$days day"));


$couponCodeSql = "SELECT `id` FROM coupon order by id DESC";
$stmt = $db_host->prepare($couponCodeSql);
$stmt->execute();
$code = $stmt->rowCount();


for($i=1;$i<=6;$i++){
    $random .= rand(1,9);
}
$cpnCode = date("ymd").str_pad($code,5,0,STR_PAD_LEFT);


$pdoSql = "INSERT INTO `coupon`(`name`, `coupon_code`, `start_date`, `end_date`, `discount`, `lower_purchase`, `quantity`, `img`, `brand`, `accessories`, `is_deleted`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $db_host->prepare($pdoSql);
try{
    $stmt->execute([$name,$cpnCode,$timeNow,$timeEnd,$discount,$lower_purchase,$quantity,$uploadImg,$brand,$accessories,0]);
}catch(PDOException $e){
    echo json_encode("預處理陳述式執行失敗！ <br/>");
    echo json_encode("Error: " . $e->getMessage() . "<br/>");
    $db_host = NULL;
    exit;
}

?>
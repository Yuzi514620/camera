<?php
require_once("../db_connect.php");

if (!isset($_POST["account"])) {
    exit("請循正常管道進入此網頁");
}
$img = isset($_POST["img"]) ? $_POST["img"] : '';
$account = isset($_POST["account"]) ? $_POST["account"] : '';
$password = isset($_POST["password"]) ? $_POST["password"] : '';
$repassword = isset($_POST["repassword"]) ? $_POST["repassword"] : '';
$name = isset($_POST["name"]) ? $_POST["name"] : '';
$email = isset($_POST["email"]) ? $_POST["email"] : '';
$phone = isset($_POST["phone"]) ? $_POST["phone"] : '';
$address = isset($_POST["address"]) ? $_POST["address"] : '';
$birthday = isset($_POST["birthday"]) ? $_POST["birthday"] : '';

// 驗證輸入資料
if (empty($account)) {
    $_SESSION["error"]["message"] = "請輸入帳號";
    header("Location: create-user.php");
    exit;
}
$sqlCheck = "SELECT * FROM users WHERE account = ?";
$stmt = $conn->prepare($sqlCheck);
$stmt->bind_param("s", $account);
$stmt->execute();
$resultCheck = $stmt->get_result();

if ($resultCheck->num_rows > 0) {
    $_SESSION["error"]["message"] = "帳號已被使用過";
    header("Location: create-user.php");
    exit;
}

if (empty($password)) {
    $_SESSION["error"]["message"] = "請輸入密碼";
    header("Location: create-user.php");
    exit;
}

if ($password !== $repassword) {
    $_SESSION["error"]["message"] = "前後密碼不一致";
    header("Location: create-user.php");
    exit;
}

// 驗證電子郵件地址
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["error"]["message"] = "無效的電子郵件地址";
    header("Location: create-user.php");
    exit;
}

// 驗證生日


// 檢查帳號是否已經存在
$sqlCheck = "SELECT * FROM users WHERE account = ?";
$stmt = $conn->prepare($sqlCheck);
$stmt->bind_param("s", $account);
$stmt->execute();
$resultCheck = $stmt->get_result();

if ($resultCheck->num_rows > 0) {
    $_SESSION["error"]["message"] = "帳號已被使用過";
    header("Location: create-user.php");
    exit;
}

// 檢查電子郵件地址是否已經存在
$sqlCheck = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sqlCheck);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultCheck = $stmt->get_result();

if ($resultCheck->num_rows > 0) {
    $_SESSION["error"]["message"] = "信箱已被使用過";
    header("Location: create-user.php");
    exit;
}

// 使用 bcrypt 將密碼加密
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);


$sql = "INSERT INTO users (img, account, password, name, email, phone, address, birthday, created_at)
	VALUES ('$img', '$account', '$password', '$name', '$email','$phone', '$address', '$birthday', '$now')";





// echo $sql;
// exit;

// $name=$_POST['name'];
// $phone=$_POST['phone'];
// $email=$_POST['email'];

// $sql = "INSERT INTO users (name, phone, email)
// 	VALUES ('$name, '$phone', '$email')";
 	 
if ($conn->query($sql) === TRUE) {
    $last_id=$conn->insert_id;
    	echo "新資料輸入成功, id 為 $last_id";
    } else {
    	echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

header("Location: users.php");


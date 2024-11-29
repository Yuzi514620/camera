<?php
require_once("../db_connect.php");
// session_start();


if (!isset($_POST["account"])) {
    exit("請循正常管道進入此網頁");
}

$account = $_POST["account"];
$password = $_POST["password"];
$password = md5($password);

if (empty($account)) {
    // echo "請輸入帳號";
    $_SESSION["error"]["message"] = "請輸入帳號";
    header("Location: sign-in.php");
    exit;
}
if (empty($password)) {
    // echo "請輸入密碼";
    $_SESSION["error"]["message"] = "請輸入密碼";
    header("Location: sign-in.php");
    exit;
}

$sql = "SELECT * FROM users WHERE account='$account' AND password='$password'";
$result = $conn->query($sql);
$userCount = $result->num_rows;

if ($userCount == 0) {
    if (!isset($_SESSION["error"]["times"])) {
        $_SESSION["error"]["times"] = 1;
    } else {
        $error_times = $_SESSION["error"]["times"];
        $error_times++;
        $_SESSION["error"]["times"] = $error_times;
    }

    // $_SESSION["error"]["times"]=1;
    $_SESSION["error"]["message"] = "使用者帳號或密碼錯誤";

    header("Location: sign-in.php");
    exit;
}

$user=$result->fetch_assoc();
$_SESSION["user"]=$user;
unset($_SESSION["error"]["times"]);
$conn->close();

header("Location: /camera/users/users.php");


// echo "$account, $password";
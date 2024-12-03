<?php require_once("../db_connect.php");

$sql = "SELECT * FROM users WHERE is_deleted=0";

$result = $conn->query($sql);
$row = $result->fetch_assoc();


$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$user_count = $result->num_rows;
$rows = $result->fetch_all(MYSQLI_ASSOC);


?>

<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link
    rel="apple-touch-icon"
    sizes="76x76"
    href="../assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
  <title>camera</title>
  <!--     Fonts and icons     -->
  <link
    rel="stylesheet"
    type="text/css"
    href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script
    src="https://kit.fontawesome.com/42d5adcbca.js"
    crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link
    id="pagestyle"
    href="../assets/css/material-dashboard.css?v=3.2.0"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />

  <style>
    .table {
      .padding {
        padding-left: 20px;
      }

      .padding1 {
        padding-right: 20px;
      }

    }

    .form1 {
      width: 100%;
      max-width: 300px;
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- 側邊欄 -->
  <?php $page = 'users'; ?>
  <?php include '../sidebar.php'; ?>
  <!-- 側邊欄 -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php $page = 'users'; ?>
    <?php
    // 設定麵包屑的層級
    $breadcrumbs = [
      'teacher' => '首頁', // 第一層的文字
      'teacher_list' => '會員管理',
      'teacher_add' => '新增會員', // 第一層的文字
    ];

    $page = 'teacher_add'; //當前的頁面

    // 設定麵包屑的連結
    $breadcrumbLinks = [
      'teacher' => 'users.php',           // 第一層的連結
      'teacher_list' => 'users.php',
      'teacher_add' => 'creat-user.php',   // 第三層的連結
    ];

    include '../navbar.php';
    ?>
    <!-- Navbar -->
    <div class="container-fluid py-2">
      <div class="d-flex align-items-center">
      </div>

      <!-- ------- -->
      <div class="row">


        <div class="col-12">
          <div class="card my-4">
            <div class="card-body px-0 pb-2 ">
              <div class="table-responsive p-0 rounded-top">
                <div class="text-center text-uppercase text-secondary text-xxs text-white bg-dark p-1">
                  <h5 class="text-white">新增會員</h5>
                </div>
                <table class="table table-bordered align-middle">
                  <form class="" action="doCreateUser.php" method="post">
                    <?php if ($result->num_rows > 0) : ?>
                      <input type="hidden" name="id" value="<?= $row["id"] ?>">
                      <tr class="">
                        <th class="padding">大頭貼:</th>
                        <td>
                          <div>
                            <input type="file" class="form-control form1 btn btn-white border bordrer-dark test" name="img">
                            <img class="ms-3" id="test-img" src="/camera/users/img/users.webp" alt="預覽圖" style="max-width: 100px; max-height: 100px;">
                          </div>

                        </td>
                      </tr>
                      <tr>
                        <th class="padding">帳號:</th>
                        <td class="padding1">
                          <input type="text" class="form-control form1 btn btn-white border bordrer-dark " placeholder="請輸入6-12位帳號" minlength="6" maxlength="12" name="account">
                        </td>

                      </tr>
                      <tr>
                        <th class="padding">密碼:</th>
                        <td class="padding1"><input type="password" class="form-control form1 btn btn-white border bordrer-dark " placeholder="請輸入5-20位密碼" minlength="5" maxlength="20" name="password"></td>
                      </tr>
                      <tr>
                        <th class="padding">確認密碼:</th>
                        <td class="padding1"> <input type="password" class="form-control form1 btn btn-white border bordrer-dark " name="repassword"></td>
                      </tr>
                      <tr>
                        <th class="padding">姓名:</th>
                        <td class="padding1"> <input type="text" class="form-control form1 btn btn-white border bordrer-dark " name="name"></td>
                      </tr>
                      <tr>
                        <th class="padding">性別:</th>
                        <td class="padding1">
                          <div class="form-check form-check-inline ">

                            <input class="form-check-input" type="radio" name="gender" id="gender" value="option1">
                            <label class="form-check-label " style="padding-right: 10px;" for="gender">男</label>
                          </div>
                          <div class="form-check form-check-inline mb-2">
                            <input class="form-check-input" type="radio" name="gender" id="gender" value="option2">
                            <label class="form-check-label" style="padding-right: 90px;" for="gender">女</label>
                        </td>
                      </tr>
                      <tr>
                        <th class="padding">信箱:</th>
                        <td class="padding1"><input type="text" class="form-control form1 btn btn-white border bordrer-dark " name="email"></td>
                      </tr>

                      <tr>
                        <th class="padding">手機:</th>
                        <td class="padding1"><input type="text" class="form-control form1 btn btn-white border bordrer-dark " name="phone"></td>
                      </tr>
                      <tr>
                        <th class="padding">地址:</th>
                        <td class="padding1"><input type="text" class="form-control form1 btn btn-white border bordrer-dark " name="address"></td>
                      </tr>
                      <tr>
                        <th class="padding">生日:</th>
                        <td class="padding1"><input type="date" class="form-control form1 btn btn-white border bordrer-dark " name="birthday"></td>
                      </tr>
                    <?php endif; ?>
                </table>
                <?php if (isset($_SESSION["error"]["message"])): ?>
                  <div class=" mb-2 text-danger text-start" style="padding-left: 300px;"><?= $_SESSION["error"]["message"] ?></div>
                  <?php unset($_SESSION["error"]["message"]); ?>
                <?php endif; ?>
                <div style="padding-left: 226px;">
                  <button class="btn btn-dark ms-5" type="submit">送出</button>
                  <a href="users.php" class="btn btn-primary">上一頁</a>
                  </a>
                </div>

                <!-- <table class="table align-items-center mb-0">
          <thead class="">
          <tr>
              <th class="text-end text-uppercase text-secondary text-lg ">id</th>
              <td class="text-center text-uppercase text-secondary text-lg ">1</td>
            </tr>
            <tr>
              <th class="text-end text-uppercase text-secondary text-lg ">姓名</th>
              <td class="text-center text-uppercase text-secondary text-lg ">蔡育騰</td>
            </tr>
            <tr>
              <th class="text-end text-uppercase text-secondary text-lg ">信箱</th>
              <td class="text-center text-uppercase text-secondary text-lg ">a@b.com</td>
            </tr>
            <tr>
              <th class="text-end text-uppercase text-secondary text-lg ">生日</th>
              <td class="text-center text-uppercase text-secondary text-lg ">1999/99/99</td>
            </tr>
            <tr>
              <th class="text-end text-uppercase text-secondary text-lg ">手機</th>
              <td class="text-center text-uppercase text-secondary text-lg ">098888888</td>
            </tr>
            <tr>
              <th class="text-end text-uppercase text-secondary text-lg ">地址</th>
              <td class="text-center text-uppercase text-secondary text-lg ">新北勢111111111111111111111111111</td>
            </tr>
          </thead> -->



                <tbody>
                </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>






    </div>
  </main>

  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <!-- 照片預覽 -->
  <script>
    document.querySelector(".test").addEventListener("change", function(event) {
      const file = event.target.files[0]; // 取得選中的檔案
      const testImg = document.querySelector("#test-img"); // 目標圖片元素

      if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
          testImg.src = e.target.result; // 設定圖片的src為預覽的結果
        };

        reader.readAsDataURL(file); // 開始讀取檔案
      }
    });
  </script>

  <!-- <script>
    const testImg = document.querySelector("#test-img");

    $(".test").change(function() {
      let image = $(this).val();
      newImage = image.split("\\");
      testImg.src = "/camera/users/img/" + `${newImage[newImage.length-1]}`;
      console.log(image);
      console.log(newImage);
    })
  </script> -->
  <script>
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
      var options = {
        damping: "0.5",
      };
      Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>

</body>

</html>
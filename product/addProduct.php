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
<?php
require_once("../db_connect.php");

$sql = "SELECT  
    p.id,  
    p.name AS product_name,  
    i.name AS image_name,  
    i.image_url,  
    p.price,  
    b.brand_name,  
    c.category_name,  
    p.stock,  
    p.created_at,  
    p.updated_at,  
    p.state  
FROM  
    product p  
INNER JOIN  
    category c ON p.category_id = c.category_id  
INNER JOIN  
    brand b ON p.brand_id = b.brand_id  
INNER JOIN  
    image i ON p.name = i.name  -- 條件：product 的 name 必須匹配 image 的 name  
WHERE  
    p.is_deleted = 0";


$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

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
</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- 側邊欄 -->
  <?php $page = 'product'; ?>
  <?php include 'sidebar.php'; ?>
  <!-- 側邊欄 -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3 justify-content-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
              <a class="opacity-5 text-dark" href="javascript:;">Pages</a>
            </li>
            <li class="breadcrumb-item text-sm">
              <a class="opacity-5 text-dark" href="javascript:;">商品管理</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
              新增商品
            </li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <!-- 添加 ms-auto 將內容推向右側 -->
          <ul class="navbar-nav d-flex align-items-center justify-content-end ms-auto">
            <li class="mt-1">
              <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard"
                data-icon="octicon-star" data-size="large" data-show-count="true"
                aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="material-symbols-rounded fixed-plugin-button-nav">settings</i>
              </a>
            </li>
            <li class="nav-item dropdown pe-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="material-symbols-rounded">notifications</i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <!-- 通知內容 -->
              </ul>
            </li>
            <li class="nav-item d-flex align-items-center">
              <a href="../pages/sign-in.php" class="nav-link text-body font-weight-bold px-0">
                <i class="fa-solid fa-circle-user"></i>
              </a>
            </li>
            <li class="nav-item d-flex align-items-center ms-3">
              <a href="../pages/sign-in.php" class="nav-link text-body font-weight-bold px-0">
                <i class="fa-solid fa-right-from-bracket"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Navbar -->

    <div class="container-fluid py-2">
      <a href="product.php" class="btn btn-dark">
        <i class="fa-solid fa-arrow-left"></i>
      </a>
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0 rounded-top">
                <table class="table ">
                  <thead class="bg-gradient-dark">
                    <tr>
                      <th
                        class=" text-uppercase text-secondary text-xl opacity-7 text-white" colspan="10">
                        新增商品
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <form class="" action="doaddProduct.php" method="post" enctype="multipart/form-data">
                      <!-- 商品名稱 -->
                      <tr>
                        <td >
                          <label for="name" class="form-label">商品名稱：</label>
                          <input type="text" class="form-control" name="name" placeholder="" required>
                        </td>
                      </tr>
                      <!-- 圖片 -->
                      <tr >
                        <td>
                          <label class="form-label">圖片：</label>
                          <a href="up_image.php" class="btn btn-dark">選擇圖片</a>
                        </td>
                      </tr>
                      <!-- 價格 -->
                      <tr>
                        <td>
                          <label for="price" class="form-label">價格：</label>
                          <input type="number" class="form-control" name="price" placeholder="輸入價格" required>
                        </td>
                      </tr>
                      <!-- 品牌 -->
                      <tr>
                        <td>
                          <label for="brand_id" class="form-label">品牌：</label>
                          <select name="brand_id" id="brand_id" class="form-select border border-dark ps-2">
                            <option value="0">-請選擇品牌-</option>
                            <option value="1">Leica</option>
                            <option value="2">Nikon</option>
                            <option value="3">Sony</option>
                            <option value="4">Hasselblad</option>
                            <option value="5">Canon</option>
                          </select>
                        </td>
                      </tr>
                      <!-- 種類 -->
                      <tr>
                        <td>
                          <label for="category_id" class="form-label">種類：</label>
                          <select name="category_id" id="category_id" class="form-select border border-dark ps-2">
                            <option value="0">-請選擇種類-</option>
                            <option value="1">相機</option>
                            <option value="2">鏡頭</option>
                            <option value="3">配件</option>
                          </select>
                        </td>
                      </tr>
                      <!-- 庫存 -->
                      <tr>
                        <td>
                          <label for="stock" class="form-label">庫存：</label>
                          <input type="number" class="form-control" name="stock" min="0" placeholder="輸入庫存數量" required>
                        </td>
                      </tr>
                      <!-- 規格 -->
                      <tr>
                        <td>
                          <label for="spec" class="form-label">規格：</label>
                          <textarea class="form-control" name="spec" placeholder="輸入規格"></textarea>
                        </td>
                      </tr>
                      <!-- 狀態 -->
                      <tr>
                        <td>
                          <label for="state" class="form-label">狀態：</label>
                          <input type="text" class="form-control" name="state" placeholder="輸入狀態">
                        </td>
                      </tr>
                      <!-- 提交按鈕 -->
                      <tr>
                        <td class="text-center">
                          <button class="btn btn-primary" type="submit">送出</button>
                        </td>
                      </tr>
                    </form>
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


<!-- <form action="doaddProduct.php" method="post" enctype="multipart/form-data">
            <div class="mb-2">
                <label for="name" class="form-label">商品名稱</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-2">
                <a href="up_image.php" class="btn btn-dark">選擇圖片</a>
            </div>
            <div class="mb-2">
                <label for="price" class="form-label">價格</label>
                <input type="number" class="form-control" name="price" required>
            </div>
            <div class="mb-2">
                <label for="brand_id" class="form-label">品牌</label>
                <select name="brand_id" id="brand_id" class="form-select">
                    <option value="1">Leica</option>
                    <option value="2">Nikon</option>
                    <option value="3">Sony</option>
                    <option value="4">Hasselblad</option>
                    <option value="5">Canon</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="category_id" class="form-label">種類</label>
                <select name="category_id" id="category_id" class="form-select">
                    <option value="1">相機</option>
                    <option value="2">鏡頭</option>
                    <option value="3">配件</option>
                </select>
            </div>
            <div class="mb-2">
                <label for="stock" class="form-label">庫存</label>
                <input type="number" class="form-control" name="stock" min="0" required>
            </div>
            <div class="mb-2">
                <label for="spec" class="form-label">規格</label>
                <textarea type="text" class="form-control" name="spec"></textarea>
            </div>
            <div class="mb-2">
                <label for="state" class="form-label">狀態</label>
                <input type="text" class="form-control" name="state">
            </div>
            <button class="btn btn-primary" type="submit">送出</button>
        </form> -->
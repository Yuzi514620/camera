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
</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- 側邊欄 -->
  <?php $page = 'product'; ?>
  <?php include 'sidebar.php'; ?>
  <!-- 側邊欄 -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php $page = 'product'; ?>
    <?php include 'navbar.php'; ?>
    <!-- Navbar -->
    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0 rounded-top">
                <table class="table align-items-center mb-0">
                  <thead class="bg-gradient-dark">
                    <tr>
                      <th
                        class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        ID
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 text-white">
                        商品名稱
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        照片
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-white">
                        價格
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        品牌
                      </th>
                      <th
                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">
                        種類
                      </th>
                      <th
                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">
                        創立時間
                      </th>
                      <th
                        class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        更新時間
                      </th>
                      <th
                        class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        庫存
                      </th>
                      <th
                        class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        狀態
                      </th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
                <div class="container">
                  <?php if (isset($_GET["search"])):  ?>
                    <a class="btn btn-primary" href="product.php"><i class="fa-solid fa-left-long fa-fw"></i></a>
                  <?php endif; ?>
                  <div class="row">
                    <div class="col-md-12">
                      <h1>商品管理</h1>
                      <div class="col-md-6">
                        <form action="" method="get">
                          <div class="input-group">
                            <input type="search" class="form-control" name="search" value="<?= $_GET["search"] ?? "" ?>">
                            <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                          </div>
                        </form>
                      </div>
                      <div class="py-2 d-flex justify-content-between align-items-center">
                        <div class="btn-group ">
                          <a class="btn btn-dark <?php if ($order == 1) echo "active" ?>" href="users.php?p=<?= $p ?>&order=1"><i class="fa-solid fa-arrow-up-wide-short fa-fw"></i></i></a>
                          <a class="btn btn-dark <?php if ($order == 2) echo "active" ?>" href="users.php?p=<?= $p ?>&order=2"><i class="fa-solid fa-arrow-down-wide-short fa-fw"></i></a>
                          <a class="btn btn-dark <?php if ($order == 3) echo "active" ?>" href="users.php?p=<?= $p ?>&order=3"><i class="fa-solid fa-arrow-up-a-z fa-fw"></i></a>
                          <a class="btn btn-dark <?php if ($order == 4) echo "active" ?>" href="users.php?p=<?= $p ?>&order=4"><i class="fa-solid fa-arrow-up-z-a fa-fw"></i></a>
                        </div>
                        <a href="addProduct.php" class="btn btn-primary">
                          <i class="fa-solid fa-folder-plus fa-fw"></i>
                        </a>
                      </div>
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>id</th>
                            <th>商品名稱</th>
                            <th>照片</th>
                            <th>價格</th>
                            <th>品牌</th>
                            <th>種類</th>
                            <th>創立時間</th>
                            <th>更新時間</th>
                            <th>庫存</th>
                            <th>狀態</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          // 假設你有一個資料庫連接
                          include 'db_connection.php';

                          // 查詢資料庫以獲取產品資料
                          $query = "SELECT * FROM products";
                          $result = mysqli_query($conn, $query);

                          if ($result) {
                              $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
                          } else {
                              $products = [];
                          }

                          // 確保關閉資料庫連接
                          mysqli_close($conn);
                          ?>
                          <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                              <tr>
                                <td><?= $product["id"] ?></td>
                                <td><a href="product-content.php?id=<?= $product["id"] ?>"><?= $product["name"] ?></a></td>
                                <td style="width: 100px;">
                                  <div class="ratio ratio-16x9">
                                    <img class="object-fit-cover" src="upload/<?= $product["image_url"] ?>" alt="">
                                  </div>
                                </td>
                                <td><?= number_format($product["price"]) ?></td>
                                <td><?= $product["brand_name"] ?></td>
                                <td><?= $product["category_name"] ?></td>
                                <td><?= $product["created_at"] ?></td>
                                <td><?= $product["updated_at"] ?></td>
                                <td><?= $product["stock"] ?></td>
                                <td><?= $product["state"] ?></td>
                                <td><a href="product-edit.php?id=<?= $product["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square fa-fw"></i></a></td>
                              </tr>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <p>沒有產品可顯示。</p>
                          <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
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
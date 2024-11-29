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

$per_page = 10;
$p = isset($_GET["p"]) ? intval($_GET["p"]) : 1;
$sqlCount = "SELECT COUNT(*) AS total FROM product p WHERE p.is_deleted = 0";
$resultCount = $conn->query($sqlCount);
$totalData = $resultCount->fetch_assoc()["total"];
$totalPage = ceil($totalData / $per_page);
$start_item = ($p - 1) * $per_page;



$sql = "SELECT  
    p.id,  
    p.name AS product_name,
    i.name AS image_name,  
    i.image_url,  
    p.price,  
    b.brand_name,  
    c.category_name,  
    p.stock,
    p.is_deleted,
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
    image i ON p.name = i.name  
WHERE  
    p.is_deleted = 0";

$search = $_GET['search'] ?? '';
if (!empty($search)) {
  $search = $conn->real_escape_string($search);
  $sql .= " AND p.name LIKE '%$search%'";
}

$start_item = ($p - 1) * $per_page; // 計算當前頁面的起始記錄
$order = $_GET['order'] ?? 'asc'; // 預設為升序
$order = ($order === 'desc') ? 'desc' : 'asc'; // 只允許 asc 或 desc
$sql .= " ORDER BY p.id $order LIMIT $start_item, $per_page"; // 根據排序參數排序

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
  <?php include '../sidebar.php'; ?>
  <!-- 側邊欄 -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php
        // 設定麵包屑的層級
        $breadcrumbs = [
          'teacher' => '首頁', // 第一層的文字
          'teacher_list' => '商品管理', // 第一層的文字
          ];

        $page = 'teacher_list';//當前的頁面

        // 設定麵包屑的連結
        $breadcrumbLinks = [
            'teacher' => 'product.php',           // 第一層的連結
            'teacher_list' => 'product.php',      // 第二層的連結
        ];

        include '../navbar.php';
        ?>
    <!-- Navbar -->
    <div class="container-fluid py-2">
      <div class="d-flex justify-content-between align-items-center">
        <form action="" method="get">
          <div class="input-group d-flex">
            <input type="search" cla  ss="form-control border border-secondary rounded-end-0 form-control-sm" name="search" value="<?= $_GET["search"] ?? "" ?>" style="height: 38px;">
            <button class="btn btn-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
          </div>
        </form>
        <a class="btn btn-dark ms-3 " href="addProduct.php"><i class="fa-solid fa-plus  "></i></a>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0 rounded-top">
                <table class="table align-items-center mb-0">
                  <thead class="bg-gradient-dark">
                    <tr>
                      <th class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        <a href="?p=<?= $p ?>&search=<?= $search ?>&order=<?= ($order === 'asc') ? 'desc' : 'asc' ?>"
                          class="text-white text-decoration-none">
                          編號
                          <?php if ($order === 'asc'): ?>
                            <i class="fa-solid fa-arrow-up"></i>
                          <?php else: ?>
                            <i class="fa-solid fa-arrow-down"></i>
                          <?php endif; ?>
                        </a>
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 text-white">
                        圖片
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        價格
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-white">
                        品牌
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        種類
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        更新時間
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        庫存
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        狀態
                      </th>
                      <th
                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">
                        編輯
                      </th>
                      <th
                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">
                        檢視
                      </th>
                      <th
                        class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        刪除
                      </th>
                      <!-- <th class="text-secondary opacity-7"></th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($products as $product): ?>
                      <tr>
                        <td class="text-center">
                          <!-- ID -->
                          <p class="text-xs font-weight-bold mb-0"><?= $product["id"] ?></p>
                        </td>
                        <td>
                          <!-- 圖片 -->
                          <div class="d-flex px-2 py-1">
                            <div>
                              <a href="product-content.php?id=<?= $product['id'] ?>">
                                <img
                                  src="../album/upload/<?= $product["image_url"] ?>"
                                  class="avatar avatar-xxl me-3 border-radius-lg object-fit-contain"
                                  alt="">
                              </a>
                            </div>
                            <div
                              class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm"><?= htmlspecialchars($product["image_name"]) ?></h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <!-- 價格 -->
                          <p class="text-xs font-weight-bold mb-0"><?= number_format($product["price"]) ?> </p>
                        </td>
                        <!-- 品牌 -->
                        <td>
                          <p class="text-xs font-weight-bold mb-0">
                            <?= htmlspecialchars($product["brand_name"]) ?>
                          </p>
                        </td>

                        <!-- 電話 -->
                        <td>
                          <p class="text-xs font-weight-bold mb-0">
                            <?= htmlspecialchars($product["category_name"]) ?>
                          </p>
                        </td>
                        <!-- 更新時間 -->
                        <td>
                          <p class="text-xs font-weight-bold mb-0">
                            <?= $product["updated_at"] ?>
                          </p>
                        </td>
                        <!-- 庫存 -->
                        <td>
                          <p class="text-xs font-weight-bold mb-0">
                            <?= $product["stock"] ?>
                          </p>
                        </td>
                        <!-- 狀態 -->
                        <td>
                          <p class="text-xs font-weight-bold mb-0">
                            <?= htmlspecialchars($product["state"]) ?>
                          </p>
                        </td>
                        <!-- 編輯 -->
                        <td class="align-middle text-center">
                          <a
                            href="product-edit.php?id=<?= $product['id'] ?>"
                            class="text-secondary font-weight-bold text-xs"
                            data-toggle="tooltip"
                            data-original-title="Edit user">
                            <i class="fa-regular fa-pen-to-square"></i>
                          </a>
                        </td>
                        <!-- 檢視 -->
                        <td class="align-middle text-center">
                          <a
                            href="product-content.php?id=<?= $product['id'] ?>"
                            class="text-secondary font-weight-bold text-xs"
                            data-toggle="tooltip"
                            data-original-title="Edit user">
                            <i class="fa-regular fa-eye"></i>
                          </a>
                        </td>
                        <!-- 刪除 -->
                        <td class="align-middle text-center">
                          <a
                            href="doDelete.php?id=<?= $product['id'] ?>"
                            class="text-secondary font-weight-bold text-xs"
                            data-toggle="tooltip"
                            data-original-title="Edit user">
                            <i class="fa-regular fa-trash-can"></i>
                          </a>
                        </td>
                      </tr>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <!-- 分頁 -->
              <?php if ($totalPage > 1): ?>
                <nav aria-label="Page navigation">
                  <ul class="pagination justify-content-center">
                    <li class="page-item <?= ($p == 1) ? 'disabled' : '' ?>">
                      <a class="page-link" href="product.php?p=<?= $p - 1 ?>&search=<?= $search ?>">上頁</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                      <li class="page-item <?= ($i == $p) ? 'active' : '' ?>">
                        <a class="page-link" href="product.php?p=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
                      </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($p == $totalPage) ? 'disabled' : '' ?>">
                      <a class="page-link" href="product.php?p=<?= $p + 1 ?>&search=<?= $search ?>">下頁</a>
                    </li>
                  </ul>
                </nav>
              <?php endif; ?>
            </div>
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
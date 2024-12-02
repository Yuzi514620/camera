<?php
require_once("../db_connect.php");

$per_page = 10; // 每頁顯示 10 筆
$p = isset($_GET["p"]) ? intval($_GET["p"]) : 1; // 當前頁碼
$selectedBrand = $_GET['brand'] ?? ''; // 獲取品牌篩選條件
$selectedCategory = $_GET['category'] ?? ''; // 獲取種類篩選條件
$selectedState = $_GET['state'] ?? ''; // 獲取狀態篩選條件
$search = $_GET['search'] ?? ''; // 獲取搜尋條件
$order = $_GET['order'] ?? 'asc'; // 獲取排序條件

// 取得商品總數（含篩選條件）
$sqlCount = "SELECT COUNT(*) AS total FROM product p
INNER JOIN brand b ON p.brand_id = b.brand_id
INNER JOIN category c ON p.category_id = c.category_id
WHERE p.is_deleted = 0";

// 加入搜尋條件
if (!empty($search)) {
  $search = $conn->real_escape_string($search);
  $sqlCount .= " AND p.name LIKE '%$search%'";
}

// 加入品牌篩選條件
if (!empty($selectedBrand)) {
  $sqlCount .= " AND b.brand_id = '$selectedBrand'";
}

// 加入種類篩選條件
if (!empty($selectedCategory)) {
  $sqlCount .= " AND c.category_id = '$selectedCategory'";
}

// 加入狀態篩選條件
if (!empty($selectedState)) {
  $sqlCount .= " AND p.state = '$selectedState'";
}

$resultCount = $conn->query($sqlCount);
$totalData = $resultCount->fetch_assoc()["total"]; // 總數據
$totalPage = ceil($totalData / $per_page); // 總頁數
$start_item = ($p - 1) * $per_page; // 計算起始數據

// 取得商品資料（含篩選條件）
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
INNER JOIN category c ON p.category_id = c.category_id  
INNER JOIN brand b ON p.brand_id = b.brand_id
INNER JOIN image i ON p.name = i.name  
WHERE p.is_deleted = 0";

// 加入搜尋條件
if (!empty($search)) {
  $sql .= " AND p.name LIKE '%$search%'";
}

// 加入品牌篩選條件
if (!empty($selectedBrand)) {
  $sql .= " AND b.brand_id = '$selectedBrand'";
}

// 加入種類篩選條件
if (!empty($selectedCategory)) {
  $sql .= " AND c.category_id = '$selectedCategory'";
}

// 加入狀態篩選條件
if (!empty($selectedState)) {
  $sql .= " AND p.state = '$selectedState'";
}

// 加入排序條件
$order = ($order === 'desc') ? 'desc' : 'asc'; // 僅允許 asc 或 desc
$sql .= " ORDER BY p.id $order LIMIT $start_item, $per_page";

$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);

// 取得所有品牌資料
$sqlBrand = "SELECT brand_id, brand_name FROM brand";
$resultBrand = $conn->query($sqlBrand);
$brands = $resultBrand->fetch_all(MYSQLI_ASSOC);

// 取得所有種類資料
$sqlCategory = "SELECT category_id, category_name FROM category";
$resultCategory = $conn->query($sqlCategory);
$categories = $resultCategory->fetch_all(MYSQLI_ASSOC);

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
<style>
  .page-link {
    color: #ff6600;
    /* 修改為橘色 */
  }

  .page-link:hover {
    color: #cc5500;
    /* 滑鼠懸停時顏色 */
    background-color: transparent;
    /* 可避免有背景色 */
  }

  .page-item.active .page-link {
    background-color: black;
    /* 背景顏色改為橘色 */
    border-color: black;
    /* 邊框顏色改為橘色 */
    color: #ffffff;
    /* 文字顏色改為白色 */
  }
</style>

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

    $page = 'teacher_list'; //當前的頁面

    // 設定麵包屑的連結
    $breadcrumbLinks = [
      'teacher' => 'product.php',           // 第一層的連結
      'teacher_list' => 'product.php',      // 第二層的連結
    ];

    include '../navbar.php';
    ?>
    <!-- Navbar -->
    <div class="container-fluid py-2">
      <div class="d-flex justify-content-between">
        <form action="" method="get">
          <div class="input-group">
            <input type="search" class="form-control border border-secondary" style="height: 38px;" name="search" value="<?= $_GET["search"] ?? "" ?>">
            <button class="btn btn-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
          </div>
        </form>
        <a class="btn btn-dark ms-2" href="addProduct.php">新增商品</i></a>
      </div>

    </div>
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
      <!-- 商品總數 -->
      <h6 class="mt-3">共 <?= $totalData ?> 件商品</h6>

      <!-- 篩選表單 -->
      <form action="" method="get" class="d-flex flex-wrap align-items-center gap-3">
        <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
        <input type="hidden" name="p" value="<?= htmlspecialchars($p) ?>">

        <!-- 排序選單 -->
        <select name="order" class="form-select ps-2" style="width: 200px;" onchange="this.form.submit()">
          <option value="asc" <?= ($order === 'asc') ? 'selected' : '' ?>>編號由上到下</option>
          <option value="desc" <?= ($order === 'desc') ? 'selected' : '' ?>>編號由下到上</option>
        </select>

        <!-- 品牌選單 -->
        <select name="brand" class="form-select ps-2" style="width: 200px;" onchange="this.form.submit()">
          <option value="">全部品牌</option>
          <?php foreach ($brands as $brand): ?>
            <option value="<?= $brand['brand_id'] ?>" <?= ($selectedBrand == $brand['brand_id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($brand['brand_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <!-- 種類選單 -->
        <select name="category" class="form-select ps-2" style="width: 200px;" onchange="this.form.submit()">
          <option value="">全部種類</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?= $category['category_id'] ?>" <?= ($selectedCategory == $category['category_id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($category['category_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <!-- 狀態選單 -->
        <select name="state" class="form-select ps-2" style="width: 200px;" onchange="this.form.submit()">
          <option value="">全部狀態</option>
          <option value="上架" <?= ($selectedState == '上架') ? 'selected' : '' ?>>上架</option>
          <option value="下架" <?= ($selectedState == '下架') ? 'selected' : '' ?>>下架</option>
        </select>
      </form>
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
                      編號
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
                      class="text-uppercase text-secondary text-xxs opacity-7 ps-0 text-white">
                      庫存
                    </th>
                    <th
                      class="text-uppercase text-secondary text-xxs opacity-7 ps-5 text-white">
                      狀態
                    </th>
                    <th
                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">
                      編輯
                    </th>
                    <th
                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">
                      詳細
                    </th>
                    <th
                      class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                      刪除
                    </th>
                    <!-- <th class="text-secondary opacity-7"></th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($products)): ?>
                    <tr>
                      <td colspan="11" class="text-center text-danger fs-5">查無此商品</td>
                    </tr>
                  <?php else: ?>
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
                              <img src="../album/upload/<?= $product["image_url"] ?>" class="avatar avatar-xxl me-3 border-radius-lg object-fit-contain" alt="">
                            </div>
                            <div class="d-flex flex-column justify-content-center">
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
                        <!-- 類別 -->
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
                        <td class="text-center">
                          <span
                            class="text-xs font-weight-bold mb-0"
                            style="
              padding: 2px 8px; 
              border-radius: 4px;
              background-color: <?= $product['state'] === '上架' ? '#d4edda' : ($product['state'] === '下架' ? '#f8d7da' : 'transparent') ?>;
              color: <?= $product['state'] === '上架' ? '#155724' : ($product['state'] === '下架' ? '#721c24' : '#000') ?>;">
                            <?= htmlspecialchars($product["state"]) ?>
                          </span>
                        </td>
                        <!-- 編輯 -->
                        <td class="align-middle text-center">
                          <a href="product-edit.php?id=<?= $product['id'] ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                            <i class="fa-regular fa-pen-to-square"></i>
                          </a>
                        </td>
                        <!-- 檢視 -->
                        <td class="align-middle text-center">
                          <a href="product-content.php?id=<?= $product['id'] ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                            <i class="fa-regular fa-eye"></i>
                          </a>
                        </td>
                        <!-- 刪除 -->
                        <td class="align-middle text-center">
                          <a href="doDelete.php?id=<?= $product['id'] ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                            <i class="fa-regular fa-trash-can"></i>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            <!-- 分頁 -->
            <nav aria-label="Page navigation">
              <ul class="pagination justify-content-center">
                <?php
                $range = 2; // 當前頁碼前後顯示的頁碼數量
                $start = max(1, $p - $range); // 計算顯示的起始頁碼
                $end = min($totalPage, $p + $range); // 計算顯示的結束頁碼

                // 首頁按鈕
                if ($p > 1) {
                  echo '<li class="page-item">
        <a class="page-link" href="product.php?p=1&search=' . htmlspecialchars($search) . '&brand=' . htmlspecialchars($selectedBrand) . '&category=' . htmlspecialchars($selectedCategory) . '&state=' . htmlspecialchars($selectedState) . '&order=' . htmlspecialchars($order) . '"><<</a>
      </li>';
                } else {
                  echo '<li class="page-item disabled">
        <a class="page-link" href="#"><<</a>
      </li>';
                }

                // 第一頁及省略
                if ($start > 1) {
                  echo '<li class="page-item">
                <a class="page-link" href="product.php?p=1&search=' . htmlspecialchars($search) . '&brand=' . htmlspecialchars($selectedBrand) . '&category=' . htmlspecialchars($selectedCategory) . '&state=' . htmlspecialchars($selectedState) . '&order=' . htmlspecialchars($order) . '">1</a>
              </li>';
                  if ($start > 2) {
                    echo '<li class="page-item dropdown">
                    <a class="page-link" href="#" role="button" data-bs-toggle="dropdown">...</a>
                    <ul class="dropdown-menu">';
                    for ($i = 2; $i < $start; $i++) {
                      echo '<li><a class="dropdown-item" href="product.php?p=' . $i . '&search=' . htmlspecialchars($search) . '&brand=' . htmlspecialchars($selectedBrand) . '&category=' . htmlspecialchars($selectedCategory) . '&state=' . htmlspecialchars($selectedState) . '&order=' . htmlspecialchars($order) . '">' . $i . '</a></li>';
                    }
                    echo '</ul>
                  </li>';
                  }
                }

                // 中間的頁碼
                for ($i = $start; $i <= $end; $i++) {
                  echo '<li class="page-item ' . ($i == $p ? 'active' : '') . '">
                <a class="page-link" href="product.php?p=' . $i . '&search=' . htmlspecialchars($search) . '&brand=' . htmlspecialchars($selectedBrand) . '&category=' . htmlspecialchars($selectedCategory) . '&state=' . htmlspecialchars($selectedState) . '&order=' . htmlspecialchars($order) . '">' . $i . '</a>
              </li>';
                }

                // 最後一頁及省略
                if ($end < $totalPage) {
                  if ($end < $totalPage - 1) {
                    echo '<li class="page-item dropdown">
                    <a class="page-link" href="#" role="button" data-bs-toggle="dropdown">...</a>
                    <ul class="dropdown-menu">';
                    for ($i = $end + 1; $i < $totalPage; $i++) {
                      echo '<li><a class="dropdown-item" href="product.php?p=' . $i . '&search=' . htmlspecialchars($search) . '&brand=' . htmlspecialchars($selectedBrand) . '&category=' . htmlspecialchars($selectedCategory) . '&state=' . htmlspecialchars($selectedState) . '&order=' . htmlspecialchars($order) . '">' . $i . '</a></li>';
                    }
                    echo '</ul>
                  </li>';
                  }
                  echo '<li class="page-item">
                <a class="page-link" href="product.php?p=' . $totalPage . '&search=' . htmlspecialchars($search) . '&brand=' . htmlspecialchars($selectedBrand) . '&category=' . htmlspecialchars($selectedCategory) . '&state=' . htmlspecialchars($selectedState) . '&order=' . htmlspecialchars($order) . '">' . $totalPage . '</a>
              </li>';
                }

                // 末頁按鈕
                if ($p < $totalPage) {
                  echo '<li class="page-item">
        <a class="page-link" href="product.php?p=' . $totalPage . '&search=' . htmlspecialchars($search) . '&brand=' . htmlspecialchars($selectedBrand) . '&category=' . htmlspecialchars($selectedCategory) . '&state=' . htmlspecialchars($selectedState) . '&order=' . htmlspecialchars($order) . '">>></a>
      </li>';
                } else {
                  echo '<li class="page-item disabled">
        <a class="page-link" href="#">>></a>
      </li>';
                }
                ?>
              </ul>
            </nav>
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
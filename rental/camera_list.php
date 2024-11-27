<?php
require_once("../db_connect.php");

// 設定頁面標題
$title = isset($_GET["search"]) ? "搜尋結果：" . htmlspecialchars($_GET["search"]) : "租借列表";

// 搜尋條件
$whereClause = "1=1";
$search = isset($_GET["search"]) ? trim($_GET["search"]) : '';
if (!empty($search)) {
    $search_escaped = $conn->real_escape_string($search);
    $whereClause .= " AND (images.name LIKE '%$search_escaped%' OR images.description LIKE '%$search_escaped%')";
}

// 設定分頁
$items_per_page = 10;
$currentPage = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;

// 計算總數與分頁
$count_sql = "SELECT COUNT(*) AS total FROM camera JOIN images ON camera.image_id = images.id WHERE $whereClause";
$count_result = $conn->query($count_sql);
$totalItems = $count_result ? $count_result->fetch_assoc()['total'] : 0;
$totalPages = max(ceil($totalItems / $items_per_page), 1);

$offset = ($currentPage - 1) * $items_per_page;

// 撈取資料
$sql = "SELECT camera.*, images.name AS image_name, images.description AS image_description, 
        images.type AS image_type, images.image_url
        FROM camera
        JOIN images ON camera.image_id = images.id
        WHERE $whereClause
        ORDER BY camera.id DESC
        LIMIT $items_per_page OFFSET $offset";
$result = $conn->query($sql);
$cameras = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

// 圖片資料邏輯
$imgSql = "SELECT * FROM images";
$resultImg = $conn->query($imgSql);
$images = $resultImg->fetch_all(MYSQLI_ASSOC);
$imageArr = [];
foreach ($images as $image) {
    $imageArr[$image["id"]] = $image["name"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
  <title>camera</title>

  <?php include("link.php") ?>

</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- 側邊欄 -->
  <?php $page = 'camera'; ?>
  <?php include '../pages/sidebar.php'; ?>
  <!-- 側邊欄 -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
      <?php $page = 'camera'; ?>
      <?php include '../pages/navbar.php'; ?>
    <!-- Navbar -->

    <div class="container-fluid ">
      <div class="px-1">
      <!-- 總數 -->           
      <div class="py-1">共計 <?=$totalItems?> 項目</div>
        <div class="d-flex justify-content-between align-items-center">
          <!-- 搜尋 -->
          <form method="GET" action="camera_list.php">
            <div class="input-group">
              <input type="search" name="search" class="btn btn-light text-start" value="<?= htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : '') ?>" placeholder="搜尋名稱或描述">
              <div class="btn-group ps-1">
                <button type="submit" class="btn btn-dark" title="搜尋">搜尋</button>
                <a href="camera_list.php" class="btn btn-outline-secondary" title="清除搜尋">清除搜尋</a>
              </div>
            </div>
          </form>          
          <!-- 新增 -->
          <div class="text-end">
            <a class="btn btn-dark" href="create-user.php" title="新增使用者"><i class="fa-solid fa-fw fa-user-plus"></i></a>
          </div>
        </div>


      </div>

      <div class="card my-1 px-0">
        <div class="table-responsive p-0 rounded-top">
        <!-- 表格 -->
          <table class="table align-items-center mb-0">
            <thead class="bg-gradient-dark">
              <tr>
                <th class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                  選擇</th>
                <th class="text-uppercase text-secondary text-xxs opacity-7 text-white">
                  圖片</th>
                <th class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                  規格</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-white">
                  租金 / 押金</th>
                <th class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                  庫存</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">
                  狀態</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">
                  編輯</th>
                <th class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                  刪除</th>
              </tr>
            </thead> 
            <tbody>
            <?php foreach($cameras as $camera): ?>
              <tr>
                <!-- 選擇 check box -->
                <td class="text-center">
                  <input type="checkbox" name="selected[]" value="<?= $camera['id'] ?>">
                </td>
                <!-- 圖片 -->
                <td>                        
                  <div class="d-flex px-2 py-1">
                    <div>
                      <img src="../album/upload/<?= htmlspecialchars($camera['image_url']) ?>" 
                        class="avatar avatar-sm me-3 border-radius-lg"
                        alt="<?= htmlspecialchars($camera['image_name']) ?>" />
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm"><?= htmlspecialchars($camera['image_name']) ?></h6>
                      <p class="text-xs text-secondary mb-0"><?= htmlspecialchars($camera['image_type']) ?></p>
                    </div>
                  </div>
                </td>
                <!-- 規格 -->
                <td>
                  <p class="text-xs font-weight-bold mb-0"><?= htmlspecialchars($camera['image_description']) ?></p>
                </td>
                <!-- 租金 / 押金 -->
                <td>
                  <p class="text-xs font-weight-bold mb-0"><?= htmlspecialchars($camera['fee']) ?> / <?= htmlspecialchars($camera['deposit']) ?></p>
                </td>
                <!-- 庫存 -->
                <td>
                  <p class="text-xs font-weight-bold mb-0"><?= htmlspecialchars($camera['stock']) ?></p>
                </td>
                <!-- 狀態 -->
                <td class="align-middle text-center">
                  <a href="javascript:;"
                    class="text-secondary font-weight-bold text-xs"
                    data-toggle="tooltip"
                    data-original-title="View Status">
                    <i class="fa-regular fa-eye"></i>
                  </a>
                </td>
                <!-- 編輯 -->
                <td class="align-middle text-center">
                  <a href="edit.php?id=<?= $camera['id'] ?>"
                    class="text-secondary font-weight-bold text-xs"
                    data-toggle="tooltip"
                    data-original-title="Edit">
                    <i class="fa-regular fa-pen-to-square"></i>
                  </a>
                </td>
                <!-- 刪除 -->
                <td class="align-middle text-center">
                  <a href="delete.php?id=<?= $camera['id'] ?>"
                    class="text-secondary font-weight-bold text-xs"
                    data-toggle="tooltip"
                    data-original-title="Delete">
                    <i class="fa-regular fa-trash-can"></i>
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <!-- 表格-end -->

          <!-- 分頁導航 -->
          <nav aria-label="Page navigation">
              <ul class="pagination justify-content-center">
                  <!-- 首頁 -->
                  <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
                      <a class="page-link" href="camera_list.php?page=1&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                      <i class="fa-solid fa-angles-left"></i></a>
                  </li>

                  <!-- 上一頁 -->
                  <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                      <a class="page-link" href="camera_list.php?page=<?= max(1, $currentPage - 1) ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                      <i class="fa-solid fa-angle-left"></i></a>
                  </li>

                  <!-- 中間頁碼 -->
                  <?php
                  $visiblePages = 5; // 最大顯示頁碼數量
                  $startPage = max(1, $currentPage - floor($visiblePages / 2));
                  $endPage = min($totalPages, $startPage + $visiblePages - 1);

                  // 確保顯示 5 個頁碼範圍
                  if ($endPage - $startPage + 1 < $visiblePages) {
                      $startPage = max(1, $endPage - $visiblePages + 1);
                  }
                  ?>

                  <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                      <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                          <a class="page-link" href="camera_list.php?page=<?= $i ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"><?= $i ?></a>
                      </li>
                  <?php endfor; ?>

                  <!-- 下一頁 -->
                  <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                      <a class="page-link" href="camera_list.php?page=<?= min($totalPages, $currentPage + 1) ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                      <i class="fa-solid fa-chevron-right"></i></a>
                  </li>

                  <!-- 末頁 -->
                  <li class="page-item <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                      <a class="page-link" href="camera_list.php?page=<?= $totalPages ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                      <i class="fa-solid fa-angles-right"></i></a>
                  </li>
              </ul>
          </nav>
          <!-- 分頁-end -->
              
        </div>
      </div>
    </div>
  </main>
  
  <?php include("script.php") ?>

</body>

</html>
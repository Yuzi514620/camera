<?php
require_once("../db_connect.php");  // 資料庫連接

$title="媒體庫管理";

// 確認資料庫連接是否成功
if ($conn->connect_error) {
  die("資料庫連接失敗: " . $conn->connect_error);
}


$where_clause = 'WHERE 1=1'; // 初始化

$search = isset($_GET["search"]) ? trim($_GET["search"]) : '';
if (!empty($search)) {
    $search_escaped = $conn->real_escape_string($search);
    $where_clause .= " AND (name LIKE '%$search_escaped%' OR description LIKE '%$search_escaped%')";
}

// 排序邏輯
$order = isset($_GET["order"]) ? $_GET["order"] : 'i1'; // 默認為按 id 降序排序
switch ($order) {
    case 'i0': $order_by = 'image.id ASC'; break;
    case 'n0': $order_by = 'image.name ASC'; break;
    case 'n1': $order_by = 'image.name DESC'; break;
    case 'd0': $order_by = 'image.description ASC'; break;
    case 'd1': $order_by = 'image.description DESC'; break;
    default: $order_by = 'image.id DESC'; break;
}


// 分頁設定
$items_per_page = 18;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page);  // 確保頁數不小於 1
$offset = ($page - 1) * $items_per_page;

// // 搜尋設定
// $search = isset($_GET['search']) ? trim($_GET['search']) : '';
// $where_clause = '';
// if (!empty($search)) {
//   $search_escaped = $conn->real_escape_string($search);
//   $where_clause = "WHERE description LIKE '%$search_escaped%'";
// }


// 查詢資料數量
$count_sql = "SELECT COUNT(*) AS total FROM image $where_clause";
$count_result = $conn->query($count_sql);
$total_items = $count_result->fetch_assoc()['total'] ?? 0; // 確保有默認值
$total_pages = ceil($total_items / $items_per_page);

// 查詢資料
$sql = "SELECT * FROM image $where_clause ORDER BY $order_by LIMIT $items_per_page OFFSET $offset";
$result = $conn->query($sql);
$rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : []; // 確保有默認值

// 確保變數初始化，避免未定義錯誤
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$currentPage = max(1, $currentPage); // 確保頁數最小為 1

$totalPages = $total_pages ?? 1; // 確保總頁數有默認值

// 設定分頁範圍
$visiblePages = 5; // 最大顯示頁碼數量
$startPage = max(1, $currentPage - floor($visiblePages / 2));
$endPage = min($totalPages, $startPage + $visiblePages - 1);

// 確保顯示固定範圍的頁碼
if ($endPage - $startPage + 1 < $visiblePages) {
    $startPage = max(1, $endPage - $visiblePages + 1);
}

include("../rental/link.php");
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
  <title><?=$title?></title>

</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- 側邊欄 -->
  <?php $page = 'album'; ?>
  <?php include '../sidebar.php'; ?>
  <!-- 側邊欄 -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php
        // 設定麵包屑的層級
        $breadcrumbs = [
            'users' => '首頁', // 第一層的文字
            'album' => '媒體庫管理', // 第一層的文字
        ];

        $page = 'album';//當前的頁面

        // 設定麵包屑的連結
        $breadcrumbLinks = [
            'users' => 'users.php',           // 第一層的連結
            'album' => 'album.php',      // 第二層的連結
        ];

        include '../navbar.php';
        ?>
    <!-- Navbar -->

    <div class="container-fluid ">
      <div class="px-1">
      <!-- 總數 -->           
        <div class="py-1">共計 <?=$total_items?> 項目</div>
          <div class="d-flex justify-content-between align-items-center">          
            <!-- 搜尋 -->
            <form class="d-flex mb-4" id="searchForm" action="" method="get">
              <div class="input-group">
                  <input type="hidden" name="page" value="1">
                  <input type="search" name="search" class="btn btn-light text-start" 
                        value="<?= htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : '') ?>" 
                        placeholder="搜尋名稱或描述">
                  <input type="hidden" name="order" value="<?= htmlspecialchars($order, ENT_QUOTES, 'UTF-8') ?>">
                  <div class="btn-group ps-1">
                      <button type="submit" class="btn btn-dark" title="搜尋">搜尋</button>
                      <a href="album.php" class="btn btn-outline-secondary" title="清除搜尋">清除搜尋</a>
                  </div>
              </div>
          </form>
            <!-- 新增 -->
            <div>
              <button id="deleteImageButton" class="btn btn-secondary" disabled>刪除照片</button>
              <button id="loadModalButton" class="btn btn-dark">新增圖片</button>              
            </div>
          </div>
      </div>

      <div class="card my-1 px-0">
        <div class="table-responsive p-0 rounded-top">
        <!-- 搜尋表單 -->


          <table class="table align-items-center mb-0">
            <thead class="bg-gradient-dark">
              <tr>
                <th class="text-uppercase text-secondary text-xs opacity-7 text-white">
                  編號
                  <?php if ($order === 'i1'): ?>
                      <a href="album.php?page=<?= htmlspecialchars($currentPage, ENT_QUOTES, 'UTF-8') ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>&order=i0" class="btn btn-borderless text-light font-weight-bold text-xs m-0"><i class="fa-solid fa-caret-up"></i></a>
                  <?php else: ?>
                      <a href="album.php?page=<?= htmlspecialchars($currentPage, ENT_QUOTES, 'UTF-8') ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>&order=i1" class="btn btn-borderless text-light font-weight-bold text-xs m-0" style="transform: translatey(-2px);"><i class="fa-solid fa-sort-down"></i></a>
                  <?php endif; ?>    
                </th>
                <th class="text-uppercase text-secondary text-xs opacity-7 ps-2 text-white">
                  名稱
                  <?php if ($order === 'n1'): ?>
                      <a href="album.php?page=<?= htmlspecialchars($currentPage, ENT_QUOTES, 'UTF-8') ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>&order=n0" class="btn btn-borderless text-light font-weight-bold text-xs m-0"><i class="fa-solid fa-caret-up"></i></a>
                  <?php else: ?>
                      <a href="album.php?page=<?= htmlspecialchars($currentPage, ENT_QUOTES, 'UTF-8') ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>&order=n1" class="btn btn-borderless text-light font-weight-bold text-xs m-0" style="transform: translatey(-2px);"><i class="fa-solid fa-sort-down"></i></a>
                  <?php endif; ?>    
                </th>
                <th class="text-uppercase text-secondary text-xs opacity-7 ps-2 text-white">
                  描述
                  <?php if ($order === 'd1'): ?>
                      <a href="album.php?page=<?= htmlspecialchars($currentPage, ENT_QUOTES, 'UTF-8') ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>&order=d0" class="btn btn-borderless text-light font-weight-bold text-xs m-0"><i class="fa-solid fa-caret-up"></i></a>
                  <?php else: ?>
                      <a href="album.php?page=<?= htmlspecialchars($currentPage, ENT_QUOTES, 'UTF-8') ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>&order=d1" class="btn btn-borderless text-light font-weight-bold text-xs m-0" style="transform: translatey(-2px);"><i class="fa-solid fa-sort-down"></i></a>
                  <?php endif; ?>    
                </th>
                <th class="text-uppercase text-secondary text-xs opacity-7 ps-2 text-white">
            </thead>
          </table>
          <!-- 圖片列表 -->
          <div class="row mx-2 my-3" id="imageContainer">
            <?php if (empty($rows)): ?>
                <p class="text-center">目前沒有圖片資料。</p>
            <?php else: ?>
                <?php foreach ($rows as $row): ?>
                  <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                <div class="card checkCard p-1" data-id="<?= htmlspecialchars($row['id']) ?>" style="height: 180px;">
                    <img src="../album/upload/<?= htmlspecialchars($row['image_url']) ?>"                 
                         style="max-height:100px; width: 100%; object-fit: contain;" 
                         class="card-img-top p-1" 
                         alt="<?= htmlspecialchars($row['name']) ?>">
                    <div class="card-body text-center">
                        <h6 class="mb-0 text-sm px-1"><?= htmlspecialchars($row['name']) ?></h6>
                        <p class="text-xs text-secondary mb-0"><?= htmlspecialchars($row['description']) ?></p>
                    </div>
                </div>
            </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>



<!-- 分頁導航 -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <!-- 首頁 -->
        <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="album.php?page=1&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>&order=<?= htmlspecialchars($order, ENT_QUOTES, 'UTF-8') ?>">
                <i class="fa-solid fa-angles-left"></i>
            </a>
        </li>

        <!-- 上一頁 -->
        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="album.php?page=<?= max(1, $currentPage - 1) ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>&order=<?= htmlspecialchars($order, ENT_QUOTES, 'UTF-8') ?>">
                <i class="fa-solid fa-angle-left"></i>
            </a>
        </li>

        <!-- 中間頁碼 -->
        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                <a class="page-link" href="album.php?page=<?= $i ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>&order=<?= htmlspecialchars($order, ENT_QUOTES, 'UTF-8') ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <!-- 下一頁 -->
        <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="album.php?page=<?= min($totalPages, $currentPage + 1) ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>&order=<?= htmlspecialchars($order, ENT_QUOTES, 'UTF-8') ?>">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </li>

        <!-- 末頁 -->
        <li class="page-item <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="album.php?page=<?= $totalPages ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>&order=<?= htmlspecialchars($order, ENT_QUOTES, 'UTF-8') ?>">
                <i class="fa-solid fa-angles-right"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- 分頁-end -->
              
        </div>
      </div>
    </div>

    <div id="albumModalContainer"></div>

  </main>
  
  <?php include("../rental/script.php") ?>


  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- jQuery -->


<script>
        $(document).ready(function () {
            // 當按鈕被點擊時
            $('#loadModalButton').click(function () {
                // 使用 AJAX 加載模態框內容
                $.ajax({
                    url: '../album/images_create.php', // 請求目標
                    method: 'GET', // 請求方法
                    success: function (data) {
                        $('#albumModalContainer').html(data); // 將回應的 HTML 插入到容器中
                        // 顯示模態框
                        $('#albumModalContainer .modal').modal('show');
                    },
                    error: function () {
                        alert('模態框內容載入失敗，請稍後再試。');
                    }
                });
            });
        });
    </script>

<script>
    // 自定義關閉模態框
    $(document).on('click', '.modalClose', function () {
      var modal = $(this).closest('.modal'); // 獲取當前模態框

      // 使用 Bootstrap 的方法關閉模態框
      modal.modal('hide'); // 正確隱藏模態框

      // 在模態框完全隱藏後移除 HTML，防止累積
      modal.on('hidden.bs.modal', function () {
          // modal.remove();
          location.reload();
      });
  });
  </script>

<script>
    $(document).ready(function () {
        let lastSelectedCard = null; // 記錄最後一個選中的卡片

        // 卡片點擊事件處理器
        $('.checkCard').click(function () {
            if (lastSelectedCard) {
                // 如果之前有選中的卡片，移除 outline
                lastSelectedCard.css('outline', 'none');
            }

            // 設定當前卡片為選中的卡片，並加上 outline
            lastSelectedCard = $(this);
            lastSelectedCard.css('outline', '3px solid #333');

            // 啟用刪除按鈕
            $('#deleteImageButton').prop('disabled', false);

            // 保存選中卡片的 image ID
            const dataId = $(this).data('id');
            $('#deleteImageButton').data('id', dataId);
        });

        // 頁面刷新或跳轉到其他頁面時，重置選擇
        $(document).on('click', 'a.page-link', function () {
            if (lastSelectedCard) {
                lastSelectedCard.css('outline', 'none');
            }
            lastSelectedCard = null;
            $('#deleteImageButton').prop('disabled', true);
        });

        // 點擊刪除按鈕時的處理
        $('#deleteImageButton').click(function () {
            const dataId = $(this).data('id');

            if (confirm('您確定要刪除此圖片嗎？')) {
                // 發送 AJAX 請求刪除圖片
                $.ajax({
                    url: '../album/images_delete.php', // 修正這裡的路徑
                    type: 'POST',
                    data: { id: dataId },
                    success: function (response) {
                        if (response.trim() === "success") {
                            alert('圖片刪除成功！');
                            location.reload(); // 重新載入頁面
                        } else {
                            alert(response); // 顯示錯誤訊息
                        }
                    },
                    error: function () {
                        alert('圖片刪除失敗，請稍後再試。');
                    }
                });
            }
        });
    });
</script>
</body>

</html>
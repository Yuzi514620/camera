<?php
require_once("../db_connect.php");  // 資料庫連接

$title="媒體庫管理";

// 確認資料庫連接是否成功
if ($conn->connect_error) {
  die("資料庫連接失敗: " . $conn->connect_error);
}

// 分頁設定
$items_per_page = 18;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page);  // 確保頁數不小於 1
$offset = ($page - 1) * $items_per_page;

// 搜尋設定
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where_clause = '';
if (!empty($search)) {
  $search_escaped = $conn->real_escape_string($search);
  $where_clause = "WHERE description LIKE '%$search_escaped%'";
}

// 查詢資料數量
$count_sql = "SELECT COUNT(*) AS total FROM images $where_clause";
$count_result = $conn->query($count_sql);
$total_items = $count_result->fetch_assoc()['total'] ?? 0; // 確保有默認值
$total_pages = ceil($total_items / $items_per_page);

// 查詢資料
$sql = "SELECT * FROM images $where_clause ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
$result = $conn->query($sql);
$rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : []; // 確保有默認值


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
  <title>camera</title>

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
        <div class="py-1">共計 <?=$total_items?> 項目</div>
          <div class="d-flex justify-content-between align-items-center">          
            <!-- 搜尋 -->
            <form class="d-flex mb-4" id="searchForm" action="" method="get">
              <div class="input-group">
                  <input type="search" name="search" class="btn btn-light text-start" 
                        value="<?= htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : '') ?>" 
                        placeholder="搜尋名稱或描述">
                  <div class="btn-group ps-1">
                      <button type="submit" class="btn btn-dark" title="搜尋">搜尋</button>
                      <a href="album.php" class="btn btn-outline-secondary" title="清除搜尋">清除搜尋</a>
                  </div>
              </div>
          </form>
            <!-- 新增 -->
            <div>
            <button button id="loadModalButton" class="btn btn-primary">新增圖片</button>

              <a class="btn btn-dark" href="create-user.php" title="新增使用者"><i class="fa-solid fa-fw fa-user-plus"></i></a>
            </div>
          </div>
      </div>

      <div class="card my-1 px-0">
        <div class="table-responsive p-0 rounded-top">
        <!-- 搜尋表單 -->


          <table class="table align-items-center mb-0">
            <thead class="bg-gradient-dark">
              <tr>
                <th class="text-center text-uppercase text-secondary text-xs opacity-7 text-white">
                  選擇</th>
                <th class="text-uppercase text-secondary text-xs opacity-7 text-white">
                  圖片</th>
                <th class="text-uppercase text-secondary text-xs opacity-7 ps-2 text-white">
                  規格</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2 text-white">
                  租金 / 押金</th>
                <th class="text-uppercase text-secondary text-xs opacity-7 ps-2 text-white">
                  庫存</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-white">
                  狀態</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-white">
                  編輯</th>
                <th class="text-center text-uppercase text-secondary text-xs opacity-7 text-white">
                  刪除</th>
              </tr>
            </thead>
          </table>
          <!-- 圖片列表 -->
          <div class="row mx-2 my-3" id="imageContainer">
            <?php if (empty($rows)): ?>
                <p class="text-center">目前沒有圖片資料。</p>
            <?php else: ?>
                <?php foreach ($rows as $row): ?>
                  <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                <div class="card p-1" style="height: 180px;">
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


        <?php
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
?>

<!-- 分頁導航 -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <!-- 首頁 -->
        <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="album.php?page=1&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                <i class="fa-solid fa-angles-left"></i>
            </a>
        </li>

        <!-- 上一頁 -->
        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="album.php?page=<?= max(1, $currentPage - 1) ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                <i class="fa-solid fa-angle-left"></i>
            </a>
        </li>

        <!-- 中間頁碼 -->
        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                <a class="page-link" href="album.php?page=<?= $i ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <!-- 下一頁 -->
        <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="album.php?page=<?= min($totalPages, $currentPage + 1) ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </li>

        <!-- 末頁 -->
        <li class="page-item <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="album.php?page=<?= $totalPages ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                <i class="fa-solid fa-angles-right"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- 分頁-end -->
              
        </div>
      </div>
    </div>

  <div id="cameraModalContainer"></div>

  </main>
  
  <?php include("../rental/script.php") ?>


  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- jQuery -->
  <script>
    // 通用model按鈕點擊事件
    $(document).on('click', '[data-toggle="modal"]', function () {
        var targetUrl = $(this).data('target'); // 獲取目標 URL
        var dataId = $(this).data('id') || null; // 獲取數據 ID（如果有）

        // 發送 AJAX 請求
        $.ajax({
            url: targetUrl,
            type: 'GET',
            data: { id: dataId }, // 如果沒有 ID，傳遞空值
            success: function (response) {
                // 將返回的模態框 HTML 插入容器中
                $('#cameraModalContainer').html(response);
                // 顯示模態框
                var modal = $('#cameraModalContainer .modal');
                modal.modal('show');
                // 清理舊事件以避免多次綁定
                modal.on('hidden.bs.modal', function () {
                  modal.remove(); // 移除模態框的 DOM 元素，防止累積
                });
            },
            error: function () {
                alert('無法加載內容，請稍後再試！');
            },
        });
    });

    // 專屬於 open-edit-modal 的按鈕點擊事件
    $(document).on('click', '.next-modal', function () {
        var targetUrl = $(this).data('target'); // 獲取目標 URL
        var dataId = $(this).data('id');       // 獲取數據 ID
        var currentModal = $(this).closest('.modal'); // 當前模態框

        // 關閉當前模態框
        currentModal.modal('hide');

        // AJAX 請求加載目標模態框
        $.ajax({
            url: targetUrl,
            type: 'GET',
            data: { id: dataId },
            success: function (response) {
                // 插入返回的模態框 HTML
                $('#cameraModalContainer').html(response);

                // 顯示新的模態框
                var newModal = $('#cameraModalContainer .modal');
                newModal.modal('show');

                // 清理舊事件，避免重複綁定
                newModal.on('hidden.bs.modal', function () {
                    newModal.remove(); // 移除 DOM，防止累積
                });
            },
            error: function () {
                alert('無法加載內容，請稍後再試！');
            },
        });
    });

    // 更新提示
    $(document).on('submit', '#updateForm', function (e) {
        e.preventDefault(); // 防止默認表單提交行為

        $.ajax({
            url: 'camera_edit.php',
            type: 'POST',
            data: $(this).serialize(), // 序列化表單數據
        });
    });


    // 自定義關閉模態框
    $(document).on('click', '.close-modal', function () {
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

      <!-- Include Bootstrap and jQuery -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // 當按鈕被點擊時
            $('#openModal').click(function () {
                // 顯示模態框
                $('#imagesModal').modal('show');
                // 使用 AJAX 加載內容
                $.ajax({
                    url: 'images_create.php',
                    method: 'GET',
                    success: function (data) {
                        $('#modalContent').html(data); // 將回應插入模態框
                    },
                    error: function () {
                        $('#modalContent').html('<p class="text-danger">無法載入內容，請稍後再試。</p>');
                    }
                });
            });
        });
    </script>
</body>

</html>
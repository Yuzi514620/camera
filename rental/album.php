<?php
require_once("../db_connect.php");  // 資料庫連接

$title="媒體庫管理";

// 確認資料庫連接是否成功
if ($conn->connect_error) {
  die("資料庫連接失敗: " . $conn->connect_error);
}

// 分頁設定
$items_per_page = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page);  // 確保頁數不小於 1
$offset = ($page - 1) * $items_per_page;

// 搜尋設定
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where_clause = '';
if (!empty($search)) {
    $search_escaped = $conn->real_escape_string($search);
    $where_clause = "WHERE name LIKE '%$search_escaped%' OR description LIKE '%$search_escaped%'";
}

// 更新查詢
$sql = "SELECT * FROM images $where_clause ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";

// 查詢資料數量
$count_sql = "SELECT COUNT(*) AS total FROM images $where_clause";
$count_result = $conn->query($count_sql);
$total_items = $count_result->fetch_assoc()['total'] ?? 0; // 確保有默認值
$total_pages = ceil($total_items / $items_per_page);

// 查詢資料
$sql = "SELECT * FROM images $where_clause ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
$result = $conn->query($sql);
$rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : []; // 確保有默認值

// 確保變數初始化，避免未定義錯誤
$modalPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$modalPage = max(1, $modalPage); // 確保頁數最小為 1

$totalPages = $total_pages ?? 1; // 確保總頁數有默認值

// 設定分頁範圍
$visiblePages = 5; // 最大顯示頁碼數量
$startPage = max(1, $modalPage - floor($visiblePages / 2));
$endPage = min($totalPages, $startPage + $visiblePages - 1);

// 確保顯示固定範圍的頁碼
if ($endPage - $startPage + 1 < $visiblePages) {
    $startPage = max(1, $endPage - $visiblePages + 1);
}


?>
<div class="modal-xl modal fade" id="cameraModal<?= $id ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <!-- 相機名稱 -->
                <h5 class="modal-title"><?=$title?></h5>
                <button type="button" class="close-modal btn btn-borderless text-secondary text-lg m-0" aria-label="Close">
                    <span aria-hidden="true ">&times;</span>
                </button>
            </div>
            <form id="updateForm" method="POST">
                <div class="modal-body">

                    <div class="px-1">
                        <!-- 總數 -->           
                        <div class="py-1">共計 <?=$total_items?> 項目</div>
                        <div class="d-flex justify-content-between align-items-center">          
                            <!-- 搜尋 -->
                            <form id="searchForm" action="album.php" method="GET">
                            <div class="input-group">
                                <input type="search" name="search" class="btn btn-light text-start" 
                                        value="<?= htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : '') ?>" 
                                        placeholder="搜尋名稱或描述">
                                <div class="btn-group ps-1">
                                    <button type="submit" class="btn btn-dark" title="搜尋">搜尋</button>
                                    <button type="button" class="btn btn-outline-secondary" id="clearSsearch" title="清除搜尋">清除搜尋</button>
                                </div>
                            </div>
                        </form>
                            <!-- 新增 -->
                            <div>
                            <button id="loadModalButton" class="btn btn-primary">新增圖片</button>

                            </div>
                        </div>
                    </div>

  
                    <!-- 圖片列表 -->
                    <div class="row mx-2 my-3" id="imageContainer">
                        <?php if (empty($rows)): ?>
                            <p class="text-center">目前沒有圖片資料。</p>
                        <?php else: ?>
                            <?php foreach ($rows as $row): ?>
                            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                            <div class="card p-1" style="height: 190px;">
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
                        <ul class="tinyPages pagination justify-content-center">
                            <!-- 首頁 -->
                            <li class="page-item <?= $modalPage == 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="album.php?page=1&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                                    <i class="fa-solid fa-angles-left"></i>
                                </a>
                            </li>

                            <!-- 上一頁 -->
                            <li class="page-item <?= $modalPage <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="album.php?page=<?= max(1, $modalPage - 1) ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                                    <i class="fa-solid fa-angle-left"></i>
                                </a>
                            </li>

                            <!-- 中間頁碼 -->
                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <li class="page-item <?= $i == $modalPage ? 'active' : '' ?>">
                                    <a class="page-link" href="album.php?page=<?= $i ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- 下一頁 -->
                            <li class="page-item <?= $modalPage >= $totalPages ? 'disabled' : '' ?>">
                                <a class="page-link" href="album.php?page=<?= min($totalPages, $modalPage + 1) ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </a>
                            </li>

                            <!-- 末頁 -->
                            <li class="page-item <?= $modalPage == $totalPages ? 'disabled' : '' ?>">
                                <a class="page-link" href="album.php?page=<?= $totalPages ?>&search=<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                                    <i class="fa-solid fa-angles-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>


                <div class="modal-footer d-flex justify-content-between align-items-center">
                    <div>                        
                        <button type="submit" class="btn btn-primary">儲存</button>
                        <button type="button" 
                                class="btn btn-primary next-modal"
                                data-id="<?= $id ?>" 
                                data-target="camera_edit.php">返回
                        </button>
                    </div>
                </div>                    
            </form>
        </div>
    </div>
</div>


   <div id="albumModalContainer"></div>

  </main>
  





  <script>
// album 搜尋
  $(document).on('submit', '#searchForm', function (e) {
    e.preventDefault(); // 阻止表單默認提交
    const form = $(this);
    const url = form.attr('action'); // 取得目標 URL
    const formData = form.serialize(); // 序列化表單數據

    // 發送 AJAX 請求
    $.ajax({
        url: url,
        method: 'GET',
        data: formData,
        success: function (data) {
            // 更新列表內容
            $('#listContainer').html($(data).find('#listContainer').html());
            $('.tinyPages').html($(data).find('.tinyPages').html());
        },
        error: function () {
            alert('搜尋失敗，請稍後再試。');
        }
    });
});
</script>


<script>
// album 清空搜尋
$(document).on('click', '.btn-clear-search', function (e) {
    e.preventDefault(); // 阻止默認行為
    const url = 'camera_list.php'; // 重置到初始頁面

    // 發送 AJAX 請求
    $.ajax({
        url: url,
        method: 'GET',
        success: function (data) {
            // 清空搜尋欄位並刷新內容
            $('#searchForm input[name="search"]').val('');
            $('#listContainer').html($(data).find('#listContainer').html());
            $('.tinyPages').html($(data).find('.tinyPages').html());
        },
        error: function () {
            alert('清空搜尋失敗，請稍後再試。');
        }
    });
});
</script>



<script>
        $(document).on('submit', '#searchForm', function (e) {
            e.preventDefault(); // 阻止默認提交行為
            const form = $(this);
            const url = form.attr('action'); // 獲取表單提交的 URL
            const formData = form.serialize(); // 序列化表單數據

            // 發送 AJAX 請求
            $.ajax({
                url: url,
                method: 'GET', // 確保與後端一致
                data: formData,
                success: function (data) {
                    // 更新圖片容器與分頁導航
                    $('#imageContainer').html($(data).find('#imageContainer').html());
                    $('.tinyPages').html($(data).find('.tinyPages').html());
                },
                error: function () {
                    alert('搜尋失敗，請稍後再試。');
                }
            });
        });
</script>

<script>
    $(document).on('click', '.tinyPages a', function (e) {
    e.preventDefault(); // 防止默認行為
    const url = $(this).attr('href'); // 獲取分頁的 URL

    // 發送 AJAX 請求
    $.ajax({
        url: url,
        method: 'GET',
        success: function (data) {
            // 用返回的 HTML 更新內容
            $('#imageContainer').html($(data).find('#imageContainer').html());
            $('.tinyPages').html($(data).find('.tinyPages').html());
        },
        error: function () {
            alert('分頁載入失敗，請稍後再試。');
        }
    });
});
</script>

<script>
    $(document).on('click', '.clearSsearch', function (e) {
        e.preventDefault(); // 阻止默認行為
        const url = 'album.php'; // 重置為初始狀態的 URL

        // 發送 AJAX 請求
        $.ajax({
            url: url,
            method: 'GET',
            success: function (data) {
                // 清空搜尋欄位並刷新內容
                $('#searchForm input[name="search"]').val('');
                $('#imageContainer').html($(data).find('#imageContainer').html());
                $('.tinyPages').html($(data).find('.tinyPages').html());
            },
            error: function () {
                alert('清空搜尋失敗，請稍後再試。');
            }
        });
    });
</script>

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
    $(document).on('click', '.tinyPages a', function (e) {
    e.preventDefault(); // 阻止默認行為
    const url = $(this).attr('href'); // 獲取分頁的 URL

    // 發送 AJAX 請求
    $.ajax({
        url: url,
        method: 'GET',
        success: function (data) {
            // 更新圖片容器和分頁導航
            $('#imageContainer').html($(data).find('#imageContainer').html());
            $('.tinyPages').html($(data).find('.tinyPages').html());
        },
        error: function () {
            alert('分頁載入失敗，請稍後再試。');
        }
    });
});
</script>
<script>
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
</body>

</html>
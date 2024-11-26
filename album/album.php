<?php
require_once("../db_camera_connect.php");  

// 確認資料庫連接是否成功
if ($conn->connect_error) {
    die("資料庫連接失敗: " . $conn->connect_error);
}

// 分頁設定
$items_per_page = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $items_per_page;

// 搜尋設定
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where_clause = "";
if (!empty($search)) {
    $search_escaped = $conn->real_escape_string($search);
    $where_clause = "WHERE description LIKE '%$search_escaped%'";
}

// 查詢資料數量
$count_sql = "SELECT COUNT(*) AS total FROM images $where_clause";
$count_result = $conn->query($count_sql);
$total_items = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_items / $items_per_page);

// 查詢資料
$sql = "SELECT * FROM images $where_clause ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
$result = $conn->query($sql);

$rows = $result->fetch_all(MYSQLI_ASSOC);
?>
<div class="container my-4">
    <h2>圖片相簿</h2>
    <!-- 搜尋表單 -->
    <form class="d-flex mb-4" id="searchForm" action="" method="get">
        <input type="text" class="form-control me-2" name="search" placeholder="搜尋描述">
        <button class="btn btn-primary" type="submit">搜</button>
    </form>

    <!-- 圖片列表 -->
    <div class="row" id="imageContainer">
        <?php foreach ($rows as $row): ?>
            <div class="col-sm-2 mb-4">
                <div class="card h-100 .card.selected">
                    <img src="upload/<?= htmlspecialchars($row["image_url"], ENT_QUOTES, 'UTF-8') ?>" style="max-height:130px;" class="card-img-top object-fit-contain" alt="<?= htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8') ?>">
                    <div class="card-body text-center">
                        <h6 class="card-title"><?= htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8') ?></h6>
                        <p class="card-text"><?= htmlspecialchars($row["description"], ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- 分頁導航 -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page == 1): ?>
                <li class="page-item active">
                    <a class="page-link" href="#" data-page="1" data-search="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">首頁</a>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link" href="#" data-page="1" data-search="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">首頁</a>
                </li>
            <?php endif; ?>

            <?php
            $visible_pages = 7;
            $middle_pages = $visible_pages - 2;
            $start_page = max(2, $page - floor($middle_pages / 2));
            $end_page = min($total_pages - 1, $start_page + $middle_pages - 1);

            if ($end_page - $start_page + 1 < $middle_pages) {
                $start_page = max(2, $end_page - $middle_pages + 1);
            }

            for ($i = $start_page; $i <= $end_page; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="#" data-page="<?= $i ?>" data-search="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($page == $total_pages): ?>
                <li class="page-item active">
                    <a class="page-link" href="#" data-page="<?= $total_pages ?>" data-search="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">末頁</a>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link" href="#" data-page="<?= $total_pages ?>" data-search="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">末頁</a>
                </li>
            <?php endif; ?>
        </ul>

        <div class="modal-footer">
            <button type="button" title="選擇" class="btn btn-primary " id="selectButton">選擇</button>
            <button type="button" title="關閉" class="btn btn-secondary ms-1" onclick="closeModal()" >關閉</button>
        </div>
    </nav>
</div>
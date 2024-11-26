<?php  
require_once("../db_connect.php");  

// 確認資料庫連接是否成功
if ($conn->connect_error) {
    die("資料庫連接失敗: " . $conn->connect_error);
}

// 分頁設定
$items_per_page = 8;
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
<!doctype html>  
<html lang="en">  
<head>  
    <title>上傳圖片</title>  
    <meta charset="utf-8" />  
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />  
</head>  
<body>  
<div class="container my-4">  
        <h1>上傳多張圖片</h1>  
        <form id="uploadForm" action="doUpload2.php" method="post" enctype="multipart/form-data">  
            <div class="mb-2">  
                <label for="type" class="form-label">類型</label>  
                <input type="text" class="form-control" name="type" required>  
            </div>  
            <div class="mb-2">  
                <label for="description" class="form-label">描述</label>  
                <textarea class="form-control" name="description" rows="3"></textarea>  
            </div>  
            <div id="fileInputsContainer" class="mb-2">  
                <div class="row mb-2">  
                    <div class="col">  
                        <label for="myFile" class="form-label">選擇檔案</label>  
                        <input type="file" class="form-control" name="myFile[]" accept="image/*" required multiple>  
                    </div>  
                </div>  
            </div>  
            <button type="button" id="addFileInput" class="btn btn-secondary">新增檔案名稱</button>  
            <button class="btn btn-primary" type="submit">送出</button>  
        </form>  
        <hr>  
        <h2>圖片相簿</h2>
        <!-- 搜尋表單 -->
        <form class="d-flex mb-4" id="searchForm" action="" method="get">
            <input type="text" class="form-control me-2" name="search" placeholder="搜尋描述">
            <button class="btn btn-primary" type="submit">搜</button>
        </form>

        <table class="table table-bordered">  
            <thead>  
                <tr>  
                    <th>圖片</th>  
                    <th>名稱</th>  
                    <th>類型</th>  
                    <th>描述</th>  
                    <th>上傳時間</th>  
                </tr>  
            </thead>  
            <tbody>  
                <?php foreach ($rows as $row): ?>  
                <tr>  
                    <td>  
                        <div class="ratio ratio-1x1">  
                            <img class="object-fit-contain" src="upload/<?= htmlspecialchars($row["image_url"], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8') ?>">  
                        </div>  
                    </td>  
                    <td><?= htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8') ?></td>  
                    <td><?= htmlspecialchars($row["type"], ENT_QUOTES, 'UTF-8') ?></td>  
                    <td><?= htmlspecialchars($row["description"], ENT_QUOTES, 'UTF-8') ?></td>  
                    <td><?= htmlspecialchars($row["created_at"], ENT_QUOTES, 'UTF-8') ?></td>  
                </tr>  
                <?php endforeach; ?>  
            </tbody>  
        </table>  
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
        </nav>
    </div>

    <script>  
        document.getElementById('addFileInput').addEventListener('click', function() {  
            const inputContainer = document.createElement('div');  
            inputContainer.classList.add('row', 'mb-2');  
            inputContainer.innerHTML = `  
                <div class="col">  
                    <label class="form-label">檔案名稱</label>  
                    <input type="text" class="form-control" name="fileName[]" placeholder="檔案名稱">  
                </div>  
            `;  
            document.getElementById('fileInputsContainer').appendChild(inputContainer);  
        });  
    </script>  
</body>  
</html>  
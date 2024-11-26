<?php
require_once("db_connect.php");

// 確認資料庫連接是否成功  
if ($conn->connect_error) {
    die("資料庫連接失敗: " . $conn->connect_error);
}

$sql = "SELECT * FROM image ORDER BY id DESC";
$result = $conn->query($sql);

if ($result === false) {
    die("SQL 查詢失敗: " . $conn->error);
}

$rows = $result->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
    <title>上傳圖片</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <?php include("../css.php") ?>
</head>

<body>
    <div class="container my-4">
        <div class="py-2">
            <a href="product.php" class="btn btn-primary" title="回商品管理"><i class="fa-solid fa-left-long"></i></a>
        </div>
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
        <h2>圖片列表</h2>
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
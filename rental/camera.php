<?php
require_once("../db_connect.php");

// 檢查是否提供 id
if (!isset($_GET["id"])) {
    echo "請從選單檢視";
    exit;
}

$id = intval($_GET["id"]); // 確保 id 是數字

// 定義 $whereClause
$whereClause = "camera.id = $id";

// 設定分頁參數
$items_per_page = 10; // 每頁顯示的項目數
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1; // 確保頁數大於等於 1
$offset = ($currentPage - 1) * $items_per_page; // 計算偏移量

// 查詢相機清單
$sql = "SELECT camera.*, images.name AS image_name, images.description AS image_description, 
        images.type AS image_type, images.image_url
        FROM camera
        JOIN images ON camera.image_id = images.id
        WHERE $whereClause
        ORDER BY camera.id DESC
        LIMIT $items_per_page OFFSET $offset";

$result = $conn->query($sql);
$cameras = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

if (empty($cameras)) {
    echo "找不到相機資料";
    exit;
}

// 顯示資料
?>


<div class="container">
  <div class="py-2 text-end">
      <a href="users.php" class="btn btn-dark" title="回使用者列表"><i class="fa-solid fa-right-to-bracket"></i></a>
  </div>

  <table class="table table-bordered">
      <?php foreach ($cameras as $camera): ?>
      <tr>
        <div class="d-flex px-2 py-1">
          <img src="../album/upload/<?= htmlspecialchars($camera['image_url']) ?>" 
            class="avatar avatar-sm me-3 border-radius-lg"
            while="auto" height="300px"
            alt="<?= htmlspecialchars($camera['image_name']) ?>" />
        </div>
      </tr>
      <tr>
          <th>規格</th>
          <td><?= htmlspecialchars($camera['image_description']) ?></td>
      </tr>
      <tr>
          <th>租金</th>
          <td><?= htmlspecialchars($camera['fee']) ?></td>
      </tr>
      <tr>
          <th>押金</th>
          <td><?= htmlspecialchars($camera['deposit']) ?></td>
      </tr>
      <tr>
          <th>庫存</th>
          <td><?= htmlspecialchars($camera['stock']) ?></td>
      </tr>
      <?php endforeach; ?>
  </table>
  <a href="user-edit.php?id=<?=$id?>" class="btn btn-dark" title="修改資料"><i class="fa-solid fa-pen-to-square"></i></a>
</div>
<?php
require_once("../db_connect.php");

// 大標
$title = "租借列表";

// 撈
$imgSql = "SELECT * FROM images";
$resultImg = $conn->query($imgSql);
$images = $resultImg->fetch_all(MYSQLI_ASSOC);

// 重組
$imageArr = [];
foreach ($images as $image) {
    $imageArr[$image["id"]] = $image["name"];

}

$whereClause = "1=1";

// 可用 name 或 description 搜尋
if (isset($_GET["search"])) {
    $search = $conn->real_escape_string($_GET["search"]); // 防止 SQL 注入
    $whereClause .= " AND (images.name LIKE '%$search%' OR images.description LIKE '%$search%')";
    $title = "搜尋結果：$search";
} elseif (isset($_GET["min"]) && isset($_GET["max"]) && is_numeric($_GET["min"]) && is_numeric($_GET["max"])) {
    $min = (int) $_GET["min"];
    $max = (int) $_GET["max"];
    $whereClause .= " AND .id BETWEEN $min AND $max"; // 根據你的需求修改這條件
} elseif (isset($_GET["image"])) {
    $image_id = (int) $_GET["image"];
    if (isset($imageArr[$image_id])) { // 檢查 image_id 是否有效
        $title = "Kind : " . $imageArr[$image_id];
        $whereClause .= " AND images.id = $image_id";
    } else {
        $title = "Unknown Image";
    }
}

// 搜尋
$sql = "SELECT camera.*, images.name AS image_name, images.description AS image_description, images.type AS image_type, images.image_url
        FROM camera
        JOIN images ON camera.image_id = images.id
        WHERE $whereClause";

$result = $conn->query($sql);
$camerasCount = $result->num_rows;
$cameras = $result->fetch_all(MYSQLI_ASSOC);

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
    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0 rounded-top">
                <table class="table align-items-center mb-0">
                  <thead class="bg-gradient-dark">
                    <tr>
                      <th class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        選擇</th>
                      <th class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        產品</th>
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
                      <!-- 產品 -->
                      <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0"><?= htmlspecialchars($camera['image_name']) ?></p>
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
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  <?php include("script.php") ?>

</body>

</html>
<?php
require_once("../db_connect.php");

$title = "狀態";

// 檢查是否提供 id
if (!isset($_GET["id"])) {
    echo "未提供正確的 ID";
    exit;
}

$id = intval($_GET["id"]); // 確保 id 是數字
$sql = "SELECT camera.*, image.name AS image_name, image.description AS image_description, 
        image.type AS image_type, image.image_url
        FROM camera
        JOIN image ON camera.image_id = image.id
        WHERE camera.id = $id";

$result = $conn->query($sql);
if ($result && $camera = $result->fetch_assoc()) {

?>

<div class="modal fade" id="cameraModal<?= $id ?>" data-id="<?= $camera['id'] ?>" tabindex="-1" role="dialog">
    <div div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <!-- 相機名稱 -->
                <h5 class="modal-title"><?=$title?></h5>
                <button type="button" class="modalClose btn btn-borderless text-secondary text-lg m-0" aria-label="Close">
                <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- 相機狀態 -->
                <div class="container">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="../album/upload/<?= htmlspecialchars($camera['image_url']) ?>" 
                            class="me-3 border-radius-lg p-1"
                            height="255px" style="width: 100%; object-fit: contain;"
                            alt="<?= htmlspecialchars($camera['image_name']) ?>" />
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>名稱</th>
                            <td><?= htmlspecialchars($camera['image_name']) ?></td>
                        </tr>
                        <tr>
                            <th>規格</th>
                            <td><?= htmlspecialchars($camera['image_description']) ?> / <?= htmlspecialchars($camera['image_type']) ?></td>
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
                    </table>
                </div>
            </div>
            <div class="modal-footer">
   
                <!-- 按鈕用於打開 camera_edit.php -->
                <button type="button" 
                        class="btn btn-primary modalChange" 
                        data-id="<?= $camera['id'] ?>" 
                        data-target="camera_edit.php">編輯
                </button>
            </div>
        </div>
    </div>
</div>
<?php
} else {
    echo "找不到相機資料";
}
?>



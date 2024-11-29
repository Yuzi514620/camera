<?php
require_once("../db_connect.php");

$title = "編輯";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $fee = intval($_POST['fee']);
    $deposit = intval($_POST['deposit']);
    $stock = intval($_POST['stock']);

    // 確保有正確的 ID
    if ($id > 0) {
        $sql = "UPDATE camera SET fee = ?, deposit = ?, stock = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iiii', $fee, $deposit, $stock, $id);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            http_response_code(200); // 成功
        } else {
            http_response_code(400); // 無改動或失敗
        }
    } else {
        http_response_code(400); // 無效 ID
    }
    exit;
}

// 檢查是否提供 id
if (!isset($_GET["id"])) {
    echo "未提供正確的 ID";
    exit;
}
$id = intval($_GET["id"]); // 確保 id 是數字
$sql = "SELECT camera.*, images.name AS image_name, images.description AS image_description, 
        images.type AS image_type, images.image_url
        FROM camera
        JOIN images ON camera.image_id = images.id
        WHERE camera.id = $id";

$result = $conn->query($sql);
if ($result && $camera = $result->fetch_assoc()) {

?>

<div class="modal fade" id="cameraModal<?= $id ?>" tabindex="-1" role="dialog">
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
                    <!-- 相機狀態 -->
                    <div class="container">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="../album/upload/<?= htmlspecialchars($camera['image_url']) ?>" 
                                class="me-3 border-radius-lg p-1"
                                height="255px" style="width: 100%; object-fit: contain;"
                                alt="<?= htmlspecialchars($camera['image_name']) ?>" />
                        </div>

                            <table class="table table-bordered">
                                <input type="hidden" name="id" value="<?= $id ?>">
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
                                        <td><input type="number" class="form-control p-0" name="fee" value="<?= htmlspecialchars($camera['fee']) ?>"></td>
                                    </tr>
                                    <tr>
                                        <th>押金</th>
                                        <td><input type="number" class="form-control p-0" name="deposit" value="<?= htmlspecialchars($camera['deposit']) ?>"></td>
                                    </tr>
                                    <tr>
                                        <th>庫存</th>
                                        <td><input type="number" class="form-control p-0" name="stock" value="<?= htmlspecialchars($camera['stock']) ?>"></td>
                                    </tr>                        
                            </table>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between align-items-center">
                    <div>
                        <button type="button" 
                                class="btn btn-info" 
                                data-toggle="modal" 
                                data-id="<?= $albumId ?>" 
                                data-target="album.php">更換圖片
                        </button>
                    </div>
                    <div>                        
                        <button type="submit" class="btn btn-primary">儲存</button>
                        <button type="button" 
                                class="btn btn-primary next-modal"
                                data-id="<?= $id ?>" 
                                data-target="camera.php">返回
                        </button>
                    </div>
                </div>                    
            </form>
        </div>
    </div>
</div>
<?php
} else {
    echo "找不到相機資料";
}
?>



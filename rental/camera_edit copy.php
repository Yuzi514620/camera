<?php
require_once("../db_connect.php");

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
        <h5 class="modal-title"><input type="text" class="form-control" name="stock" value="<?= htmlspecialchars($camera['image_type']) ?>"></h5>
        <button type="button" class="close-modal btn btn-borderless text-secondary text-lg m-0" aria-label="Close">
          <span aria-hidden="true ">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- 相機狀態 -->
        <div class="container">
            <div class="d-flex justify-content-center align-items-center">
                <img src="../album/upload/<?= htmlspecialchars($camera['image_url']) ?>" 
                    class="me-3 border-radius-lg"
                    while="auto" height="300px"
                    alt="<?= htmlspecialchars($camera['image_name']) ?>" />
            </div>
            <table class="table table-bordered">
                <tr>
                    <th>規格</th>
                    <td><input type="text" class="form-control" name="stock" value="<?= htmlspecialchars($camera['image_description']) ?>"></td>
                </tr>
                <tr>
                    <th>租金</th>
                    <td><input type="number" class="form-control" name="stock" value="<?= htmlspecialchars($camera['fee']) ?>"></td>
                </tr>
                <tr>
                    <th>押金</th>
                    <td><input type="number" class="form-control" name="stock" value="<?= htmlspecialchars($camera['deposit']) ?>"></td>
                </tr>
                    <th>庫存</th>
                    <td><input type="number" class="form-control" name="stock" value="<?= htmlspecialchars($camera['stock']) ?>"></td>
                </tr>
            </table>
        </div>

    </div>
    <div class="modal-footer">
        <div>
            <button type="submit" class="btn btn-dark" title="確定修改"><i class="fa-solid fa-fw fa-file-pen"></i></button>
            <a href="camera.php?id=<?=$camera['id']?>" class="btn btn-dark" title="返回相機狀態"><i class="fa-solid fa-fw fa-rotate-left"></i></a>
            <a href="" class="btn btn-danger"><i class="fa-solid fa-fw fa-user-xmark"></i></a>
        </div>

      </div>
    </div>
  </div>
</div>
<?php
} else {
    echo "找不到相機資料";
}
?>



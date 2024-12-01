<?php
// 連接資料庫
require_once("../db_connect.php");

$title = "新增相機";

// 檢查資料庫連接是否成功
if (!$conn) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

// 取得所有 image 資料
$sql_images = "SELECT id, name, type, description, image_url FROM images";
$result_images = $conn->query($sql_images);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 獲取來自表單的資料
    $fee = intval($_POST['fee']);
    $deposit = intval($_POST['deposit']);
    $stock = intval($_POST['stock']);
    $image_id = intval($_POST['image_id']);

    // 插入新的 camera 資料，並設置 is_deleted 為 1
    $sql_insert = "INSERT INTO camera (fee, deposit, stock, image_id, is_deleted) VALUES (?, ?, ?, ?, 1)";
    $stmt = $conn->prepare($sql_insert);
    if ($stmt) {
        $stmt->bind_param("iiii", $fee, $deposit, $stock, $image_id);

        if ($stmt->execute()) {
            echo "Camera 資料新增成功";
            header("Location: camera_list.php");
        } else {
            echo "錯誤: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "錯誤: 無法準備 SQL 語句 - " . $conn->error;
    }

    $conn->close();
    exit;
}
?>
<!-- 模態框 -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="exampleModalLabel"><?=$title?></h5>
                    <button type="button" class="btn-close btn btn-borderless text-secondary text-lg m-0" data-bs-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </button>
                </div>
                <div class="modal-body">
                    <!-- 這裡的內容可以是不同的 -->
                    <?php if ($_SERVER['REQUEST_METHOD'] != 'POST') { ?>
                    <form method="POST" action="camera_create.php">
                    <table class="table table-bordered">
                            <tr>
                                <th><label for="image_id">選擇圖片</label></th>
                                <td>
                                    <select id="image_id" name="image_id" style="width:100%" onchange="showImage()" required>
                                        <?php
                                        if ($result_images && $result_images->num_rows > 0) {
                                            while ($row = $result_images->fetch_assoc()) {
                                                echo "<option value='" . $row['id'] . "'>" . $row['name'] . " (" . $row['type'] . ") ". "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>沒有可用的圖片</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="fee">租金</label></th>
                                <td><input type="number" id="fee" name="fee" class="form-control p-0" required></td>
                            </tr>
                            <tr>
                                <th><label for="deposit">押金</label></th>
                                <td><input type="number" id="deposit" name="deposit" class="form-control p-0" required></td>
                            </tr>
                            <tr>
                                <th><label for="stock">庫存</label></th>
                                <td><input type="number" id="stock" name="stock" class="form-control p-0" required></td>
                            </tr>  
                        </table>
                        <div class="modal-footer pb-0">
                            <button type="submit" class="btn btn-primary">新增</button>
                        </div>
                    </form>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var myModal = document.getElementById('exampleModal');
    myModal.addEventListener('show.bs.modal', function (event) {
        // 在這裡你可以用 AJAX 從伺服器獲取資料並顯示在模態框中
        fetch('camera_details.php')
            .then(response => response.text())
            .then(data => {
                document.querySelector('#exampleModal .modal-content').innerHTML = data;
            });
    });
});
</script>
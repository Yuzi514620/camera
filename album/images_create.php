<?php
require_once("../db_connect.php");

$title = "上傳圖片";

// 檢查資料庫連接
if ($conn->connect_error) {
    die("資料庫連接失敗：" . $conn->connect_error);
}

// 處理非同步請求
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['myFile'])) {
    $name = $_POST['name'] ?? '';
    $type = $_POST['type'] ?? '';
    $description = $_POST['description'] ?? '';
    $files = $_FILES['myFile'];

    $response = [];

    // 允許的副檔名
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    foreach ($files['name'] as $index => $originalFileName) {
        if ($files['error'][$index] === UPLOAD_ERR_OK) {
            $tmpFilePath = $files['tmp_name'][$index];

            // 取得副檔名
            $extension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

            // 檢查副檔名是否允許
            if (!in_array($extension, $allowedExtensions)) {
                $response[] = ['fileName' => $originalFileName, 'message' => '不支持的檔案格式'];
                continue;
            }

            // 生成新檔案名稱（只使用 name 和副檔名）
            $newFileName = $name . '.' . $extension;
            $destinationPath = "upload/" . $newFileName;

            // 檢查並創建目錄
            if (!is_dir("upload/")) {
                mkdir("upload/", 0777, true);
            }

            // 防止檔案名稱衝突
            $counter = 1;
            while (file_exists($destinationPath)) {
                $newFileName = $name . '_' . $counter . '.' . $extension;
                $destinationPath = "upload/" . $newFileName;
                $counter++;
            }

            // 移動上傳的檔案
            if (move_uploaded_file($tmpFilePath, $destinationPath)) {
                // 插入資料到資料庫
                $stmt = $conn->prepare("INSERT INTO images (name, type, description, image_url, created_at) VALUES (?, ?, ?, ?, NOW())");
                $stmt->bind_param("ssss", $name, $type, $description, $newFileName);

                if ($stmt->execute()) {
                    $response[] = ['fileName' => $newFileName, 'message' => '上傳成功'];
                } else {
                    $response[] = ['fileName' => $newFileName, 'message' => '無法保存到資料庫'];
                }
            } else {
                $response[] = ['fileName' => $originalFileName, 'message' => '無法移動檔案'];
            }
        } else {
            $response[] = ['fileName' => $originalFileName, 'message' => '上傳失敗'];
        }
    }

    // 返回 JSON 響應
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'data' => $response]);
    exit;
}

// 撈取現有資料（可選）
$sql = "SELECT * FROM images";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
?>



<!-- 模態框 -->



<div class="modal fade" id="imagesModal" tabindex="-1" aria-labelledby="imagesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title"><?= htmlspecialchars($title) ?></h5>
                <button type="button" class="modalClose btn btn-borderless text-secondary text-lg m-0" aria-label="Close">
                    <span aria-hidden="true ">&times;</span>
                </button>
            </div>
            <form method="POST" enctype="multipart/form-data" action="images_create.php">
            <!-- <form id="uploadForm" method="post" enctype="multipart/form-data"> -->
                <div class="modal-body">
                    <!-- 資料填寫 -->
                    <div class="container">


                        <table class="table table-bordered">
                            <tr>
                                <th><label for="name" class="form-label">名稱</label></th>
                                <td><input type="text" class="form-control p-0" name="name" required></td>
                            </tr>
                            <tr>
                                <th><label for="type" class="form-label">類型</label></th>
                                <td><input type="text" class="form-control p-0" name="type" required></td>
                            </tr>

                            <tr>
                                <th><label for="description" class="form-label">描述</label></th>
                                <td><textarea class="form-control p-0" name="description" rows="3"></textarea></td>
                            </tr>
                            <tr>
                                <th><label for="myFile" class="form-label">選擇檔案</label></th>
                                <td><input type="file" class="form-control p-0" name="myFile[]" accept="image/*" required multiple></td>
                            </tr>                     
                        </table>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="submit" class="btn btn-primary">送出</button>
                </div>                    
            </form>
        </div>
    </div>
</div>


<!-- 單獨打開上傳 -->

<!-- <script>
document.getElementById('uploadForm').addEventListener('submit', function (event) {
    event.preventDefault(); // 阻止表單的默認提交行為

    const formData = new FormData(this); // 獲取表單數據

    fetch('', { // 發送請求到同一頁面
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('上傳成功');
                // 重置表單
                document.getElementById('uploadForm').reset();
            } else {
                alert('上傳失敗：' + data.message);
            }
        })
        .catch(error => {
            alert('上傳過程中出現錯誤');
            console.error(error);
        });
});
</script> -->

<!-- modal 專用 -->
<script>
    $(document).on('submit', '#imagesModal form', function (e) {
    e.preventDefault(); // 阻止默認提交行為
    var formData = new FormData(this);

    $('#submitButton').prop('disabled', true);

    $.ajax({
        url: 'images_create.php', // 確保與表單 action 一致
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            alert('圖片上傳成功！');
            location.reload();
            $('#imagesModal').modal('hide');
        },
        error: function () {
            alert('上傳過程中出現錯誤');
        }
    });
});
</script>

<?php
require_once("../db_connect.php");  // 資料庫連接

$title="媒體庫管理";

// 確認資料庫連接是否成功

// 撈資料庫
$sql = "SELECT * FROM images";
$result = $conn->query($sql);

include("/link.php");
?>


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
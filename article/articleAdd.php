<?php
require_once("./pdo_connect_camera.php");  
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {  
    // 撈取 article_category 資料表的資料  
    $sql = "SELECT id, name FROM article_category";  
    $stmt = $pdo->query($sql);  
    $categories = $stmt->fetchAll();  
} catch (PDOException $e) {  
    echo "資料撈取失敗: " . $e->getMessage();  
}  

// 獲取錯誤訊息和之前輸入的數據
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

// 清除錯誤訊息和舊數據
unset($_SESSION['errors'], $_SESSION['old']);
?>  


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link
    rel="apple-touch-icon"
    sizes="76x76"
    href="../assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
  <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <style>
    .add-title{
      border-radius: 10px 10px 0 0;
    }
    .ck-editor__editable_inline {
      min-height: 400px ;
      height:auto ;
    }
    .warning-message {
    color: red;
    margin-top: 10px;
    animation: shake 0.5s;
}

@keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    50% { transform: translateX(5px); }
    75% { transform: translateX(-5px); }
    100% { transform: translateX(0); }
}
  </style>
  <title>camera_articleAdd</title>
  <!--     Fonts and icons     -->
  <link
    rel="stylesheet"
    type="text/css"
    href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Material Icons -->
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link
    id="pagestyle"
    href="../assets/css/material-dashboard.css?v=3.2.0"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
		<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
</head>

<body class="g-sidenav-show bg-gray-100">
   <!-- 側邊欄 -->
    <?php $page = 'article.php'; ?>
    <?php include 'sidebar.php'; ?>
  <!-- 側邊欄 -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3 justify-content-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
              <a class="opacity-5 text-dark" href="javascript:;">Pages</a>
            </li>
            <li class="breadcrumb-item text-sm">
              <a class="opacity-5 text-dark" href="article.php">文章列表</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
              新增文章
            </li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <!-- 添加 ms-auto 將內容推向右側 -->
          <ul class="navbar-nav d-flex align-items-center justify-content-end ms-auto">
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item d-flex align-items-center">
              <a href="../pages/sign-in.php" class="nav-link text-body font-weight-bold px-0">
                <i class="fa-solid fa-circle-user"></i>
              </a>
            </li>
            <li class="nav-item d-flex align-items-center ms-3">
              <a href="../pages/sign-in.php" class="nav-link text-body font-weight-bold px-0">
                <i class="fa-solid fa-right-from-bracket"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
   <!-- Navbar -->

    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <table class="table align-items-center mb-0">
              <thead class="bg-gradient-dark">
                <tr>
                  <th class="bg-dark text-left text-uppercase text-xl text-white add-title"  colspan="8">
                    新增文章
                  </th>
                </tr>
              </thead>
            </table>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0 rounded-top">
                  <form action="doAdd.php" method="post" id="articleForm">
                    <!-- 隱藏的 ID 欄位 -->
                    <input type="hidden" name="id" value="<?= htmlspecialchars($article['id']) ?>">

                    <div class="container mt-3">
                        <!-- 文章類別選擇 -->
                        <div class="d-flex my-3">
                            <h5 class="mt-2">文章類別 :</h5>
                            <select class="ms-2" style="border-radius:5px" name="category_id" id="category_id" required>
                                <option value="0">選擇分類</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['id']) ?>">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- 標題輸入 -->
                        <div class="input-group mb-1">
                            <div class="input-group-text pe-4">標題</div>
                            <input type="text" name="title" class="form-control border border-secondary rounded ps-4" style="font-size:20px; font-weight:500;" value="<?= htmlspecialchars($old['title'] ?? '') ?>" required>
                        </div>

                        <!-- 內容編輯器 -->
                        <div class="mb-3">
                            <label for="content">內容</label>
                            <textarea name="content" id="content" class="form-control" required><?= htmlspecialchars($old['content'] ?? '') ?></textarea>
                        </div>

                        <!-- 警告訊息 -->  
                        <div id="warning" class="warning-message" style="display: block;">
                        </div>

                        <!-- 送出和返回按鈕 -->
                        <div class="d-flex mt-3">
                            <button type="submit" class="btn btn-sm btn-dark ms-auto me-1 align-content-center btn-send" style="height:45px; border-radius:15px;">送出</button>
                            <a class="btn btn-sm btn-dark align-content-center" style="height:45px; border-radius:15px;" href="article.php">返回</a>
                        </div>
                    </div>
                  </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

<!-- CKEditor 初始化 -->
<script src="https://cdn.ckeditor.com/ckeditor5/43.3.1/classic/ckeditor.js"></script>
<script>
  
    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
            this.uploadUrl = 'upload.php'; // 上傳圖片的 PHP 腳本路徑
        }

        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', this.uploadUrl, true);
                    xhr.responseType = 'json';

                    xhr.onload = () => {
                        const response = xhr.response;

                        if (!response || xhr.status !== 200) {
                            return reject('無法上傳圖片。');
                        }

                        if (response.error) {
                            return reject(response.error);
                        }

                        resolve({
                            default: response.url
                        });
                    };

                    xhr.onerror = () => reject('無法上傳圖片。');
                    xhr.upload.onprogress = evt => {
                        if (evt.lengthComputable) {
                            this.loader.uploadTotal = evt.total;
                            this.loader.uploaded = evt.loaded;
                        }
                    };

                    const formData = new FormData();
                    formData.append('upload', file);
                    xhr.send(formData);
                }));
        }

        abort() {
            // 可選的中止上傳邏輯
        }
    }

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    ClassicEditor
        .create(document.querySelector('#content'), {
            extraPlugins: [MyCustomUploadAdapterPlugin],
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', 'mediaEmbed', 'undo', 'redo', 'imageUpload', 'imageResize'
                ]
            },
            image: {
                toolbar: [
                    'imageStyle:full',
                    'imageStyle:side',
                    'imageStyle:inline',
                    'imageStyle:wrapText',
                    'imageStyle:breakText',
                    '|',
                    'imageTextAlternative',
                    'imageResize'
                ],
                resizeOptions: [
                    {
                        name: 'resizeImage:original',
                        label: '原始大小',
                        value: null
                    },
                    {
                        name: 'resizeImage:50',
                        label: '50%',
                        value: '50'
                    },
                    {
                        name: 'resizeImage:75',
                        label: '75%',
                        value: '75'
                    }
                ],
                resizeUnit: '%'
            },
            licenseKey: '', // 如有 CKEditor 授權密鑰，請填寫
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error(error);
        });
</script>
<script>
// 選取必要的元素
const warning = document.getElementById('warning');
const btnSend = document.querySelector(".btn-send");
const form = document.querySelector("form");
const categorySelect = document.querySelector("[name=category_id]");
const inputTitle = document.querySelector("[name=title]");
const contentInput = document.querySelector("textarea[name='content']");

if (btnSend) {
    btnSend.addEventListener("click", function(event) {  
        event.preventDefault(); // 防止表單默認提交
        let isValid = true;
        let warningMessage = '';

        // 同步 CKEditor 的內容到 textarea 元素
        contentInput.value = window.editor.getData(); 
        // 檢查分類是否選擇
        if (categorySelect.value === "0") {
            isValid = false;
            warningMessage += '請選擇文章類別。<br>';
        }

        // 檢查標題是否填寫
        if (!inputTitle.value.trim()) {
            isValid = false;
            warningMessage += '標題必須填寫。<br>';
        }

        // 檢查內容是否填寫
        if (!contentInput.value.trim()) {
            isValid = false;
            warningMessage += '內容必須填寫。<br>';
        }

        if (!isValid) {
            warning.innerHTML = warningMessage;
            warning.style.display = 'block';
            warning.classList.add('shake');
        } else {
            // warning.style.display = 'none';
            form.submit(); // 提交表單  
        }
    });
}
</script>
  
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
//     let editorInstance;
//     const saveURL = "./doAdd.php";
//     const input1 = document.querySelector("form input");

// if (btnSend) {
//       btnSend.addEventListener("click", function(event) {  
//         event.preventDefault(); // 防止表單默認提交
//         const contentInput = document.querySelector("textarea[name='content']");  // 獲取隱藏字段
//         contentInput.value = window.editor.getData(); // 將編輯器內容填入隱藏字段  
//         form.submit(); // 提交表單  
//       });
//     }
  </script>
<script>
    document.querySelectorAll('.content p').forEach(function(p) {  
        p.style.display = 'none'; // 隱藏所有 <p> 標籤  
    });
</script> 
</body>

</html>


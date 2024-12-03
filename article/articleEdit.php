<?php
require_once("./pdo_connect_camera.php");
try {
  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    // 準備 SQL 語句來根據 id 讀取文章
    $sql = "SELECT * FROM article WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    // 取得文章資料
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($article) {
      $cleanContent = strip_tags($article['content']); // 移除 HTML 標籤
    } else {
      die("找不到這篇文章。");
    }
  } else {
      die("無效的文章 ID。");
  }

} catch (PDOException $e) {
  die("資料庫連接失敗: " . $e->getMessage());
}


try {
  // 撈取 article_category 資料表的資料
  $sql = "SELECT id, name FROM article_category";
  $stmt = $pdo->query($sql);
  $categories = $stmt->fetchAll();
} catch (PDOException $e) {
  echo "資料撈取失敗: " . $e->getMessage();
}

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
    .ck-editor__editable_inline {
      min-height: 400px ;
      height:auto ;
    }

    .Edit-title{
      border-radius: 15px 15px 0 0;
    }
    .btn-back a{
    width: 40px;
    height: 40px;
    border-radius: 50%;
    color: #FFF;

  }
  .btn-back a:hover{
    background: #FFF;
      color: #000;
  }

  .btn-under button{
    width: 50px;
  }
  .btn-under button:hover{
    background: #FFF;
    color:#000;
  }

  .btn-under a:hover{
    background: #FFF;
    color:#dc3545;
  }
  </style>
  <title>camera_articleEdit</title>
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
          <?php
          $breadcrumbs = [
              'users' => '首頁',
              'article' => '文章管理',
              'articleEdit' => '編輯文章',
          ];

          $page = 'articleEdit';

          $breadcrumbLinks = [
              'users' => '../users/users.php',
              'article' => 'article.php',
              'articleEdit' => 'articleEdit.php',
          ];

          include '../navbar.php';
          ?>

    <div class="container-fluid py-2 ">
      <div class="d-flex ps-5 mt-4 btn-back">
          <a class="btn btn-dark align-content-center" href="article.php">
            <i class="fa-solid fa-chevron-left"></i>
          </a>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card my-4" style="border-radius: 15px;">
                <table class="table align-items-center mb-0 input-table">
                  <thead class="bg-gradient-dark input-table">
                    <tr>
                      <th class="bg-dark text-left text-uppercase text-xl text-white Edit-title"  colspan="8">
                        編輯內容
                      </th>
                    </tr>
                  </thead>
                </table>
                <div class="card-body px-0 pb-2">
                  <div class="table-responsive p-0 rounded-top">
                    <form action="doEdit.php" method="post">
                      <!-- 隱藏的 ID 欄位 -->
                      <input type="hidden" name="id" value="<?= htmlspecialchars($article['id']) ?>">

                      <div class="container mt-3">
                          <!-- 文章類別選擇 -->
                          <div class="d-flex my-3">
                              <h5 class="mt-2 font-weight-bold text-md">文章類別 :</h5>
                              <select class="ms-2" style="border-radius:5px" name="category_id" id="category_id" onchange="updateCategory(this.value)" required>
                                  <option value=""> --請選擇分類-- </option>
                                  <?php foreach ($categories as $category): ?>
                                      <option value="<?= htmlspecialchars($category['id']) ?>" <?= $category['id'] == $article['category_id'] ? 'selected' : '' ?>>
                                          <?= htmlspecialchars($category['name']) ?>
                                      </option>
                                  <?php endforeach; ?>
                              </select>
                          </div>

                          <!-- 標題輸入 -->
                          <div class="input-group mb-1">
                              <div class="input-group-text pe-4">標題</div>
                              <input type="text" name="title" class="form-control border border-secondary rounded ps-4" style="font-size:20px; font-weight:500;" value="<?= htmlspecialchars($article["title"]) ?>" required>
                          </div>

                          <!-- 內容編輯器 -->
                          <div class="mb-3">
                              <label for="content">內容</label>
                              <textarea name="content" id="content" class="form-control" required><?= htmlspecialchars($article["content"]) ?></textarea>
                          </div>

                          <!-- 送出和返回按鈕 -->
                          <div class="d-flex mt-3 btn-under">
                              <button type="submit" class="btn btn-sm btn-dark ms-auto me-1 d-flex align-items-center justify-content-center font-weight-bold" style="height:45px; width:45px; border-radius:50%;">送出</button>
                              <a class="btn btn-sm btn-danger d-flex align-items-center justify-content-center font-weight-bold" style="height:45px; width:45px; border-radius:50%;" href="article.php">取消</a>
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
<script type="module" src="path/to/main.js"></script>
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
  
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    let editorInstance;
    const btnSend = document.querySelector(".btn-send");
    const saveURL = "./doEdit.php";
    const inputTitle = document.querySelector("[name=title]");
    const input1 = document.querySelector("form input");
    const form = document.querySelector("form");
    
    

    btnSend.addEventListener("click", function() {  
      const contentInput = document.querySelector("textarea[name='content']");  // 獲取隱藏字段
      contentInput.value = editorInstance.getData(); // 將編輯器內容填入隱藏字段  
      form.submit(); // 提交表單  
    });  

    class MyUploadAdapter {
      constructor(loader) {
        this.loader = loader;
      }

      upload() {
        return this.loader.file
          .then(file => new Promise((resolve, reject) => {
            const data = new FormData();
            data.append('upload', file);

            fetch('upload.php', {
              method: 'POST',
              body: data
            })
              .then(response => response.json())
              .then(data => {
                resolve({
                  default: data.url
                });
              })
              .catch(err => {
                reject(err);
              });
          }));
      }

      abort() {
        // If the user aborts the upload, this method is called.
      }
    }

    function MyCustomUploadAdapterPlugin(editor) {
      editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader);
      };
    }

    ClassicEditor
      .create(document.querySelector('#editor'), {
        extraPlugins: [MyCustomUploadAdapterPlugin]
      })
      .then(editor => {
        editorInstance = editor;
      })
      .catch(error => {
        console.error(error);
      });

  </script>
<script>
    document.querySelectorAll('.content p').forEach(function(p) {  
        p.style.display = 'none'; // 隱藏所有 <p> 標籤  
    });
</script> 
</body>

</html>
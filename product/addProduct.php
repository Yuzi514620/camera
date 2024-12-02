<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<?php
require_once("../db_connect.php");

$sql = "SELECT  
    p.id,  
    p.name AS product_name,  
    i.name AS image_name,  
    i.image_url,  
    p.price,  
    b.brand_name,  
    c.category_name,  
    p.stock,  
    p.state,
    p.created_at,  
    p.updated_at
FROM  
    product p  
INNER JOIN  
    category c ON p.category_id = c.category_id  
INNER JOIN  
    brand b ON p.brand_id = b.brand_id  
INNER JOIN  
    image i ON p.name = i.name  -- 條件：product 的 name 必須匹配 image 的 name  
WHERE  
    p.is_deleted = 0";


$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
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
  <title>camera</title>
  <!--     Fonts and icons     -->
  <link
    rel="stylesheet"
    type="text/css"
    href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script
    src="https://kit.fontawesome.com/42d5adcbca.js"
    crossorigin="anonymous"></script>
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
</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- 側邊欄 -->
  <?php $page = 'product'; ?>
  <?php include '../sidebar.php'; ?>
  <!-- 側邊欄 -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php
    // 設定麵包屑的層級
    $breadcrumbs = [
      'teacher' => '首頁', // 第一層的文字
      'teacher_list' => '商品管理', // 第一層的文字
      'teacher_add' => '新增商品', // 第二層的文字

    ];

    $page = 'teacher_add'; //當前的頁面

    // 設定麵包屑的連結
    $breadcrumbLinks = [
      'teacher' => 'product.php',           // 第一層的連結
      'teacher_list' => 'product.php',      // 第二層的連結
      'teacher_add' => 'addProduct.php',      // 第二層的連結
    ];

    include '../navbar.php';
    ?>
    <!-- Navbar -->

    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0 rounded-top">
                <table class="table table-bordered">
                  <thead class="bg-gradient-dark">
                    <tr>
                      <th
                        class=" text-uppercase text-secondary text-xl opacity-7 text-white" colspan="10">
                        新增商品
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <form class="" action="doaddProduct.php" method="post" enctype="multipart/form-data">
                      <!-- 商品名稱 -->
                      <tr>
                        <td>
                          <label for="name" class="form-label">商品名稱：</label>
                          <input type="text" class="form-control" name="name" placeholder="輸入商品名稱" required>
                        </td>
                      </tr>
                      <!-- 圖片 -->
                      <tr>
                        <td>
                          <!-- <label for="image" class="form-label">上傳圖片：</label> -->
                          <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#uploadImageModal">
                            上傳圖片
                          </button>
                        </td>
                      </tr>
                      <!-- 價格 -->
                      <tr>
                        <td>
                          <label for="price" class="form-label">價格：</label>
                          <input type="number" class="form-control" name="price" placeholder="輸入價格" required>
                        </td>
                      </tr>
                      <!-- 品牌 -->
                      <tr>
                        <td>
                          <label for="brand_id" class="form-label">品牌：</label>
                          <select name="brand_id" id="brand_id" class="form-select border border-dark ps-2">
                            <option value="0">-請選擇品牌-</option>
                            <option value="1">Leica</option>
                            <option value="2">Nikon</option>
                            <option value="3">Sony</option>
                            <option value="4">Hasselblad</option>
                            <option value="5">Canon</option>
                          </select>
                        </td>
                      </tr>
                      <!-- 種類 -->
                      <tr>
                        <td>
                          <label for="category_id" class="form-label">種類：</label>
                          <select name="category_id" id="category_id" class="form-select border border-dark ps-2">
                            <option value="0">-請選擇種類-</option>
                            <option value="1">相機</option>
                            <option value="2">鏡頭</option>
                            <option value="3">配件</option>
                          </select>
                        </td>
                      </tr>
                      <!-- 庫存 -->
                      <tr>
                        <td>
                          <label for="stock" class="form-label">庫存：</label>
                          <input type="number" class="form-control" name="stock" min="0" placeholder="輸入庫存數量" required>
                        </td>
                      </tr>
                      <!-- 規格 -->
                      <tr>
                        <td>
                          <label for="spec" class="form-label">規格：</label>
                          <textarea class="form-control" name="spec" placeholder="輸入規格"></textarea>
                        </td>
                      </tr>
                      <!-- 狀態 -->
                      <tr>
                        <td>
                          <label for="state" class="form-label">狀態:</label>
                          <select class="form-select ps-2" name="state" id="state" required>
                            <option value="上架" selected>上架</option>
                            <option value="下架">下架</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <!-- 預設值為今天 -->
                          <label for="form-label">日期</label>
                          <input type="date" class="form-control" name="created_at" placeholder="選擇日期" value="<?= date('Y-m-d') ?>" min="2020-01-01" max="2030-12-31">
                        </td>
                      </tr>
                      <!-- 提交按鈕 -->
                      <tr>
                        <td class="text-center">
                          <button class="btn btn-dark" type="submit">送出</button>
                          <a class="btn btn-dark" href="product.php">取消</a>
                        </td>
                      </tr>
                    </form>
                  </tbody>
                  <!-- 圖片上傳模態框 -->
                  <div class="modal fade" id="uploadImageModal" tabindex="-1" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="uploadImageModalLabel">上傳圖片</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form id="uploadForm" action="doUpload.php" method="post" enctype="multipart/form-data">
                            <div class="mb-2">
                              <label for="name" class="form-label">圖片名稱</label>
                              <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-2">
                              <label for="myFile" class="form-label">選擇檔案</label>
                              <input type="file" class="form-control" id="fileInput" name="myFile[]" accept="image/*" multiple>
                            </div>
                            <label for="type" class="form-label">類型</label>
                            <select class="form-control" name="type" id="type" required>
                              <option value="" disabled selected hidden>請選擇類型</option>
                              <option value="相機">相機</option>
                              <option value="配件">配件</option>
                              <option value="鏡頭">鏡頭</option>
                            </select>
                            <div id="previewContainer" class="mb-4"></div>
                            <button class="btn btn-dark" type="submit">送出</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!--   Core JS Files   -->
  <script>
    document.getElementById('fileInput').addEventListener('change', function(event) {
      const files = event.target.files;
      const previewContainer = document.getElementById('previewContainer');
      previewContainer.innerHTML = ''; // 清空之前的預覽內容

      Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '150px';
            img.style.height = '150px';
            img.style.marginRight = '10px';
            img.style.objectFit = 'contain';
            previewContainer.appendChild(img);
          };
          reader.readAsDataURL(file);
        }
      });
    });
  </script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
      var options = {
        damping: "0.5",
      };
      Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>



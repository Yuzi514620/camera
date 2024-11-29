<?php
require_once("db_connect.php");

// 確認資料庫連接是否成功  
if ($conn->connect_error) {
    die("資料庫連接失敗: " . $conn->connect_error);
}

$sql = "SELECT * FROM image ORDER BY created_at DESC LIMIT 1";
$result = $conn->query($sql);

if ($result === false) {
    die("SQL 查詢失敗: " . $conn->error);
}

$rows = $result->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
    <title>上傳圖片</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
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
    <?php include("../css.php") ?>

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
          'teacher_aaa' => '上傳圖片', // 第二層的文字
          ];

        $page = 'teacher_aaa';//當前的頁面

        // 設定麵包屑的連結
        $breadcrumbLinks = [
            'teacher' => 'product.php',           // 第一層的連結
            'teacher_list' => 'product.php',      // 第二層的連結
            'teacher_add' => 'addProduct.php',      // 第二層的連結
            'teacher_aaa' => 'up_image.php',      // 第二層的連結
        ];

        include '../navbar.php';
        ?>
        <!-- Navbar -->

        <div class="container my-4">
            <div class="py-2">
                <a href="addProduct.php" class="btn btn-dark" title="回商品管理"><i class="fa-solid fa-left-long"></i></a>
            </div>
            <h1>上傳圖片</h1>
            <form id="uploadForm" action="doUpload.php" method="post" enctype="multipart/form-data">
                <div class="mb-2">
                    <div class="mb-2">
                        <label for="name" class="form-label">圖片名稱</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="mb-2">
                        <label for="myFile" class="form-label">選擇檔案</label>
                        <input type="file" class="form-control" id="fileInput" name="myFile[]" accept="image/*" multiple required>
                    </div>
                    <label for="type" class="form-label">類型</label>
                    <select class="form-control" name="type" id="type" required>
                        <option value="" disabled selected>請選擇類型</option>
                        <option value="相機">相機</option>
                        <option value="配件">配件</option>
                        <option value="鏡頭">鏡頭</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="description" class="form-label">描述</label>
                    <textarea class="form-control" name="description" rows="3"></textarea>
                </div>
                <div id="previewContainer" class="mb-4"></div>
                <button class="btn btn-dark" type="submit">送出</button>
            </form>
        </div>
    </main>
    <script>
        // 監聽檔案選擇事件
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
                        img.style.width = '300px';
                        img.style.height = '300px';
                        img.style.marginRight = '10px';
                        img.style.objectFit = 'contain';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
    <!--   Core JS Files   -->
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

<!--  -->
<?php
require_once("db_connect.php");

// 確認資料庫連接是否成功  
if ($conn->connect_error) {
    die("資料庫連接失敗: " . $conn->connect_error);
}

$sql = "SELECT * FROM image ORDER BY id DESC";
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
                            <a class="opacity-5 text-dark" href="javascript:;">商品管理</a>
                        </li>
                        <li class="breadcrumb-item text-sm">
                            <a class="opacity-5 text-dark" href="javascript:;">新增商品</a>
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                            上傳圖片
                        </li>
                    </ol>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <!-- 添加 ms-auto 將內容推向右側 -->
                    <ul class="navbar-nav d-flex align-items-center justify-content-end ms-auto">
                        <li class="mt-1">
                            <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard"
                                data-icon="octicon-star" data-size="large" data-show-count="true"
                                aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0">
                                <i class="material-symbols-rounded fixed-plugin-button-nav">settings</i>
                            </a>
                        </li>
                        <li class="nav-item dropdown pe-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="material-symbols-rounded">notifications</i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                                <!-- 通知內容 -->
                            </ul>
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

        <div class="container my-4">
        <div class="py-2">
            <a href="addProduct.php" class="btn btn-dark" title="回商品管理"><i class="fa-solid fa-left-long"></i></a>
        </div>
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
            <button class="btn btn-dark" type="submit">送出</button>
        </form>
        <hr>
        <h2>圖片列表</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>圖片</th>
                    <th>名稱</th>
                    <th>類型</th>
                    <th>描述</th>
                    <th>上傳時間</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td>
                            <div class="ratio ratio-1x1">
                                <img class="object-fit-contain" src="../album/upload/<?= htmlspecialchars($row["image_url"], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8') ?>">
                            </div>
                        </td>
                        <td><?= htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row["type"], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row["description"], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row["created_at"], ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </main>
    <script>
        document.getElementById('addFileInput').addEventListener('click', function() {
            const inputContainer = document.createElement('div');
            inputContainer.classList.add('row', 'mb-2');
            inputContainer.innerHTML = `  
                <div class="col">  
                    <label class="form-label">檔案名稱</label>  
                    <input type="text" class="form-control" name="fileName[]" placeholder="檔案名稱">  
                </div>  
            `;
            document.getElementById('fileInputsContainer').appendChild(inputContainer);
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
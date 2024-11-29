<?php
require_once("db_connect.php");

if (!isset($_GET["id"])) {
    echo "請帶入 id 到此頁";
    exit;
}
$id = $_GET["id"];

$sql = "SELECT 
    product.*, 
    brand.brand_name, 
    category.category_name
FROM 
    product
INNER JOIN 
    brand 
ON 
    product.brand_id = brand.brand_id
INNER JOIN 
    category 
ON 
    product.category_id = category.category_id
WHERE 
    product.id = '$id'
";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

// 獲取品牌列表
$sql_brands = "SELECT * FROM brand";
$brands_result = $conn->query($sql_brands);

// 獲取種類列表
$sql_categories = "SELECT * FROM category";
$categories_result = $conn->query($sql_categories);

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
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                            商品管理
                        </li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                            編輯商品
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

        <div class="container-fluid py-2">
            <a href="product.php" class="btn btn-dark"><i class="fa-solid fa-arrow-left fa-fw"></i></a>

            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0 rounded-top">
                                <table class="table align-items-center mb-0">
                                    <thead class="bg-gradient-dark">
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white" colspan="10">
                                                編輯商品
                                            </th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">確認刪除</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        確認刪除該帳號
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                        <a href="doDelete.php?id=<?= $row["id"] ?>" class="btn btn-danger">確認</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container">
                                            <?php if ($result->num_rows > 0): ?>
                                                <form action="updateProduct.php" method="post">
                                                    <table class="table table-bordered">
                                                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                                        <tr>
                                                            <th>id</th>
                                                            <td><?= $row["id"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>商品名稱</th>
                                                            <td>
                                                                <input type="text" class="form-control" name="name" value="<?= $row["name"] ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>價格</th>
                                                            <td>
                                                                <input type="text" class="form-control" name="price" value="<?= $row["price"] ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>品牌</th>
                                                            <td>
                                                                <!-- <label for="brand_id" class="form-label">品牌：</label> -->
                                                                <select name="brand_id" id="brand_id" class="form-select ps-2">
                                                                    <option value="0">-請選擇品牌-</option>
                                                                    <option value="1">Leica</option>
                                                                    <option value="2">Nikon</option>
                                                                    <option value="3">Sony</option>
                                                                    <option value="4">Hasselblad</option>
                                                                    <option value="5">Canon</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>種類</th>
                                                            <td>
                                                                <select name="category_id" id="category_id" class="form-select ps-2">
                                                                    <option value="0">-請選擇種類-</option>
                                                                    <option value="1">相機</option>
                                                                    <option value="2">鏡頭</option>
                                                                    <option value="3">配件</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>最後更新時間</th>
                                                            <td><?= htmlspecialchars($row["updated_at"]) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>產品規格</th>
                                                            <td>
                                                                <textarea style="height: 250px;" class="form-control" name="spec"><?= $row["spec"] ?></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>庫存</th>
                                                            <td>
                                                                <input type="text" class="form-control" name="stock" value="<?= $row["stock"] ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>狀態</th>
                                                            <td>
                                                                <div class="form-check form-check-inline">
                                                                    <input
                                                                        class="form-check-input"
                                                                        type="radio"
                                                                        name="state"
                                                                        id="inlineRadio1"
                                                                        value="1"
                                                                        <?= $row["is_deleted"] == 0 ? "checked" : "" ?>>
                                                                    <label class="form-check-label" for="inlineRadio1">上架</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input
                                                                        class="form-check-input"
                                                                        type="radio"
                                                                        name="state"
                                                                        id="inlineRadio2"
                                                                        value="0"
                                                                        <?= $row["is_deleted"] == 1 ? "checked" : "" ?>>
                                                                    <label class="form-check-label" for="inlineRadio2">下架</label>
                                                                </div>


                                                                <!-- <div class="form-check form-check-inline">
                                                                    <input
                                                                        class="form-check-input"
                                                                        type="radio"
                                                                        name="state"
                                                                        id="inlineRadio1"
                                                                        value="1"
                                                                        <?= $row["state"] == 1 ? "checked" : "" ?>>
                                                                    <label class="form-check-label" for="inlineRadio1">上架</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input
                                                                        class="form-check-input"
                                                                        type="radio"
                                                                        name="state"
                                                                        id="inlineRadio2"
                                                                        value="0"
                                                                        <?= $row["state"] == 0 ? "checked" : "" ?>>
                                                                    <label class="form-check-label" for="inlineRadio2">下架</label>
                                                                </div> -->
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="">
                                                            <button class="btn btn-dark" type="submit">儲存</button>
                                                            <a href="product.php?id=<?= $row["id"] ?>" class="btn btn-dark">取消</a>
                                                        </div>
                                                        <!-- <div>
                                                            <a href="doDelete.php?id=<?= $row["id"] ?>" data-bs-toggle="modal" data-bs-target="#confirmModal" class="btn btn-danger" type="button">刪除</a>
                                                        </div> -->
                                                    </div>
                                                </form>
                                            <?php else: ?>
                                                <h1>找不到使用者</h1>
                                            <?php endif; ?>
                                        </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
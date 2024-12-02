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
    category.category_name,
    image.image_url
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
LEFT JOIN
    image
ON
    product.name = image.name
    
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
    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
</head>
<style>
    .custom-header th {
        text-transform: uppercase;
        background: linear-gradient(90deg, #1a1a1a, #333);
        color: white;
        text-align: center;
        font-size: 14px;
        opacity: 0.9;
        border-bottom: none !important;
        /* 移除底部邊框 */
        padding-bottom: 0;
        /* 確保內邊距不導致間距 */
    }

    .table {
        margin-top: 0 !important;
        /* 移除可能的頂部間距 */
    }

    .card-body {
        padding: 0 !important;
        /* 確保父容器無內間距 */
    }
</style>

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
            'teacher_add' => '編輯商品', // 第二層的文字
        ];

        $page = 'teacher_add'; //當前的頁面

        // 設定麵包屑的連結
        $breadcrumbLinks = [
            'teacher' => 'product.php',           // 第一層的連結
            'teacher_list' => 'product.php',      // 第二層的連結
            'teacher_add' => 'product-edit.php',      // 第二層的連結
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
                                <table class="table align-items-center mb-0">
                                    <thead class="custom-header">
                                        <tr>
                                            <th colspan="10">編輯商品</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <div class="container">
                                            <?php if ($result->num_rows > 0): ?>
                                                <form action="updateProduct.php" method="post" enctype="multipart/form-data">
                                                    <table class="table table-bordered">
                                                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                                        <tr>
                                                            <th>商品名稱</th>
                                                            <td>
                                                                <input type="text" class="form-control" name="name" value="<?= $row["name"] ?>">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>更新圖片</th>
                                                            <td>
                                                                <!-- 顯示當前圖片 -->
                                                                <?php if (!empty($row["image_url"])): ?>
                                                                    <div class="ratio ratio-4x3" style="width: 300px;">
                                                                        <img class="object-fit-cover" src="../album/upload/<?= htmlspecialchars($row["image_url"]) ?>" alt="商品圖片">
                                                                    </div>
                                                                <?php else: ?>
                                                                    <p>尚未上傳圖片</p>
                                                                <?php endif; ?>

                                                                <!-- 圖片上傳欄位 -->
                                                                <input type="file" class="form-control mt-2" name="image">
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
                                                                <select name="brand_id" id="brand_id" class="form-select ps-2">
                                                                    <?php while ($brand = $brands_result->fetch_assoc()): ?>
                                                                        <option value="<?= $brand['brand_id'] ?>" <?= $row["brand_id"] == $brand['brand_id'] ? "selected" : "" ?>>
                                                                            <?= htmlspecialchars($brand['brand_name']) ?>
                                                                        </option>
                                                                    <?php endwhile; ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>種類</th>
                                                            <td>
                                                                <select name="category_id" id="category_id" class="form-select ps-2">
                                                                    <?php while ($category = $categories_result->fetch_assoc()): ?>
                                                                        <option value="<?= $category['category_id'] ?>" <?= $row["category_id"] == $category['category_id'] ? "selected" : "" ?>>
                                                                            <?= htmlspecialchars($category['category_name']) ?>
                                                                        </option>
                                                                    <?php endwhile; ?>
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
                                                                <select class="form-select ps-2" name="state" id="state" required>
                                                                    <option value="上架" <?= $row["state"] == "上架" ? "selected" : "" ?>>上架</option>
                                                                    <option value="下架" <?= $row["state"] == "下架" ? "selected" : "" ?>>下架</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div class="d-flex justify-content-center">
                                                        <div class="">
                                                            <button class="btn btn-dark" type="submit">儲存</button>
                                                            <a href="product.php?id=<?= $row["id"] ?>" class="btn btn-dark">取消</a>
                                                        </div>
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
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
    product.id = '$id' AND product.is_deleted = 0;
";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
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
          'teacher_add' => '商品內容', // 第二層的文字

          ];

        $page = 'teacher_add';//當前的頁面

        // 設定麵包屑的連結
        $breadcrumbLinks = [
            'teacher' => 'product.php',           // 第一層的連結
            'teacher_list' => 'product.php',      // 第二層的連結
            'teacher_add' => 'product-content.php',      // 第二層的連結
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
                  <thead class="bg-gradient-dark">
                    <tr>
                      <th
                        class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white " colspan="10">
                        商品內容
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <div class="container">
                      <table class="table table-bordered">
                        <?php if ($result->num_rows > 0): ?>
                          <h1><?= $row["name"] ?></h1>
                          <tr>
                            <th>編號</th>
                            <td><?= $row["id"] ?></td>
                          </tr>
                          <tr>
                            <th>照片</th>
                            <td>
                              <div class="ratio ratio-4x3" style="width: 300px;">
                                <img class="object-fit-cover" src="../album/upload/<?= $row["image_url"] ?>" alt="">
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>價格</th>
                            <td><?= number_format($row["price"]) ?></td>
                          </tr>
                          <tr>
                            <th>品牌</th>
                            <td><?= $row["brand_name"] ?></td>
                          </tr>
                          <tr>
                            <th>商品規格</th>
                            <td><?= nl2br($row["spec"]) ?></td>
                          </tr>
                      </table>
                    <?php else: ?>
                      <h1>查無資料</h1>
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
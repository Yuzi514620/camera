<?php
require_once("../coupon/pdo_connect.php");
$title = 'coupon';

$pdoSqlALl = "SELECT * FROM coupon ";
$stmt = $db_host->prepare($pdoSqlALl);
$stmt->execute();
$resultCount = $stmt->rowCount();

$per_page = 8;
if (isset($_GET["search"])) {
  $search = $_GET["search"];
  if ($_GET["search"] == "") {
    header("location: coupon.php?p=1&sort=1");
  }
  $pdosql = "SELECT * FROM coupon WHERE coupon_code LIKE '%$search%' or lower_purchase LIKE '%$search%'";
} else if (isset($_GET["p"])) {
  $p = $_GET["p"];
  if (!isset($_GET["sort"])) {
    header("location: coupon.php?p=1&sort=1");
  }
  $sort = $_GET["sort"];
  $start_item = ($p - 1) * $per_page;
  

  $pdoCluse = '';
  switch ($sort) {
    case 1:
      $pdoCluse = "order by `id` ASC";
      break;
    case 2:
      $pdoCluse = "order by `start_date` ASC";
      break;
    case 3:
      $pdoCluse = "order by `start_date` DESC";
      break;
    case 4:

      $pdoSqlALl = "SELECT * FROM coupon where `is_deleted` = 0";
      $stmt = $db_host->prepare($pdoSqlALl);
      $stmt->execute();
      $resultCount = $stmt->rowCount();
      $pdoCluse = 'where `is_deleted` = 0';
      break;
    case 5:
      $pdoSqlALl = "SELECT * FROM coupon where `is_deleted` = 1";
      $stmt = $db_host->prepare($pdoSqlALl);
      $stmt->execute();
      $resultCount = $stmt->rowCount();
      $pdoCluse = 'where `is_deleted` = 1';
      break;
  }

  $total_page = ceil($resultCount / $per_page);
  $pdosql = "SELECT * FROM coupon $pdoCluse limit $start_item, $per_page ";
} else {
  header("location: coupon.php?p=1&sort=1");
}

$stmt = $db_host->prepare($pdosql);
try {
  $stmt->execute();
  $rows = $stmt->fetchALL(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "預處理陳述式執行失敗！ <br/>";
  echo "Error: " . $e->getMessage() . "<br/>";
  $db_host = NULL;
  exit;
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

  <style>
    .textbox {
      input {
        border: 2px solid gray;
        color: black;
      }

      input:focus {
        color: black;
        border: 2px solid black;
        transition: 0.4s;
      }

    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- 側邊欄 -->
  <?php $page = 'coupon'; ?>
  <?php include '../sidebar.php'; ?>
  <!-- 側邊欄 -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php 
        // 設定麵包屑的層級
        $breadcrumbs = [
            'coupon' => '優惠券列表', // 第一層的文字
        ];

        $page = 'coupon';//當前的頁面

        // 設定麵包屑的連結
        $breadcrumbLinks = [
            'coupon' => 'coupon.php',           // 第一層的連結
        ];

        include '../navbar.php';
        ?>
    <!-- Navbar -->

    <div class="container-fluid py-2">
      <div class="container-fluid py-2">
        <div class="row">
          <div class="col-12">
            <div class="col-md-6">
              <form action="" method="get">
                <div class="input-group textbox">
                  <input type="search" class="form-control " name="search" value="<?= $_GET["search"] ?? "" ?>">
                  <div class="input-group-append btn-box">
                    <button class="btn btn-primary m-0 btn-search" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                  </div>
                </div>
              </form>
            </div>
            <div class="py-2 d-flex <?php echo (!isset($_GET["p"])) ? "justify-content-end" : "justify-content-between" ?> align-items-center">
              <?php
              if (isset($_GET["p"])) :
                $sort = $_GET["sort"] ?? "";
              ?>
                <div class="btn-group ">
                  <a class="btn btn-dark <?php if ($sort == 2) echo "active" ?>" href="coupon.php?p=<?= $p ?>&sort=2">
                    從最舊
                  </a>
                  <a class="btn btn-dark <?php if ($sort == 3) echo "active" ?>" href="coupon.php?p=<?= $p ?>&sort=3">
                    從最新
                  </a>
                  <a class="btn btn-dark <?php if ($sort == 4) echo "active" ?>" href="coupon.php?p=<?= $p ?>&sort=4">
                    已上架
                  </a>
                  <a class="btn btn-dark <?php if ($sort == 5) echo "active" ?>" href="coupon.php?p=<?= $p ?>&sort=5">
                    已下架
                  </a>
                </div>
              <?php endif; ?>
              <div class="me-2">
                <a class="btn btn-info" href="../coupon/addCoupon.php">新增優惠券</a>
              </div>
            </div>
            <div class="card my-4">
              <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0 rounded-top">
                  <table class="table align-items-center mb-0">
                    <thead class="bg-gradient-dark">
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">名稱</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white ps-2">優惠券代碼</th>
                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">開始日</th>
                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">截止日</th>
                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">折扣</th>
                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">最低消費</th>
                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">數量</th>
                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">狀態</th>
                        <th class="opacity-7"></th>
                        <!-- <th class="text-secondary opacity-7"></th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($rows as $row):
                      ?>
                        <tr>
                          <td><?= $row["name"] ?></td>
                          <td><?= $row["coupon_code"] ?></td>
                          <td><?= $row["start_date"] ?></td>
                          <td><?= $row["end_date"] ?></td>
                          <td><?= $row["discount"] ?></td>
                          <td class="text-end"><?= number_format($row["lower_purchase"]) ?></td>
                          <td class="text-end"><?= number_format($row["quantity"]) ?></td>
                          <td class="status">
                            <?php if ($row["is_deleted"] == 0): ?><span style="color: green;">已上架</span>
                            <?php else: ?><span style="color: red;">已下架</span>
                          <?php endif; ?>
                          </td>
                          <td>
                            <div class="d-flex justify-content-center">
                              <button class="btn mb-2 mt-2 btn-upDownLoad" data-status="0" data-id="<?= $row["id"] ?>"><i class="fa-solid fa-arrow-up"></i></button>
                              <button class="btn mb-2 mt-2 btn-upDownLoad" data-status="1" data-id="<?= $row["id"] ?>"><i class="fa-solid fa-arrow-down"></i></button>
                              <form action="../coupon/updateCoupon.php" method="POST">
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                <button class="btn mb-2 mt-2 btn-updated" type="submit">
                                  <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                              </form>
                              <button type="button" class="btn mb-2 mt-2 btn-deletedData" data-id="<?= $row["id"] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal">
                              <i class="fa-solid fa-trash"></i>
                              </button>
                              <!-- Modal -->
                              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-body">
                                      確定要刪除
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">返回</button>
                                      <button type="button" class="btn btn-primary btn-deleted">刪除</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-center">
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                  
                  <?php if (isset($_GET["p"])): ?>
                    <li class="page-item">
                    <a class="page-link" href="coupon.php?p=<?= ($p != 1) ? $p - 1 : $p = 1; ?>&sort=1" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                    <?php for ($i = 1; $i <= $total_page; $i++): ?>
                      <li class="page-item <?php if ($i == $_GET["p"]) echo "active"; ?>">
                        <a class="page-link" href="coupon.php?p=<?= $i ?>&sort=1"><?= $i ?></a>
                      </li>
                    <?php endfor; ?>
                    <li class="page-item">
                    <a class="page-link" href="coupon.php?p=<?= ($p != $total_page) ? $p + 1 : $p = $total_page; ?>&sort=1" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                  <?php endif; ?>
                  
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- Button trigger modal -->

</body>
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
  
  <script src="https://code.jquery.com/jquery-3.7.1.js" 
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" 
        crossorigin="anonymous">
</script>

  <script>
    const status = document.querySelector(".status");
    let deleteId = 0;
    $(".btn-upDownLoad").click(function() {
      let transData = $(this).data();
      $.ajax({
          method: "POST",
          url: "../coupon/doCouponStatus.php",
          dataType: "json",
          data: {
            status: transData.status,
            id: transData.id
          }
        })
        .done(function(response) {

          document.location.reload();
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
        })
    })

    $(".btn-deletedData").click(function() {
      deleteId = $(this).data();
      
    })
    $(".btn-deleted").click(function(){
        $.ajax({
          method: "POST",
          url: "../coupon/doDeleteCoupon.php",
          dataType: "json",
          data: {
            id: deleteId.id
          }
        })
        .done(function(response) {
          document.location.reload();
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus);
        })
      })

    $(".btn-search").click(function() {
      const search = document.querySelector(".btn-searcg")
      $.ajax({
          method: "POST",
          url: "../coupon/doSearchCoupon.php",
          dataType: "json",
          data: {
            id: transData.id
          }
        })
        .done(function(response) {
          document.location.reload();
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus);
        })
    })
  </script>
</html>
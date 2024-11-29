<?php require_once("../db_connect.php");


// $per_page = 10;
// $sqlAll = "SELECT * FROM users WHERE is_deleted=0";
// $resultAll = $conn->query($sqlAll);
// $userAllCount = $resultAll->num_rows;

// if (isset($_GET["search"])) {
//   $search = $_GET["search"];
//   $sql = "SELECT * FROM users WHERE name LIKE '%$search%' AND is_deleted=0";
// } else if (isset($_GET["p"])) {
//   $p = $_GET["p"];
//   if (!isset($_GET["order"])) {
//       header("location: users.php?p=1&order=1");
//   }
//   $order = $_GET["order"];
//   $start_item = ($p - 1) * $per_page;
//   $total_page = ceil($userAllCount / $per_page);
//   $whereClause="";
//   switch($order){
//       case 1:
//           $whereClause="ORDER BY id ASC";
//           break;
//       case 2:
//           $whereClause="ORDER BY id DESC";
//           break;
//       case 3:
//           $whereClause="ORDER BY account ASC";
//           break;
//       case 4:
//           $whereClause="ORDER BY account DESC";
//           break;
//   }
//   $sql = "SELECT * FROM users WHERE is_deleted=0 
//       $whereClause
//       LIMIT $start_item, $per_page";

// } else {
//   header("location: users.php?p=1&order=1");
// }
// $result = $conn->query($sql);
// if (isset($_GET["search"])) {
//   $user_count = $result->num_rows;
// } else {
//   $user_count = $userAllCount;
// }

// $rows = $result->fetch_all(MYSQLI_ASSOC);
// 

// 搜尋 //
$per_page = 8;
$sqlAll = "SELECT * FROM users WHERE is_deleted=0";
$resultAll = $conn->query($sqlAll);
$userAllCount = $resultAll->num_rows;

if (isset($_GET["search"])) {
  $search = $_GET["search"];
  $sql = "SELECT * FROM users WHERE (
  LOWER(name) LIKE LOWER('%$search%') 
  OR email LIKE '%$search%' 
  OR id LIKE '%$search%'
  OR account LIKE '%$search%'
  OR phone LIKE '%$search%'
  OR address LIKE '%$search%'
  OR created_at LIKE '%$search%'
  ) AND is_deleted=0";
} else if (isset($_GET["p"])) {
  $p = $_GET["p"];

  if (!isset($_GET["order"])) {
    header("location: users.php?p=1&order=1");
  }
  $order = $_GET["order"];
  $start_item = ($p - 1) * $per_page;
  $total_page = ceil($userAllCount / $per_page);

  // if ($order == 1) {
  //   $sql = "SELECT * FROM users WHERE is_deleted=0
  //  ORDER BY id ASC
  //  LIMIT $start_item, $per_page";
  // } else if ($order == 2) {
  //   $sql = "SELECT * FROM users WHERE is_deleted=0
  //  ORDER BY id DESC 
  //  LIMIT $start_item, $per_page";
  // }
  switch ($order) {
    case 1:
      $whereClause = "ORDER BY id ASC";
      break;
    case 2:
      $whereClause = "ORDER BY id DESC";
      break;
    case 3:
      $whereClause = "ORDER BY name ASC";
      break;
    case 4:
      $whereClause = "ORDER BY name DESC";
      break;
  }
  $sql = "SELECT * FROM users WHERE is_deleted=0
  $whereClause
  LIMIT $start_item, $per_page";
} else {
  header("location: users.php?p=1&order=1");
  // $sql = "SELECT * FROM users WHERE is_deleted=0";

}

$result = $conn->query($sql);

if (isset($_GET["search"])) {
  $user_count = $result->num_rows;
} else {
  $user_count = $userAllCount;
}
$rows = $result->fetch_all(MYSQLI_ASSOC);


// foreach ($rows as $row) {
//   $gender = $row["gender"];
//   $gender == 1 ? "男" : "女";
// }
// $gender=$rows["gender"];
// echo $gender == 1 ? "男" : "女";

?>

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
      .active1{
        background-color: pink ;
        background: pink ;
        z-index: 3;
      }
    </style>
</head>

<body class="g-sidenav-show bg-gray-100">

  <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">確認刪除</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          確認刪除該帳號?
        </div>
        <div class="modal-footer">

          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
          <a href="doDeleted.php?id=<?= $row["id"] ?> " class="btn btn-danger">確認</a>

        </div>
      </div>
    </div>
  </div>

  <!-- 側邊欄 -->
  <?php $page = 'users'; ?>
  <?php include 'sidebar.php'; ?>
  <!-- 側邊欄 -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php $page = 'users'; ?>
    <?php include 'navbar.php'; ?>
    <!-- Navbar -->
    <div class="container-fluid py-2">
      <div class="d-flex align-items-center">
      </div>

      <div class="row">
        <div class="d-flex justify-content-between ">
          <div class="">
            <form action="" method="get">
              <?php if (isset($_GET["search"])):?>
              <a href="users.php" class="btn btn-dark"><i class="fa-solid fa-arrow-rotate-left"></i></a>
              <?php endif ?>
              <input class="border-radius-lg btn btn-white border border-dark" type="search" name="search" placeholder="請輸入要搜尋的關鍵字">
              <button type="submit" class="btn btn-dark"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
          </div>

        </div>
        <div class="d-flex justify-content-between">
          <div>
            共 <?= $user_count ?> 個會員
          </div>
          <div class="d-flex">
            <?php if (isset($_GET["p"])): ?>
              <?php $order = $_GET["order"] ?? ""; ?>
              <div class="col-md-auto">
                <a href="users.php?p=<?= $p ?>&order=1" class="btn btn-secondary <?php if ($order == 1) echo "active" ?> " title="asc"><i class="fa-solid fa-arrow-up-1-9
              
              "></i></a>
              </div>
              <div class="col-md-auto ms-1">
                <a href="users.php?p=<?= $p ?>&order=2" class="btn btn-secondary <?php if ($order == 2) echo "active" ?>" title="asc"><i class="fa-solid fa-arrow-up-9-1 
              "></i></a>
              </div>
              <div class="col-md-auto ms-2">
                <a href="users.php?p=<?= $p ?>&order=3" class="btn btn-secondary <?php if ($order == 3) echo "active" ?>" title="asc"><i class="fa-solid fa-arrow-up-a-z 
              "></i></a>
              </div>
              <div class="col-md-auto ms-1">
                <a href="users.php?p=<?= $p ?>&order=4" class="btn btn-secondary <?php if ($order == 4) echo "active" ?>" title="asc"><i class="fa-solid fa-arrow-up-z-a 
              "></i></a>
              </div>
            <?php endif; ?>

            <div class="col-md-auto ms-5">
              <a href="create-user.php" class="btn btn-dark " title="新增使用者"><i class="fa-solid fa-user-plus"></i></a>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="card my-4">
            <!-- <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Authors table</h6>
              </div>
            </div> -->
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0 rounded-top">
                <table class="table align-items-center mb-0">
                  <thead class="bg-gradient-dark">
                    <tr>
                      <th
                        class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        ID
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 text-white">
                        姓名
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        性別
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-white">
                        帳號
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        手機號碼
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        地址
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        加入時間
                      </th>
                      <th
                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">
                        檢視
                      </th>
                      <th
                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">
                        編輯
                      </th>
                      <th
                        class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        刪除
                      </th>
                      <!-- <th class="text-secondary opacity-7"></th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($rows as $user): ?>

                      <tr>
                        <td class="text-center">
                          <!-- ID -->
                          <p class="text-xs font-weight-bold mb-0"><?= $user["id"] ?></p>
                        </td>
                        <td>
                          <!-- 圖片 -->
                          <div class="d-flex px-2 py-1">
                            <div>
                              <img
                                src="/camera/users/img/<?= $user["img"] ?>"
                                class="avatar avatar-sm me-3 border-radius-lg"
                                alt="user1" />
                            </div>
                            <!-- 姓名+Email -->
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm"><?= $user["name"] ?></h6>
                              <p class="text-xs text-secondary mb-0">
                                <?= $user["email"] ?>
                              </p>
                            </div>
                          </div>
                        </td>

                        <td>
                          <!-- 性別 -->
                          <p class="text-xs font-weight-bold mb-0"><?= $user["gender"] == 1 ? "男" : "女" ?></p>
                        </td>
                        <!-- 帳號 -->
                        <td>
                          <p class="text-xs font-weight-bold mb-0">
                            <?= $user["account"] ?>
                          </p>
                        </td>

                        <!-- 電話 -->
                        <td>
                          <p class="text-xs font-weight-bold mb-0">
                            <?= $user["phone"] ?>
                          </p>
                        </td>
                        <!-- 地址 -->
                        <td>
                          <p class="text-xs font-weight-bold mb-0">
                            <?= $user["address"] ?>
                          </p>
                        </td>
                        <!-- 加入時間 -->
                        <td>
                          <p class="text-xs font-weight-bold mb-0">
                            <?= $user["created_at"] ?>
                          </p>
                        </td>
                        <!-- 檢視 -->
                        <td class="align-middle text-center">
                          <a
                            href="user.php?id=<?= $user["id"]; ?>"
                            class="text-secondary font-weight-bold text-xs"
                            data-toggle="tooltip"
                            data-original-title="Edit user">
                            <i class="fa-regular fa-eye"></i>
                          </a>
                        </td>
                        <!-- 編輯 -->
                        <td class="align-middle text-center">
                          <a
                            href="user-edit.php?id=<?= $user["id"]; ?>"
                            class="text-secondary font-weight-bold text-xs"
                            data-toggle="tooltip"
                            data-original-title="Edit user">
                            <i class="fa-regular fa-pen-to-square"></i>
                          </a>
                        </td>
                        <!-- 刪除 -->
                        <td class="align-middle text-center">
                          <a
                            class="text-secondary font-weight-bold text-xs"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmModal">
                            <i class="fa-regular fa-trash-can"></i>
                          </a>
                        </td>
                      </tr>

                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php if (isset($_GET["p"])) : ?>
        <nav aria-label="Page navigation example ">

          <ul class="pagination d-flex justify-content-center">
            <li class="page-item">
              <a class="page-link" href="users.php?p=1&order=1" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php for ($i = 1; $i <= $total_page; $i++) : ?>
              <li class="page-item <?php if ($i == $_GET["p"]) echo "active"; ?>"><a class="page-link" href="users.php?p=<?= $i ?>&order=<?= $order ?>"><?= $i ?></a></li>
            <?php endfor; ?>
            <li class="page-item">
              <a class="page-link" href="users.php?p=<?= $total_page ?>&order=1" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>

        </nav>
      <?php endif; ?>
      <!-- <footer class="footer py-4">
          <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-between">
              <div class="col-lg-6 mb-lg-0 mb-4">
                <div
                  class="copyright text-center text-sm text-muted text-lg-start"
                >
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with <i class="fa fa-heart"></i> by
                  <a
                    href="https://www.creative-tim.com"
                    class="font-weight-bold"
                    target="_blank"
                    >Creative Tim</a
                  >
                  for a better web.
                </div>
              </div> -->
      <!-- <div class="col-lg-6">
                <ul
                  class="nav nav-footer justify-content-center justify-content-lg-end"
                >
                  <li class="nav-item">
                    <a
                      href="https://www.creative-tim.com"
                      class="nav-link text-muted"
                      target="_blank"
                      >Creative Tim</a
                    >
                  </li>
                  <li class="nav-item">
                    <a
                      href="https://www.creative-tim.com/presentation"
                      class="nav-link text-muted"
                      target="_blank"
                      >About Us</a
                    >
                  </li>
                  <li class="nav-item">
                    <a
                      href="https://www.creative-tim.com/blog"
                      class="nav-link text-muted"
                      target="_blank"
                      >Blog</a
                    >
                  </li>
                  <li class="nav-item">
                    <a
                      href="https://www.creative-tim.com/license"
                      class="nav-link pe-0 text-muted"
                      target="_blank"
                      >License</a
                    >
                  </li>
                </ul>
              </div> -->
      <!-- </div>
          </div>
        </footer> -->
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
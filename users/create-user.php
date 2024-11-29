<?php require_once("../db_connect.php");

$sql = "SELECT * FROM users WHERE is_deleted=0";

$result=$conn->query($sql);
$row=$result->fetch_assoc();

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


$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$user_count = $result->num_rows;
$rows = $result->fetch_all(MYSQLI_ASSOC);


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
    .form1 {
      width: 100%;
      max-width: 300px;
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
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
                        新增使用者
                      </th>

                      <!-- <th class="text-secondary opacity-7"></th> -->
                    </tr>
                  </thead>



                  <tbody>

                    <tr>
                      <td class="text-center">
                        <form action="doCreateUser.php" method="post">
                          
                          <div class="mb-2">
                    
                            </div>
                            <div>
                            <label for="" class="form-label ">大頭貼</label>
                            <input type="file" class="input-group-text form-control form1 btn btn-white border bordrer-dark test" name="img" aria-describedby="inputGroupFileAddon04" aria-label="Upload" value="<?= $row["img"] ?>">
                            </div>
                            <div class="mb-2">
                              <label for="" class="form-label">帳號</label>
                              <input type="text" class="form-control form1 btn btn-white border bordrer-dark " placeholder="請輸入6-12位帳號" minlength="6" maxlength="12" name="account">
                            </div>
                            <div class="mb-2">
                              <label for="" class="form-label">密碼</label>
                              <input type="password" class="form-control form1 btn btn-white border bordrer-dark " placeholder="請輸入6-20位密碼" minlength="6" maxlength="20" name="password">
                            </div>
                            <div class="mb-2">
                              <label for="" class="form-label">確認密碼</label>
                              <input type="password" class="form-control form1 btn btn-white border bordrer-dark " name="repassword">
                            </div>
                            <div class="mb-2">
                              <label for="" class="form-label">姓名</label>
                              <input type="text" class="form-control form1 btn btn-white border bordrer-dark " name="name">
                            </div>
                            <div class="mb-2">
                              <label for="" class="form-label">email</label>
                              <input type="text" class="form-control form1 btn btn-white border bordrer-dark " name="email">
                            </div>
                            <div class="mb-2">
                              <label for="" class="form-label">手機號碼</label>
                              <input type="text" class="form-control form1 btn btn-white border bordrer-dark " name="phone">
                            </div>
                            <div class="mb-2">
                              <label for="" class="form-label">住址</label>
                              <input type="text" class="form-control form1 btn btn-white border bordrer-dark " name="address">
                            </div>
                            <div class="mb-2">
                              <label for="" class="form-label">生日</label>
                              <input type="date" class="form-control form1 btn btn-white border bordrer-dark " name="birthday">
                            </div>
                            <?php if(isset($_SESSION["error"]["message"])):?>
                  <div class="p-1 mb-2 text-danger text-center"><?=$_SESSION["error"]["message"]?></div>
                  <?php unset($_SESSION["error"]["message"]); ?>
                  <?php endif; ?>
                            <button class="btn btn-dark" type="submit">送出</button>
                            <a href="users.php" class="btn btn-primary">上一頁</a>
                            </a>
                        </form>
                      
                      </td>


                      <!-- <div class="row">
          <div class="col-12">
            <div class="card my-4">
              <div
                class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"
              >
                <div
                  class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3"
                >
                  <h6 class="text-white text-capitalize ps-3">
                    Projects table
                  </h6>
                </div>
              </div>
              <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                  <table
                    class="table align-items-center justify-content-center mb-0"
                  >
                    <thead>
                      <tr>
                        <th
                          class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                        >
                          Project
                        </th>
                        <th
                          class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                        >
                          Budget
                        </th>
                        <th
                          class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                        >
                          Status
                        </th>
                        <th
                          class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2"
                        >
                          Completion
                        </th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="d-flex px-2">
                            <div>
                              <img
                                src="../assets/img/small-logos/logo-asana.svg"
                                class="avatar avatar-sm rounded-circle me-2"
                                alt="spotify"
                              />
                            </div>
                            <div class="my-auto">
                              <h6 class="mb-0 text-sm">Asana</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-sm font-weight-bold mb-0">$2,500</p>
                        </td>
                        <td>
                          <span class="text-xs font-weight-bold">working</span>
                        </td>
                        <td class="align-middle text-center">
                          <div
                            class="d-flex align-items-center justify-content-center"
                          >
                            <span class="me-2 text-xs font-weight-bold"
                              >60%</span
                            >
                            <div>
                              <div class="progress">
                                <div
                                  class="progress-bar bg-gradient-info"
                                  role="progressbar"
                                  aria-valuenow="60"
                                  aria-valuemin="0"
                                  aria-valuemax="100"
                                  style="width: 60%"
                                ></div>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle">
                          <button class="btn btn-link text-secondary mb-0">
                            <i class="fa fa-ellipsis-v text-xs"></i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex px-2">
                            <div>
                              <img
                                src="../assets/img/small-logos/github.svg"
                                class="avatar avatar-sm rounded-circle me-2"
                                alt="invision"
                              />
                            </div>
                            <div class="my-auto">
                              <h6 class="mb-0 text-sm">Github</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-sm font-weight-bold mb-0">$5,000</p>
                        </td>
                        <td>
                          <span class="text-xs font-weight-bold">done</span>
                        </td>
                        <td class="align-middle text-center">
                          <div
                            class="d-flex align-items-center justify-content-center"
                          >
                            <span class="me-2 text-xs font-weight-bold"
                              >100%</span
                            >
                            <div>
                              <div class="progress">
                                <div
                                  class="progress-bar bg-gradient-success"
                                  role="progressbar"
                                  aria-valuenow="100"
                                  aria-valuemin="0"
                                  aria-valuemax="100"
                                  style="width: 100%"
                                ></div>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle">
                          <button
                            class="btn btn-link text-secondary mb-0"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >
                            <i class="fa fa-ellipsis-v text-xs"></i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex px-2">
                            <div>
                              <img
                                src="../assets/img/small-logos/logo-atlassian.svg"
                                class="avatar avatar-sm rounded-circle me-2"
                                alt="jira"
                              />
                            </div>
                            <div class="my-auto">
                              <h6 class="mb-0 text-sm">Atlassian</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-sm font-weight-bold mb-0">$3,400</p>
                        </td>
                        <td>
                          <span class="text-xs font-weight-bold">canceled</span>
                        </td>
                        <td class="align-middle text-center">
                          <div
                            class="d-flex align-items-center justify-content-center"
                          >
                            <span class="me-2 text-xs font-weight-bold"
                              >30%</span
                            >
                            <div>
                              <div class="progress">
                                <div
                                  class="progress-bar bg-gradient-danger"
                                  role="progressbar"
                                  aria-valuenow="30"
                                  aria-valuemin="0"
                                  aria-valuemax="30"
                                  style="width: 30%"
                                ></div>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle">
                          <button
                            class="btn btn-link text-secondary mb-0"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >
                            <i class="fa fa-ellipsis-v text-xs"></i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex px-2">
                            <div>
                              <img
                                src="../assets/img/small-logos/bootstrap.svg"
                                class="avatar avatar-sm rounded-circle me-2"
                                alt="webdev"
                              />
                            </div>
                            <div class="my-auto">
                              <h6 class="mb-0 text-sm">Bootstrap</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-sm font-weight-bold mb-0">$14,000</p>
                        </td>
                        <td>
                          <span class="text-xs font-weight-bold">working</span>
                        </td>
                        <td class="align-middle text-center">
                          <div
                            class="d-flex align-items-center justify-content-center"
                          >
                            <span class="me-2 text-xs font-weight-bold"
                              >80%</span
                            >
                            <div>
                              <div class="progress">
                                <div
                                  class="progress-bar bg-gradient-info"
                                  role="progressbar"
                                  aria-valuenow="80"
                                  aria-valuemin="0"
                                  aria-valuemax="80"
                                  style="width: 80%"
                                ></div>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle">
                          <button
                            class="btn btn-link text-secondary mb-0"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >
                            <i class="fa fa-ellipsis-v text-xs"></i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex px-2">
                            <div>
                              <img
                                src="../assets/img/small-logos/logo-slack.svg"
                                class="avatar avatar-sm rounded-circle me-2"
                                alt="slack"
                              />
                            </div>
                            <div class="my-auto">
                              <h6 class="mb-0 text-sm">Slack</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-sm font-weight-bold mb-0">$1,000</p>
                        </td>
                        <td>
                          <span class="text-xs font-weight-bold">canceled</span>
                        </td>
                        <td class="align-middle text-center">
                          <div
                            class="d-flex align-items-center justify-content-center"
                          >
                            <span class="me-2 text-xs font-weight-bold"
                              >0%</span
                            >
                            <div>
                              <div class="progress">
                                <div
                                  class="progress-bar bg-gradient-success"
                                  role="progressbar"
                                  aria-valuenow="0"
                                  aria-valuemin="0"
                                  aria-valuemax="0"
                                  style="width: 0%"
                                ></div>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle">
                          <button
                            class="btn btn-link text-secondary mb-0"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >
                            <i class="fa fa-ellipsis-v text-xs"></i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex px-2">
                            <div>
                              <img
                                src="../assets/img/small-logos/devto.svg"
                                class="avatar avatar-sm rounded-circle me-2"
                                alt="xd"
                              />
                            </div>
                            <div class="my-auto">
                              <h6 class="mb-0 text-sm">Devto</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-sm font-weight-bold mb-0">$2,300</p>
                        </td>
                        <td>
                          <span class="text-xs font-weight-bold">done</span>
                        </td>
                        <td class="align-middle text-center">
                          <div
                            class="d-flex align-items-center justify-content-center"
                          >
                            <span class="me-2 text-xs font-weight-bold"
                              >100%</span
                            >
                            <div>
                              <div class="progress">
                                <div
                                  class="progress-bar bg-gradient-success"
                                  role="progressbar"
                                  aria-valuenow="100"
                                  aria-valuemin="0"
                                  aria-valuemax="100"
                                  style="width: 100%"
                                ></div>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle">
                          <button
                            class="btn btn-link text-secondary mb-0"
                            aria-haspopup="true"
                            aria-expanded="false"
                          >
                            <i class="fa fa-ellipsis-v text-xs"></i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div> -->
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
  <!-- 照片預覽 -->
  <script>

    const testImg = document.querySelector("#test-img");

    $(".test").change(function(){
      let image = $(this).val();
      newImage = image.split("\\");
      testImg.src="/camera/users/img/"+`${newImage[newImage.length-1]}`;
      console.log(image);
      console.log(newImage);
    })
  </script>
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
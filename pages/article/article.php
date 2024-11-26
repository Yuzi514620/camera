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
    <?php $page = 'article'; ?>
    <?php include 'sidebar.php'; ?>
  <!-- 側邊欄 -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
      <?php $page = 'article'; ?>
      <?php include 'navbar.php'; ?>
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
                        class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        ID
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 text-white">
                        圖片
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        姓名
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-white">
                        帳號 / email
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        電話
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
                    <tr>
                      <td class="text-center">
                        <!-- ID -->
                        <p class="text-xs font-weight-bold mb-0">1</p>
                      </td>
                      <td>
                        <!-- 圖片 -->
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img
                              src="../assets/img/team-2.jpg"
                              class="avatar avatar-sm me-3 border-radius-lg"
                              alt="user1" />
                          </div>
                          <div
                            class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">John Michael</h6>
                            <p class="text-xs text-secondary mb-0">
                              john@creative-tim.com
                            </p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <!-- 姓名 -->
                        <p class="text-xs font-weight-bold mb-0">Manager</p>
                      </td>
                      <!-- 帳號 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">
                          test@gmail.com
                        </p>
                      </td>

                      <!-- 電話 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">
                          0900000000
                        </p>
                      </td>
                      <!-- 檢視 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-eye"></i>
                        </a>
                      </td>
                      <!-- 編輯 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                      </td>
                      <!-- 刪除 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-trash-can"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-center">
                        <!-- ID -->
                        <p class="text-xs font-weight-bold mb-0">1</p>
                      </td>
                      <td>
                        <!-- 圖片 -->
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img
                              src="../assets/img/team-2.jpg"
                              class="avatar avatar-sm me-3 border-radius-lg"
                              alt="user1" />
                          </div>
                          <div
                            class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">John Michael</h6>
                            <p class="text-xs text-secondary mb-0">
                              john@creative-tim.com
                            </p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <!-- 姓名 -->
                        <p class="text-xs font-weight-bold mb-0">Manager</p>
                      </td>
                      <!-- 帳號 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">
                          test@gmail.com
                        </p>
                      </td>

                      <!-- 電話 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">
                          0900000000
                        </p>
                      </td>
                      <!-- 檢視 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-eye"></i>
                        </a>
                      </td>
                      <!-- 編輯 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                      </td>
                      <!-- 刪除 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-trash-can"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-center">
                        <!-- ID -->
                        <p class="text-xs font-weight-bold mb-0">1</p>
                      </td>
                      <td>
                        <!-- 圖片 -->
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img
                              src="../assets/img/team-2.jpg"
                              class="avatar avatar-sm me-3 border-radius-lg"
                              alt="user1" />
                          </div>
                          <div
                            class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">John Michael</h6>
                            <p class="text-xs text-secondary mb-0">
                              john@creative-tim.com
                            </p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <!-- 姓名 -->
                        <p class="text-xs font-weight-bold mb-0">Manager</p>
                      </td>
                      <!-- 帳號 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">
                          test@gmail.com
                        </p>
                      </td>

                      <!-- 電話 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">
                          0900000000
                        </p>
                      </td>
                      <!-- 檢視 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-eye"></i>
                        </a>
                      </td>
                      <!-- 編輯 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                      </td>
                      <!-- 刪除 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-trash-can"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-center">
                        <!-- ID -->
                        <p class="text-xs font-weight-bold mb-0">1</p>
                      </td>
                      <td>
                        <!-- 圖片 -->
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img
                              src="../assets/img/team-2.jpg"
                              class="avatar avatar-sm me-3 border-radius-lg"
                              alt="user1" />
                          </div>
                          <div
                            class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">John Michael</h6>
                            <p class="text-xs text-secondary mb-0">
                              john@creative-tim.com
                            </p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <!-- 姓名 -->
                        <p class="text-xs font-weight-bold mb-0">Manager</p>
                      </td>
                      <!-- 帳號 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">
                          test@gmail.com
                        </p>
                      </td>

                      <!-- 電話 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">
                          0900000000
                        </p>
                      </td>
                      <!-- 檢視 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-eye"></i>
                        </a>
                      </td>
                      <!-- 編輯 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                      </td>
                      <!-- 刪除 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-trash-can"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-center">
                        <!-- ID -->
                        <p class="text-xs font-weight-bold mb-0">1</p>
                      </td>
                      <td>
                        <!-- 圖片 -->
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img
                              src="../assets/img/team-2.jpg"
                              class="avatar avatar-sm me-3 border-radius-lg"
                              alt="user1" />
                          </div>
                          <div
                            class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">John Michael</h6>
                            <p class="text-xs text-secondary mb-0">
                              john@creative-tim.com
                            </p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <!-- 姓名 -->
                        <p class="text-xs font-weight-bold mb-0">Manager</p>
                      </td>
                      <!-- 帳號 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">
                          test@gmail.com
                        </p>
                      </td>

                      <!-- 電話 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">
                          0900000000
                        </p>
                      </td>
                      <!-- 檢視 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-eye"></i>
                        </a>
                      </td>
                      <!-- 編輯 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                      </td>
                      <!-- 刪除 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-trash-can"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-center">
                        <!-- ID -->
                        <p class="text-xs font-weight-bold mb-0">1</p>
                      </td>
                      <td>
                        <!-- 圖片 -->
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img
                              src="../assets/img/team-2.jpg"
                              class="avatar avatar-sm me-3 border-radius-lg"
                              alt="user1" />
                          </div>
                          <div
                            class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">John Michael</h6>
                            <p class="text-xs text-secondary mb-0">
                              john@creative-tim.com
                            </p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <!-- 姓名 -->
                        <p class="text-xs font-weight-bold mb-0">Manager</p>
                      </td>
                      <!-- 帳號 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">
                          test@gmail.com
                        </p>
                      </td>

                      <!-- 電話 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">
                          0900000000
                        </p>
                      </td>
                      <!-- 檢視 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-eye"></i>
                        </a>
                      </td>
                      <!-- 編輯 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                      </td>
                      <!-- 刪除 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-trash-can"></i>
                        </a>
                      </td>
                    </tr>
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
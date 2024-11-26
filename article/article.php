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
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3 justify-content-end">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
              <a class="opacity-5 text-dark" href="javascript:;">Pages</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
              Tables
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
    <div class="container-fluid py-2">
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
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
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
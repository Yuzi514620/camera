<?php





?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
  <title>camera</title>

  <?php include("link.php") ?>

</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- 側邊欄 -->
  <?php $page = 'rental'; ?>
  <?php include '../pages/sidebar.php'; ?>
  <!-- 側邊欄 -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
      <?php $page = 'rental'; ?>
      <?php include '../pages/navbar.php'; ?>
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
                      <th class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        選擇</th>
                      <th class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        產品</th>
                      <th class="text-uppercase text-secondary text-xxs opacity-7 text-white">
                        圖片</th>
                      <th class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        規格</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-white">
                        租金 / 押金</th>
                      <th class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        庫存</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">
                        狀態</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">
                        編輯</th>
                      <th class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        刪除</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <!-- 選擇 check box -->
                      <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">1</p>
                      </td>
                      <!-- 產品 -->
                      <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">1</p>
                      </td>
                      <!-- 圖片 -->
                      <td>                        
                        <div class="d-flex px-2 py-1">
                          <div>
                            <img src="../assets/img/team-2.jpg"
                              class="avatar avatar-sm me-3 border-radius-lg"
                              alt="user1" />
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">John Michael</h6>
                            <p class="text-xs text-secondary mb-0">john@creative-tim.com</p>
                          </div>
                        </div>
                      </td>
                      <!-- 規格 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Manager</p>
                      </td>
                      <!-- 租金 / 押金 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">test@gmail.com</p>
                      </td>
                      <!-- 庫存 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">0900000000</p>
                      </td>
                      <!-- 狀態 -->
                      <td class="align-middle text-center">
                        <a href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-eye"></i>
                        </a>
                      </td>
                      <!-- 編輯 -->
                      <td class="align-middle text-center">
                        <a href="javascript:;"
                          class="text-secondary font-weight-bold text-xs"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                      </td>
                      <!-- 刪除 -->
                      <td class="align-middle text-center">
                        <a href="javascript:;"
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
  
  <?php include("script.php") ?>

</body>

</html>
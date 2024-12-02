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

<?php
require_once("../db_connect.php");

$title = "師資列表";

// 每頁顯示五筆資料
$limit = 5;

// 處理搜尋條件
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_condition = $search ? "WHERE teacher.name LIKE '%$search%' AND teacher.is_visible = 1" : "WHERE teacher.is_visible = 1";

// 計算總資料筆數
$sql_count = "SELECT COUNT(*) AS total FROM teacher $search_condition";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_records = $row_count['total'];

// 計算總頁數
$total_pages = ceil($total_records / $limit);

// 當前頁數
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$current_page = max(1, min($current_page, $total_pages));  // 保證頁數在範圍內

// 設定排序狀態
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'id'; // 預設按 ID 排序
$order_type = isset($_GET['order_type']) && $_GET['order_type'] == 'desc' ? 'desc' : 'asc'; // 預設為升冪排序

// 查詢當前頁數的資料並加入排序
$offset = ($current_page - 1) * $limit;
$sql = "SELECT 
            teacher.*,     
            course_image.name AS image_name  
        FROM teacher
        LEFT JOIN course_image ON teacher.course_image_id = course_image.id
        $search_condition
        ORDER BY $order_by $order_type
        LIMIT $offset, $limit";

// 執行查詢
$result = $conn->query($sql);

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
  <title>師資管理</title>
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
    href="../assets/css/material-dashboard.css"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- jQuery（Bootstrap 需要）-->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="teacher.css">
</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- 側邊欄 -->
  <?php $page = 'teacher'; ?>
  <?php include '../sidebar.php'; ?>
  <!-- 側邊欄 -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php $page = 'teacher'; ?>
    <?php
    $breadcrumbs = [
      'users' => '首頁',
      'teacher' => '師資管理',
    ];

    $page = 'teacher';

    $breadcrumbLinks = [
      'users' => '../users/users.php',
      'teacher' => 'teacher.php',
    ];

    include '../navbar.php';
    ?>


    <div class="container-fluid pt-2 mt-5">

      <!-- 搜尋欄位 -->
      <div class="d-flex justify-content-between align-items-center p-0">
        <div class="d-flex">
          <form method="GET" action="" class="d-flex">
            <!-- 隱藏目前分頁和排序參數 -->
            <input type="hidden" name="page" value="<?= $current_page ?>">
            <input type="hidden" name="order_by" value="<?= $order_by ?>">
            <input type="hidden" name="order_type" value="<?= $order_type ?>">

            <!-- 清空搜尋按鈕 -->
            <a href="teacher.php" class="btn btn-outline-secondary me-2 my-0">
              <i class="fa-solid fa-arrow-rotate-left fa-fw pe-1"></i>
            </a>

            <!-- 搜尋欄位 -->
            <input
              type="text"
              name="search"
              class="form-control me-2 ps-3 py-0"
              placeholder="搜尋講師名稱"
              value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-secondary my-0"><i class="fa-solid fa-magnifying-glass fa-fw pe-1"></i></button>
          </form>
          <!-- 新增課程 -->
          <a href="teacher_add.php" class="btn btn-secondary m-0 mx-3">新增師資</a>
        </div>


        <!-- 排序按鈕 -->
        <div class="d-flex justify-content-end ">
          <p class="text-xs text-end px-2 mb-0 mt-4">總共有 <?php echo $row_count['total']; ?> 筆資料</p>
          <!-- <a href="?page=<?= $current_page ?>&order_by=id&order_type=<?= $order_type === 'asc' ? 'desc' : 'asc' ?>" class="btn btn-secondary mb-0 mx-1">
            id
            <i class="fa-solid <?= $order_type === 'asc' ? 'fa-arrow-down-wide-short' : 'fa-arrow-down-short-wide' ?>"></i>
          </a> -->
        </div>
      </div>
    </div>

    </div>


    <div class="container-fluid mt-0">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0 rounded-top">
                <table class="table align-items-center mb-0">
                  <thead class="bg-gradient-dark card-header">
                    <tr>
                      <th class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        <a href="?order_by=id&order_type=<?= ($order_by == 'id' && $order_type == 'asc') ? 'desc' : 'asc'; ?>" class="text-white">
                          ID <i class="fa-solid fa-sort"></i>
                        </a>
                      </th>
                      <th class="text-uppercase text-secondary text-xxs opacity-8 text-white"><a class="text-white">照片</a></th>
                      <th class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white"><a class="text-white">姓名</a></th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-white"><a class="text-white">簡介</a></th>
                      <th class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        <a href="?order_by=email&order_type=<?= ($order_by == 'email' && $order_type == 'asc') ? 'desc' : 'asc'; ?>" class="text-white">
                          信箱 <i class="fa-solid fa-sort"></i>
                        </a>
                      </th>
                      <th class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        <a href="?order_by=phone&order_type=<?= ($order_by == 'phone' && $order_type == 'asc') ? 'desc' : 'asc'; ?>" class="text-white">
                          電話 <i class="fa-solid fa-sort"></i>
                        </a>
                      </th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white"><a class="text-white">檢視</a></th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white"><a class="text-white">編輯</a></th>
                      <th class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white"><a class="text-white">刪除</a></th>
                    </tr>
                  </thead>

                  <?php if ($result->num_rows > 0): ?>
                    <tbody>
                      <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                          <td class="text-center">
                            <p class="text-xs font-weight-bold mb-0"><?= $row['id']; ?></p>
                          </td>
                          <td>
                            <div class="d-flex px-2 py-1">
                              <img src="../course_images/teacher/<?= $row['image_name']; ?>" class="me-3 border-radius-lg teacher-img img-fit" alt="teacher_image" />
                            </div>
                          </td>
                          <td>
                            <p class="text-xs font-weight-bold mb-0"><?= htmlspecialchars($row['name']); ?></p>
                          </td>
                          <td>
                            <p class="text-xs font-weight-bold mb-0 text-ellipsis"><?= htmlspecialchars($row['info']); ?></p>
                          </td>
                          <td>
                            <p class="text-xs font-weight-bold mb-0"><?= htmlspecialchars($row['email']); ?></p>
                          </td>
                          <td>
                            <p class="text-xs font-weight-bold mb-0"><?= htmlspecialchars($row['phone']); ?></p>
                          </td>
                          <td class="align-middle text-center">
                            <a href="teacher_info.php?id=<?= $row['id']; ?>" class="text-secondary font-weight-bold text-xs">
                              <i class="fa-solid fa-magnifying-glass"></i>
                            </a>
                          </td>
                          <td class="align-middle text-center">
                            <a href="teacher_edit.php?id=<?= $row['id']; ?>" class="text-secondary font-weight-bold text-xs">
                              <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                          </td>
                          <td class="align-middle text-center">
                            <a href="#" class="text-secondary font-weight-bold text-xs delete-btn" data-id="<?= $row['id']; ?>" data-toggle="modal" data-target="#deleteModal">
                              <i class="fa-regular fa-trash-can"></i>
                            </a>
                          </td>
                        </tr>
                      <?php endwhile; ?>
                    </tbody>
                  <?php endif; ?>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">確認刪除</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            確定要刪除這筆資料嗎？
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <a href="#" id="confirmDeleteBtn" class="btn btn-danger">確定刪除</a>
          </div>
        </div>
      </div>
    </div>

    <!-- 分頁按鈕 -->
    <nav>
      <ul class="pagination justify-content-center">
        <!-- 第一頁按鈕 -->
        <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=1&order_by=<?= $order_by ?>&order_type=<?= $order_type ?>">
            <i class="fa-solid fa-angles-left"></i>
          </a>
        </li>
        <!-- 上一頁按鈕 -->
        <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= $current_page - 1 ?>&order_by=<?= $order_by ?>&order_type=<?= $order_type ?>">
            <i class="fa-solid fa-angle-left"></i>
          </a>
        </li>

        <!-- 顯示頁碼 -->
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>&order_by=<?= $order_by ?>&order_type=<?= $order_type ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>

        <!-- 下一頁按鈕 -->
        <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= $current_page + 1 ?>&order_by=<?= $order_by ?>&order_type=<?= $order_type ?>">
            <i class="fa-solid fa-chevron-right"></i>
          </a>
        </li>
        <!-- 最後一頁按鈕 -->
        <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
          <a class="page-link" href="?page=<?= $total_pages ?>&order_by=<?= $order_by ?>&order_type=<?= $order_type ?>">
            <i class="fa-solid fa-angles-right"></i>
          </a>
        </li>
      </ul>
    </nav>
    </div>
  </main>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          document.getElementById('confirmDeleteBtn').href = `teacher_delete.php?id=${id}`;
        });
      });
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
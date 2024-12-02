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

// 每頁顯示五筆資料
$limit = 5;

// 處理搜尋條件
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_condition = $search ? "WHERE course.title LIKE '%$search%' AND course.is_visible = 1" : "WHERE course.is_visible = 1";

// 計算總資料筆數
$sql_count = "SELECT COUNT(*) AS total FROM course $search_condition";
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
            course.*,          
            course_image.name AS image_name,
            teacher.name AS teacher_name,
            course_category.name AS category_name
        FROM course
        LEFT JOIN course_image ON course.course_image_id = course_image.id
        LEFT JOIN teacher ON course.teacher_id = teacher.id
        LEFT JOIN course_category ON course.category_id = course_category.id
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
  <title>課程管理</title>
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

  <link rel="stylesheet" href="course.css">
</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- 側邊欄 -->
  <?php $page = 'course'; ?>
  <?php include '../sidebar.php'; ?>
  <!-- 側邊欄 -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php $page = 'course'; ?>
    <?php
    $breadcrumbs = [
      'users' => '首頁',
      'course' => '課程管理',
    ];

    $page = 'course';

    $breadcrumbLinks = [
      'users' => '../users/users.php',
      'course' => 'course.php',
    ];

    include '../navbar.php';
    ?>

    <!-- Navbar -->


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
            <a href="course.php" class="btn btn-outline-secondary me-2 my-0">
              <i class="fa-solid fa-arrow-rotate-left fa-fw pe-1"></i>
            </a>

            <!-- 搜尋欄位 -->
            <input
              type="text"
              name="search"
              class="form-control me-2 ps-3 py-0"
              placeholder="搜尋課程名稱"
              value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-secondary my-0"><i class="fa-solid fa-magnifying-glass fa-fw pe-1"></i></button>
          </form>
          <!-- 新增課程 -->
          <a href="course_add.php" class="btn btn-secondary m-0 mx-3">新增課程</a>
        </div>


        <!-- 排序按鈕 -->

        <div class="d-flex justify-content-end">
          <p class="text-xs text-end px-2 mb-0 mt-4">總共有 <?php echo $row_count['total']; ?> 筆資料</p>
          <!-- <a href="?page=<?= $current_page ?>&order_by=id&order_type=<?= $order_type === 'asc' ? 'desc' : 'asc' ?>" class="btn btn-secondary mb-0 mx-1">
            id
            <i class="fa-solid <?= $order_type === 'asc' ? 'fa-arrow-down-wide-short' : 'fa-arrow-down-short-wide' ?>"></i>
          </a>
         
          <div class="d-flex justify-content-end">
            <a href="?page=<?= $current_page ?>&order_by=apply_start&order_type=<?= $order_type === 'asc' ? 'desc' : 'asc' ?>" class="btn btn-secondary mb-0 mx-1">
              報名開始時間
            
              <i class="fa-solid <?= $order_type === 'asc' ? 'fa-arrow-down-wide-short' : 'fa-arrow-down-short-wide' ?>"></i>
            </a>
          </div>

         
          <div class="d-flex justify-content-end">
            <a href="?page=<?= $current_page ?>&order_by=course_start&order_type=<?= $order_type === 'asc' ? 'desc' : 'asc' ?>" class="btn btn-secondary mb-0 mx-1">
              課程開始時間
          
              <i class="fa-solid <?= $order_type === 'asc' ? 'fa-arrow-down-wide-short' : 'fa-arrow-down-short-wide' ?>"></i>
            </a> -->
        </div>
      </div>
    </div>




    <div class="container-fluid mt-0">
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
                      <th class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        <a href="?order_by=id&order_type=<?php echo ($order_by == 'id' && $order_type == 'asc') ? 'desc' : 'asc'; ?>" class="text-white">
                          ID <i class="fa-solid fa-sort"></i>
                        </a>
                      </th>
                      <th class="text-uppercase text-secondary text-xxs opacity-7 text-white">
                        <a href="" class="text-white">圖片</a>
                      </th>
                      <th class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        <a href="" class="text-white">名稱</a>
                      </th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-white">
                        <a href="" class="text-white">分類</a>
                      </th>
                      <th class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        <a href="?order_by=price&order_type=<?php echo ($order_by == 'price' && $order_type == 'asc') ? 'desc' : 'asc'; ?>" class="text-white">
                          價格 <i class="fa-solid fa-sort"></i>
                        </a>
                      </th>
                      <th class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        <a href="" class="text-white">講師</a>
                      </th>
                      <th class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        <a href="?order_by=apply_start&order_type=<?php echo ($order_by == 'apply_start' && $order_type == 'asc') ? 'desc' : 'asc'; ?>" class="text-white">
                          報名時間 <i class="fa-solid fa-sort"></i>
                        </a>
                      </th>
                      <th class="text-uppercase text-secondary text-xxs opacity-7 ps-2 text-white">
                        <a href="?order_by=course_start&order_type=<?php echo ($order_by == 'course_start' && $order_type == 'asc') ? 'desc' : 'asc'; ?>" class="text-white">
                          課程時間 <i class="fa-solid fa-sort"></i>
                        </a>
                      </th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">
                        <a href="" class="text-white">檢視</a>
                      </th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-white">
                        <a href="" class="text-white">編輯</a>
                      </th>
                      <th class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        <a href="" class="text-white">狀態</a>
                      </th>
                      <th class="text-center text-uppercase text-secondary text-xxs opacity-7 text-white">
                        <a href="" class="text-white">刪除</a>
                      </th>
                      <!-- <th class="text-secondary opacity-7"></th> -->
                    </tr>
                  </thead>

                  <?php if ($result->num_rows > 0): ?>
                    <tbody>
                      <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                          <td class="text-center">
                            <!-- ID -->
                            <p class="text-xs font-weight-bold mb-0"><?php echo $row['id']; ?></p>
                          </td>
                          <td>
                            <!-- 圖片 -->
                            <div class="d-flex px-2 py-1" style="overflow: hidden">
                              <div>
                                <img src="../course_images/course_cover/<?php echo $row['image_name']; ?>" class="me-3 border-radius-lg course-img img-fit" alt="course image" />
                              </div>
                            </div>
                          </td>
                          <td>
                            <!-- 名稱 -->
                            <p class="text-xs font-weight-bold mb-0"><?php echo htmlspecialchars($row['title']); ?></p>
                          </td>
                          <td>
                            <!-- 分類 -->
                            <p class="text-xs font-weight-bold mb-0"><?php echo htmlspecialchars($row['category_name']); ?></p>
                          </td>
                          <td>
                            <!-- 價格 -->
                            <p class="text-xs font-weight-bold mb-0"><?php echo number_format($row['price']); ?></p>
                          </td>
                          <td>
                            <!-- 講師 -->
                            <p class="text-xs font-weight-bold mb-0"><?php echo htmlspecialchars($row['teacher_name']); ?></p>
                          </td>
                          <td>
                            <!-- 報名時間 -->
                            <p class="text-xs font-weight-bold mb-0">
                              <?php echo date("Y/m/d", strtotime($row['apply_start'])) . " ~ " . date("Y/m/d", strtotime($row['apply_end'])); ?>
                            </p>
                          </td>
                          <td>
                            <!-- 課程時間 -->
                            <p class="text-xs font-weight-bold mb-0">
                              <?php echo date("Y/m/d", strtotime($row['course_start'])) . " ~ " . date("Y/m/d", strtotime($row['course_end'])); ?>
                            </p>
                          </td>
                          <td class="align-middle text-center">
                            <!-- 檢視 -->
                            <a href="course_info.php?id=<?php echo $row['id']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                              <i class="fa-solid fa-magnifying-glass"></i>
                            </a>
                          </td>
                          <td class="align-middle text-center">
                            <!-- 編輯 -->
                            <a href="course_edit.php?id=<?php echo $row['id']; ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                              <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                          </td>
                          <td class="align-middle text-center">
                            <!-- 狀態 -->
                            <a href="course_status.php?id=<?php echo $row['id']; ?>" class="text-secondary font-weight-bold text-xs">
                              <?php echo $row['status'] == 1 ? '<i class="fa-solid fa-eye"></i>' : '<i class="fa-solid fa-eye-slash"></i>'; ?>
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
          document.getElementById('confirmDeleteBtn').href = `course_delete.php?id=${id}`;
        });
      });
    });
  </script>


  <!-- <?php if (isset($_GET['message']) && $_GET['message'] === 'success'): ?>
    <script>
      alert('課程資料新增完成！');
      history.replaceState(null, '', 'course.php');
    </script>
  <?php endif; ?> -->
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
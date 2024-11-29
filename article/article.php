<?php
require_once 'pdo_connect_camera.php';

// 只在函數不存在時定義 truncate()，避免重複宣告
if (!function_exists('truncate')) {
    function truncate($text, $length = 150, $suffix = '...') {
        if (mb_strlen($text, 'UTF-8') > $length) {
            return mb_substr($text, 0, $length, 'UTF-8') . $suffix;
        }
        return $text;
    }
}

//下面function是用來計算時間差的
function time_elapsed_string($datetime, $full = false) {
  date_default_timezone_set('Asia/Taipei'); // 設定時區
  $now = new DateTime;
  $ago = new DateTime($datetime);
  $diff = $now->diff($ago);

  // 計算各個單位的時間差
  $diff->w = floor($diff->d / 7);
  $diff->d -= $diff->w * 7;

  // 定義時間單位
  $string = array(
      'y' => '年',
      'm' => '個月',
      'w' => '週',
      'd' => '天',
      'h' => '小時',
      'i' => '分鐘',
      's' => '秒',
  );
  foreach ($string as $k => &$v) {//&$v是傳址
      if ($diff->$k) {//如果時間差有值
          $v = $diff->$k . $v . '前';//diff->k是時間差 v是時間單位
      } else {
          unset($string[$k]);//如果時間差沒有值，就刪除
      }
  }
  // 返回結果
  if (!$full) $string = array_slice($string, 0, 1);//array_slice()函數從陣列中取出一段
  return $string ? reset($string) : '剛剛';//reset()函數返回陣列中的第一個元素的值
}

$search = $_GET['search'] ?? '';
try {
  if (!empty($search)) {
      // 使用預處理語句以防止 SQL 注入
      $sql = "SELECT a.*, c.name as category_name
              FROM article a
              JOIN article_category c ON a.category_id = c.id
              WHERE a.title LIKE :search OR a.content LIKE :search";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(['search' => '%' . $search . '%']);//執行預處理語句
  } else {
      // 如果沒有搜尋關鍵字，則顯示所有文章
      $sql = "SELECT a.*, c.name as category_name
              FROM article a
              JOIN article_category c ON a.category_id = c.id";
      $stmt = $pdo->query($sql);
  }
  $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e){
  echo "資料撈取失敗: " . $e->getMessage();
}

try {
    $sql = "SELECT a.*, c.name as category_name
    FROM article a
    JOIN article_category c ON a.category_id=c.id";

    $stmt = $pdo->query($sql);
    $articles = $stmt->fetchAll();
    $articleCount = $stmt->rowCount();
} catch (PDOException $e){
    echo "資料撈取失敗: " . $e->getMessage();
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
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/dist/boxicons.js" integrity="sha512-Dm5UxqUSgNd93XG7eseoOrScyM1BVs65GrwmavP0D0DujOA8mjiBfyj71wmI2VQZKnnZQsSWWsxDKNiQIqk8sQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <style>
    .content {
        word-wrap: break-word; /* 自動換行 */
        white-space: normal;   /* 保留正常的空白符號 */
    }
    .search-bar{
      input{
        height: 35px;
      }
      button{
        height: 35px;
      }
      button:hover{
        background: #fff;
        color: #000;
      }
    }
    .btn-addAeticle{
      width: 35px;
      height: 35px;
    }
  </style>
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
              文章列表
            </li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <!-- 添加 ms-auto 將內容推向右側 -->
          <ul class="navbar-nav d-flex align-items-center justify-content-end ms-auto">
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



    <!-- 文章列表 -->
    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <!-- 搜尋 -->
          <div class="d-flex justify-content-between align-items-center pe-5 ps-1">
            <form class="d-flex search-bar" method="GET" action="article.php">
              <input class="form-control me-2 border border-secondary px-1" type="search" placeholder="搜尋文章" aria-label="Search">
              <button class="btn btn-dark" type="submit"><i class="fas fa-search"></i></button>
            </form>
            <button class="btn btn-dark text-white btn-addAeticle px-2">
              <i class="fa-solid fa-pen"></i>
            </button>

          </div>
          <div class="px-2 mb-2">目前共有 <?= htmlspecialchars($articleCount) ?> 篇文章</div>
          <div class="card ">
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0 rounded-top">
                <table class="table align-items-center mb-0">
                  <thead class="bg-gradient-dark">
                    <tr>
                      <th
                        class="text-center text-uppercase text-secondary text-xs opacity-7 text-white" style="width:5%">
                        分類
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xs opacity-7 text-white " style="width:25%">
                        文章列表
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xs opacity-7 ps-2 text-white" style="width:10%">
                        編輯者
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2 text-white" colspan="2" style="width:35%">
                        內文
                      </th>
                      <th
                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2 text-white" style="width:10%">
                        最後更新時間
                      </th>
                      <th
                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-white" style="width:5%">
                        檢視
                      </th>
                      <th
                        class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-white" style="width:5%">
                        編輯
                      </th>
                      <th
                        class="text-center text-uppercase text-secondary text-xs opacity-7 text-white" style="width:5%">
                        刪除
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php foreach ($articles as $article): ?>
                    <tr>
                      <td class="text-center">
                        <!-- 分類 -->
                        <p class="text-xs font-weight-bold mb-0 text-warning"><?= htmlspecialchars($article['category_name']) ?></p>
                      </td>
                      <td>
                        <!-- 文章列表 -->
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center" >
                            <h6 class="mb-0 text-sm"><?= htmlspecialchars($article['title']) ?></h6>
                          </div>
                        </div>
                      </td>
                      <!-- 編輯者 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0">Manager</p>
                      </td>
                      <!-- 內文 -->
                      <td colspan="2" style="width:25%">
                        <p class="text-xs font-weight-bold mb-0 content">
                          <?= htmlspecialchars(truncate(strip_tags($article['content']), 150)) ?>
                        </p>
                      </td>
                      <!--更新時間 -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0 text-secondary"><?= isset($article['update_time']) ? htmlspecialchars(time_elapsed_string($article['update_time'])) : '未更新' ?></p>
                      </td>
                      <!-- 檢視-->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-secondary font-weight-bold text-sm"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-eye"></i>
                        </a>
                      </td>
                      <!-- 編輯 -->
                      <td class="align-middle text-center">
                        <a
                          href="articleEdit.php?id=<?= $article['id'] ?>"
                          class="text-secondary font-weight-bold text-sm"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                      </td>
                      <!-- 刪除 -->
                      <td class="align-middle text-center">
                        <a
                          href="javascript:;"
                          class="text-danger font-weight-bold text-sm"
                          data-toggle="tooltip"
                          data-original-title="Edit user">
                          <i class="fa-regular fa-trash-can"></i>
                        </a>
                      </td>
                    <?php endforeach; ?>
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
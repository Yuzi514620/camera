<?php
    require_once("pdo_connect.php");

    $pdoSql = "SELECT * FROM coupon";
    $stmt = $db_host->prepare($pdoSql);
    try{
        $stmt->execute();
        $rows = $stmt->fetchALL(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
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
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
  <title>camera</title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-dark my-2"
    id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="#"
        target="_blank">
        <span class="ms-1 text-sm text-white">Camera</span>
        </a>
      </div>
      <hr class="horizontal dark mt-0 mb-2" />
      <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link text-white" href="../pages/users.php">
            <i class="fa-solid fa-user"></i>
            <span class="nav-link-text ms-1">會員管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="../pages/order.php">
          <i class="fa-solid fa-file"></i>
            <span class="nav-link-text ms-1">訂單管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="../pages/product.php">
            <i class="fa-solid fa-camera"></i>
            <span class="nav-link-text ms-1">商品管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="../pages/rental.php">
            <i class="fa-solid fa-handshake"></i>
            <span class="nav-link-text ms-1">租借商品管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="../pages/course.php">
            <i class="fa-solid fa-book"></i>
            <span class="nav-link-text ms-1">課程管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active bg-white text-dark" href="../pages/coupon.php">
            <i class="fa-solid fa-ticket"></i>
            <span class="nav-link-text ms-1">優惠券管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="../pages/article.php">
            <i class="fa-solid fa-book-open"></i>
            <span class="nav-link-text ms-1">文章管理</span>
          </a>
        </li>
      </ul>
    </div>

  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur"
      data-scroll="true">
      <div class="container-fluid py-1 px-3 justify-content-end">
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
    <!-- End Navbar -->
    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">優惠券列表</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">名稱</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">優惠券代碼</th>
                      <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">開始日</th>
                      <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">截止日</th>
                      <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">折扣</th>
                      <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">最低消費</th>
                      <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">數量</th>
                      <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">狀態</th>
                      <th class="qopacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        foreach($rows as $row):
                    ?>
                    <tr>
                        <td><?=$row["name"]?></td>
                        <td><?=$row["coupon_code"]?></td>
                        <td><?=$row["start_date"]?></td>
                        <td><?=$row["end_date"]?></td>
                        <td><?=$row["discount"]?></td>
                        <td><?=$row["lower_purchase"]?></td>
                        <td><?=$row["quantity"]?></td>
                        <td id="show">
                            <?php if($row["is_deleted"] == 0):?>已上架
                            <?php else:?>已下架
                            <?php endif;?>
                            
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success mb-2 mt-2 btn-upDownLoad" data-status="0" data-id="<?=$row["id"] ?>">上架</button>
                                <button class="btn btn-warning mb-2 mt-2 btn-upDownLoad" data-status="1" data-id="<?=$row["id"] ?>">下架</button>
                                <a href="updateCoupon.php" class="btn btn-info">修改</a>
                                <button class="btn btn-danger mb-2 mt-2 btn-deleted" data-id="<?=$row["id"] ?>">刪除</button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer py-4  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                for a better web.
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-symbols-rounded py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Material UI Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-symbols-rounded">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1" />
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark active" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2" data-class="bg-gradient-dark" onclick="sidebarType(this)">
            Dark
          </button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">
            Transparent
          </button>
          <button class="btn bg-gradient-dark px-3 mb-2 active ms-2" data-class="bg-white" onclick="sidebarType(this)">
            White
          </button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">
          You can change the sidenav type just on desktop view.
        </p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)" />
          </div>
        </div>
        <hr class="horizontal dark my-3" />
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)" />
          </div>
        </div>
        <hr class="horizontal dark my-sm-4" />
        <a class="btn bg-gradient-info w-100" href="https://www.creative-tim.com/product/material-dashboard-pro">Free
          Download</a>
        <a class="btn btn-outline-dark w-100"
          href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View documentation</a>
        <div class="w-100 text-center">
          <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard"
            data-icon="octicon-star" data-size="large" data-show-count="true"
            aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
          <h6 class="mt-3">Thank you for sharing!</h6>
          <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard"
            class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard"
            class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i>
            Share
          </a>
        </div>
      </div>
    </div>
  </div>
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
  <?php include_once("../../js.php")?>
  <script>
     $(".btn-upDownLoad").click(function(){
        let transData = $(this).data();
        $.ajax({
            method:"POST",
            url:"./api/statusCouponStatus.php",
            data:{
                status:transData.status,
                id:transData.id
            }
        })
        .done(function(response){   
          document.location.reload();
        })
        .fail(function(jqXHR,textStatus,errorThrown){
            console.log(textStatus,errorThrown);
        }) 
    })

    $(".btn-deleted").click(function(){
        let transData = $(this).data();
        console.log(transData);
        $.ajax({
            method:"POST",
            url:"./api/doDeleteCoupon.php",
            data:{
                id:transData.id
            }
        })
        .done(function(response){   
          document.location.reload();
        })
        .fail(function(jqXHR,textStatus,errorThrown){
            console.log(textStatus,errorThrown);
        }) 
    })
  </script>
</body>

</html>
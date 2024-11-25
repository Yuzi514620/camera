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
  <?php $page = 'coupon'; ?>
  <?php include 'sidebar.php'; ?>
  <!-- 側邊欄 -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
      <?php $page = 'coupon'; ?>
      <?php include 'navbar.php'; ?>
    <!-- Navbar -->

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
                      <!-- <th class="text-secondary opacity-7"></th> -->
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
                        <td>
                            <?php if($row["is_deleted"] == 0):?>已上架
                            <?php else:?>已下架
                            <?php endif;?>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success mb-2 mt-2 btn-upDownLoad" data-status="0" data-id="<?=$row["id"] ?>">上架</button>
                                <button class="btn btn-danger mb-2 mt-2 btn-upDownLoad" data-status="1" data-id="<?=$row["id"] ?>">下架</button>
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
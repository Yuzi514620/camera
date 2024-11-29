<?php
session_start();
$id = $_SESSION["id"];
require_once("pdo_connect.php");
$pdoSql = "SELECT * FROM coupon WHERE `coupon`.`id` = ?";

$stmt = $db_host->prepare($pdoSql);
try {
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $data = [
        'message' => '預處理陳述式執行失敗！ <br/>',
        'code' =>   "Error: " . $e->getMessage() . "<br/>"
    ];
    echo json_encode($data);
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
    <style>
        .textbox {

            .input-box,
            .btn-box {
                width: auto;
                display: flex;
                justify-content: center;
            }

            input {
                border: 2px solid gray;
                color: black;
            }

            input:focus {
                color: black;
                border: 2px solid black;
                transition: 0.4s;
            }
        }
    </style>

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
            <div class="container-fluid py-2">
                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="textbox card-body px-0 pb-2">
                                <div class=" p-0 rounded-top">
                                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                        <h6 class="text-white text-capitalize ps-3">修改優惠券</h6>
                                    </div>
                                    <div class="input-box row-auto g-2 mt-2">
                                        <div class="col-1">
                                            <span>名稱</span>
                                        </div>
                                        <div class="col-5">
                                            <input type="text" class="form-control " name="name" id="name" value="<?= $result["name"] ?>">
                                        </div>
                                    </div>
                                    <div class="input-box row-auto g-2 mt-2">
                                        <div class="col-1">
                                            <span>折扣</span>
                                        </div>
                                        <div class="col-5">
                                            <input type="number" class="form-control " name="discount" id="discount" value="<?= $result["discount"] ?>">
                                        </div>
                                    </div>
                                    <div class="input-box row-auto g-2 mt-2">
                                        <div class="col-1">
                                            <span>最低消費</span>
                                        </div>
                                        <div class="col-5">
                                            <input type="text" class="form-control " name="lower_purchase" id="lower_purchase" value="<?= $result["lower_purchase"] ?>">
                                        </div>
                                    </div>
                                    <div class="input-box row-auto g-2 mt-2">
                                        <div class="col-1">
                                            <span>數量</span>
                                        </div>
                                        <div class="col-5">
                                            <input type="text" class="form-control " name="quantity" id="quantity" value="<?= $result["quantity"] ?>">
                                        </div>
                                    </div>
                                    <div class="btn-box position-relative mt-3 ">
                                        <button class="btn btn-info btn-update me-3">完成</button>
                                        <a href="../pages/coupon.php" class="btn btn-info">返回</a>
                                    </div>
                                </div>
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
    <?php include_once("../../js.php") ?>
    <script>
        const name = document.querySelector("#name");
        const discount = document.querySelector("#discount");
        const lower_purchase = document.querySelector("#lower_purchase");
        const quantity = document.querySelector("#quantity");
        const id = <?= $id ?>;
        $(".btn-update").click(function() {
            $.ajax({
                    method: "POST",
                    url: "doUpdateCoupon.php",

                    data: {
                        id: id,
                        name: name.value,
                        discount: discount.value,
                        lower_purchase: lower_purchase.value,
                        quantity: quantity.value
                    }
                })
                .done(function(response) {
                    window.location.replace("../pages/coupon.php");
                })
                .fail(function(jqXHR, textStatus) {
                    console.log(textStatus);
                })
        })
    </script>
</body>

</html>
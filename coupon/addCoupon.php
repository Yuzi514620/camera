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

            input,
            select {
                border: 2px solid gray;
                color: black;
            }

            input:focus,
            select:focus {
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
    <?php include '../sidebar.php'; ?>
    <!-- 側邊欄 -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <?php
        // 設定麵包屑的層級
        $breadcrumbs = [
            'user' => '首頁',
            'coupon' => '優惠券列表', // 第一層的文字
            'addCoupon' => "新增優惠券"
        ];

        $page = 'addCoupon'; //當前的頁面

        // 設定麵包屑的連結
        $breadcrumbLinks = [
            'user' => '../users/users.php',
            'coupon' => '../pages/coupon.php', // 第一層的連結
            'addCoupon' => 'addCoupon.php'
        ];

        include '../navbar.php';
        ?>
        <!-- Navbar -->
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <div class="container-fluid py-2">
                <div class="container-fluid py-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="card my-4">
                                <div class="card-body px-0 pb-2">
                                    <div class="p-0 rounded-top">
                                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                            <h6 class="text-white text-capitalize ps-3">新增優惠券</h6>
                                        </div>
                                        <div class="textbox card-body px-0 pb-2 mt-3 position-relative">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-1 ">
                                                    <span>品牌</span>
                                                </div>
                                                <div class="col-2">
                                                    <select name="coupon-select" class="coupon-select form-select " aria-label="Default select example">
                                                        <option value="" selected disabled>請選擇</option>
                                                        <option value="0">全館</option>
                                                        <option value="1">sony</option>
                                                        <option value="2">Nikon</option>
                                                        <option value="3">Canon</option>
                                                        <option value="4">FUJFILM</option>
                                                    </select>
                                                </div>
                                                <div class="col-1">
                                                    <span>配件</span>
                                                </div>
                                                <div class="col-1">
                                                    <select name="coupon-subselect" class="coupon-subselect form-select" aria-label="Default select example">
                                                        <option value="" selected disabled>請選擇</option>
                                                        <option value="0">全館</option>
                                                        <option value="1">相機</option>
                                                        <option value="2">鏡頭</option>
                                                        <option value="3">包包</option>
                                                        <option value="4">背帶</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="input-box row-auto g-2 mt-2 ms-2 align-items-center">
                                                <div class="col-1">
                                                    <span>名稱</span>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control " name="name" id="name">
                                                </div>
                                            </div>
                                            <div class="input-box row-auto g-2 mt-2 ms-2 align-items-center">
                                                <div class="col-1">
                                                    <span>折扣</span>
                                                </div>
                                                <div class="col-4">
                                                    <input type="number" class="form-control " name="discount" id="discount">
                                                </div>
                                            </div>
                                            <div class="input-box row-auto g-2 mt-2 ms-2 align-items-center">
                                                <div class="col-1">
                                                    <span>最低消費</span>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control " name="lower_purchase" id="lower_purchase">
                                                </div>
                                            </div>
                                            <div class="input-box row-auto g-2 mt-2 ms-2 align-items-center">
                                                <div class="col-1">
                                                    <span>數量</span>
                                                </div>
                                                <div class="col-4">
                                                    <input type="number" class="form-control " name="quantity" id="quantity">
                                                </div>
                                            </div>
                                            <div class="input-box row-auto g-2 mt-2 ms-2 align-items-center">
                                                <div class="col-1">
                                                    <span>有效天數</span>
                                                </div>
                                                <div class="col-4">
                                                    <input type="number" class="form-control " name="quantity" id="days">
                                                </div>
                                            </div>
                                            <div class="input-box row-auto g-2 mt-2 ms-2 align-items-center">
                                                <div class="col-1">
                                                    <span>上傳圖片</span>
                                                </div>
                                                <div class="col-4">
                                                    <input type="file" class="form-control " name="img" id="uploadImg" accept="image/*">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <span class="imgError"></span>
                                            </div>
                                            <div class="btn-box position-relative mt-3 ">
                                                <button class="btn btn-success btn-add me-3">完成</button>
                                                <a href="../pages/coupon.php" class="btn btn-info">返回</a>
                                            </div>
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
            $(".btn-add").click(function() {
                const brand = $("select[name='coupon-select']").val();
                const accessories = $("select[name='coupon-subselect']").val();
                const brandText = $(".coupon-select option:selected").text();
                const accessoriesText = $(".coupon-subselect option:selected").text();

                const name = document.querySelector("#name").value;
                const discount = document.querySelector("#discount").value;
                const lower_purchase = document.querySelector("#lower_purchase").value;
                const quantity = document.querySelector("#quantity").value;
                const days = document.querySelector("#days").value;
                const imgError = document.querySelector(".imgError");

                const file_data = $('#uploadImg').prop('files')[0];
                
                if (file_data != null) {
                    $.ajax({
                            method: "POST",
                            url: "doAddCoupon.php",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data(file_data,name,discount,lower_purchase,quantity,days,brand,accessories,brandText,accessoriesText)

                        })
                        .done(function(response) {
                            
                            window.location.replace("../pages/coupon.php");
                        })
                        .fail(function(jqXHR, textStatus) {
                            console.log(textStatus);
                        })
                } 
                else {
                    imgError.textContent = "請上傳圖片";
                    imgError.style.color = "red";
                }
            })
            function form_data(file_data,name,discount,lower_purchase,quantity,days,brand,accessories,brandText,accessoriesText) {
                let form_data = new FormData();
                keyArr = ['file','name','discount','lower_purchase','quantity','days','brand','accessories','brandText','accessoriesText'];
                dataArr = [file_data,name,discount,lower_purchase,quantity,days,brand,accessories,brandText,accessoriesText];
                length = dataArr.length;

                for(let i = 0 ;i<length; i++){
                    form_data.append(`${keyArr[i]}`,dataArr[i]);
                }

                return form_data;
            }
        </script>
</body>

</html>
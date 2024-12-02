<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-gradient-dark my-2"
    id="sidenav-main">
    <div class="sidenav-header d-flex justify-content-center align-items-center">
        <i
            class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true"
            id="iconSidenav"></i>
        <a
            class=" px-4 py-2 mt-4"
            href="#"
            target="_blank">
            <img
                src="../assets/img/camera_logo-01.png"
                class=""
                style="width: 100px; height: 100px;"
                alt="main_logo" />
            <!-- <span class="ms-1 text-sm text-white">Camera</span> -->
        </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2" />
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?= $page === 'users' ? 'active bg-white text-dark' : 'text-white' ?>" href="../users/users.php">
                    <i class="fa-regular fa-user opacity-5 fa-xs" style="font-size: 15px"></i>
                    <span class="nav-link-text ms-1">會員管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page === 'order' ? 'active bg-white text-dark' : 'text-white' ?>" href="">
                    <i class="material-symbols-rounded opacity-5">table_view</i>
                    <span class="nav-link-text ms-1">訂單管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page === 'product' ? 'active bg-white text-dark' : 'text-white' ?>" href="../product/product.php">
                    <i class="material-symbols-rounded opacity-5">receipt_long</i>
                    <span class="nav-link-text ms-1">商品管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page === 'course' ? 'active bg-white text-dark' : 'text-white' ?>" href="../course/course.php">
                    <i class="material-symbols-rounded opacity-5">view_in_ar</i>
                    <span class="nav-link-text ms-1">課程管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page === 'teacher' ? 'active bg-white text-dark' : 'text-white' ?>" href="../teacher/teacher.php">
                    <i class="fa-regular fa-address-book opacity-5" style="font-size: 15px"></i>
                    <span class="nav-link-text ms-1">師資管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page === 'article' ? 'active bg-white text-dark' : 'text-white' ?>" href="../article/article.php">
                    <i class="fa-regular fa-newspaper opacity-5" style="font-size: 14px"></i>
                    <span class="nav-link-text ms-1">文章管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page === 'coupon' ? 'active bg-white text-dark' : 'text-white' ?>" href="../pages/coupon.php">
                    <i class="fa-solid fa-ticket opacity-5" style="font-size: 13px"></i>
                    <span class="nav-link-text ms-1">優惠券管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page === 'album' ? 'active bg-white text-dark' : 'text-white' ?>" href="../album/album.php">
                    <i class="fa-regular fa-image opacity-5" style="font-size: 14px"></i> 
                    <span class="nav-link-text ms-1">媒體庫管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page === 'rental' ? 'active bg-white text-dark' : 'text-white' ?>" href="../rental/camera_list.php">
                    <i class="fa-solid fa-arrow-right-arrow-left opacity-5" style="font-size: 14px"></i>
                    <span class="nav-link-text ms-1">租借商品管理</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-dark my-2" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none fa-fw" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand px-4 py-3 m-0" href="#" target="_blank">
            <span class="ms-1 text-sm text-white">Camera</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2" />
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?= $page === 'users' ? 'active bg-white text-dark' : 'text-white' ?>" href="../pages/users.php">
                    <i class="fa-solid fa-user fa-fw"></i>
                    <span class="nav-link-text ms-1">會員管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page === 'order' ? 'active bg-white text-dark' : 'text-white' ?>" href="../pages/order.php">
                    <i class="fa-solid fa-file fa-fw"></i>
                    <span class="nav-link-text ms-1">訂單管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page === 'product' ? 'active bg-white text-dark' : 'text-white' ?>" href="../pages/product.php">
                    <i class="fa-solid fa-camera fa-fw"></i>
                    <span class="nav-link-text ms-1">商品管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page === 'rental' ? 'active bg-white text-dark' : 'text-white' ?>" href="../pages/rental.php">
                    <i class="fa-solid fa-handshake fa-fw"></i>
                    <span class="nav-link-text ms-1">租借商品管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page === 'course' ? 'active bg-white text-dark' : 'text-white' ?>" href="../pages/course.php">
                    <i class="fa-solid fa-book fa-fw"></i>
                    <span class="nav-link-text ms-1">課程管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page === 'coupon' ? 'active bg-white text-dark' : 'text-white' ?>" href="../pages/coupon.php">
                    <i class="fa-solid fa-ticket fa-fw"></i>
                    <span class="nav-link-text ms-1">優惠券管理</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page === 'article' ? 'active bg-white text-dark' : 'text-white' ?>" href="../pages/article.php">
                    <i class="fa-solid fa-book-open fa-fw"></i>
                    <span class="nav-link-text ms-1">文章管理</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-light sidebar accordion" id="accordionSidebar">
<!-- Sidebar sidebar-light - Brand -->

<a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
    <div class="sidebar-brand-icon">
        <!-- <i class="fas fa-laugh-wink"></i> -->
         <img width="25px" src="/themes/sb-admin-2-gh-pages/img/CPN-Fav-ICON.png" alt="">
    </div>
    <!-- <div class="sidebar-brand-text mx-3">Compaynet</div> -->
    <div class="sidebar-brand-text"><img width="140px" src="/themes/sb-admin-2-gh-pages/img/Compaynet_logo_no_icon.png" alt=""></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item <?php echo ($active_sidebar == 'dashboard') ? 'active' : '';?>">
    <a class="nav-link" href="/">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Interface
</div>
<li class="nav-item <?php echo ($active_sidebar == 'users') ? 'active' : '';?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
        aria-expanded="true" aria-controls="collapseOne">
        <i class="fas fa-fw fa-user-circle"></i>
        <span>Users</span>
    </a>
    <div id="collapseOne" class="collapse <?php echo ($active_sidebar == 'users') ? 'show' : '';?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Users Management:</h6>
            <a class="collapse-item" href="<?php echo site_url('users/new');?>">New User</a>
            <a class="collapse-item" href="<?php echo site_url('users');?>">Lists of Users</a>
        </div>
    </div>
</li>
<li class="nav-item <?php echo ($active_sidebar == 'seller') ? 'active' : '';?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-users"></i>
        <span>Sellers</span>
    </a>
    <div id="collapseTwo" class="collapse <?php echo ($active_sidebar == 'seller') ? 'show' : '';?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Seller Management:</h6>
            <a class="collapse-item" href="<?php echo site_url('seller/add');?>">New Seller</a>
            <a class="collapse-item" href="<?php echo site_url('seller');?>">Lists of Sellers</a>
        </div>
    </div>
</li>

<li class="nav-item <?php echo ($active_sidebar == 'buyer') ? 'active' : '';?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
        aria-expanded="true" aria-controls="collapseThree">
        <i class="fas fa-fw fa-user"></i>
        <span>Buyers</span>
    </a>
    <div id="collapseThree" class="collapse <?php echo ($active_sidebar == 'buyer') ? 'show' : '';?>" aria-labelledby="collapseThree" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Buyer Management:</h6>
            <a class="collapse-item" href="<?php echo site_url('buyer/add');?>">New Buyer</a>
            <a class="collapse-item" href="<?php echo site_url('buyer');?>">Lists of Buyers</a>
        </div>
    </div>
</li>


<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item <?php echo ($active_sidebar == 'factoring') ? 'active' : '';?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#FactoringFacilities"
        aria-expanded="true" aria-controls="FactoringFacilities">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Factoring</span>
    </a>
    <div id="FactoringFacilities" class="collapse <?php echo ($active_sidebar == 'factoring') ? 'show' : '';?>" aria-labelledby="headingFactoringFacilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Factoring Facility:</h6>
            <a class="collapse-item" href="<?php echo site_url('factoring/create');?>">Create factoring</a>
            <a class="collapse-item" href="<?php echo site_url('factoring');?>">Lists of factoring</a>
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<!-- <div class="sidebar-heading">
    Addons
</div> -->

<!-- Nav Item - Pages Collapse Menu -->
<!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-folder"></i>
        <span>Pages</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Login Screens:</h6>
            <a class="collapse-item" href="/themes/sb-admin-2-gh-pages/login.html">Login</a>
            <a class="collapse-item" href="/themes/sb-admin-2-gh-pages/register.html">Register</a>
            <a class="collapse-item" href="/themes/sb-admin-2-gh-pages/forgot-password.html">Forgot Password</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Pages:</h6>
            <a class="collapse-item" href="/themes/sb-admin-2-gh-pages/404.html">404 Page</a>
            <a class="collapse-item" href="/themes/sb-admin-2-gh-pages/blank.html">Blank Page</a>
        </div>
    </div>
</li> -->

<!-- Nav Item - Charts -->
<!-- <li class="nav-item">
    <a class="nav-link" href="/themes/sb-admin-2-gh-pages/charts.html">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Charts</span></a>
</li> -->

<!-- Nav Item - Tables -->
<!-- <li class="nav-item">
    <a class="nav-link" href="/themes/sb-admin-2-gh-pages/tables.html">
        <i class="fas fa-fw fa-table"></i>
        <span>Tables</span></a>
</li> -->

<!-- Divider -->
<!-- <hr class="sidebar-divider d-none d-md-block"> -->

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

<!-- Sidebar Message -->
<div class="sidebar-card d-none d-lg-flex bd-gray-700">
    <p class="text-center mb-2 text-gray-900">Powered by </p>
    <img class="sidebar-card-illustration mb-2" width="80" style="height: 15px;" src="/themes/sb-admin-2-gh-pages/img/mondu-new_logo.svg" alt="...">
    <!-- <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a> -->
</div>

</ul>
<!-- End of Sidebar -->
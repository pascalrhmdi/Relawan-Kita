<ul class="navbar-nav bg-gray-900 sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3">RELAWAN KITA - <?= $_SESSION['role']; ?></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <?php if ($_SESSION['role'] == 'admin') : ?>
        <!-- Heading -->
        <div class="sidebar-heading">
            Kelola Acara
        </div>

        <li class="nav-item">
            <a class="nav-link " href="./jenis-acara.php">
                <i class="fa fa-list"></i>
                <span>Kelola Jenis Acara</span></a>
            <a class="nav-link " href="./acara.php">
                <i class="fa fa-list"></i>
                <span>List Acara</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Kelola User
        </div>

        <li class="nav-item">
            <a class="nav-link " href="./relawan.php">
                <i class="fa fa-list"></i>
                <span>Manajemen Relawan</span></a>
            <a class="nav-link " href="./organisasi.php">
                <i class="fa fa-list"></i>
                <span>Manajemen Organisasi</span></a>
        </li>

    <?php else : ?>
        <!-- Heading -->
        <div class="sidebar-heading">
            Kelola Acara
        </div>

        <li class="nav-item">
            <a class="nav-link " href="./listacara.php">
                <i class="fa fa-list"></i>
                <span>List Acara</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Pengaturan
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link" href="./editprofil.php">
                <i class="fa fa-user-edit"></i>
                <span>Ubah Profile</span></a>
        </li>
    <?php endif; ?>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">


    <!-- Heading -->
    <div class="sidebar-heading">
        Lainnya
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fa fa-sign-out-alt"></i>
            <span>Log Out</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
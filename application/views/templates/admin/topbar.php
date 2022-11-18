<!-- Content Start -->
<div class="content" id="my-container">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand sticky-top fixed-top px-4 py-0" style="background-color: #242F9B;">
        <a style="background-color: #242F9B;" href="#" class="sidebar-toggler flex-shrink-0" id="tugel">
            <i class="fa fa-bars text-white"></i>
        </a>
        <div class="navbar-nav align-items-center ms-auto">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle" style="background-color: #242F9B;"></i>
                    <span class="d-none d-lg-inline-flex"><b><i
                                style="background-color: #242F9B;"><?= $user['username'] ?></i></b></span>
                </a>
                <div style="background-color: #242F9B;"
                    class="dropdown-menu dropdown-menu-end border-0 rounded-0 rounded-bottom m-0">
                    <a style="background-color: #242F9B;" href="<?= base_url('auth/logout') ?>"
                        class="dropdown-item text-light"><i class="fas fa-sign-out-alt me-2"></i> <b>Keluar</b></a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
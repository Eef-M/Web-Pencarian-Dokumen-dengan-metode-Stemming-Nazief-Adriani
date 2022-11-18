<!-- <div class="main bf-dark" id="top"> -->
<div class="content">

    <nav class="navbar navbar-expand-lg navbar-dark mb-3" style="background-color: #242F9B;">
        <div class="container-fluid">
            <a href="<?= base_url('user/landingpage') ?>" class="navbar-brand"><strong>PENCARIAN DOKUMEN</strong></a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto">
                    <a href="#" class="nav-item nav-link text-white" style="pointer-events: none;"><i
                            class="fa-solid fa-user me-2"></i><?= $user['username'] ?></a>
                    <!-- <a href="#" class="nav-item nav-link"><i class="fa-solid fa-book me-2"></i>Library</a> -->
                    <a href="<?= base_url('auth/logout') ?>" class="nav-item nav-link text-white"><i
                            class="fas fa-sign-out-alt me-2"></i>Keluar</a>
                </div>
            </div>
        </div>
    </nav>
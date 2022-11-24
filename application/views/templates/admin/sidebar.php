<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3" style="background-color: #DBDFFD;">
    <nav class="navbar">
        <div class="d-flex justify-content-center align-items-center mx-2 flex-column p-2">
            <a href="#" style="color: #242F9B;"><b>PENCARIAN DOKUMEN</b></a>
            <p style="color: #242F9B;">Stemming Nazief & Adriani</p>
        </div>
        <ul class="navbar-nav w-100">
            <li class="nav-item mb-2">
                <a href="<?= base_url('admin/dashboard') ?>"
                    class="nav-link <?php if($this->uri->segment(2) == 'dashboard') echo 'active' ?>">
                    <i class="fa fa-tachometer-alt me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="<?= base_url('admin/datadokumen') ?>"
                    class="nav-link <?php if($this->uri->segment(2) == 'datadokumen') echo 'active' ?>">
                    <i class="fas fa-file-alt me-2"></i>
                    Data Document
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="<?= base_url('admin/tokenandstemdata') ?>"
                    class="nav-link <?php if($this->uri->segment(2) == 'tokenandstemdata') echo 'active' ?>">
                    <i class="fas fa-th-list me-2"></i>
                    Data Stemming
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="<?= base_url('admin/tambahdata') ?>"
                    class="nav-link <?php if($this->uri->segment(2) == 'tambahdata') echo 'active' ?>">
                    <i class="fas fa-folder-plus me-2 me-2"></i>
                    Tambah Data
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="<?= base_url('auth/logout') ?>" class="nav-link">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Keluar
                </a>
            </li>
        </ul>

        <!-- <div class="navbar-nav w-100">
            <a href="<?= base_url('dashboard') ?>" class="nav-item nav-link mb-2 ">
                <i class="fa fa-tachometer-alt me-2"></i>
                Dashboard
            </a>

            <a href="<?= base_url('admin/tambah_data') ?>" class="nav-item nav-link mb-2 ">
                <i class="fas fa-folder-plus me-2 me-2"></i>
                Tambah Data
            </a>

            <a href="table.html" class="nav-item nav-link mb-2">
                <i class="fas fa-file-alt me-2 me-2"></i></i>
                Data Document
            </a>

            <a href="chart.html" class="nav-item nav-link mb-2">
                <i class="fas fa-sign-out-alt me-2 me-2"></i>
                Logout
            </a>
        </div> -->
    </nav>
</div>
<!-- Sidebar End -->
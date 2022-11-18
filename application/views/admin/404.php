<div class="container-fluid pt-4 px-4">
    <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
        <div class="col-md-6 text-center p-4">
            <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
            <h1 class="display-1 fw-bold">ERROR</h1>
            <h1 class="mb-4">File tidak dapat di upload</h1>
            <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error ?></div>
            <?php endif ?>
            <p class="mb-4">We’re sorry, the page you have looked for does not exist in our website!
                Maybe go to our home page or try to use a search?</p>
            <a class="btn btn-primary rounded-pill py-3 px-5" href="<?= base_url('admin/tambahdata') ?>">Kembali ke
                Tambah Data</a>
        </div>
    </div>
</div>
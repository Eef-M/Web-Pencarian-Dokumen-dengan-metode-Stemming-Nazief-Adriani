<!-- Blank Start -->
<div class="container-fluid py-4 px-4">
    <div class="row">
        <div class="col-12 mt-3 mb-1">
            <h5 class="text-uppercase" style="color: #242F9B;">Dashboard</h5>
            <p>Stemming Algoritma Nazief & Adriani</p>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12 mb-4">
            <div class="card" style="background-color: #DBDFFD;">
                <div class="card-body">
                    <div class="d-flex justify-content-between px-md-1">
                        <div>
                            <h3 class="text-success"><?= $total_upload ?></h3>
                            <p class="mb-0 text-success"><strong>DATA DOKUMEN</strong></p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-book-open text-success fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 mb-4">
            <div class="card" style="background-color: #DBDFFD;">
                <div class="card-body">
                    <div class="d-flex justify-content-between px-md-1">
                        <div>
                            <h3 class="text-primary"><?= $total_token ?></h3>
                            <p class="mb-0 text-primary"><strong>STEMMING</strong></p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-database text-primary fa-3x"></i>
                            <!-- <i class="far fa-comments text-warning fa-3x"></i> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-3 mb-1">
            <div class="card my-3 mx-2 p-3" style="background-color: #DBDFFD;">
                <img src="<?= base_url('assets/img/uad.webp') ?>" class="card-img-top" alt="...">
            </div>
        </div>
    </div>
</div>
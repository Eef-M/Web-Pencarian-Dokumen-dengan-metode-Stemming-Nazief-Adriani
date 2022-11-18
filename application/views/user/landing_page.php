<div class="container rounded search-box">
    <div class="row rounded align-items-center justify-content-center mx-0">
        <div class="col-md-9 text-center">
            <?= $this->session->flashdata('message') ?>
            <form action="<?= base_url('user/search') ?>" method="post">
                <div class="input-group form-container">
                    <input required type="text" name="keyword" class="form-control border border-primary"
                        placeholder="Cari Dokumen ..." autocomplete="off" autofocus>
                    <button style="background-color: #242F9B;" type="submit" class="btn text-white">Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- 
<div class="container">
    <div class="card text-center my-4 mx-4 bg-dark">
        <div class="card-body">
            <form action="" method="post">
                <div class="input-group form-container">
                    <input type="text" name="search" class="form-control border border-primary"
                        placeholder="Cari Dokumen ..." autocomplete="off" autofocus>
                    <button style="background-color: #2155CD;" type="submit" class="btn text-white">Cari</button>
                </div>
            </form>
        </div>
    </div>
</div> -->

<!-- <div class="container pt-4 px-4 bg-warning">
    <div class="row vh-100 rounded align-items-center justify-content-center">
        <div class="col-md-6 text-center bg-dark">
            <h3>DASHBOARD</h3>
        </div>
    </div>
</div> -->
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
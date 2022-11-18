<div class="card mx-6 my-3">
    <div class="card-body text-start">


        <?php if (empty($stemming)) { ?>
        <h1 class="text-center">Data Belum di Stemming</h1>
        <p class="text-center"><i>Silahkan Stemming terlebih dahulu melalui <b>Admin</b></i></p>
        <div class="mb-2 text-center">
            <a href="<?= base_url('user/landingpage') ?>" class="btn"
                style="background-color: #242F9B; color: white;">Kembali ke halaman pencarian</a>
        </div>
        <?php } else { ?>
        <div class="mb-2">
            <a href="<?= base_url('user/landingpage') ?>" class="btn"
                style="background-color: #242F9B; color: white;">Kembali ke halaman pencarian</a>
        </div>
        <table class="table table-bordered border-primary">
            <thead>
                <tr class="text-center" style="background-color: #242F9B; color: white;">
                    <th scope="col">ID Token</th>
                    <th scope="col">Token</th>
                    <th scope="col">Stemming</th>
                </tr>
            </thead>
            <?php $no = 1; ?>
            <?php foreach($stemming as $stem) { ?>
            <tbody>
                <tr class="text-center" style="background-color: #DBDFFD; color: white;">
                    <td><strong class="text-dark"><?= $stem->dokumen_id ?></strong></td>
                    <td><strong class="fw-bold fst-italic text-dark"><?= $stem->token ?></strong></td>
                    <td><strong class="fw-bold fst-italic text-dark"><?= $stem->stemming ?></strong></td>
                </tr>
            </tbody>
            <?php } ?>
        </table>
        <?php } ?>


    </div>
    <!-- </a> -->
</div>


<div>
    <div class="card my-4"></div>
</div>
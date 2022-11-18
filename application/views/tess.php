<div class="card mx-6 my-3">
    <div class="card-body text-start">
        <div class="mb-2">
            <a href="<?= base_url('user/landingpage') ?>" class="btn btn-primary">Kembali</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr class="text-center text-dark bg-200">
                    <th scope="col">No</th>
                    <th scope="col">Dokumen ID</th>
                    <th scope="col">Token</th>
                    <th scope="col">Stemming</th>
                </tr>
            </thead>
            <?php $no = 1; ?>
            <?php foreach($stemming as $stem) { ?>
            <tbody>
                <tr class="text-center">
                    <td><strong class="text-900"><b><?= $no++; ?></b></strong>
                    </td>
                    <td><strong class="fw-bold fst-italic text-info"><?= $stem->dokumen_id ?></strong>
                    </td>
                    <td><strong class="fw-bold fst-italic text-danger"><?= $stem->token ?></strong>
                    </td>
                    <td><strong class="fw-bold fst-italic text-primary"><?= $stem->stemming ?></strong>
                    </td>
                </tr>
            </tbody>
            <?php } ?>
        </table>
    </div>
    <!-- </a> -->
</div>


<div>
    <div class="card my-4"></div>
</div>
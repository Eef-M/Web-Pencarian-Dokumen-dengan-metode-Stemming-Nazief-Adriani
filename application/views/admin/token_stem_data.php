<div class="container-fluid pt-4 px-4 mb-4">
    <div class="rounded p-4 h-100" id="ThePage">
        <!-- <div class="mb-2">
            <a href="<?= base_url('user/landingpage') ?>" class="btn btn-secondary">Kembali</a>
        </div> -->
        <h3 class="mb-4 text-center">DATA STEMMING DAN TOKEN</h3>
        <hr class="mb-4" style="border-radius: 3px; height: 5px; color: #646FD4">
        <?= $this->session->flashdata('message') ?>
        <table class="table table-bordered border-secondary">
            <thead>
                <tr class="text-center text-light">
                    <th scope="col">No</th>
                    <th scope="col">Dokumen ID</th>
                    <th scope="col">Token</th>
                    <th scope="col">Stemming</th>
                </tr>
            </thead>
            <?php $no = 1; ?>
            <?php foreach($stemming as $stem) { ?>
            <tbody>
                <tr class="text-center text-dark">
                    <td><?= $no++; ?></td>
                    <td><?= $stem->dokumen_id ?></td>
                    <td><strong class="fw-bold fst-italic text-dark"><?= $stem->token ?></strong>
                    </td>
                    <td><strong class="fw-bold fst-italic text-dark"><?= $stem->stemming ?></strong>
                    </td>
                </tr>
            </tbody>
            <?php } ?>
        </table>
    </div>
</div>
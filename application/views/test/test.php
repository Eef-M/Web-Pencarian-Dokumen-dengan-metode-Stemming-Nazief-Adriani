<!-- Blank Start -->
<div class="container-fluid pt-4 px-4">
    <div class="rounded p-4 h-100 bg-light" id="ThePage">
        <h3 class="mb-4 text-center">DATA DOKUMEN</h3>
        <?= $this->session->flashdata('message') ?>
        <hr class="mb-4" style=" color: #2155cd; border-radius: 3px; height: 5px;">
        <div class="table-responsive">
            <table class="table text-center">
                <thead class="text-dark" style="background-color: #2155cda3;">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Judul Dokumen</th>
                        <th scope="col">Nama Penulis</th>
                        <th scope="col">File Dokumen</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <?php
                        $no = 1;
                        foreach($dokumen as $dkmn) {
                        ?>
                <tbody>
                    <tr>
                        <th scope="row"><?= $no++ ?></th>
                        <td><?= $dkmn->judul_dokumen ?></td>
                        <td><?= $dkmn->nama_penulis ?></td>
                        <td><a class="btn btn-success fw-bold"
                                href="<?= base_url('uploads/').$dkmn->file_dokumen ?>"><span>Download File</span></a>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/datadokumen/edit/'. $dkmn->id) ?>"
                                class="btn btn-info me-2 mb-2"><i class="bi bi-pencil-fill"></i></a>
                            <a href="<?= base_url('admin/datadokumen/hapus/'. $dkmn->id) ?>"
                                class="btn btn-danger me-2 mb-2"><i class="bi bi-trash-fill"></i></a>
                        </td>
                    </tr>
                </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
<!-- Blank End -->
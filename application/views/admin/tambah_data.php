<style>
input[type="text"] {
    text-transform: uppercase;
}

input::placeholder {
    text-transform: lowercase;
}
</style>

<div class="container-fluid pt-4 px-4 mb-4">
    <div class="rounded p-4 h-100" id="ThePage">
        <h3 class="mb-4 text-center">TAMBAH DATA DOKUMEN</h3>
        <hr class="mb-4" style="border-radius: 3px; height: 5px; color: #646FD4">
        <?= $this->session->flashdata('message') ?>
        <form action="<?= base_url('admin/tambahdata/tambah_aksi') ?>" method="POST">
            <div class="mb-3">
                <label for="dokumen_id" class="form-label"><b>ID Dokumen</b> <b style="color:red;">*</b></label><br>
                <label class="form-label text-secondary"><i>Contoh: 001/INF/2022</i></label>
                <input type="text" class="form-control text-dark" id="dokumen_id" name="dokumen_id"
                    placeholder="Masukkan id dokumen..">
                <?= form_error('dokumen_id', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="mb-3">
                <label for="dokumen_judul" class="form-label"><b>Judul Dokumen</b> <b style="color:red;">*</b></label>
                <input type="text" class="form-control text-dark" id="dokumen_judul" name="dokumen_judul"
                    placeholder="Masukkan judul dokumen..">
                <?= form_error('dokumen_judul', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="mb-3">
                <label for="dokumen_penulis" class="form-label"><b>Penulis Dokumen</b> <b
                        style="color:red;">*</b></label>
                <input type="text" class="form-control text-dark" id="dokumen_penulis" name="dokumen_penulis"
                    placeholder="Masukkan penulis dokumen..">
                <?= form_error('dokumen_penulis', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="mb-3">
                <label for="dokumen_tahun" class="form-label"><b>Tahun Dokumen</b> <b style="color:red;">*</b></label>
                <input type="text" class="form-control text-dark" id="dokumen_tahun" name="dokumen_tahun"
                    placeholder="Masukkan Tahun dokumen..">
                <?= form_error('dokumen_tahun', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <button type="submit" class="btn text-white" style="background-color: #242F9B;">Submit</button>
        </form>
    </div>
</div>
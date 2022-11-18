<!-- Blank Start -->
<div class="container-fluid pt-4 px-4">
    <div class="rounded p-4 h-100" id="ThePage">
        <h3 class="mb-4 text-center"></h3>
        <?= $this->session->flashdata('message') ?>
        <hr class="mb-4" style="border-radius: 3px; height: 5px; color: #646FD4">
        <div class="table-responsive">
            <table class="table text-center">
                <thead class="text-dark" style="background-color: #2155cda3;">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Token</th>
                        <th scope="col">Token Stemming</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <th scope="row"></th>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <a href="<?= base_url('admin/tambahdata'); ?>" class="btn text-white"
                style="background-color: #2155cd;">Kembali</a>
        </div>
    </div>
</div>
<!-- Blank End -->
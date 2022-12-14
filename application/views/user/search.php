<?php
require_once 'vendor/autoload.php';

use \Sastrawi\Stemmer\StemmerFactory;
use \Sastrawi\StopWordRemover\StopWordRemoverFactory;
use \Smalot\PdfParser\Parser;
use \TextAnalysis\Tokenizers\PennTreeBankTokenizer;

?>

<?php

require_once('../pds-na/application/views/user/func/manual.php');

?>

<div class="card text-center mx-4">
    <div class="card-body">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-9">
                <form action="<?= base_url('user/search') ?>" method="post" enctype="multipart/form-data">
                    <div class="input-group form-container">
                        <input required type=" text" name="keyword" class="form-control border border-primary"
                            placeholder="Cari Dokumen ..." autocomplete="off" autofocus
                            value="<?= $this->input->post('keyword') ?>">
                        <button style="background-color: #242F9B;" type="submit" class="btn text-white">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- BAG-1 -->

<?php if(empty($dokumen)) : ?>

<div class="d-flex align-items-center justify-content-center mx-6 mt-4 gap-2">
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
    <h5 class=" text-center badge p-2" style="color: #242F9B; font-size: 18px;">
        <b><?= $this->input->post('keyword') ?></b>
    </h5>
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
</div>

<div class="card mx-6 my-2" style="background-color: #DBDFFD;">
    <div class="card-body d-flex gap-4 align-items-center justify-content-center">
        <div style="color: #242F9B;"><b>Tidak ditemukan!</b></div>
    </div>
</div>

<?php else : ?>

<div class="d-flex align-items-center justify-content-center mx-6 mt-4 gap-2">
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
    <h5 class=" text-center badge p-2" style="color: #242F9B; font-size: 18px;">
        <b><?= $this->input->post('keyword') ?></b>
    </h5>
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
</div>

<?php foreach (array_slice($dokumen, 0, 2) as $dkmn) : ?>

<div class="card mx-6 my-3" style="background-color: #DBDFFD;">
    <div class="card-body d-flex flex-column p-3 gap-2">
        <div class="d-flex align-items-center">
            <p style="text-align: justify;" class="text-dark"><b><?= $dkmn['dokumen_judul'] ?></b></p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge text-white" style="background-color: #646FD4;"><?= $dkmn['dokumen_penulis'] ?></span>
            <span class="badge text-white" style="background-color: #646FD4;"><?= $dkmn['dokumen_id'] ?></span>
            <span class="badge text-white" style="background-color: #646FD4;"><?= $dkmn['dokumen_tahun'] ?></span>
        </div>
        <div class="d-flex align-items-center gap-2 mt-2">
            <?php
                $url = explode("/", $dkmn['dokumen_id']);
                $hit_url = count($url);

                if ($hit_url == 3) {
                    $url3 = $url[0] . '-' . $url[1] . '-' . $url[2];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url3) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>

            <?php
                } elseif ($hit_url == 4) {
                    $url4 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url4) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>

            <?php
                } elseif ($hit_url == 5) {
                    $url5 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3] . '-' . $url[4];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url5) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>

            <?php
                } elseif ($hit_url == 6) {
                    $url6 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3] . '-' . $url[4] . '-' . $url[5];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url6) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>

            <?php } ?>



        </div>
    </div>
</div>


<?php endforeach ?>
<?php 
    $exKey = explode(" ", $this->input->post('keyword'));
    $imKey = implode("_", $exKey);
?>
<div class="d-flex align-items-center justify-content-center mx-6 gap-2">
    <p class=" text-center p-1">
        <a class="badge text-white p-2" style="background-color: #242F9B; font-size: 14px; text-decoration: none;"
            href="<?= base_url('user/semua_hasil/index/'. $imKey) ?>">Lihat Semua Hasil</a>
    </p>
</div>
<?php endif; ?>
<!-- END-BAG-1 -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
<!-- BAG-2 -->
<?php if(empty($dokstem)) : ?>

<?php if (empty($allkey)) : ?>

<?php else : ?>

<div class="d-flex align-items-center justify-content-center mx-6 mt-4 gap-2">
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
    <h5 class=" text-center badge p-2" style="color: #242F9B; font-size: 18px;">
        <b><?= $allkey ?></b>
    </h5>
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
</div>

<div class="card mx-6 my-2" style="background-color: #DBDFFD;">
    <div class="card-body d-flex gap-4 align-items-center justify-content-center">
        <div style="color: #242F9B;"><b>Tidak ditemukan!</b></div>
    </div>
</div>

<?php endif; ?>

<?php else : ?>

<div class="d-flex align-items-center justify-content-center mx-6 mt-4 gap-2">
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
    <h5 class=" text-center badge p-2" style="color: #242F9B; font-size: 18px;">
        <b><?= $allkey ?></b>
    </h5>
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
</div>

<?php foreach (array_slice($dokstem, 0, 2) as $dksm) : ?>

<div class="card mx-6 my-3" style="background-color: #DBDFFD;">
    <div class="card-body d-flex flex-column p-3 gap-2">
        <div class="d-flex align-items-center">
            <p style="text-align: justify;" class="text-dark"><b><?= $dksm['dokumen_judul'] ?></b></p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge text-white" style="background-color: #646FD4;"><?= $dksm['dokumen_penulis'] ?></span>
            <span class="badge text-white" style="background-color: #646FD4;"><?= $dksm['dokumen_id'] ?></span>
            <span class="badge text-white" style="background-color: #646FD4;"><?= $dksm['dokumen_tahun'] ?></span>
        </div>
        <div class="d-flex align-items-center gap-2 mt-2">
            <?php
                $url = explode("/", $dksm['dokumen_id']);
                $hit_url = count($url);

                if ($hit_url == 3) {
                    $url3 = $url[0] . '-' . $url[1] . '-' . $url[2];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url3) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>

            <?php
                } elseif ($hit_url == 4) {
                    $url4 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url4) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>

            <?php
                } elseif ($hit_url == 5) {
                    $url5 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3] . '-' . $url[4];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url5) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>

            <?php
                } elseif ($hit_url == 6) {
                    $url6 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3] . '-' . $url[4] . '-' . $url[5];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url6) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>

            <?php } ?>



        </div>
    </div>

    <!-- </a> -->
</div>

<?php endforeach ?>
<?php 
    $exKey1 = explode(" ", $allkey);
    $imKey1 = implode("_", $exKey1);
?>
<div class="d-flex align-items-center justify-content-center mx-6 gap-2">
    <p class=" text-center p-1">
        <a class="badge text-white p-2" style="background-color: #242F9B; font-size: 14px; text-decoration: none;"
            href="<?= base_url('user/semua_hasil/index/'. $imKey1) ?>">Lihat Semua Hasil</a>
    </p>
</div>
<?php endif; ?>
<!-- END-BAG-2 -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
<!-- BAG-3 -->
<?php if(empty($dokunstem)) : ?>

<?php if(empty($unstemkey)) : ?>

<?php else : ?>

<div class="d-flex align-items-center justify-content-center mx-6 mt-4 gap-2">
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
    <h5 class=" text-center badge p-2" style="color: #242F9B; font-size: 18px;">
        <b><?= $unstemkey ?></b>
    </h5>
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
</div>

<div class="card mx-6 my-2" style="background-color: #DBDFFD;">
    <div class="card-body d-flex gap-4 align-items-center justify-content-center">
        <div style="color: #242F9B;"><b>Tidak ditemukan!</b></div>
    </div>
</div>

<?php endif; ?>

<?php else : ?>

<div class="d-flex align-items-center justify-content-center mx-6 mt-4 gap-2">
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
    <h5 class=" text-center badge p-2" style="color: #242F9B; font-size: 18px;">
        <b><?= $unstemkey ?></b>
    </h5>
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
</div>

<?php foreach (array_slice($dokunstem, 0, 2) as $dkn) : ?>

<div class="card mx-6 my-3" style="background-color: #DBDFFD;">
    <div class="card-body d-flex flex-column p-3 gap-2">
        <div class="d-flex align-items-center">
            <p style="text-align: justify;" class="text-dark"><b><?= $dkn['dokumen_judul'] ?></b></p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge text-white" style="background-color: #646FD4;"><?= $dkn['dokumen_penulis'] ?></span>
            <span class="badge text-white" style="background-color: #646FD4;"><?= $dkn['dokumen_id'] ?></span>
            <span class="badge text-white" style="background-color: #646FD4;"><?= $dkn['dokumen_tahun'] ?></span>
        </div>
        <div class="d-flex align-items-center gap-2 mt-2">
            <?php
                $url = explode("/", $dkn['dokumen_id']);
                $hit_url = count($url);

                if ($hit_url == 3) {
                    $url3 = $url[0] . '-' . $url[1] . '-' . $url[2];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url3) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>

            <?php
                } elseif ($hit_url == 4) {
                    $url4 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url4) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>

            <?php
                } elseif ($hit_url == 5) {
                    $url5 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3] . '-' . $url[4];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url5) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>

            <?php
                } elseif ($hit_url == 6) {
                    $url6 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3] . '-' . $url[4] . '-' . $url[5];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url6) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>

            <?php } ?>



        </div>
    </div>

    <!-- </a> -->
</div>

<?php endforeach ?>
<?php 
    $exKey2 = explode(" ", $unstemkey);
    $imKey2 = implode("_", $exKey2);
?>
<div class="d-flex align-items-center justify-content-center mx-6 gap-2">
    <p class=" text-center p-1">
        <a class="badge text-white p-2" style="background-color: #242F9B; font-size: 14px; text-decoration: none;"
            href="<?= base_url('user/semua_hasil/index/'. $imKey2) ?>">Lihat Semua Hasil</a>
    </p>
</div>
<?php endif; ?>
<!-- END-BAG-3 -->

<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
<!-- BATAS BAWAH -->
<div>
    <div class="card my-4"></div>
</div>
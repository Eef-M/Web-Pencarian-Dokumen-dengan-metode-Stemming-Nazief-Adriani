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

<?php if(empty($dokumen) && empty($doksemua) && empty($dokakhiran)) : ?>

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

<!-- BAG-1 -->
<?php $no = 1; ?>
<?php $sc = "/" . $this->input->post('keyword') . "/i"; ?>
<?php $key = $this->input->post('keyword') ?>
<?php $rp = "<i><b style='background-color: #FFF6BF; color:black;'>$0</b></i>"; ?>

<?php if(empty($dokumen)) : ?>

<div class="d-flex align-items-center justify-content-center mx-6 mt-4 gap-2">
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
    <h5 class=" text-center badge p-2" style="color: #242F9B; font-size: 18px;">
        <b><?= $key ?></b>
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
        <b><?= $key ?></b>
    </h5>
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
</div>

<?php foreach (array_slice($dokumen, 0, 2) as $dok) : ?>

<?php $ccc = trim(substr($dok['dokumen_judul'], strpos($dok['dokumen_judul'], $key) + 0)) ?>

<div class="card mx-6 my-3" style="background-color: #DBDFFD;">
    <div class="card-body d-flex flex-column p-3 gap-2">
        <div class="d-flex align-items-center">
            <p style="text-align: justify;" class="text-dark"><b><?= preg_replace($sc, $rp, $ccc); ?></b></p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge text-white" style="background-color: #646FD4;"><?= $dok['dokumen_penulis'] ?></span>
            <span class="badge text-white" style="background-color: #646FD4;"><?= $dok['dokumen_id'] ?></span>
            <span class="badge text-white" style="background-color: #646FD4;"><?= $dok['dokumen_tahun'] ?></span>
        </div>
        <div class="d-flex align-items-center gap-2 mt-2">
            <?php
                $url = explode("/", $dok['dokumen_id']);
                $hit_url = count($url);

                if ($hit_url == 3) {
                    $url3 = $url[0] . '-' . $url[1] . '-' . $url[2];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url3) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>
            <a href="<?= base_url('user/search/setidforstem/' . $url3) ?>" class="btn text-white"
                style="background-color: #242F9B;">Data Stemming</a>

            <?php
                } elseif ($hit_url == 4) {
                    $url4 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url4) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>
            <a href="<?= base_url('user/search/setidforstem/' . $url4) ?>" class="btn text-white"
                style="background-color: #242F9B;">Data Stemming</a>

            <?php
                } elseif ($hit_url == 5) {
                    $url5 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3] . '-' . $url[4];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url5) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>
            <a href="<?= base_url('user/search/setidforstem/' . $url5) ?>" class="btn text-white"
                style="background-color: #242F9B;">Data Stemming</a>

            <?php
                } elseif ($hit_url == 6) {
                    $url6 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3] . '-' . $url[4] . '-' . $url[5];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url6) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>
            <a href="<?= base_url('user/search/setidforstem/' . $url6) ?>" class="btn text-white"
                style="background-color: #242F9B;">Data Stemming</a>

            <?php } ?>



        </div>
    </div>

    <!-- </a> -->
</div>

<?php endforeach ?>

<?php 
    $exKey = explode(" ", $key);
    $isset1 = isset($exKey[1]) ? $exKey[1] : null; 
    $isset2 = isset($exKey[2]) ? $exKey[2] : null; 
    
    if($isset1 == null) { ?>

<div class="d-flex align-items-center justify-content-center mx-6 gap-2">
    <p class=" text-center p-1">
        <a class="badge text-white p-2" style="background-color: #242F9B; font-size: 14px; text-decoration: none;"
            href="<?= base_url('user/semua_hasil/index/'. $key) ?>">Lihat Semua Hasil</a>
    </p>
</div>

<?php } elseif($isset2 == null) { ?>

<?php $addString = $exKey[0]."_".$exKey[1]; ?>

<div class="d-flex align-items-center justify-content-center mx-6 gap-2">
    <p class=" text-center p-1">
        <a class="badge text-white p-2" style="background-color: #242F9B; font-size: 14px; text-decoration: none;"
            href="<?= base_url('user/semua_hasil/index/'. $addString) ?>"><b>Lihat Semua Hasil</b></a>
    </p>
</div>


<?php } else { ?>

<?php $addString2 = $exKey[0]."_".$exKey[1]."_".$exKey[2]; ?>

<div class="d-flex align-items-center justify-content-center mx-6 gap-2">
    <p class=" text-center p-1">
        <a class="badge text-white p-2" style="background-color: #242F9B; font-size: 14px; text-decoration: none;"
            href="<?= base_url('user/semua_hasil/index/'. $addString2) ?>"><b>Lihat Semua Hasil</b></a>
    </p>
</div>

<?php } ?>

<?php endif; ?>
<!-- END-BAG-1 -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
<!-- BAG-2 -->
<?php $sc1 = "/" . $semua . "/i"; ?>
<?php $key1 = $semua ?>
<?php $rp1 = "<i><b style='background-color:#FFF6BF; color:black;'>$0</b></i>"; ?>

<?php if(empty($doksemua)) : ?>

<div class="d-flex align-items-center justify-content-center mx-6 mt-4 gap-2">
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
    <h5 class=" text-center badge p-2" style="color: #242F9B; font-size: 18px;">
        <b><?= $key1 ?></b>
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
        <b><?= $key1 ?></b>
    </h5>
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
</div>

<?php foreach (array_slice($doksemua, 0, 2) as $dksm) : ?>

<?php $ccc1 = trim(substr($dksm['dokumen_judul'], strpos($dksm['dokumen_judul'], $key1) + 0)) ?>

<div class="card mx-6 my-3" style="background-color: #DBDFFD;">
    <div class="card-body d-flex flex-column p-3 gap-2">
        <div class="d-flex align-items-center">
            <p style="text-align: justify;" class="text-dark"><b><?= preg_replace($sc1, $rp1, $ccc1); ?></b></p>
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
            <a href="<?= base_url('user/search/setidforstem/' . $url3) ?>" class="btn text-white"
                style="background-color: #242F9B;">Data Stemming</a>

            <?php
                } elseif ($hit_url == 4) {
                    $url4 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url4) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>
            <a href="<?= base_url('user/search/setidforstem/' . $url4) ?>" class="btn text-white"
                style="background-color: #242F9B;">Data Stemming</a>

            <?php
                } elseif ($hit_url == 5) {
                    $url5 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3] . '-' . $url[4];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url5) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>
            <a href="<?= base_url('user/search/setidforstem/' . $url5) ?>" class="btn text-white"
                style="background-color: #242F9B;">Data Stemming</a>

            <?php
                } elseif ($hit_url == 6) {
                    $url6 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3] . '-' . $url[4] . '-' . $url[5];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url6) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>
            <a href="<?= base_url('user/search/setidforstem/' . $url6) ?>" class="btn text-white"
                style="background-color: #242F9B;">Data Stemming</a>

            <?php } ?>



        </div>
    </div>

    <!-- </a> -->
</div>

<?php endforeach ?>

<?php 
    $exKey1 = explode(" ", $key1);
    $isset1_1 = isset($exKey1[1]) ? $exKey1[1] : null; 
    $isset1_2 = isset($exKey1[2]) ? $exKey1[2] : null; 
    
    if($isset1_1 == null) { ?>

<div class="d-flex align-items-center justify-content-center mx-6 gap-2">
    <p class=" text-center p-1">
        <a class="badge text-white p-2" style="background-color: #242F9B; font-size: 14px; text-decoration: none;"
            href="<?= base_url('user/semua_hasil/index/'. $key1) ?>"><b>Lihat Semua Hasil</b></a>
    </p>
</div>

<?php } elseif($isset1_2 == null) { ?>

<?php $addString1_1 = $exKey1[0]."_".$exKey1[1]; ?>

<div class="d-flex align-items-center justify-content-center mx-6 gap-2">
    <p class=" text-center p-1">
        <a class="badge text-white p-2" style="background-color: #242F9B; font-size: 14px; text-decoration: none;"
            href="<?= base_url('user/semua_hasil/index/'. $addString1_1) ?>"><b>Lihat Semua Hasil</b></a>
    </p>
</div>


<?php } else { ?>

<?php $addString1_2 = $exKey1[0]."_".$exKey1[1]."_".$exKey1[2]; ?>

<div class="d-flex align-items-center justify-content-center mx-6 gap-2">
    <p class=" text-center p-1">
        <a class="badge text-white p-2" style="background-color: #242F9B; font-size: 14px; text-decoration: none;"
            href="<?= base_url('user/semua_hasil/index/'. $addString1_2) ?>"><b>Lihat Semua Hasil</b></a>
    </p>
</div>

<?php } ?>

<?php endif; ?>
<!-- END-BAG-2 -->
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
<!-- BAG-3 -->
<?php $sc2 = "/" . $akhiran . "/i"; ?>
<?php $key2 = $akhiran ?>
<?php $rp2 = "<i><b style='background-color:#FFF6BF; color:black;'>$0</b></i>"; ?>

<?php if(empty($dokakhiran)) : ?>

<div class="d-flex align-items-center justify-content-center mx-6 mt-4 gap-2">
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
    <h5 class=" text-center badge p-2" style="color: #242F9B; font-size: 18px;">
        <b><?= $key2 ?></b>
    </h5>
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
</div>

<div class="card mx-6 my-2" style="background-color: #DBDFFD;">
    <div class="card-body d-flex gap-4 align-items-center justify-content-center">
        <div style="color: #242F9B;"><b>Tidak ditemukan!</b></div>
    </div>
</div>

<?php elseif ($akhiran == null) : ?>

<!-- NULL -->

<?php else : ?>

<div class="d-flex align-items-center justify-content-center mx-6 mt-4 gap-2">
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
    <h5 class=" text-center badge p-2" style="color: #242F9B; font-size: 18px;">
        <b><?= $key2 ?></b>
    </h5>
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
</div>

<?php foreach (array_slice($dokakhiran, 0, 2) as $dkend) : ?>

<?php $ccc2 = trim(substr($dkend['dokumen_judul'], strpos($dkend['dokumen_judul'], $key2) + 0)) ?>

<div class="card mx-6 my-2" style="background-color: #DBDFFD;">
    <div class="card-body d-flex flex-column p-3 gap-2">
        <div class="d-flex align-items-center">
            <p style="text-align: justify;" class="text-dark"><b><?= preg_replace($sc2, $rp2, $ccc2); ?></b></p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge text-white" style="background-color: #646FD4;"><?= $dkend['dokumen_penulis'] ?></span>
            <span class="badge text-white" style="background-color: #646FD4;"><?= $dkend['dokumen_id'] ?></span>
            <span class="badge text-white" style="background-color: #646FD4;"><?= $dkend['dokumen_tahun'] ?></span>
        </div>
        <div class="d-flex align-items-center gap-2 mt-2">
            <?php
                $url = explode("/", $dkend['dokumen_id']);
                $hit_url = count($url);

                if ($hit_url == 3) {
                    $url3 = $url[0] . '-' . $url[1] . '-' . $url[2];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url3) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>
            <a href="<?= base_url('user/search/setidforstem/' . $url3) ?>" class="btn text-white"
                style="background-color: #242F9B;">Data Stemming</a>

            <?php
                } elseif ($hit_url == 4) {
                    $url4 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url4) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>
            <a href="<?= base_url('user/search/setidforstem/' . $url4) ?>" class="btn text-white"
                style="background-color: #242F9B;">Data Stemming</a>

            <?php
                } elseif ($hit_url == 5) {
                    $url5 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3] . '-' . $url[4];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url5) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>
            <a href="<?= base_url('user/search/setidforstem/' . $url5) ?>" class="btn text-white"
                style="background-color: #242F9B;">Data Stemming</a>

            <?php
                } elseif ($hit_url == 6) {
                    $url6 = $url[0] . '-' . $url[1] . '-' . $url[2] . '-' . $url[3] . '-' . $url[4] . '-' . $url[5];
            ?>

            <a href="<?= base_url('user/search/setidfordok/' . $url6) ?>" class="btn text-white"
                style="background-color: #242F9B;">Detail Data</a>
            <a href="<?= base_url('user/search/setidforstem/' . $url6) ?>" class="btn text-white"
                style="background-color: #242F9B;">Data Stemming</a>

            <?php } ?>



        </div>
    </div>

    <!-- </a> -->
</div>

<?php endforeach ?>

<?php 
    $exKey2 = explode(" ", $key2);
    $isset2_1 = isset($exKey2[1]) ? $exKey2[1] : null; 
    $isset2_2 = isset($exKey2[2]) ? $exKey2[2] : null; 
    
    if($isset2_1 == null) { ?>

<div class="d-flex align-items-center justify-content-center mx-6 gap-2">
    <p class="text-center p-1">
        <a class="badge text-white p-2" style="background-color: #242F9B; font-size: 14px; text-decoration: none;"
            href="<?= base_url('user/semua_hasil/index/'. $key2) ?>"><b>Lihat Semua Hasil</b></a>
    </p>
</div>

<?php } elseif($isset2_2 == null) { ?>

<?php $addString2_1 = $exKey2[0]."_".$exKey2[1]; ?>

<div class="d-flex align-items-center justify-content-center mx-6 gap-2">
    <p class="text-center p-1">
        <a class="badge text-white p-2" style="background-color: #242F9B; font-size: 14px; text-decoration: none;"
            href="<?= base_url('user/semua_hasil/index/'. $addString2_1) ?>"><b>Lihat Semua Hasil</b></a>
    </p>
</div>


<?php } else { ?>

<?php $addString2_2 = $exKey2[0]."_".$exKey2[1]."_".$exKey2[2]; ?>

<div class="d-flex align-items-center justify-content-center mx-6 gap-2">
    <p class="text-center p-1">
        <a class="badge text-white p-2" style="background-color: #242F9B; font-size: 14px; text-decoration: none;"
            href="<?= base_url('user/semua_hasil/index/'. $addString2_2) ?>"><b>Lihat Semua Hasil</b></a>
    </p>
</div>

<?php } ?>
<?php endif; ?>
<!-- END-BAG-3 -->

<?php endif; ?>



<!-- ------------------------------------------------------------------------------------------------------------------------------------------------ -->
<!-- BATAS BAWAH -->
<div>
    <div class="card my-4"></div>
</div>
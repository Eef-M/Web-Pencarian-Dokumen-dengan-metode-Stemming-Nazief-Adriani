<?php $sc2 = "/" . $names . "/i"; ?>
<?php $key2 = $names ?>
<?php $rp2 = "<i><b style='background-color:#FFF6BF; color:black;'>$0</b></i>"; ?>

<div class="d-flex align-items-center justify-content-center mx-6 mt-2 gap-2">
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
    <h5 class="badge p-3 d-flex align-items-center justify-content-center flex-column gap-2"
        style="color: #242F9B; font-size: 16px;">
        <b><?= $names ?></b>
        <b class='text-secondary'><?= count($allResult) ?> HASIL</b>
    </h5>
    <div class="w-100 rounded" style="background-color: #9BA3EB; height: 3px;"></div>
</div>

<?php foreach ($allResult as $ar) : ?>

<?php $ccc2 = trim(substr($ar['dokumen_judul'], strpos($ar['dokumen_judul'], $key2) + 0)) ?>

<div class="card mx-6 my-2" style="background-color: #DBDFFD;">
    <div class="card-body d-flex flex-column p-3 gap-2">
        <div class="d-flex align-items-center">
            <p style="text-align: justify;" class="text-dark"><b><?= preg_replace($sc2, $rp2, $ccc2); ?></b></p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge text-white" style="background-color: #646FD4;"><?= $ar['dokumen_penulis'] ?></span>
            <span class="badge text-white" style="background-color: #646FD4;"><?= $ar['dokumen_id'] ?></span>
            <span class="badge text-white" style="background-color: #646FD4;"><?= $ar['dokumen_tahun'] ?></span>
        </div>
        <div class="d-flex align-items-center gap-2 mt-2">
            <?php
                $url = explode("/", $ar['dokumen_id']);
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

<!-- BATAS BAWAH -->
<div>
    <div class="card my-4"></div>
</div>
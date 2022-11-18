<!-- Blank Start -->
<?php
require_once 'vendor/autoload.php';
use \Sastrawi\Stemmer\StemmerFactory;
use \Sastrawi\StopWordRemover\StopWordRemoverFactory;
use \Smalot\PdfParser\Parser;
use \TextAnalysis\Tokenizers\PennTreeBankTokenizer;

$stemmerFactory = new StemmerFactory();
$stopWordRemoverFactory = new StopWordRemoverFactory();
$thetokens = new PennTreeBankTokenizer();
$stemmer  = $stemmerFactory->createStemmer();
$stopword = $stopWordRemoverFactory->createStopWordRemover();
?>

<div class="container-fluid pt-4 px-4 mb-4">
    <div class="rounded p-4 h-100" id="ThePage">
        <h3 class="mb-4 text-center">DATA DOKUMEN</h3>
        <hr class="mb-4" style="border-radius: 3px; height: 5px; color: #646FD4">
        <?= $this->session->flashdata('message') ?>

        <?php
            if(empty($stemming)) {
                ?><a href="<?= base_url('admin/stemming/stemall'); ?>" class="btn mb-3 text-white"
            style="background-color: #1E5128;"><b>Stemming
                Semua Data</b></a><?php
            } else {
                ?><a href="<?= base_url('admin/stemming/delAllStem'); ?>" class="btn mb-3 text-light"
            style="background-color: #950101;"><b>Hapus Semua
                Stemming</b></a><?php
            }
        ?>


        <div class="table-responsive">
            <table class="table text-center table-bordered border-secondary">
                <thead class="text-light">
                    <tr>
                        <th scope=" col">No</th>
                        <th scope="col">ID Dokumen</th>
                        <th scope="col">Judul Dokumen</th>
                        <!-- <th scope="col">Stemming</th> -->
                        <th scope="col">Penulis</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php


                        $no = 1;
                        foreach($dokumen as $dkmn) {
                     ?>

                    <?php 
                                 $token = $thetokens->tokenize($dkmn->dokumen_judul);
                                 $outputstopword = $stopword->remove($dkmn->dokumen_judul);
                                 $output = $stemmer->stem($outputstopword);?>
                    <tr class="text-dark">
                        <th scope="row"><?= $no++ ?></th>
                        <td><?= $dkmn->dokumen_id ?></td>
                        <td style="text-align: justify;"><?= $dkmn->dokumen_judul ?></td>
                        <!-- <td style="text-align: justify;"><i><?= $output ?></i></td> -->
                        <td style="text-align: left;"><?= $dkmn->dokumen_penulis ?></td>
                        <td style="text-align: left;"><?= $dkmn->dokumen_tahun ?></td>
                        <td>
                            <?php 
                            $url = explode("/",$dkmn->dokumen_id);
                            $hit_url = count($url);
                            if ($hit_url == 3) {
                                $url3 = $url[0].'-'.$url[1].'-'.$url[2];

                                if($dkmn->active == 0) {
                                    ?>
                            <a href="<?= base_url('admin/stemming/setidforstem/'.$url3); ?>" class="btn"
                                style="background-color: #1E5128; color: white;"><b>Stemming</b></a>
                            <?php
                                } else {
                                    ?>
                            <a href="<?= base_url('admin/stemming/setidfordelstem/'.$url3); ?>" class="btn"
                                style="background-color: #950101; color: white;"><b>Hapus Stemming</b></a>
                            <?php
                                }
                            } elseif ($hit_url == 4) {
                                $url4 = $url[0].'-'.$url[1].'-'.$url[2].'-'.$url[3];
                                if($dkmn->active == 0) {
                                    ?>
                            <a href="<?= base_url('admin/stemming/setidforstem/'.$url4); ?>" class="btn"
                                style="background-color: #1E5128; color: white;"><b>Stemming</b></a>
                            <?php
                                } else {
                                    ?>
                            <a href="<?= base_url('admin/stemming/setidfordelstem/'.$url4); ?>" class="btn"
                                style="background-color: #950101; color: white;"><b>Hapus Stemming</b></a>
                            <?php
                                }
                                ?>
                            <?php
                            } elseif ($hit_url == 5) {
                                $url5 = $url[0].'-'.$url[1].'-'.$url[2].'-'.$url[3].'-'.$url[4];
                                if($dkmn->active == 0) {
                                    ?>
                            <a href="<?= base_url('admin/stemming/setidforstem/'.$url5); ?>" class="btn"
                                style="background-color: #1E5128; color: white;"><b>Stemming</b></a>
                            <?php
                                } else {
                                    ?>
                            <a href="<?= base_url('admin/stemming/setidfordelstem/'.$url5); ?>" class="btn"
                                style="background-color: #950101; color: white;"><b>Hapus Stemming</b></a>
                            <?php
                                }
                                ?>
                            <?php
                            } elseif ($hit_url == 6) {
                                $url6 = $url[0].'-'.$url[1].'-'.$url[2].'-'.$url[3].'-'.$url[4].'-'.$url[5];
                                if($dkmn->active == 0) {
                                    ?>
                            <a href="<?= base_url('admin/stemming/setidforstem/'.$url6); ?>" class="btn"
                                style="background-color: #1E5128; color: white;"><b>Stemming</b></a>
                            <?php
                                } else {
                                    ?>
                            <a href="<?= base_url('admin/stemming/setidfordelstem/'.$url6); ?>" class="btn"
                                style="background-color: #950101; color: white;"><b>Hapus Stemming</b></a>
                            <?php
                                }
                                ?>
                            <?php
                            }
                            
                            // $urls = $url[0].'-'.$url[1].'-'.$url[2].'-'.$url[3].'-'.$url[4].'-'.$url[5];
                            ?>

                        </td>
                    </tr>
                    <!-- <?php
                        foreach ($token as $tkn) {
                            $outputstopword2 = $stopword->remove($tkn);
                            $output2 = $stemmer->stem($outputstopword2);
                            echo $output2."<br>";
                        }
                    ?> -->
                    <?php 
                } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Blank End -->
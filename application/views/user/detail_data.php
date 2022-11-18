<?php 
require_once 'vendor/autoload.php';
use \Sastrawi\Stemmer\StemmerFactory;
use \Sastrawi\StopWordRemover\StopWordRemoverFactory;
use \Smalot\PdfParser\Parser;
use \TextAnalysis\Tokenizers\PennTreeBankTokenizer;
?>

<?php foreach ($dokumen as $dok) {?>
<div class="card mx-11 p-4 gap-3" style="background-color: #DBDFFD;">
    <div class="card-body d-flex gap-2 rounded align-items-start flex-column justify-content-center">
        <div class="">
            <h4>
                <span class="badge p-2" style="background-color: #242F9B; color: white;">PENULIS</span>
            </h4>
        </div>
        <div class="">
            <div class="fs-1" style="color: #242F9B;" style="text-align: justify;"><?= $dok->dokumen_penulis ?></div>
        </div>
    </div>
    <div class="card-body d-flex gap-2 rounded align-items-start flex-column justify-content-center">
        <div class="">
            <h4>
                <span class="badge p-2" style="background-color: #242F9B; color: white;">ID DOKUMEN</span>
            </h4>
        </div>
        <div class="">
            <div class="fs-1" style="color: #242F9B;" style="text-align: justify;"><?= $dok->dokumen_id ?></div>
        </div>
    </div>
    <div class="card-body d-flex gap-2 rounded align-items-start flex-column justify-content-center">
        <div class="">
            <h4>
                <span class="badge p-2" style="background-color: #242F9B; color: white;">JUDUL</span>
            </h4>
        </div>
        <div class="">
            <div class="fs-1" style="color: #242F9B; text-align: justify;"><?= $dok->dokumen_judul ?></div>
        </div>
    </div>
    <div class="card-body d-flex gap-2 rounded align-items-start flex-column justify-content-center">
        <div class="">
            <h4>
                <span class="badge p-2" style="background-color: #242F9B; color: white;">STEMMING</span>
            </h4>
        </div>
        <div class="">
            <?php 
                $stemmerFactory = new StemmerFactory();
                $stopWordRemoverFactory = new StopWordRemoverFactory();
                $stemmer  = $stemmerFactory->createStemmer();
                $stopword = $stopWordRemoverFactory->createStopWordRemover();

                $text = $dok->dokumen_judul;

                $text = str_replace("'", " ", $text);
                $text = str_replace("-", " ", $text);
                $text = str_replace(")", " ", $text);
                $text = str_replace("(", " ", $text);
                $text = str_replace("\"", " ",$text);
                $text = str_replace("/", " ", $text);
                $text = str_replace("=", " ", $text);
                $text = str_replace(".", " ", $text);
                $text = str_replace(",", " ", $text);
                $text = str_replace(":", " ", $text);
                $text = str_replace(";", " ", $text);
                $text = str_replace("!", " ", $text);
                $text = str_replace("?", " ", $text);
                $text = str_replace(">", " ", $text);
                $text = str_replace("<", " ", $text);

                $outputstopword = $stopword->remove($text);
                $output = $stemmer->stem($outputstopword); 
            ?>
            <div class="fs-1" style="color: #242F9B; text-align: justify;"><?= $output ?></div>
        </div>
    </div>
</diV>
<?php } ?>

<div>
    <div class="card my-4"></div>
</div>
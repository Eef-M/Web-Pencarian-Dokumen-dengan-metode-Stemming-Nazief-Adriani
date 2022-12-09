<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'vendor/autoload.php';
use \Sastrawi\Stemmer\StemmerFactory;
use \Sastrawi\StopWordRemover\StopWordRemoverFactory;
use \Smalot\PdfParser\Parser;
use \TextAnalysis\Tokenizers\PennTreeBankTokenizer;

class Tess extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
        $this->load->model('m_imbuhan');
    }
    
    public function index() {
        // $str = "SISTEM PENDUKUNG KEPUTUSAN PENEMPATAN PENYULUH PERTANIAN MENGGUNAKAN KRITERIA BAYES";

        $cari = 'menggunakan bayes';
        $expSemua = explode(' ', $cari);

        $hs_1 = array();
        $hs_2 = array();
        $hs_3 = array();
        $hs_4 = array();
        $addImbuh = array();

        $stemmerFactory = new StemmerFactory();
        $stemmer  = $stemmerFactory->createStemmer();
        
        $theStem = $stemmer->stem($cari);  
        $expStem = explode(' ', $theStem);

        foreach($expSemua as $smm) {
            if(!$this->cekKamus($smm)) {
                foreach ($expSemua as $esm) {
                    $dataSearch = $this->dataSearch($esm);
                    foreach($dataSearch as $value) {
                        foreach($expSemua as $keyword) {
                            $value['dokumen_judul'] = preg_replace("/($keyword)/i","<i><b style='background-color:#FFF6BF; color:black;'>$0</b></i>",$value['dokumen_judul']);
                        }  
                        $newReplace = $value['dokumen_judul'];
        
                        $valueData = array(
                            'dokumen_id' => $value['dokumen_id'],
                            'dokumen_judul' => $newReplace,
                            'dokumen_penulis' => $value['dokumen_penulis'],
                            'dokumen_tahun' => $value['dokumen_tahun'],
                        );
                        $hs_1[] = $valueData;
                    }
                }

                foreach ($expStem as $exStm) {
                    $dataStemm = $this->dataSearch($exStm);
                    foreach($dataStemm as $value) {
                        foreach($expStem as $keyword) {
                            $value['dokumen_judul'] = preg_replace("/($keyword)/i","<i><b style='background-color:#FFF6BF; color:black;'>$0</b></i>",$value['dokumen_judul']);
                        }  
                        $newReplace = $value['dokumen_judul'];
        
                        $valueData = array(
                            'dokumen_id' => $value['dokumen_id'],
                            'dokumen_judul' => $newReplace,
                            'dokumen_penulis' => $value['dokumen_penulis'],
                            'dokumen_tahun' => $value['dokumen_tahun'],
                        );
                        $hs_2[] = $valueData;
                    }
                }
            } else {
                foreach ($expSemua as $esm) {
                    $dataSearchNonPre = $this->dataSearch($esm);
                    foreach($dataSearchNonPre as $value) {
                        foreach($expSemua as $keyword) {
                            $value['dokumen_judul'] = preg_replace("/($keyword)/i","<i><b style='background-color:#FFF6BF; color:black;'>$0</b></i>",$value['dokumen_judul']);
                        }  
                        $newReplace = $value['dokumen_judul'];
        
                        $valueData = array(
                            'dokumen_id' => $value['dokumen_id'],
                            'dokumen_judul' => $newReplace,
                            'dokumen_penulis' => $value['dokumen_penulis'],
                            'dokumen_tahun' => $value['dokumen_tahun'],
                        );
                        $hs_3[] = $valueData;
                    }
                }

                $ResImbuh = $this->tambahImbuhan($smm);
                $addImbuh[] = $ResImbuh;
                $newUnstemArr = array();
                foreach ($addImbuh as $plus) {
                    foreach ($expSemua as $esm) {
                        $pos = strpos($plus, $esm);
                        if($pos === FALSE) {
                            $unstemmed = $this->dataUnstemming($addImbuh);
                            $newUnstemArr[] = $unstemmed;
                        } else {
                            $newImbuh = preg_replace('/'.$esm.'/i', $plus, $cari);
                            $expNewImbuh = explode(' ', $newImbuh);
                            $unstemmed = $this->dataUnstemming($expNewImbuh);
                            $newUnstemArr[] = $unstemmed;
                        }
                    }
                }
            }
        }

        if(empty($newUnstemArr)) {
            NULL;
        } else {
            $resUnstem = $newUnstemArr[0];
            $Hasil_4 = $this->super_unique($resUnstem);
            print '<pre>';
            print_r($Hasil_4);
            print '</pre>';

            foreach ($Hasil_4 as $d4) {
                echo $d4['dokumen_id'].'<br>';
                echo $d4['dokumen_judul'].'<br><br>';
            }
        }

        

        
        echo '<br> -------------------------------------------------------'.$cari.'------------------------------------------------------------ <br>';
        
        $Hasil_1 = $this->super_unique($hs_1);
        print '<pre>';
        print_r($Hasil_1);
        print '</pre>';

        foreach ($Hasil_1 as $d1) {
            echo $d1['dokumen_id'].'<br>';
            echo $d1['dokumen_judul'].'<br><br>';
        }

        $cariStem = implode(' ', $expStem);
        echo '<br> ----------------------------------------------------'.$cariStem.'--------------------------------------------------------------- <br>';

        $Hasil_2 = $this->super_unique($hs_2);
        print '<pre>';
        print_r($Hasil_2);
        print '</pre>';

        foreach ($Hasil_2 as $d2) {
            echo $d2['dokumen_id'].'<br>';
            echo $d2['dokumen_judul'].'<br><br>';
        }

        echo '<br> -------------------------------------------------------'.$cari.'------------------------------------------------------------ <br>';
        
        $Hasil_3 = $this->super_unique($hs_3);
        print '<pre>';
        print_r($Hasil_3);
        print '</pre>';

        foreach ($Hasil_3 as $d3) {
            echo $d3['dokumen_id'].'<br>';
            echo $d3['dokumen_judul'].'<br><br>';
        }

        echo empty($impNewImbuh) ? NULL : '<h3>'.$impNewImbuh.'</h3>'  ;
        
        $Hasil_4 = $this->super_unique($hs_4);
        print '<pre>';
        print_r($Hasil_4);
        print '</pre>';

        foreach ($Hasil_4 as $d4) {
            echo $d4['dokumen_id'].'<br>';
            echo $d4['dokumen_judul'].'<br><br>';
        }

    }

    public function super_unique($array) {
        $result = array_map("unserialize", array_unique(array_map("serialize", $array)));

        foreach ($result as $key => $value) {
            if ( is_array($value) ) {
                $result[$key] = $this->super_unique($value);
            }
        }

        return $result;
    }

    public function dataUnstemming($array) {
        $newArray = array();
        foreach ($array as $arr) {
            $dataSearch = $this->dataSearch($arr);
            foreach($dataSearch as $value) {
                foreach($array as $keyword) {
                    $value['dokumen_judul'] = preg_replace("/($keyword)/i","<i><b style='background-color:#FFF6BF; color:black;'>$0</b></i>",$value['dokumen_judul']);
                }  
                $newReplace = $value['dokumen_judul'];

                $valueData = array(
                    'dokumen_id' => $value['dokumen_id'],
                    'dokumen_judul' => $newReplace,
                    'dokumen_penulis' => $value['dokumen_penulis'],
                    'dokumen_tahun' => $value['dokumen_tahun'],
                );
                $newArray[] = $valueData;
            }
        }

        return $newArray;
    }

    public function dataSearch($loop) {
        $arrSrc = array();
        $mencariData = $this->m_data->searchkey($loop);
        foreach(array_slice($mencariData, 0, 2) as $key => $mcd) {
            $allDataArray = array(
                'dokumen_id' => $mcd['dokumen_id'],
                'dokumen_judul' => $mcd['dokumen_judul'],
                'dokumen_penulis' => $mcd['dokumen_penulis'],
                'dokumen_tahun' => $mcd['dokumen_tahun'],
            );
            $arrSrc[] = $allDataArray;
        }
        return $arrSrc;
    }

    // tambah imbuhan
    public function tambahImbuhan($kata) {
        $kataAsal = $kata;
        if ($kata == 'belajar') {
            $__kata = preg_replace('/^/','pem',$kata);
            if($__kata) {
                $__kata__ = preg_replace('/$/','an',$__kata);
                return $__kata__;
            } else {
                return $kata;
            }
        }

        if ($kata == 'diagnosa') {
            $__kata = preg_replace('/^/','men',$kata);
            return $__kata;
        }

        if ($kata == 'nyaman') {
            $__kata = preg_replace('/^/','ke',$kata);
            if($__kata) {
                $__kata__ = preg_replace('/$/','an',$__kata);
                return $__kata__;
            } else {
                return $kata;
            }
        }
        

        if ($this->cekKamus($kata)) {

            if ($kata == 'basis') {
                if(preg_match('/^(b)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','ber',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }
            } elseif ($kata == "tani") {

                if(preg_match('/^(t)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','per',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

            } elseif ($kata == "sambung") {

                if(preg_match('/^(s)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^(s)/','peny',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

            } elseif ($kata == "dagang") {

                if(preg_match('/^(d)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','per',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

            } elseif ($kata == "dasar") {

                if(preg_match('/^(d)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','ber',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','kan',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

            } elseif ($kata == "pecah") {

                if(preg_match('/^(p)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^(p)/','pem',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

            } elseif ($kata == "guru") {

                if(preg_match('/^(g)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','per',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

            } else {

                if(preg_match('/^(anc)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','per',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(aj)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','pel',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(aks)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','peng',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(b)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','pem',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(c)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','ke',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(k)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^(k)/','peng',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }
    
                if(preg_match('/^(t)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^(t)/','pen',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }
    
                if(preg_match('/^(d)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','pen',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(p)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','ke',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(l)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','pe',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(m)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','me',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','kan',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(u)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','ke',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(s)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','per',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(r)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','pe',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                // 2 Hasil
                // guna, aman
                if(preg_match('/^(am)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','peng',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        
                    } 
                    $__kata2 = preg_replace('/^(peng)/', 'ke', $__kata__);
                    if ($__kata2) {
                        $__kata__2 = preg_replace('/(an)$/','an',$__kata2);
                    }

                    return $__kata__2; 
                }

                if(preg_match('/^(g)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','peng',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        
                    } 
                    $__kata2 = preg_replace('/^(peng)/', 'meng', $__kata__);
                    if ($__kata2) {
                        $__kata__2 = preg_replace('/(an)$/','kan',$__kata2);
                    }

                    return $__kata__2; 
                }
            }
        }

        if ($this->cekKamus($kata)) {
            if(preg_match('/^(k)[aiueo]\S{1,}/',$kata)) {
                $__kata = preg_replace('/^(k)/','penge',$kata);
                if($__kata) {
                    $__kata__ = preg_replace('/$/','an',$__kata);
                    return $__kata__;
                } else {
                    return $__kata;
                }
            }
        }

        return $kataAsal;
    }

    public function isPlural($word)
    {
        // -ku|-mu|-nya
        // nikmat-Ku, etc
        if (preg_match('/^(.*)-(ku|mu|nya|lah|kah|tah|pun)$/', $word, $words)) {
            return strpos($words[1], '-') !== false;
        }

        return strpos($word, '-') !== false;
    }

    public function cekKamus($kata){			
        $ci =& get_instance();
    
        $sql = "SELECT * from tb_katadasar where katadasar ='$kata' LIMIT 1";
        $hasil = $ci->db->query($sql);
        if($hasil->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function pembalikSemua($kata) {
        $kataAsal = $kata;
        if ($kata == 'belajar') {
            $__kata = preg_replace('/^/','pem',$kata);
            if($__kata) {
                $__kata__ = preg_replace('/$/','an',$__kata);
                return $__kata__;
            } else {
                return $kata;
            }
        }

        if ($kata == 'diagnosa') {
            $__kata = preg_replace('/^/','men',$kata);
            return $__kata;
        }

        if ($this->cekKamus($kata)) {

            if ($kata == 'basis') {
                if(preg_match('/^(b)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','ber',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }
            } elseif ($kata == "tani") {

                if(preg_match('/^(t)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','per',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

            } elseif ($kata == "sambung") {

                if(preg_match('/^(s)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^(s)/','peny',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

            } elseif ($kata == "dagang") {

                if(preg_match('/^(d)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','per',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

            } elseif ($kata == "dasar") {

                if(preg_match('/^(d)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','ber',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','kan',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

            } elseif ($kata == "pecah") {

                if(preg_match('/^(p)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^(p)/','pem',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

            } else {

                if(preg_match('/^(anc)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','per',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(aj)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','pel',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(aks)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','peng',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(b)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','pem',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(c)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','ke',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(k)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^(k)/','peng',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }
    
                if(preg_match('/^(t)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^(t)/','pen',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }
    
                if(preg_match('/^(d)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','pen',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(p)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','ke',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(l)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','pe',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(m)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','me',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','kan',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(u)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','ke',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(s)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','per',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                if(preg_match('/^(r)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','pe',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        return $__kata__;
                    } else {
                        return $kata;
                    }
                }

                // 2 Hasil
                // guna, aman
                if(preg_match('/^(am)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','peng',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        
                    } 
                    $__kata2 = preg_replace('/^(peng)/', 'ke', $__kata__);
                    if ($__kata2) {
                        $__kata__2 = preg_replace('/(an)$/','an',$__kata2);
                    }

                    return $__kata__." - ".$__kata__2; 
                }

                if(preg_match('/^(g)[aiueo]\S{1,}/',$kata)) {
                    $__kata = preg_replace('/^/','peng',$kata);
                    if($__kata) {
                        $__kata__ = preg_replace('/$/','an',$__kata);
                        
                    } 
                    $__kata2 = preg_replace('/^(peng)/', 'meng', $__kata__);
                    if ($__kata2) {
                        $__kata__2 = preg_replace('/(an)$/','kan',$__kata2);
                    }

                    return $__kata__." - ".$__kata__2; 
                }
            }
        }

        if ($this->cekKamus($kata)) {
            if(preg_match('/^(k)[aiueo]\S{1,}/',$kata)) {
                $__kata = preg_replace('/^(k)/','penge',$kata);
                if($__kata) {
                    $__kata__ = preg_replace('/$/','an',$__kata);
                    return $__kata__;
                } else {
                    return $__kata;
                }
            }
        }

        return $kataAsal;
    }

    public function pembalikDepan($kata) {

        if ($this->cekKamus($kata)) {
            if(preg_match('/^(k)[aiueo]\S{1,}/',$kata)) {
                $__kata = preg_replace('/^(k)/','peng',$kata);
               return $__kata;
            }
        }

        if ($this->cekKamus($kata)) {
            if(preg_match('/^(k)[aiueo]\S{1,}/',$kata)) {
                $__kata = preg_replace('/^(k)/','penge',$kata);
                return $__kata;
            }
        }
    }

    public function pembalikBelakang($kata) {
        if($this->cekKamus($kata)){ // Cek Kamus			
            $__kata = preg_replace('/$/','an',$kata);
            return $__kata;
        }
    }

    public function Cek_Prefix_Disallowed_Sufixes($kata){
        if(mb_eregi('^(be)[[:alpha:]]+(i)$',$kata)){ // be- dan -i
            return true;
        }
        if(mb_eregi('^(di)[[:alpha:]]+(an)$',$kata)){ // di- dan -an				
            return true;
            
        }
        if(mb_eregi('^(ke)[[:alpha:]]+(i|kan)$',$kata)){ // ke- dan -i,-kan
            return true;
        }
        if(mb_eregi('^(me)[[:alpha:]]+(an)$',$kata)){ // me- dan -an
            return true;
        }
        if(mb_eregi('^(se)[[:alpha:]]+(i|kan)$',$kata)){ // se- dan -i,-kan
            return true;
        }
        return false;
    }

    public function Del_Derivation_Suffixes($kata){
        $kataAsal = $kata;
        if(preg_match('/(kan)$/',$kata)){ // Cek Suffixes
            $__kata = preg_replace('/(kan)$/','',$kata);		
            if($this->cekKamus($__kata)){ // Cek Kamus			
                return $__kata;
            }
        }
        if(preg_match('/(an|i)$/',$kata)){ // cek -kan 				
            $__kata__ = preg_replace('/(an|i)$/','',$kata);
            if($this->cekKamus($__kata__)){ // Cek Kamus
                return $__kata__;
            }
        }
        if($this->Cek_Prefix_Disallowed_Sufixes($kata)){
            return $kataAsal;
        }
        return $kataAsal;
    }

    public function awalan($kata){
        $kataAsal = $kata;	
        /* ------ Tentukan Tipe Awalan ------------*/
        if(preg_match('/^(di|[ks]e)\S{1,}/',$kata)){ // Jika di-,ke-,se-
            $__kata = preg_replace('/^(di|[ks]e)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
        }
        if(preg_match('/^([^aiueo])e\\1[aiueo]\S{1,}/i',$kata)){ // aturan  37
            $__kata = preg_replace('/^([^aiueo])e/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
        }
        if(preg_match('/^([tmbp]e)\S{1,}/',$kata)){ //Jika awalannya adalah “te-”, “me-”, “be-”, atau “pe-”
            /*------------ Awalan “be-”, ---------------------------------------------*/
            if(preg_match('/^(be)\S{1,}/',$kata)){ // Jika awalan “be-”,
                if(preg_match('/^(ber)[aiueo]\S{1,}/',$kata)){ // aturan 1.
                    $__kata = preg_replace('/^(ber)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                    $__kata = preg_replace('/^(ber)/','r',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }				
                }
                
                if(preg_match('/^(ber)[^aiueor][[:alpha:]](?!er)\S{1,}/',$kata)){ //aturan  2.
                    $__kata = preg_replace('/^(ber)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(ber)[^aiueor][[:alpha:]]er[aiueo]\S{1,}/',$kata)){ //aturan  3.
                    $__kata = preg_replace('/^(ber)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^belajar\S{0,}/',$kata)){ //aturan  4.
                    $__kata = preg_replace('/^(bel)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(be)[^aiueolr]er[^aiueo]\S{1,}/',$kata)){ //aturan  5.
                    $__kata = preg_replace('/^(be)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
            }
            /*------------end “be-”, ---------------------------------------------*/
            /*------------ Awalan “te-”, ---------------------------------------------*/
            if(preg_match('/^(te)\S{1,}/',$kata)){ // Jika awalan “te-”,
            
                if(preg_match('/^(terr)\S{1,}/',$kata)){ 
                    return $kata;
                }
                if(preg_match('/^(ter)[aiueo]\S{1,}/',$kata)){ // aturan 6.
                    $__kata = preg_replace('/^(ter)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                    $__kata = preg_replace('/^(ter)/','r',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(ter)[^aiueor]er[aiueo]\S{1,}/',$kata)){ // aturan 7.
                    $__kata = preg_replace('/^(ter)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                if(preg_match('/^(ter)[^aiueor](?!er)\S{1,}/',$kata)){ // aturan 8.
                    $__kata = preg_replace('/^(ter)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                if(preg_match('/^(te)[^aiueor]er[aiueo]\S{1,}/',$kata)){ // aturan 9.
                    $__kata = preg_replace('/^(te)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(ter)[^aiueor]er[^aiueo]\S{1,}/',$kata)){ // aturan  35 belum bisa
                    $__kata = preg_replace('/^(ter)/','',$kata);
                    if($this->cekKamus($__kata)){			
                         return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
            }
            /*------------end “te-”, ---------------------------------------------*/
            /*------------ Awalan “me-”, ---------------------------------------------*/
            if(preg_match('/^(me)\S{1,}/',$kata)){ // Jika awalan “me-”,
        
                if(preg_match('/^(me)[lrwyv][aiueo]/',$kata)){ // aturan 10
                    $__kata = preg_replace('/^(me)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }				
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(mem)[bfvp]\S{1,}/',$kata)){ // aturan 11.
                    $__kata = preg_replace('/^(mem)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                /*if(preg_match('/^(mempe)\S{1,}/',$kata)){ // aturan 12
                    $__kata = preg_replace('/^(mem)/','pe',$kata);	
                    
                    if($this->cekKamus($__kata)){
                        
                        return $__kata; // Jika ada balik
                    }				
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){					
                        return $__kata;
                    }				
                }*/
                if (preg_match('/^(mem)((r[aiueo])|[aiueo])\S{1,}/', $kata)){//aturan 13
                    $__kata = preg_replace('/^(mem)/','m',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                    $__kata = preg_replace('/^(mem)/','p',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(men)[cdjszt]\S{1,}/',$kata)){ // aturan 14.
                    $__kata = preg_replace('/^(men)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if (preg_match('/^(men)[aiueo]\S{1,}/',$kata)){//aturan 15
                    $__kata = preg_replace('/^(men)/','n',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                    $__kata = preg_replace('/^(men)/','t',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(meng)[ghqk]\S{1,}/',$kata)){ // aturan 16.
                    $__kata = preg_replace('/^(meng)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(meng)[aiueo]\S{1,}/',$kata)){ // aturan 17
                    $__kata = preg_replace('/^(meng)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                    $__kata = preg_replace('/^(meng)/','k',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                    $__kata = preg_replace('/^(menge)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(meny)[aiueo]\S{1,}/',$kata)){ // aturan 18.
                    $__kata = preg_replace('/^(meny)/','s',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                    $__kata = preg_replace('/^(me)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
            }
            /*------------end “me-”, ---------------------------------------------*/
            
            /*------------ Awalan “pe-”, ---------------------------------------------*/
            if(preg_match('/^(pe)\S{1,}/',$kata)){ // Jika awalan “pe-”,
            
                if(preg_match('/^(pe)[wy]\S{1,}/',$kata)){ // aturan 20.
                    $__kata = preg_replace('/^(pe)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }				
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }				
                }
                
                if(preg_match('/^(per)[aiueo]\S{1,}/',$kata)){ // aturan 21
                    $__kata = preg_replace('/^(per)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                    $__kata = preg_replace('/^(per)/','r',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                if(preg_match('/^(per)[^aiueor][[:alpha:]](?!er)\S{1,}/',$kata)){ // aturan  23
                    $__kata = preg_replace('/^(per)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(per)[^aiueor][[:alpha:]](er)[aiueo]\S{1,}/',$kata)){ // aturan  24
                    $__kata = preg_replace('/^(per)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(pem)[bfv]\S{1,}/',$kata)){ // aturan  25
                    $__kata = preg_replace('/^(pem)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(pem)(r[aiueo]|[aiueo])\S{1,}/',$kata)){ // aturan  26
                    $__kata = preg_replace('/^(pem)/','m',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                    $__kata = preg_replace('/^(pem)/','p',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(pen)[cdjzt]\S{1,}/',$kata)){ // aturan  27
                    $__kata = preg_replace('/^(pen)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(pen)[aiueo]\S{1,}/',$kata)){ // aturan  28
                    $__kata = preg_replace('/^(pen)/','n',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                    $__kata = preg_replace('/^(pen)/','t',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(peng)[^aiueo]\S{1,}/',$kata)){ // aturan  29
                    $__kata = preg_replace('/^(peng)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(peng)[aiueo]\S{1,}/',$kata)){ // aturan  30
                    $__kata = preg_replace('/^(peng)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                    $__kata = preg_replace('/^(peng)/','k',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                    $__kata = preg_replace('/^(penge)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(peny)[aiueo]\S{1,}/',$kata)){ // aturan  31
                    $__kata = preg_replace('/^(peny)/','s',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                    $__kata = preg_replace('/^(pe)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(pel)[aiueo]\S{1,}/',$kata)){ // aturan  32
                    $__kata = preg_replace('/^(pel)/','l',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if (preg_match('/^(pelajar)\S{0,}/',$kata)){
                    $__kata = preg_replace('/^(pel)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(pe)[^rwylmn]er[aiueo]\S{1,}/',$kata)){ // aturan  33
                    $__kata = preg_replace('/^(pe)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(pe)[^rwylmn](?!er)\S{1,}/',$kata)){ // aturan  34
                    $__kata = preg_replace('/^(pe)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
                
                if(preg_match('/^(pe)[^aiueor]er[^aiueo]\S{1,}/',$kata)){ // aturan  36
                    $__kata = preg_replace('/^(pe)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata;
                    }
                }
            }
        }
            /*------------end “pe-”, ---------------------------------------------*/
            /*------------ Awalan “memper-”, ---------------------------------------------*/
        if(preg_match('/^(memper)\S{1,}/',$kata)){				
            $__kata = preg_replace('/^(memper)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
            //*-- Cek luluh -r ----------
            $__kata = preg_replace('/^(memper)/','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
        }
        /*------------end “memper-”, ---------------------------------------------*/
        /*------------ Awalan “mempel-”, ---------------------------------------------*/
        if(preg_match('/^(mempel)\S{1,}/',$kata)){				
            $__kata = preg_replace('/^(mempel)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
            //*-- Cek luluh -r ----------
            $__kata = preg_replace('/^(mempel)/','l',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
        }
        /*------------end “mempel-”, ---------------------------------------------*/
        /*------------awalan  “memter-”, ---------------------------------------------*/
        if(preg_match('/^(menter)\S{1,}/',$kata)){				
            $__kata = preg_replace('/^(menter)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
            //*-- Cek luluh -r ----------
            $__kata = preg_replace('/^(menter)/','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
        }
        /*------------end “memter-”, ---------------------------------------------*/
        /*------------awalan “member-”, ---------------------------------------------*/
        if(preg_match('/^(member)\S{1,}/',$kata)){				
            $__kata = preg_replace('/^(member)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
            //*-- Cek luluh -r ----------
            $__kata = preg_replace('/^(member)/','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
        }
        /*------------end member-”, ---------------------------------------------*/
        /*------------awalan “diper-”, ---------------------------------------------*/
        if(preg_match('/^(diper)\S{1,}/',$kata)){			
            $__kata = preg_replace('/^(diper)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
            /*-- Cek luluh -r ----------*/
            $__kata = preg_replace('/^(diper)','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
        }
        /*------------end “diper-”, ---------------------------------------------*/
        /*------------awalan “diter-”, ---------------------------------------------*/
        if(preg_match('/^(diter)\S{1,}/',$kata)){			
            $__kata = preg_replace('/^(diter)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
            /*-- Cek luluh -r ----------*/
            $__kata = preg_replace('/^(diter)','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
        }
        /*------------end “diter-”, ---------------------------------------------*/
        /*------------awalan “dipel-”, ---------------------------------------------*/
        if(preg_match('/^(dipel)\S{1,}/',$kata)){			
            $__kata = preg_replace('/^(dipel)/','l',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
            /*-- Cek luluh -l----------*/
            $__kata = preg_replace('/^(dipel)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
        }
        /*------------end dipel-”, ---------------------------------------------*/
        /*------------kata “terpelajar”(kasus khusus), ---------------------------------------------*/
        if(preg_match('/terpelajar/',$kata)){			
            $__kata = preg_replace('/terpel/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
        }
        /*------------end “terpelajar”-”, ---------------------------------------------*/
        /*------------kata seseorang(kasus khusus), ---------------------------------------------*/
        if(preg_match('/seseorang/',$kata)){			
            $__kata = preg_replace('/^(sese)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
        }
        /*------------end seseorang-”, ---------------------------------------------*/
        /*------------awalan "diber-"---------------------------------------------*/
        if(preg_match('/^(diber)\S{1,}/',$kata)){			
            $__kata = preg_replace('/^(diber)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
            /*-- Cek luluh -l----------*/
            $__kata = preg_replace('/^(diber)/','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
        }
        /*------------end "diber-"---------------------------------------------*/
        /*------------awalan "keber-"---------------------------------------------*/
        if(preg_match('/^(keber)\S{1,}/',$kata)){			
            $__kata = preg_replace('/^(keber)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
            /*-- Cek luluh -l----------*/
            $__kata = preg_replace('/^(keber)/','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
        }
        /*------------end "keber-"---------------------------------------------*/
        /*------------awalan "keter-"---------------------------------------------*/
        if(preg_match('/^(keter)\S{1,}/',$kata)){			
            $__kata = preg_replace('/^(keter)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
            /*-- Cek luluh -l----------*/
            $__kata = preg_replace('/^(keter)/','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
        }
        /*------------end "keter-"---------------------------------------------*/
        /*------------awalan "berke-"---------------------------------------------*/
        if(preg_match('/^(berke)\S{1,}/',$kata)){			
            $__kata = preg_replace('/^(berke)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata;
            }
        }
        /*------------end "berke-"---------------------------------------------*/
        /* --- Cek Ada Tidaknya Prefik/Awalan (“di-”, “ke-”, “se-”, “te-”, “be-”, “me-”, atau “pe-”) ------*/
        if(preg_match('/^(di|[kstbmp]e)\S{1,}/',$kata) == FALSE){
            return $kataAsal;
        }
        
        return $kataAsal;
    }

    public function akhiran($kata){
        $kataAsal = $kata;
        if(preg_match_all('/(kan)$/',$kata)){ // Cek Suffixes
            $__kata = preg_replace('/(kan)$/','',$kata);		
            return $__kata;
        }
        if(preg_match_all('/(an|i)$/',$kata)){ // cek -kan 				
            $__kata__ = preg_replace('/(an|i)$/','',$kata);
            return $__kata__;
        }
        if($this->Cek_Prefix_Disallowed_Sufixes($kata)){
            return $kataAsal;
        }

        if(mb_eregi('([km]u|nya|[kl]ah|pun)$',$kata)){ // Cek Inflection Suffixes
            $__kata = mb_eregi_replace('([km]u|nya|[kl]ah|pun)$','',$kata);
            if(mb_eregi('([klt]ah|pun)$',$kata)){ // Jika berupa particles (“-lah”, “-kah”, “-tah” atau “-pun”)
                if(mb_eregi('([km]u|nya)$',$__kata)){ // Hapus Possesive Pronouns (“-ku”, “-mu”, atau “-nya”)
                    $__kata__ = mb_eregi_replace('([km]u|nya)$','',$__kata);
                    return $__kata__;
                }
            }
            return $__kata;	
        }
        return $kataAsal;
    }

    function semua($kata){
        $kataAsal = $kata;	
        /* ------ Tentukan Tipe Awalan ------------*/
        if(preg_match('/^(di|[ks]e)\S{1,}/',$kata)){ // Jika di-,ke-,se-
            $__kata = preg_replace('/^(di|[ks]e)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        if(preg_match('/^([^aiueo])e\\1[aiueo]\S{1,}/i',$kata)){ // aturan  37
            $__kata = preg_replace('/^([^aiueo])e/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        if(preg_match('/^([tmbp]e)\S{1,}/',$kata)){ //Jika awalannya adalah “te-”, “me-”, “be-”, atau “pe-”
            /*------------ Awalan “be-”, ---------------------------------------------*/
            if(preg_match('/^(be)\S{1,}/',$kata)){ // Jika awalan “be-”,
                if(preg_match('/^(ber)[aiueo]\S{1,}/',$kata)){ // aturan 1.
                    $__kata = preg_replace('/^(ber)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                    $__kata = preg_replace('/^(ber)/','r',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }				
                }
                
                if(preg_match('/^(ber)[^aiueor][[:alpha:]](?!er)\S{1,}/',$kata)){ //aturan  2.
                    $__kata = preg_replace('/^(ber)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(ber)[^aiueor][[:alpha:]]er[aiueo]\S{1,}/',$kata)){ //aturan  3.
                    $__kata = preg_replace('/^(ber)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^belajar\S{0,}/',$kata)){ //aturan  4.
                    $__kata = preg_replace('/^(bel)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(be)[^aiueolr]er[^aiueo]\S{1,}/',$kata)){ //aturan  5.
                    $__kata = preg_replace('/^(be)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
            }
            /*------------end “be-”, ---------------------------------------------*/
            /*------------ Awalan “te-”, ---------------------------------------------*/
            if(preg_match('/^(te)\S{1,}/',$kata)){ // Jika awalan “te-”,
            
                if(preg_match('/^(terr)\S{1,}/',$kata)){ 
                    return $kata;
                }
                if(preg_match('/^(ter)[aiueo]\S{1,}/',$kata)){ // aturan 6.
                    $__kata = preg_replace('/^(ter)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                    $__kata = preg_replace('/^(ter)/','r',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(ter)[^aiueor]er[aiueo]\S{1,}/',$kata)){ // aturan 7.
                    $__kata = preg_replace('/^(ter)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                if(preg_match('/^(ter)[^aiueor](?!er)\S{1,}/',$kata)){ // aturan 8.
                    $__kata = preg_replace('/^(ter)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                if(preg_match('/^(te)[^aiueor]er[aiueo]\S{1,}/',$kata)){ // aturan 9.
                    $__kata = preg_replace('/^(te)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(ter)[^aiueor]er[^aiueo]\S{1,}/',$kata)){ // aturan  35 belum bisa
                    $__kata = preg_replace('/^(ter)/','',$kata);
                    if($this->cekKamus($__kata)){			
                         return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
            }
            /*------------end “te-”, ---------------------------------------------*/
            /*------------ Awalan “me-”, ---------------------------------------------*/
            if(preg_match('/^(me)\S{1,}/',$kata)){ // Jika awalan “me-”,
        
                if(preg_match('/^(me)[lrwyv][aiueo]/',$kata)){ // aturan 10
                    $__kata = preg_replace('/^(me)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }				
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(mem)[bfvp]\S{1,}/',$kata)){ // aturan 11.
                    $__kata = preg_replace('/^(mem)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                /*if(preg_match('/^(mempe)\S{1,}/',$kata)){ // aturan 12
                    $__kata = preg_replace('/^(mem)/','pe',$kata);	
                    
                    if($this->cekKamus($__kata)){
                        
                        return $__kata; // Jika ada balik
                    }				
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){					
                        return $__kata__;
                    }				
                }*/
                if (preg_match('/^(mem)((r[aiueo])|[aiueo])\S{1,}/', $kata)){//aturan 13
                    $__kata = preg_replace('/^(mem)/','m',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                    $__kata = preg_replace('/^(mem)/','p',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(men)[cdjszt]\S{1,}/',$kata)){ // aturan 14.
                    $__kata = preg_replace('/^(men)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if (preg_match('/^(men)[aiueo]\S{1,}/',$kata)){//aturan 15
                    $__kata = preg_replace('/^(men)/','n',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                    $__kata = preg_replace('/^(men)/','t',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(meng)[ghqk]\S{1,}/',$kata)){ // aturan 16.
                    $__kata = preg_replace('/^(meng)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(meng)[aiueo]\S{1,}/',$kata)){ // aturan 17
                    $__kata = preg_replace('/^(meng)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                    $__kata = preg_replace('/^(meng)/','k',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                    $__kata = preg_replace('/^(menge)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(meny)[aiueo]\S{1,}/',$kata)){ // aturan 18.
                    $__kata = preg_replace('/^(meny)/','s',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                    $__kata = preg_replace('/^(me)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
            }
            /*------------end “me-”, ---------------------------------------------*/
            
            /*------------ Awalan “pe-”, ---------------------------------------------*/
            if(preg_match('/^(pe)\S{1,}/',$kata)){ // Jika awalan “pe-”,
            
                if(preg_match('/^(pe)[wy]\S{1,}/',$kata)){ // aturan 20.
                    $__kata = preg_replace('/^(pe)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }				
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }				
                }
                
                if(preg_match('/^(per)[aiueo]\S{1,}/',$kata)){ // aturan 21
                    $__kata = preg_replace('/^(per)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                    $__kata = preg_replace('/^(per)/','r',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                if(preg_match('/^(per)[^aiueor][[:alpha:]](?!er)\S{1,}/',$kata)){ // aturan  23
                    $__kata = preg_replace('/^(per)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(per)[^aiueor][[:alpha:]](er)[aiueo]\S{1,}/',$kata)){ // aturan  24
                    $__kata = preg_replace('/^(per)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(pem)[bfv]\S{1,}/',$kata)){ // aturan  25
                    $__kata = preg_replace('/^(pem)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(pem)(r[aiueo]|[aiueo])\S{1,}/',$kata)){ // aturan  26
                    $__kata = preg_replace('/^(pem)/','m',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                    $__kata = preg_replace('/^(pem)/','p',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(pen)[cdjzt]\S{1,}/',$kata)){ // aturan  27
                    $__kata = preg_replace('/^(pen)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(pen)[aiueo]\S{1,}/',$kata)){ // aturan  28
                    $__kata = preg_replace('/^(pen)/','n',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                    $__kata = preg_replace('/^(pen)/','t',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(peng)[^aiueo]\S{1,}/',$kata)){ // aturan  29
                    $__kata = preg_replace('/^(peng)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(peng)[aiueo]\S{1,}/',$kata)){ // aturan  30
                    $__kata = preg_replace('/^(peng)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                    $__kata = preg_replace('/^(peng)/','k',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                    $__kata = preg_replace('/^(penge)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(peny)[aiueo]\S{1,}/',$kata)){ // aturan  31
                    $__kata = preg_replace('/^(peny)/','s',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                    $__kata = preg_replace('/^(pe)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(pel)[aiueo]\S{1,}/',$kata)){ // aturan  32
                    $__kata = preg_replace('/^(pel)/','l',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if (preg_match('/^(pelajar)\S{0,}/',$kata)){
                    $__kata = preg_replace('/^(pel)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(pe)[^rwylmn]er[aiueo]\S{1,}/',$kata)){ // aturan  33
                    $__kata = preg_replace('/^(pe)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(pe)[^rwylmn](?!er)\S{1,}/',$kata)){ // aturan  34
                    $__kata = preg_replace('/^(pe)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
                
                if(preg_match('/^(pe)[^aiueor]er[^aiueo]\S{1,}/',$kata)){ // aturan  36
                    $__kata = preg_replace('/^(pe)/','',$kata);
                    if($this->cekKamus($__kata)){			
                        return $__kata; // Jika ada balik
                    }
                    $__kata__ = $this->Del_Derivation_Suffixes($__kata);
                    if($this->cekKamus($__kata__)){
                        return $__kata__;
                    }
                }
            }
        }
            /*------------end “pe-”, ---------------------------------------------*/
            /*------------ Awalan “memper-”, ---------------------------------------------*/
        if(preg_match('/^(memper)\S{1,}/',$kata)){				
            $__kata = preg_replace('/^(memper)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
            //*-- Cek luluh -r ----------
            $__kata = preg_replace('/^(memper)/','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        /*------------end “memper-”, ---------------------------------------------*/
        /*------------ Awalan “mempel-”, ---------------------------------------------*/
        if(preg_match('/^(mempel)\S{1,}/',$kata)){				
            $__kata = preg_replace('/^(mempel)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
            //*-- Cek luluh -r ----------
            $__kata = preg_replace('/^(mempel)/','l',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        /*------------end “mempel-”, ---------------------------------------------*/
        /*------------awalan  “memter-”, ---------------------------------------------*/
        if(preg_match('/^(menter)\S{1,}/',$kata)){				
            $__kata = preg_replace('/^(menter)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
            //*-- Cek luluh -r ----------
            $__kata = preg_replace('/^(menter)/','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        /*------------end “memter-”, ---------------------------------------------*/
        /*------------awalan “member-”, ---------------------------------------------*/
        if(preg_match('/^(member)\S{1,}/',$kata)){				
            $__kata = preg_replace('/^(member)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
            //*-- Cek luluh -r ----------
            $__kata = preg_replace('/^(member)/','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        /*------------end member-”, ---------------------------------------------*/
        /*------------awalan “diper-”, ---------------------------------------------*/
        if(preg_match('/^(diper)\S{1,}/',$kata)){			
            $__kata = preg_replace('/^(diper)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
            /*-- Cek luluh -r ----------*/
            $__kata = preg_replace('/^(diper)','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        /*------------end “diper-”, ---------------------------------------------*/
        /*------------awalan “diter-”, ---------------------------------------------*/
        if(preg_match('/^(diter)\S{1,}/',$kata)){			
            $__kata = preg_replace('/^(diter)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
            /*-- Cek luluh -r ----------*/
            $__kata = preg_replace('/^(diter)','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        /*------------end “diter-”, ---------------------------------------------*/
        /*------------awalan “dipel-”, ---------------------------------------------*/
        if(preg_match('/^(dipel)\S{1,}/',$kata)){			
            $__kata = preg_replace('/^(dipel)/','l',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
            /*-- Cek luluh -l----------*/
            $__kata = preg_replace('/^(dipel)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        /*------------end dipel-”, ---------------------------------------------*/
        /*------------kata “terpelajar”(kasus khusus), ---------------------------------------------*/
        if(preg_match('/terpelajar/',$kata)){			
            $__kata = preg_replace('/terpel/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        /*------------end “terpelajar”-”, ---------------------------------------------*/
        /*------------kata seseorang(kasus khusus), ---------------------------------------------*/
        if(preg_match('/seseorang/',$kata)){			
            $__kata = preg_replace('/^(sese)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
        }
        /*------------end seseorang-”, ---------------------------------------------*/
        /*------------awalan "diber-"---------------------------------------------*/
        if(preg_match('/^(diber)\S{1,}/',$kata)){			
            $__kata = preg_replace('/^(diber)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
            /*-- Cek luluh -l----------*/
            $__kata = preg_replace('/^(diber)/','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        /*------------end "diber-"---------------------------------------------*/
        /*------------awalan "keber-"---------------------------------------------*/
        if(preg_match('/^(keber)\S{1,}/',$kata)){			
            $__kata = preg_replace('/^(keber)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
            /*-- Cek luluh -l----------*/
            $__kata = preg_replace('/^(keber)/','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        /*------------end "keber-"---------------------------------------------*/
        /*------------awalan "keter-"---------------------------------------------*/
        if(preg_match('/^(keter)\S{1,}/',$kata)){			
            $__kata = preg_replace('/^(keter)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
            /*-- Cek luluh -l----------*/
            $__kata = preg_replace('/^(keter)/','r',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        /*------------end "keter-"---------------------------------------------*/
        /*------------awalan "berke-"---------------------------------------------*/
        if(preg_match('/^(berke)\S{1,}/',$kata)){			
            $__kata = preg_replace('/^(berke)/','',$kata);
            if($this->cekKamus($__kata)){			
                return $__kata; // Jika ada balik
            }
            $__kata__ = $this->Del_Derivation_Suffixes($__kata);
            if($this->cekKamus($__kata__)){
                return $__kata__;
            }
        }
        /*------------end "berke-"---------------------------------------------*/
        /* --- Cek Ada Tidaknya Prefik/Awalan (“di-”, “ke-”, “se-”, “te-”, “be-”, “me-”, atau “pe-”) ------*/
        if(preg_match('/^(di|[kstbmp]e)\S{1,}/',$kata) == FALSE){
            return $kataAsal;
        }
        
        return $kataAsal;
    }
}
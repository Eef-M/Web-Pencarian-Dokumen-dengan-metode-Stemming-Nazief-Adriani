<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'vendor/autoload.php';
use \Sastrawi\Stemmer\StemmerFactory;
use \Sastrawi\StopWordRemover\StopWordRemoverFactory;
use \Smalot\PdfParser\Parser;
use \TextAnalysis\Tokenizers\PennTreeBankTokenizer;

class Search extends CI_Controller { 
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
        is_logged_in();
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0',false);
        header('Pragma: no-cache');
    }

    public function index() {
        $data['title'] = 'HASIL PENCARIAN DOKUMEN';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        if ($this->input->post('keyword')) {
            $keywords = $this->input->post('keyword');

            $expSemua = explode(' ', $keywords);

            $dokumenResult = array();
            $stemAllResult = array();
            $addImbuh = array();
            $baruArr = array();

            $stemmerFactory = new StemmerFactory();
            $stemmer  = $stemmerFactory->createStemmer();
            
            $theStem = $stemmer->stem($keywords);  
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
                            $dokumenResult[] = $valueData;
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
                            $stemAllResult[] = $valueData;
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
                            $dokumenResult[] = $valueData;
                        }
                    }
                    
                    $addImbuh[] = $this->tambahImbuhan($smm);
                    $newUnstemArr = array();
                    
                    foreach ($addImbuh as $plus) {
                        $pos = strpos($plus, $smm);
                        if($pos === FALSE) {
                            $unstemmed = $this->dataUnstemming($addImbuh);
                            $newUnstemArr[] = $unstemmed;
                        } else {
                            $newImbuh = preg_replace('/'.$smm.'/i', $plus, $keywords);
                            $expNewImbuh = explode(' ', $newImbuh);
                            
                            $baruArr[] = $newImbuh;
                            $unstemmed = $this->dataUnstemming($expNewImbuh);
                            $newUnstemArr[] = $unstemmed;
                        }
                    }
                        
                }
            }
            
            $arrRevDokRes = $dokumenResult;
            $arrRevStemmRes = $stemAllResult;
            
            $Ukey = array();
            $hasilUnstem = array();
            foreach ($expSemua as $ES) {
                $Ukey[] = $this->tambahImbuhan($ES);
            }

            
            if($theStem == $keywords) {
                $data['dokumen'] = $this->super_unique($arrRevDokRes);
                $data['allkey'] = NULL;
            } else {
                $data['dokumen'] = $this->super_unique($arrRevDokRes);
                $data['dokstem'] = $this->super_unique($arrRevStemmRes);
                $data['allkey'] = $theStem;
            }

           
            if(empty($newUnstemArr)) {
                NULL;
            } else {
                $superUnstem = $this->dataUnstemming($Ukey);
                $resNewUnstem = $this->super_unique($superUnstem);
                $KeyOfUnstem = implode(' ', $Ukey); 
                
                if($KeyOfUnstem == $keywords) {
                    $data['dokunstem'] = NULL;
                    $data['unstemkey'] = NULL;
                } else {
                    $data['dokunstem'] = $resNewUnstem;
                    $data['unstemkey'] = $KeyOfUnstem;
                }
            }
            
            $this->load->view('templates/user/header', $data);
            $this->load->view('templates/user/topbar');
            $this->load->view('user/search', $data);
            $this->load->view('templates/user/footer');
        } else {
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>tidak bisa mengakses halaman Pencarian</strong><br>Silahkan masukkan katakunci terlebih dahulu
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ');
                redirect('user/landingpage');
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
            
    public function SetIdForDok($id) {
        $ids = explode("-", $id);
        $hit_id = count($ids);

        if ($hit_id == 3) {
            $id3 = $ids[0].'/'.$ids[1].'/'.$ids[2];
            $this->detailDok($id3);
        } elseif ($hit_id == 4) {
            $id4 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3];
            $this->detailDok($id4);
        } elseif ($hit_id == 5) {
            $id5 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3].'/'.$ids[4];
            $this->detailDok($id5);
        } elseif ($hit_id == 6) {
            $id6 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3].'/'.$ids[4].'/'.$ids[5];
            $this->detailDok($id6);
        }
    }

    public function detailDok($id) {
        $where = array('dokumen_id' => $id);
        $data['dokumen'] = $this->m_data->detail_data($where, 'tabel_dokumen')->result();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "DETAIL DATA";
        
        $this->load->view('templates/user/header', $data);
        $this->load->view('templates/user/topbar');
        $this->load->view('user/detail_data', $data);
        $this->load->view('templates/user/footer');
    }

    // tambah imbuhan
    public function tambahImbuhan($kata) {
        $kataAsli = $kata;
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
        
        if ($this->cekKamus($kataAsli)) {
             
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
              
                // Kata yang tidak diinginkan
                if($kata == "media") {
                    return $kata;
                }
                if($kata == "sistem") {
                    return $kata;
                }
                if($kata == "sekolah") {
                    return $kata;
                }
                if($kata == "metode") {
                    return $kata;
                }
                if($kata == "segmentasi") {
                    return $kata;
                }
                if($kata == "citra") {
                    return $kata;
                }

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

        if ($this->cekKamus($kataAsli)) {
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

        return $kataAsli;
    }

    // MANUAL STEM
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
}
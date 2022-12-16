<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'vendor/autoload.php';
use \Sastrawi\Stemmer\StemmerFactory;
use \Sastrawi\StopWordRemover\StopWordRemoverFactory;
use \Smalot\PdfParser\Parser;
use \TextAnalysis\Tokenizers\PennTreeBankTokenizer;

class Stemming extends CI_Controller { 

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
        is_logged_in();
    }
    
    public function index() {
        echo "NOT FOUND";
    }

    public function activeSet() {
        $data_active = array(
            'active' => 0
        );
        $this->m_data->set_active($data_active);
        $this->session->set_flashdata('message', '
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Data Dokumen</strong> Active set!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ');
            redirect('admin/datadokumen');
    }

    public function setIdForStem($id) {
        $ids = explode("-", $id);
        $hit_id = count($ids);
        if($hit_id == 3) {
            $id3 = $ids[0].'/'.$ids[1].'/'.$ids[2];
            $where3 = array('dokumen_id' => $id3);
            $cek3 = $this->m_data->detail_data($where3, 'tabel_dokumen')->result();
            foreach ($cek3 as $ck3) {
                $text3 = $ck3->dokumen_judul;
                $this->stemFunct($where3, $text3);
            }
        } elseif($hit_id == 4) {
            $id4 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3];
            $where4 = array('dokumen_id' => $id4);
            $cek4 = $this->m_data->detail_data($where4, 'tabel_dokumen')->result();
            foreach ($cek4 as $ck4) {
                $text4 = $ck4->dokumen_judul;
                $this->stemFunct($where4, $text4);
            }
        } elseif($hit_id == 5) {
            $id5 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3].'/'.$ids[4];
            $where5 = array('dokumen_id' => $id5);
            $cek5 = $this->m_data->detail_data($where5, 'tabel_dokumen')->result();
            foreach ($cek5 as $ck5) {
                $text5 = $ck5->dokumen_judul;
                $this->stemFunct($where5, $text5);
            }
        } elseif($hit_id == 6) {
            $id6 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3].'/'.$ids[4].'/'.$ids[5];
            $where6 = array('dokumen_id' => $id6);
            $cek6 = $this->m_data->detail_data($where6, 'tabel_dokumen')->result();
            foreach ($cek6 as $ck6) {
                $text6 = $ck6->dokumen_judul;
                $this->stemFunct($where6, $text6);
            }
        }
    }

    public function stemFunct($id_dok, $text) {
        $data['title'] = "HASIL STEMMING";

        $stemmerFactory = new StemmerFactory();
        $stopWordRemoverFactory = new StopWordRemoverFactory();
        $thetokens = new PennTreeBankTokenizer();
        $stemmer  = $stemmerFactory->createStemmer();
        $stopword = $stopWordRemoverFactory->createStopWordRemover();

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

        $token = $thetokens->tokenize($text);
        $no = 1;
        foreach ($token as $tkn) {
            $outputstopword = $stopword->remove($tkn);
            $output = $stemmer->stem($outputstopword); 
            $data = array(
                'dokumen_id' => implode($id_dok),
                'token' => $tkn,
                'stemming' => $output
            );
           $ress = $this->m_data->stemmingDokumen($data);
           
           $data_active = array(
               'active' => 1
           );
   
           $this->m_data->update_active($id_dok, $data_active, 'tabel_dokumen');
        }

        
        if($ress == false) {
            $this->session->set_flashdata('message', '
        <div class="alert alert-dismissible fade show text-white" role="alert" style="background-color: #4E9F3D;">
            <strong>Data Dokumen</strong> berhasil di Stemming!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ');
            redirect('admin/datadokumen');
        } else {
            $this->session->set_flashdata('message', '
        <div class="alert alert-dismissible fade show text-white" role="alert" style="background-color: #CA3E47;">
            <strong>Data Dokumen</strong> gagal di Stemming!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ');
            redirect('admin/datadokumen');
        }
    }

    public function setIdForDelStem($id) {
        $ids = explode("-", $id);
        $hit_id = count($ids);
        if($hit_id == 3) {
            $id3 = $ids[0].'/'.$ids[1].'/'.$ids[2];
            $where3 = array('dokumen_id' => $id3);
            $this->hapusStemming($where3);
        } elseif($hit_id == 4) {
            $id4 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3];
            $where4 = array('dokumen_id' => $id4);
            $this->hapusStemming($where4);

        } elseif($hit_id == 5) {
            $id5 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3].'/'.$ids[4];
            $where5 = array('dokumen_id' => $id5);
            $this->hapusStemming($where5);

        } elseif($hit_id == 6) {
            $id6 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3].'/'.$ids[4].'/'.$ids[5];
            $where6 = array('dokumen_id' => $id6);
            $this->hapusStemming($where6);
        }
    }

    public function delAllStem() {
        $this->m_data->hapus_semua_stem();
        
        $data_active = array (
            'active' => 0
        );
        
        $this->m_data->set_active($data_active);

        $this->session->set_flashdata('message', '
        <div class="alert alert-dismissible fade show text-white" role="alert" style="background-color: #CA3E47;">
            <strong>Semua data Stemming</strong> berhasil dihapus!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ');
        redirect('admin/datadokumen');
    }

    public function hapusStemming($dok_id) {
        $this->m_data->hapus_stem($dok_id, 'tabel_stemming');

        $data_active = array(
            'active' => 0
        );

        $this->m_data->update_active($dok_id, $data_active, 'tabel_dokumen');

        $this->session->set_flashdata('message', '
        <div class="alert alert-dismissible fade show text-white" role="alert" style="background-color: #CA3E47;">
            <strong>Data Stemming</strong> berhasil dihapus!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ');
        redirect('admin/datadokumen');
    }

    public function stemAll() {
        $data = $this->m_data->tampil_data()->result();
        foreach($data as $dt) {
                $text = $dt->dokumen_judul;
                $id_dok = $dt->dokumen_id;

                $stemmerFactory = new StemmerFactory();
                $stopWordRemoverFactory = new StopWordRemoverFactory();
                $thetokens = new PennTreeBankTokenizer();
                $stemmer  = $stemmerFactory->createStemmer();
                $stopword = $stopWordRemoverFactory->createStopWordRemover();

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

                $token = $thetokens->tokenize($text);
                $no = 1;
                foreach ($token as $tkn) {
                    $outputstopword = $stopword->remove($tkn);
                    $output = $stemmer->stem($outputstopword); 
                    $data = array(
                        'dokumen_id' => $id_dok,
                        'token' => $tkn,
                        'stemming' => $output
                    );
                    $ress = $this->m_data->stemmingDokumen($data);
                    
                    $data_active = array(
                        'active' => 1
                    );
            
                    $this->m_data->set_active($data_active);
                }
        }

        if($ress == false) {
            $this->session->set_flashdata('message', '
        <div class="alert alert-dismissible fade show text-white" role="alert" style="background-color: #4E9F3D;">
            <strong>Data Dokumen</strong> berhasil di Stemming!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ');
            redirect('admin/datadokumen');
        } else {
                $this->session->set_flashdata('message', '
            <div class="alert alert-dismissible fade show text-white" role="alert" style="background-color: #CA3E47;">
                <strong>Data Dokumen</strong> gagal di Stemming!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ');
                redirect('admin/datadokumen');
        }
    }
}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Semua_hasil extends CI_Controller { 

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
        is_logged_in();
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0',false);
        header('Pragma: no-cache');
    }

    public function index($keywords) {
        $data['title'] = 'SEMUA HASIL PENCARIAN DOKUMEN';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $key = $keywords;

        $key = str_replace("'", "", $key);
        $key = str_replace("-", "", $key);
        $key = str_replace(")", "", $key);
        $key = str_replace("(", "", $key);
        $key = str_replace("\"", "",$key);
        $key = str_replace("/", "", $key);
        $key = str_replace("=", "", $key);
        $key = str_replace(".", "", $key);
        $key = str_replace(",", "", $key);
        $key = str_replace(":", "", $key);
        $key = str_replace(";", "", $key);
        $key = str_replace("!", "", $key);
        $key = str_replace("?", "", $key);
        $key = str_replace(">", "", $key);
        $key = str_replace("<", "", $key);

        $brokeString = explode("_", $key);
        $getString = implode(" ", $brokeString);

        $data['names'] = $getString;

        $exp_getString = explode(' ', strtoupper($getString));
        $SemuaHasil = array();

        foreach ($exp_getString as $e_gs) {
            $dataSearchNonPre = $this->dataSearch($e_gs);
            foreach($dataSearchNonPre as $value) {
                $valueData = array(
                    'dokumen_id' => $value['dokumen_id'],
                    'dokumen_judul' => $value['dokumen_judul'],
                    'dokumen_penulis' => $value['dokumen_penulis'],
                    'dokumen_tahun' => $value['dokumen_tahun'],
                    'counts' => $this->substr_count_array($value['dokumen_judul'], $exp_getString),
                );
                $SemuaHasil[] = $valueData;
            }

        }

        $uniqueArray = $this->super_unique($SemuaHasil);
        $newArray = array();

        foreach($uniqueArray as $item) {
            foreach($exp_getString as $keyword) {
                $item['dokumen_judul'] = preg_replace("/($keyword)/i","<i><b style='background-color:#FFF6BF; color:black;'>$0</b></i>",$item['dokumen_judul']);
            }  

            $newReplace = $item['dokumen_judul'];

            $Rep_Array = array(
                'dokumen_id' => $item['dokumen_id'],
                'dokumen_judul' => $newReplace,
                'dokumen_penulis' => $item['dokumen_penulis'],
                'dokumen_tahun' => $item['dokumen_tahun'],
                'counts' => $item['counts'],
            );

            $newArray[] = $Rep_Array;
        }

        usort($newArray, function($a, $b) {
            return $a['counts'] - $b['counts'];
        });

        $reverseArray = array_reverse($newArray);

        $data['allResult'] = $reverseArray;

        $this->load->view('templates/user/header', $data);
        $this->load->view('templates/user/topbar');
        $this->load->view('user/semua_hasil', $data);
        $this->load->view('templates/user/footer');

        return $getString;

    }

    public function dataSearch($loop) {
        $arrSrc = array();
        $mencariData = $this->m_data->searchkey($loop);
        foreach($mencariData as $key => $mcd) {
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

    public function super_unique($array) {
        $result = array_map("unserialize", array_unique(array_map("serialize", $array)));

        foreach ($result as $key => $value) {
            if ( is_array($value) ) {
                $result[$key] = $this->super_unique($value);
            }
        }

        return $result;
    }

    public function substr_count_array($haystack, $needle){
        $initial = 0;
        $bits_of_haystack = explode(' ', $haystack);
        foreach ($needle as $substring) {
            if(!in_array($substring, $bits_of_haystack))
                continue;
    
            $initial += substr_count($haystack, $substring);
        }
        return $initial;
    }
}
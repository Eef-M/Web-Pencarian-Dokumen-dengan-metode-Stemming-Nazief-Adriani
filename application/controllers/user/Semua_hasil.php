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

    public function index($keyword) {
        $data['title'] = 'SEMUA HASIL PENCARIAN DOKUMEN';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $brokeString = explode("_", $keyword);
        $getString = implode(" ", $brokeString);

        $data['names'] = $getString;

        $exp_getString = explode(' ', $getString);
        $SemuaHasil = array();

        foreach ($exp_getString as $e_gs) {
            $dataSearchNonPre = $this->dataSearch($e_gs);
            foreach($dataSearchNonPre as $value) {
                foreach($exp_getString as $keyword) {
                    $value['dokumen_judul'] = preg_replace("/($keyword)/i","<i><b style='background-color:#FFF6BF; color:black;'>$0</b></i>",$value['dokumen_judul']);
                }  
                $newReplace = $value['dokumen_judul'];
                
                $valueData = array(
                    'dokumen_id' => $value['dokumen_id'],
                    'dokumen_judul' => $newReplace,
                    'dokumen_penulis' => $value['dokumen_penulis'],
                    'dokumen_tahun' => $value['dokumen_tahun'],
                );
                $SemuaHasil[] = $valueData;
            }

        }

        $uniqueArray = $this->super_unique($SemuaHasil);
        $data['allResult'] = $uniqueArray;

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
}
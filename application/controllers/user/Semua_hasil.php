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
        $data['allResult'] = $this->m_data->searchAllResult($getString);

        $this->load->view('templates/user/header', $data);
        $this->load->view('templates/user/topbar');
        $this->load->view('user/semua_hasil', $data);
        $this->load->view('templates/user/footer');

    }
}
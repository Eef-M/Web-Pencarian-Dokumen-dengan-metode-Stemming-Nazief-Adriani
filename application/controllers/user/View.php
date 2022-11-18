<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View extends CI_Controller { 

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
    }
    

    public function index() {
        echo "KOSONG";
    }

    public function ViewStem() {
        $data['token'] = $this->m_data->tampil_token()->result_array();
        $this->load->view('templates/user/header', $data);
        $this->load->view('templates/user/topbar');
        $this->load->view('user/tampil_text', $data);
        $this->load->view('templates/user/footer');
    }
}
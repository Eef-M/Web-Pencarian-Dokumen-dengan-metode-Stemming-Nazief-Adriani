<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail extends CI_Controller { 

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
    }

    public function index($id) {
        $where = array('id' => $id);
        $data['dokumen'] = $this->m_data->edit_data($where, 'document')->result();
        $data['title'] = "DETAIL";
        
        $this->load->view('templates/user/header', $data);
        $this->load->view('templates/user/topbar');
        $this->load->view('user/edit_data', $data);
        $this->load->view('templates/user/footer');
    }
}
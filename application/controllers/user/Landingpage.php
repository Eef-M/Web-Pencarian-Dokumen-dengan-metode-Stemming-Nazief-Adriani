<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landingpage extends CI_Controller { 

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
        is_logged_in();
    }
    

    public function index() {
        
        $data['title'] = 'SEARCH DOCUMENT';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['dokumen'] = $this->m_data->tampil_data()->result();

        $this->load->view('templates/user/header', $data);
        $this->load->view('templates/user/topbar');
        $this->load->view('user/landing_page', $data);
        $this->load->view('templates/user/footer');
    }
}
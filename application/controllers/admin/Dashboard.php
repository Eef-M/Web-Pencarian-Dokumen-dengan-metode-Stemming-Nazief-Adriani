<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller { 

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
        is_logged_in();
    }
    

    public function index() {
        $data['title'] = "ADMIN | DASHBOARD";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['total_upload'] = $this->m_data->hitungJumlahData();
        $data['total_token'] = $this->m_data->jumlahToken();
        
        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar');
        $this->load->view('templates/admin/topbar');
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/admin/footer');
    }
}
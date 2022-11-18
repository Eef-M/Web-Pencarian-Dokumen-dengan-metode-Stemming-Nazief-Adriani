<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'lib/coba.php';

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
    }

	public function index()
	{
		$data['title'] = "SASNA ADMIN | DATA DOCUMENT";

        $data['data'] = $this->m_data->cosineData()->result();

        // $this->load->view('templates/admin/header', $data);
        // $this->load->view('templates/admin/sidebar');   
        // $this->load->view('templates/admin/topbar');
        // $this->load->view('admin/cek', $data);
        // $this->load->view('admin/tess', $data);
        // $this->load->view('templates/admin/footer');

		$this->load->view('templates/user/header', $data);
		$this->load->view('templates/user/topbar');
		$this->load->view('admin/tess', $data);
		$this->load->view('templates/user/footer');
    }
}
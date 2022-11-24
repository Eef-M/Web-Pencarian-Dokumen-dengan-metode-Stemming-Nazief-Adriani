<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'vendor/autoload.php';
use \Sastrawi\Stemmer\StemmerFactory;
use \Sastrawi\StopWordRemover\StopWordRemoverFactory;
use \Smalot\PdfParser\Parser;
use \TextAnalysis\Tokenizers\PennTreeBankTokenizer;

class Tambahdata extends CI_Controller { 

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
        is_logged_in();
    }
    

    public function index() {
        $data['title'] = "SASNA ADMIN | TAMBAH DATA"; 
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar');
        $this->load->view('templates/admin/topbar');
        $this->load->view('admin/tambah_data');
        $this->load->view('templates/admin/footer');
    }

    public function tambah_aksi () {

        $this->form_validation->set_rules('dokumen_id', 'ID Dokumen', 'required');
        $this->form_validation->set_rules('dokumen_judul', 'Judul Dokumen', 'required');
        $this->form_validation->set_rules('dokumen_penulis', 'Penulis Dokumen', 'required');
        $this->form_validation->set_rules('dokumen_tahun', 'Tahun Dokumen', 'required');

        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $dokumen_id = strtoupper($this->input->post('dokumen_id'));
            $dokumen_judul = strtoupper($this->input->post('dokumen_judul'));
            $dokumen_penulis = strtoupper($this->input->post('dokumen_penulis'));
            $dokumen_tahun = strtoupper($this->input->post('dokumen_tahun'));

            $data = array(
                'dokumen_id' => $dokumen_id,
                'dokumen_judul' => $dokumen_judul,
                'dokumen_penulis' => $dokumen_penulis,
                'dokumen_tahun' => $dokumen_tahun,
                'dokumen_euclidean' => 0,
                'active' => 0,
            );

            $this->m_data->input_data($data, 'tabel_dokumen');
            $this->session->set_flashdata('message', '
            <div class="alert alert-dismissible fade show text-white" role="alert" style="background-color: #4E9F3D;">
                <strong>Data Dokumen</strong> berhasil di tambahkan!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ');
            redirect('admin/tambahdata');
        }
        
    }

}
?>
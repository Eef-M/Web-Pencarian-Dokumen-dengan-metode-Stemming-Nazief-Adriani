<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Datadokumen extends CI_Controller {
    
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_data');
        is_logged_in();
    }
    

    public function index() {

        $data['title'] = "DATA DOCUMENT";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['dokumen'] = $this->m_data->tampil_data()->result();
        $data['stemming'] = $this->m_data->tampil_stemming()->result();

        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar');   
        $this->load->view('templates/admin/topbar');
        $this->load->view('admin/data_dokumen', $data);
        $this->load->view('templates/admin/footer');
    }

    // Edit
    public function setIdForEditData($id) {
        $ids = explode("-", $id);
        $hit_id = count($ids);
        if($hit_id == 3) {
            $id3 = $ids[0].'/'.$ids[1].'/'.$ids[2];
            $this->edit($id3);
        } elseif($hit_id == 4) {
            $id4 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3];
            $this->edit($id4);
        } elseif($hit_id == 5) {
            $id5 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3].'/'.$ids[4];
            $this->edit($id5);
        } elseif($hit_id == 6) {
            $id6 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3].'/'.$ids[4].'/'.$ids[5];
            $this->edit($id6);
        }
    }

    // Delete 
    public function setIdForDelData($id) {
        $ids = explode("-", $id);
        $hit_id = count($ids);
        if($hit_id == 3) {
            $id3 = $ids[0].'/'.$ids[1].'/'.$ids[2];
            $this->delete_data($id3);
        } elseif($hit_id == 4) {
            $id4 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3];
            $this->delete_data($id4);
        } elseif($hit_id == 5) {
            $id5 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3].'/'.$ids[4];
            $this->delete_data($id5);
        } elseif($hit_id == 6) {
            $id6 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3].'/'.$ids[4].'/'.$ids[5];
            $this->delete_data($id6);
        }
    }

    public function delete_data($id) {
        $where = array('dokumen_id' => $id);
        $this->m_data->delete_data_dok($where, 'tabel_dokumen');
        $this->session->set_flashdata('message', '
        <div class="alert alert-dismissible fade show text-white" role="alert" style="background-color: #CA3E47;">
            <strong>Data Dokumen</strong> berhasil dihapus!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ');
        redirect('admin/datadokumen');
    }
   

    public function edit($id) {
        $where = array('dokumen_id' => $id);
        $data['dokumen'] = $this->m_data->edit_data($where, 'tabel_dokumen')->result();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "SASNA ADMIN | DATA DOCUMENT";
        
        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar');
        $this->load->view('templates/admin/topbar');
        $this->load->view('admin/edit_data', $data);
        $this->load->view('templates/admin/footer');
    }

    public function update() {

        $this->form_validation->set_rules('dokumen_id', 'ID Dokumen', 'required');
        $this->form_validation->set_rules('dokumen_judul', 'Judul Dokumen', 'required');
        $this->form_validation->set_rules('dokumen_penulis', 'Penulis Dokumen', 'required');
        $this->form_validation->set_rules('dokumen_tahun', 'Tahun Dokumen', 'required');

        $id = $this->input->post('dokumen_id');
        if ($this->form_validation->run() == false) {
            $this->edit($id);
        } else {
            $dokumen_id = strtoupper($id);
            $dokumen_judul = strtoupper($this->input->post('dokumen_judul'));
            $dokumen_penulis = strtoupper($this->input->post('dokumen_penulis'));
            $dokumen_tahun = strtoupper($this->input->post('dokumen_tahun'));
    
            $data = array(
                'dokumen_judul' => $dokumen_judul,
                'dokumen_penulis' => $dokumen_penulis,
                'dokumen_tahun' => $dokumen_tahun,
            );

            $where = array(
                'dokumen_id' => $dokumen_id
            );

            $this->m_data->update_data($where, $data, 'tabel_dokumen');
            $this->session->set_flashdata('message', '
            <div class="alert alert-dismissible fade show text-white" role="alert" style="background-color: #4E9F3D;">
                <strong>Data Dokumen</strong> berhasil di Update!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ');
            redirect('admin/datadokumen');
        }
    }

}

?>
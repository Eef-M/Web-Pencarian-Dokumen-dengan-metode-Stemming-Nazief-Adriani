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

    public function setId($id) {
        $ids = explode("-", $id);
        $hit_id = count($ids);
        if($hit_id == 3) {
            $id3 = $ids[0].'/'.$ids[1].'/'.$ids[2];
            $where3 = array('dokumen_id' => $id3);
            $this->hapusStemming($where3);
        } elseif($hit_id == 4) {
            $id4 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3];
            $where4 = array('dokumen_id' => $id4);
            $this->hapusStemming($where4);

        } elseif($hit_id == 5) {
            $id5 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3].'/'.$ids[4];
            $where5 = array('dokumen_id' => $id5);
            $this->hapusStemming($where5);

        } elseif($hit_id == 6) {
            $id6 = $ids[0].'/'.$ids[1].'/'.$ids[2].'/'.$ids[3].'/'.$ids[4].'/'.$ids[5];
            $where6 = array('dokumen_id' => $id6);
            $this->hapusStemming($where6);
        }
    }

    public function hapusStemming($dok_id) {
        $this->m_data->hapus_stem($dok_id, 'tabel_stemming');

        $data_active = array(
            'active' => 0
        );

        $this->m_data->update_active($dok_id, $data_active, 'tabel_dokumen');

        $this->session->set_flashdata('message', '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Data Stemming</strong> berhasil dihapus!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ');
        redirect('admin/datadokumen');
    }

    // public function hapus($id_upload) {
    //     $where = array('id_upload' => $id_upload);

    //     $this->m_data->hapus_data($where);


    //     $this->session->set_flashdata('message', '
    //     <div class="alert alert-danger alert-dismissible fade show" role="alert">
    //         <strong>Data Dokumen</strong> berhasil dihapus!
    //         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //     </div>
    //     ');
    //     redirect('admin/datadokumen');
    // }

    public function edit($id) {
        $where = array('id' => $id);
        $data['dokumen'] = $this->m_data->edit_data($where, 'document')->result();
        $data['title'] = "SASNA ADMIN | DATA DOCUMENT";
        
        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar');
        $this->load->view('templates/admin/topbar');
        $this->load->view('admin/edit_data', $data);
        $this->load->view('templates/admin/footer');
    }

    public function update() {

        $this->form_validation->set_rules('judul_dokumen', 'Judul Dokumen', 'required');
        $this->form_validation->set_rules('nama_penulis', 'Nama Penulis', 'required');

        $id = $this->input->post('id');
        if ($this->form_validation->run() == false) {
            $this->edit($id);
        } else {
            $judul_dokumen = $this->input->post('judul_dokumen');
            $nama_penulis = $this->input->post('nama_penulis');
    
            $data = array(
                'judul_dokumen' => $judul_dokumen,
                'nama_penulis' => $nama_penulis
            );

            $config['upload_path']          = FCPATH.'uploads';
            $config['allowed_types']        = 'pdf|jpg|png';
            $config['max_size']             = 30000;
            $config['max_width']            = 0;
            $config['max_height']           = 0;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
    
            $where = array(
                'id' => $id
            );

            if ( $this->upload->do_upload('file_dokumen')) {
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
                $data['file_dokumen'] = $file_name;

                $this->m_data->update_data($where, $data, 'document');
                $this->session->set_flashdata('message', '
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Data Dokumen</strong> berhasil diupdate!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ');
                redirect('admin/datadokumen');
            } else { 
                // $error = array('error' => $this->upload->display_errors());

                $this->session->set_flashdata('message', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>File Dokumen</strong> tidak dipilih!. Silahkan <b>Edit</b> Lagi
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ');
                redirect('admin/datadokumen');

                
            }
    
            
        }
    }

}


?>
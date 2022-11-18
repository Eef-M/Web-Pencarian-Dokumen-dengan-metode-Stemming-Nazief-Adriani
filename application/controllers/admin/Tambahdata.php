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
    }
    

    public function index() {
        $data['title'] = "SASNA ADMIN | TAMBAH DATA"; 

        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar');
        $this->load->view('templates/admin/topbar');
        $this->load->view('admin/tambah_data');
        $this->load->view('templates/admin/footer');
    }

    public function tambah_aksi () {

        $this->form_validation->set_rules('judul_dokumen', 'Judul Dokumen', 'required');
        $this->form_validation->set_rules('nama_penulis', 'Nama Penulis', 'required');

        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $judul_dokumen = $this->input->post('judul_dokumen');
            $nama_penulis = $this->input->post('nama_penulis');

            $data = array(
                'judul_dokumen' => $judul_dokumen,
                'nama_penulis' => $nama_penulis,
            );

            $config['upload_path']          = FCPATH.'uploads';
            $config['allowed_types']        = 'pdf|jpg|png';
            $config['max_size']             = 30000;
            $config['max_width']            = 0;
            $config['max_height']           = 0;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // $this->upload->do_upload();
            if ( $this->upload->do_upload('file_dokumen')) {
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
                $data['file_dokumen'] = $file_name;

                $this->m_data->input_data($data, 'document');
                $this->session->set_flashdata('message', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Data Dokumen</strong> berhasil ditambahlan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ');
                redirect('admin/tambahdata');
            } else { 
                $this->session->set_flashdata('message', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>File Dokumen</strong> tidak dipilih
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ');
                redirect('admin/tambahdata'); 
            }

        }
        
    }

    public function stemm($text, $nama_file, $data1) {

        $data['title'] = "HASIL STEMMING";
        $data['file_name'] = $nama_file;

        $stemmerFactory = new StemmerFactory();
        $stopWordRemoverFactory = new StopWordRemoverFactory();
        $thetokens = new PennTreeBankTokenizer();
        $stemmer  = $stemmerFactory->createStemmer();
        $stopword = $stopWordRemoverFactory->createStopWordRemover();
        
        $text = str_replace("'", " ", $text);
        $text = str_replace("-", " ", $text);
        $text = str_replace(")", " ", $text);
        $text = str_replace("(", " ", $text);
        $text = str_replace("\"", " ",$text);
        $text = str_replace("/", " ", $text);
        $text = str_replace("=", " ", $text);
        $text = str_replace(".", " ", $text);
        $text = str_replace(",", " ", $text);
        $text = str_replace(":", " ", $text);
        $text = str_replace(";", " ", $text);
        $text = str_replace("!", " ", $text);
        $text = str_replace("?", " ", $text);
        $text = str_replace(">", " ", $text);
        $text = str_replace("<", " ", $text);
        $id_upload = $this->m_data->insert_upload($data1);
        
        $data = array(
            "desk" => $text,
            "nama_file" => $nama_file,
            "id_upload" => $id_upload
        ); 

        $this->m_data->insert_text($data);
        
        $token = $thetokens->tokenize($text);

        $this->load->view('templates/admin/header', $data);
        ?>
<div class="container-fluid pt-4 px-4">
    <div class="rounded p-4 bg-light" id="ThePage">
        <h3 class="mb-4 text-center"><?= $nama_file ?></h3>
        <?= $this->session->flashdata('message') ?>
        <hr class="mb-4" style=" color: #2155cd; border-radius: 3px; height: 5px;">
        <div class="table-responsive">
            <table class="table text-center">
                <thead class="text-dark" style="background-color: #2155cda3;">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Token</th>
                        <th scope="col">Token Stemming</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
        $no = 1;
        foreach ($token as $tkn) {
            $outputstopword = $stopword->remove($tkn);
            $output = $stemmer->stem($outputstopword); 
            $data2 = array(
                'nama_file' => $nama_file,
                'token' => $tkn,
                'tokenstem' => $output,
                'id_upload' => $id_upload
            );
            ?>


                    <tr>
                        <th scope="row"><?= $no++ ?></th>
                        <td><?= $tkn ?></td>
                        <td><?= $output ?></td>
                    </tr>

                    <?php
            // $this->m_data->stem_data($nama_file, $tkn, $output);
            // $this->m_data->insert_data('dokumen', $data);
            $this->m_data->insert_dokumen($data2);
        }
        ?>
                </tbody>
            </table>
            <a href="<?= base_url('admin/tambahdata'); ?>" class="btn text-white"
                style="background-color: #2155cd;">Kembali</a>
        </div>
    </div>
</div>
<?php
    } 

    public function uploadstem() {
        $config['upload_path']          = FCPATH.'uploads';
        $config['allowed_types']        = 'pdf|jpg|png';
        $config['max_size']             = 30000;
        $config['max_width']            = 0;
        $config['max_height']           = 0;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        
        // $tgl_upload = date("Ymd");
        
        $deskripsi = $this->input->post('deskripsi');
        $tgl_upload = date('Ymd');
        
        if ( $this->upload->do_upload('fupload')) {
            $upload_data = $this->upload->data();
            $nama_file = $upload_data['file_name'];
            // $data['fupload'] = $nama_file;
            
            $data1 = array(
                'nama_file' => $nama_file,
                'deskripsi' => $deskripsi,
                'tgl_upload' => $tgl_upload
            );
            $parser = new Parser();
            $pdf = $parser->parseFile(FCPATH.'uploads/'.$nama_file);
            $textpdf = $pdf->getText();

            // $this->m_data->insert_data($nama_file, $tgl_upload);
            // $this->m_data->stem_data('upload', $data);

            $this->stemm($textpdf, $nama_file, $data1);
        } else { 
            $this->session->set_flashdata('message', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Upload File</strong> Gagal
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ');
            redirect('admin/tambahdata'); 

        }
    }
}
?>
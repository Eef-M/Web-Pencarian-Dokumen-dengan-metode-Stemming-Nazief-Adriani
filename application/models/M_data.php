<?php 

class M_data extends CI_Model {

    function get_prefixes($id) {
        $this->db->select('data');
        $this->db->where('prefixes_id',$id);
        $query = $this->db->get('prefixes');
        return $query->result();
    }

    function kata_dasar() {
        return $this->db->get('tb_katadasar');
    }

    function tampil_data() {
        return $this->db->get('tabel_dokumen');
    }
    
    function tampil_stemming() {
        return $this->db->get('tabel_stemming');
    }
    
    function input_data($data, $table) {
        $this->db->insert($table, $data);
    }

    function delete_data_dok($where, $table) {
        $this->db->where($where);
        $this->db->delete($table);
    }

    // function hapus_data($where,$table){
    //     $this->db->where($where);
    //     $query = $this->db->get('upload');
    //     $row = $query->row();

    //     unlink("./uploads/$row->nama_file");
    //     $this->db->delete($table, $where);
    // }

    function stemmingDokumen($data) {
        $this->db->insert('tabel_stemming', $data);
        // return $this->db->insert_id();
    }

    function set_active($data) {
        $this->db->update('tabel_dokumen', $data);
    }

    function update_active($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}

    function hapus_stem($where, $table) {
        $this->db->where($where);
        $this->db->delete($table);
    }

    function getDokId() {
        $query = $this->db->get('tabel_dokumen');
        foreach ($query->result() as $row) {
            echo $row->dokumen_id;
        }
    }

    function hapus_semua_stem() {
        $this->db->empty_table('tabel_stemming');
    }

    function getJudulDok() {
        $query = $this->db->get('tabel_dokumen');
        foreach ($query->result() as $row) {
            echo $row->dokumen_judul;
        }
    }

    function hapus_data($id_upload) {
        $sql = "DELETE upload,dokumen
        FROM upload,dokumen
        WHERE upload.id_upload=dokumen.id_upload 
        AND dokumen.id_upload= ?";

        $this->db->query($sql, array($id_upload));
    }

    function edit_data($where, $table) {
        return $this->db->get_where($table, $where);
    } 

    function detail_data($where, $table) {
        return $this->db->get_where($table, $where);
    } 

    function update_data($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}

    function cari_data() {
        $keyword = $this->input->post('keyword', true);
        $this->db->or_like('judul_dokumen', $keyword);
        $this->db->or_like('nama_penulis', $keyword);
        return $this->db->get('document')->result_array();
    }

    function search() {
        $keyword = $this->input->post('keyword', true);
        // $this->db->or_like('nama_file', $keyword);
        $this->db->or_like('token', $keyword);
        // $this->db->or_like('tokenstem', $keyword);
        return $this->db->get('tabel_stemming')->result_array();
    }

    function search2() {
        $keyword = $this->input->post('keyword', true);
        // $this->db->or_like('nama_file', $keyword);
        $this->db->or_like('dokumen_judul', $keyword);
        // $this->db->or_like('tokenstem', $keyword);
        return $this->db->get('tabel_dokumen')->result_array();
    }

    function searchAllResult($keyword) {
        // $keyword = $this->input->post('keyword', true);
        // $this->db->or_like('nama_file', $keyword);
        $this->db->or_like('dokumen_judul', $keyword);
        // $this->db->or_like('tokenstem', $keyword);
        return $this->db->get('tabel_dokumen')->result_array();
    }

    function searchkey($keyy) {
        $keyword = $keyy;
        // $this->db->or_like('nama_file', $keyword);
        $this->db->or_like('dokumen_judul', $keyword);
        // $this->db->or_like('tokenstem', $keyword);
        return $this->db->get('tabel_dokumen')->result_array();
    }

    function searchkey2($keyy) {
        // $this->db->or_like('nama_file', $keyword);
        $this->db->or_like('dokumen_judul', $keyy);
        // $this->db->or_like('tokenstem', $keyword);
        return $this->db->get('tabel_dokumen')->result_array();
    }

    // function pencarian() {
    //     if(!empty($_POST["keyword"])) {
    //         $keyword = $_POST["keyword"];
    //         $wordsAry = explode(" ", $keyword);
    //         $wordsCount = count($wordsAry);
    //         $queryCondition = " WHERE ";
    //         for($i=0;$i<$wordsCount;$i++) {
    //             $queryCondition .= "nama_file LIKE '%" . $wordsAry[$i] . "%' OR desk LIKE '%" . $wordsAry[$i] . "%'";
    //             if($i!=$wordsCount-1) {
    //                 $queryCondition .= " OR ";
    //             }
    //         }
    //     }
    //     $orderby = " ORDER BY id_text desc"; 
    //     $sql = "SELECT * FROM `text` " . $queryCondition;
    //     $this->db->query($sql);

    // }

    function pencarian() {
        $keyword = $this->input->post('keyword', true);
        $search_query_values = explode(' ', $keyword);
        $counter = 0;
        foreach ($search_query_values as $key => $value) {
            if ($counter == 0) {
                $this->db->like('nama_file', $value);
            }
            else {
                $this->db->or_like('nama_file', $value);
                $this->db->or_like('desk', $value);
            }
            $counter++;
        }
        return $this->db->get('text')->result_array();
    }

    // function insert_data($table, $data) {
    //     $query = $this->db->insert($table, $data);
    //     return $this->db->insert_id();
    // }

    function stem_data($table, $data) {
        $this->db->insert($table, $data);
    }

    function insert_upload($data1) {
        $this->db->insert('upload', $data1);
        return $this->db->insert_id();
    }

    public function insert_dokumen($data) {
        $this->db->insert('dokumen', $data);
        return $this->db->insert_id();
    }
    
    public function insert_text($data2) {
        $this->db->insert('text', $data2);
        return $this->db->insert_id();
    }
    
    function hitungJumlahData() {
        $query = $this->db->get('tabel_dokumen');
        if ( $query->num_rows() > 0 ) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function jumlahToken() {
        $query = $this->db->get('tabel_stemming');
        if ( $query->num_rows() > 0 ) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    function addText($table, $data) {
        $this->db->insert($table, $data);
    }

    function dataText() {
        return $this->db->get('text');
    }

    function tess_in($table, $data) {
        $this->db->insert($table, $data);
    }

    function tess_out($table, $data) {
        $this->db->insert($table, $data);
    }





    // function insert_data($nama_file, $tgl_upload) {
    //     $query = "INSERT INTO upload (nama_file, deskripsi, tgl_upload)
    //              VALUES('$nama_file', '$_POST[deskripsi]', '$tgl_upload')";
    //     $this->db->query($query);
    // }

    // function stem_data($nama_file, $token, $tokenstem) {
    //     $query = "INSERT INTO dokumen (nama_file, token, tokenstem)
    //             VALUES('$nama_file', '$token', '$tokenstem')";

    //     $this->db->query($query);
    // }
    
}

?>
<?php 
// TIDAK DIPAKAI
class M_imbuhan extends CI_Model {

    function get_prefixes($id) {
        $this->db->select('data');
        $this->db->where('prefixes_id',$id);
        $query = $this->db->get('prefixes');
        return $query->result();
    }

    function get_suffixes($id) {
        $this->db->select('data');
        $this->db->where('suffixes_id',$id);
        $query = $this->db->get('suffixes');
        return $query->result();
    }

    function get_confixes($id) {
        $this->db->select('data');
        $this->db->where('confixes_id',$id);
        $query = $this->db->get('confixes');
        return $query->result();
    }

    // Do Confixes
    function Confix_ber_an($teks) {
        $loadData = $this->get_confixes('ber_an');
        foreach ($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Confix_ke_an($teks) {
        $loadData = $this->get_confixes('ke_an');
        foreach ($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Confix_pem_an($teks) {
        $loadData = $this->get_confixes('pem_an');
        foreach ($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Confix_penge_an($teks) {
        $loadData = $this->get_confixes('penge_an');
        foreach ($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Confix_peng_an($teks) {
        $loadData = $this->get_confixes('peng_an');
        foreach ($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Confix_peny_an($teks) {
        $loadData = $this->get_confixes('peny_an');
        foreach ($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Confix_pen_an($teks) {
        $loadData = $this->get_confixes('pen_an');
        foreach ($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Confix_per_an($teks) {
        $loadData = $this->get_confixes('per_an');
        foreach ($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Confix_pe_an($teks) {
        $loadData = $this->get_confixes('pe_an');
        foreach ($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Confix_se_nya($teks) {
        $loadData = $this->get_confixes('se_nya');
        foreach ($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    // ---------------------------------------------------------------------------------------------------------------------------------
    // Do Prefixes
    function Prefix_ber($teks) {
        $loadData = $this->get_prefixes('ber');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_di($teks) {
        $loadData = $this->get_prefixes('di');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_ke($teks) {
        $loadData = $this->get_prefixes('ke');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_me($teks) {
        $loadData = $this->get_prefixes('me');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_mem($teks) {
        $loadData = $this->get_prefixes('mem');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_men($teks) {
        $loadData = $this->get_prefixes('men');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_meng($teks) {
        $loadData = $this->get_prefixes('meng');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_menge($teks) {
        $loadData = $this->get_prefixes('menge');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_meny($teks) {
        $loadData = $this->get_prefixes('meny');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_pe($teks) {
        $loadData = $this->get_prefixes('pe');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_pem($teks) {
        $loadData = $this->get_prefixes('pem');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_pen($teks) {
        $loadData = $this->get_prefixes('pen');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_peng($teks) {
        $loadData = $this->get_prefixes('peng');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_penge($teks) {
        $loadData = $this->get_prefixes('penge');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_peny($teks) {
        $loadData = $this->get_prefixes('peny');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_per($teks) {
        $loadData = $this->get_prefixes('per');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_se($teks) {
        $loadData = $this->get_prefixes('se');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Prefix_ter($teks) {
        $loadData = $this->get_prefixes('ter');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    // ---------------------------------------------------------------------------------------------------------------------------------
    // Do Suffix
    function Suffix_an($teks) {
        $loadData = $this->get_suffixes('an');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Suffix_i($teks) {
        $loadData = $this->get_suffixes('i');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Suffix_kah($teks) {
        $loadData = $this->get_suffixes('kah');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Suffix_kan($teks) {
        $loadData = $this->get_suffixes('kan');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Suffix_lah($teks) {
        $loadData = $this->get_suffixes('lah');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }

    function Suffix_nya($teks) {
        $loadData = $this->get_suffixes('nya');
        foreach($loadData as $ld) {
            $result = str_replace('-', $teks, $ld->data);
            return $result;
        }
    }
}

?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DetailAngsuran_model extends CI_Model {
    
    public function getAngsuranByIdPinjaman($id_pinjaman) {
        $this->db->where('id_pinjaman', $id_pinjaman);
        $query = $this->db->get('angsuran');
        return $query->result();
    }
    
    public function getAnggotaById($id_anggota) {
        $this->db->where('id_anggota', $id_anggota);
        $query = $this->db->get('anggota');
        return $query->row();
    }
}
?>

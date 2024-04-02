<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PerhitunganAngsuran_model extends CI_Model 
{

    public function getAngsuranDetails($id_pinjaman) {
        $this->db->select('jumlah_pinjaman, bunga');
        $this->db->from('pinjaman');
        $this->db->where('id_pinjaman', $id_pinjaman);
        $query = $this->db->get();
        return $query->row();
    }

    public function getTotalAngsuran($id_pinjaman) {
        $this->db->select_sum('jumlah_angsuran');
        $this->db->from('angsuran');
        $this->db->where('id_pinjaman', $id_pinjaman);
        $query = $this->db->get();
        return $query->row()->jumlah_angsuran;
    }


}

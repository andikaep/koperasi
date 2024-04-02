<?php defined('BASEPATH') OR exit('No direct script access allowed');


class DetailAngsuran extends CI_Controller {
    
    public function view_detail($id_pinjaman) {
        // Load model untuk mengambil data angsuran
        $this->load->model('DetailAngsuran_model');
        
        // Ambil data angsuran berdasarkan id_pinjaman
        $data['angsuran'] = $this->DetailAngsuran_model->getAngsuranByIdPinjaman($id_pinjaman);
        
        // Ambil data anggota berdasarkan id_anggota dari data angsuran pertama
        $id_anggota = $data['angsuran'][0]->id_anggota;
        $data['anggota'] = $this->DetailAngsuran_model->getAnggotaById($id_anggota);
        
        // Load view
        $this->load->view('detail_angsuran/detail_angsuran', $data);
    }
}
?>

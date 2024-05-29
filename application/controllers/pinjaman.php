<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* author inogalwargan
*/

class Pinjaman extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Anggota_model");
        $this->load->model("Pinjaman_model");
        $this->load->library('form_validation');
    }

    public function index()
{
    $data['total_pinjaman'] = $this->Pinjaman_model->countAll();

    $data["pinjaman"] = $this->Pinjaman_model->getListPinjaman();
    $this->load->view("pinjaman/lihat_pinjaman", $data);
}


    public function simulasi()
    {
        $data["pinjaman"] = $this->Pinjaman_model->getListPinjaman();
        $this->load->view("pinjaman/simulasi_pinjaman", $data);
    }
    

    public function list_anggota(){
    	$data['anggota'] = $this->Anggota_model->getAll();
        $this->load->view("pinjaman/list_anggota_pinjaman", $data);
    }

    public function add($id)
    {   
        $anggota = $this->Anggota_model->getById($id);
        $pinjaman = $this->Pinjaman_model;
        $validation = $this->form_validation;
        $validation->set_rules($pinjaman->rules());

        if ($validation->run()) {
            $pinjaman->save();
            $jumlahFormatted = "Rp " . number_format($pinjaman->jumlah_pinjaman, 0, ',', '.');
            $this->session->set_flashdata('success', 'Tambah Pinjaman <strong>' . $anggota->nama . '</strong> Sebesar ' . $jumlahFormatted . ' Berhasil Disimpan');
            redirect('pinjaman/index');
        }
        $data['anggota'] = $this->Anggota_model->getById($id);
        $this->load->view("pinjaman/tambah_pinjaman", $data);
    }

    public function edit($id){
        $anggota = $this->Anggota_model->getById($id);
        $pinjaman = $this->Pinjaman_model->getById($id);
        if(!$pinjaman) {
            show_404();
        }
    
        $anggota_id = $pinjaman->id_anggota;
        $anggota = $this->Anggota_model->getById($anggota_id);
        if(!$anggota) {
            show_404();
        }
    
        $validation = $this->form_validation;
        $validation->set_rules($this->Pinjaman_model->rules());
    
    
    
        if ($validation->run()) {
            $this->Pinjaman_model->update($id);
            
            // Ambil nilai simpanan pokok baru setelah perubahan
            $new_jumlah = "Rp " . number_format(preg_replace("/[^0-9]/", "", $this->input->post('jumlah_pinjaman')), 0, ',', '.');
            $old_jumlah = "Rp " . number_format($pinjaman->jumlah_pinjaman, 0, ',', '.');
    
            // Buat pesan dengan informasi yang diinginkan
            $message = 'Data Pinjaman <strong>' . $anggota->nama . '</strong> sebesar <strong>' . $old_jumlah . '</strong> berhasil diubah menjadi <strong>' . $new_jumlah . '</strong>';
            
            $this->session->set_flashdata('success', $message);
            redirect('pinjaman');
        }
    
        $data['pinjaman'] = $pinjaman;
        $data['anggota'] = $anggota;
        $this->load->view('pinjaman/edit_pinjaman', $data);
    }
    
        public function hide($id){
            $this->Anggota_model->update($id);
            $this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
            redirect('anggota/index');
    }

    // public function hide($id){
    // 	$this->Anggota_model->update($id);
    // 	$this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
    // 	redirect('Anggota_controller/index');
    // }

    public function delete($id){
	    $this->Pinjaman_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
	    $this->session->set_flashdata('success', 'Data Pinjaman Berhasil Dihapus');
	    redirect($_SERVER['HTTP_REFERER']);
	}
}

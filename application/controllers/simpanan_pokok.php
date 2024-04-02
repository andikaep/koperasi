<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* author
*/

class Simpanan_pokok extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Anggota_model");
        $this->load->model("SimpananPokok_model");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["anggota"] = $this->Anggota_model->getAll();
        $this->load->view("simpanan_pokok/lihat_simpanan_pokok", $data);
    }

    public function detail($id){
        // $data['anggota'] = $this->SimpananPokok_model->detail_simpanan_pokokall();
        $data['tot'] = $this->SimpananPokok_model->total_simpanan_pokok($id);
        $data['simpanan_pokok'] = $this->SimpananPokok_model->detail_simpanan_pokok($id);
        $this->load->view("simpanan_pokok/detail_simpanan_pokok", $data);
    }

    public function add($id)
    {   
        $anggota = $this->Anggota_model->getById($id);
        $simpanan_pokok = $this->SimpananPokok_model;
        $validation = $this->form_validation;
        $validation->set_rules($simpanan_pokok->rules());

        if ($validation->run()) {
            $simpanan_pokok->save();
            // Format jumlah simpanan menjadi format Rupiah dengan tiga angka di belakang titik
            $jumlahFormatted = "Rp " . number_format($simpanan_pokok->jumlah, 0, ',', '.');

            // Set pesan sukses dalam session flashdata
            $this->session->set_flashdata('success', 'Tambah Simpanan Pokok <strong>' . $anggota->nama . '</strong> Sebesar ' . $jumlahFormatted . ' Berhasil Disimpan');

            redirect('simpanan_pokok/index');
        }
        $data['anggota'] = $this->Anggota_model->getById($id);
        $this->load->view("simpanan_pokok/tambah_simpanan_pokok", $data);
    }

   public function edit($id){
    $anggota = $this->Anggota_model->getById($id);
    $simpanan_pokok = $this->SimpananPokok_model->getById($id);
    if(!$simpanan_pokok) {
        show_404();
    }

    $anggota_id = $simpanan_pokok->id_anggota;
    $anggota = $this->Anggota_model->getById($anggota_id);
    if(!$anggota) {
        show_404();
    }

    $validation = $this->form_validation;
    $validation->set_rules($this->SimpananPokok_model->rules());



    if ($validation->run()) {
        $this->SimpananPokok_model->update($id);
        
        // Ambil nilai simpanan pokok baru setelah perubahan
        $new_jumlah = "Rp " . number_format(preg_replace("/[^0-9]/", "", $this->input->post('jumlah')), 0, ',', '.');
        $old_jumlah = "Rp " . number_format($simpanan_pokok->jumlah, 0, ',', '.');

        // Buat pesan dengan informasi yang diinginkan
        $message = 'Data Simpanan Pokok <strong>' . $anggota->nama . '</strong> sebesar <strong>' . $old_jumlah . '</strong> berhasil diubah menjadi <strong>' . $new_jumlah . '</strong>';
        
        $this->session->set_flashdata('success', $message);
        redirect('simpanan_pokok/detail/'.$anggota_id);
    }

    $data['simpanan_pokok'] = $simpanan_pokok;
    $data['anggota'] = $anggota;
    $this->load->view('simpanan_pokok/edit_simpanan_pokok', $data);
}

    public function hide($id){
    	$this->Anggota_model->update($id);
    	$this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
    	redirect('anggota/index');
    }

    public function delete($id){
	    $this->SimpananPokok_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
        $jumlahFormatted = "Rp " . number_format($simpanan_pokok->jumlah, 0, ',', '.');
	    $this->session->set_flashdata('success', 'Data Simpanan Pokok Berhasil Dihapus');
	    redirect($_SERVER['HTTP_REFERER']);
	}
}

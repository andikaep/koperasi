<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* author inogalwargan
*/

class Simpanan_wajib extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Anggota_model");
        $this->load->model("SimpananWajib_model");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["anggota"] = $this->Anggota_model->getAll();
        $this->load->view("simpanan_wajib/lihat_simpanan_wajib", $data);
    }

    public function detail($id){
        // $data['anggota'] = $this->SimpananWajib_model->detail_simpanan_pokokall();
        $data['simpanan_wajib'] = $this->SimpananWajib_model->detail_simpanan_wajib($id);
        $data['tot'] = $this->SimpananWajib_model->total_simpanan_wajib($id);
        $this->load->view("simpanan_wajib/detail_simpanan_wajib", $data);
    }

    public function add($id)
    {   
        $anggota = $this->Anggota_model->getById($id);
        $simpanan_wajib = $this->SimpananWajib_model;
        $validation = $this->form_validation;
        $validation->set_rules($simpanan_wajib->rules());

        if ($validation->run()) {
            $simpanan_wajib->save();
            // Format jumlah simpanan menjadi format Rupiah dengan tiga angka di belakang titik
        $jumlahFormatted = "Rp " . number_format($simpanan_wajib->jumlah, 0, ',', '.');

        // Set pesan sukses dalam session flashdata
        $this->session->set_flashdata('success', 'Tambah Simpanan Wajib <strong>' . $anggota->nama . '</strong> Sebesar ' . $jumlahFormatted . ' Berhasil Disimpan');

            redirect('simpanan_wajib/index');
        }
        $data['anggota'] = $this->Anggota_model->getById($id);
        $this->load->view("simpanan_wajib/tambah_simpanan_wajib", $data);
    }

    public function edit($id){
        $anggota = $this->Anggota_model->getById($id);
        $simpanan_wajib = $this->SimpananWajib_model->getById($id);
        if(!$simpanan_wajib) {
            show_404();
        }
    
        $anggota_id = $simpanan_wajib->id_anggota;
        $anggota = $this->Anggota_model->getById($anggota_id);
        if(!$anggota) {
            show_404();
        }
    
        $validation = $this->form_validation;
        $validation->set_rules($this->SimpananWajib_model->rules());
    
        
    
        if ($validation->run()) {
            $this->SimpananWajib_model->update($id);
            
            // Ambil nilai simpanan pokok baru setelah perubahan
           // Ambil nilai simpanan pokok baru setelah perubahan
        $new_jumlah = "Rp " . number_format(preg_replace("/[^0-9]/", "", $this->input->post('jumlah')), 0, ',', '.');
        $old_jumlah = "Rp " . number_format($simpanan_wajib->jumlah, 0, ',', '.');

        // Buat pesan dengan informasi yang diinginkan
        $message = 'Data Simpanan Wajib <strong>' . $anggota->nama . '</strong> sebesar <strong>' . $old_jumlah . '</strong> berhasil diubah menjadi <strong>' . $new_jumlah . '</strong>';
            
            $this->session->set_flashdata('success', $message);
            redirect('simpanan_wajib/detail/'.$anggota_id);
        }
    
        $data['simpanan_wajib'] = $simpanan_wajib;
        $data['anggota'] = $anggota;
        $this->load->view('simpanan_wajib/edit_simpanan_wajib', $data);
    }

    public function hide($id){
    	$this->Anggota_model->update($id);
    	$this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
    	redirect('Anggota_controller/index');
    }

    public function delete($id){
	    $this->SimpananWajib_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
	    $this->session->set_flashdata('success', 'Data Simpanan Wajib Berhasil Dihapus');
	    redirect($_SERVER['HTTP_REFERER']);
	}
}

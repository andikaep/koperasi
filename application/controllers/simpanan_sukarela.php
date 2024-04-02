<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Simpanan_sukarela extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Anggota_model");
        $this->load->model("SimpananSukarela_model");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["anggota"] = $this->Anggota_model->getAll();
        $this->load->view("simpanan_sukarela/lihat_simpanan_sukarela", $data);
    }

    public function detail($id){

        // $data['anggota'] = $this->SimpananSukarelamodel->detail_simpanan_pokokall();
        $data['simpanan_sukarela'] = $this->SimpananSukarela_model->detail_simpanan_sukarela($id);
        $data['tot'] = $this->SimpananSukarela_model->total_simpanan_sukarela($id);
        $this->load->view("simpanan_sukarela/detail_simpanan_sukarela", $data);
    }

    public function add($id)
    {   
        $anggota = $this->Anggota_model->getById($id);
        $simpanan_sukarela= $this->SimpananSukarela_model;
        $validation = $this->form_validation;
        $validation->set_rules($simpanan_sukarela->rules());

        if ($validation->run()) {
            $simpanan_sukarela->save();
            // Format jumlah simpanan menjadi format Rupiah dengan tiga angka di belakang titik
        $jumlahFormatted = "Rp " . number_format($simpanan_sukarela->jumlah, 0, ',', '.');

        // Set pesan sukses dalam session flashdata
        $this->session->set_flashdata('success', 'Tambah Simpanan Sukarela <strong>' . $anggota->nama . '</strong> Sebesar ' . $jumlahFormatted . ' Berhasil Disimpan');

            redirect('simpanan_sukarela/index');
        }
        $data['anggota'] = $this->Anggota_model->getById($id);
        $this->load->view("simpanan_sukarela/tambah_simpanan_sukarela", $data);
    }

    public function edit($id){
        $anggota = $this->Anggota_model->getById($id);
        $simpanan_sukarela = $this->SimpananSukarela_model->getById($id);
        if(!$simpanan_sukarela) {
            show_404();
        }
    
        $anggota_id = $simpanan_sukarela->id_anggota;
        $anggota = $this->Anggota_model->getById($anggota_id);
        if(!$anggota) {
            show_404();
        }
    
        $validation = $this->form_validation;
        $validation->set_rules($this->SimpananSukarela_model->rules());
    
        
    
        if ($validation->run()) {
            $this->SimpananSukarela_model->update($id);
            
            // Ambil nilai simpanan pokok baru setelah perubahan
           // Ambil nilai simpanan pokok baru setelah perubahan
        $new_jumlah = "Rp " . number_format(preg_replace("/[^0-9]/", "", $this->input->post('jumlah')), 0, ',', '.');
        $old_jumlah = "Rp " . number_format($simpanan_sukarela->jumlah, 0, ',', '.');

        // Buat pesan dengan informasi yang diinginkan
        $message = 'Data Simpanan Sukarela <strong>' . $anggota->nama . '</strong> sebesar <strong>' . $old_jumlah . '</strong> berhasil diubah menjadi <strong>' . $new_jumlah . '</strong>';
            
            $this->session->set_flashdata('success', $message);
            redirect('simpanan_sukarela/detail/'.$anggota_id);
        }
    
        $data['simpanan_sukarela'] = $simpanan_sukarela;
        $data['anggota'] = $anggota;
        $this->load->view('simpanan_sukarela/edit_simpanan_sukarela', $data);
    }

    public function hide($id){
    	$this->Anggota_model->update($id);
    	$this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
    	redirect('Anggota_controller/index');
    }

    public function delete($id){
	    $this->SimpananSukarela_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
	    $this->session->set_flashdata('success', 'Data Simpanan Sukarela Berhasil Dihapus');
	    redirect($_SERVER['HTTP_REFERER']);
	}
}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Pengguna_model");
        $this->load->model("User_model");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["pengguna"] = $this->Pengguna_model->getAll();
        // Mengambil waktu terakhir login untuk setiap pengguna
        foreach ($data['pengguna'] as $user) {
            $user->last_login = $this->User_model->get_last_login($user->username);
        }
        $this->load->view("pengguna/lihat_pengguna", $data);
    }

    public function add()
    {
        $pengguna = $this->Pengguna_model;
        $validation = $this->form_validation;
        $validation->set_rules($pengguna->rules());

        $validation->set_rules('password', 'Password', 'required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()-_+=])[a-zA-Z0-9!@#$%^&*()-_+=]{8,}$/]',
    array(
        'required' => 'Password harus diisi.',
        'regex_match' => 'Password harus terdiri dari minimal 8 karakter yang terdiri dari setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter spesial.'
    )
    );


        if ($validation->run()) {
            // Dapatkan input password dari formulir
            $password = $this->input->post('password');

            // Enkripsi password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Simpan password yang dienkripsi bersama dengan data pengguna lainnya
            $pengguna->password = $hashed_password;
            $pengguna->save();
            $this->session->set_flashdata('success', 'Tambah Pengguna '.$pengguna->nama.' Berhasil Disimpan');
            redirect('pengguna/index');
        }

        $this->load->view("pengguna/tambah_pengguna");
    }

    public function edit($id){

    	$pengguna = $this->Pengguna_model; //object model
        $validation = $this->form_validation; //object validasi
        $validation->set_rules($pengguna->rules()); //terapkan rules di Pengguna_model.php

        if ($validation->run()) { //lakukan validasi form
            $pengguna->update($id); // update data
            $this->session->set_flashdata('success', '<div class="alert alert-success">Data Pengguna ' . $pengguna->getById($id)->nama . ' berhasil diubah.</div>');
            redirect('pengguna/index');
        }

        $data['pengguna'] = $this->Pengguna_model->getById($id);
		 if ($this->session->flashdata('success')) {
        $data['success_message'] = $this->session->flashdata('success');
        // Hapus pesan flash agar tidak ditampilkan lagi
        $this->session->unset_flashdata('success');
    }
        $this->load->view('pengguna/edit_pengguna', $data);
    }

    public function edit_password($id) {
        // Ambil data pengguna berdasarkan ID
        $data['pengguna'] = $this->Pengguna_model->getById($id);
    
        // Set aturan validasi
        $this->form_validation->set_rules('password', 'Password', 'required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()-_+=])[a-zA-Z0-9!@#$%^&*()-_+=]{8,}$/]', array(
            'required' => 'Password harus diisi.',
            'regex_match' => 'Password harus terdiri dari minimal 8 karakter yang terdiri dari setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter spesial.'
        ));
    
        // Jalankan validasi
        if ($this->form_validation->run()) {
            // Ambil password dari form
            $password = $this->input->post('password');
    
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
            // Update password pengguna
            $this->Pengguna_model->update_password($id, $hashed_password);
    
            // Set pesan sukses
            $this->session->set_flashdata('success', '<div class="alert alert-success">Password pengguna ' . $data['pengguna']->nama . ' berhasil diubah.</div>');
    
            // Redirect ke halaman pengguna
            redirect('');
        }
    
        // Tampilkan halaman edit password
        $this->load->view('pengguna/edit_password', $data);
    }
    
    
    

    public function delete($id){
	    $this->Pengguna_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
	    $this->session->set_flashdata('success', 'Data Pengguna Berhasil Dihapus');
	    redirect('pengguna/index');
	}

}

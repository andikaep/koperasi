<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends MY_Controller {

	public function index()
	{
		$this->load->model('Pegawai_model');
		$this->load->model('Anggota_model');
		$this->load->model('Pinjaman_model');
		$this->load->model('Angsuran_model');
		$this->load->model('SimpananPokok_model');
		$this->load->model('SimpananSukarela_model');
		$this->load->model('SimpananWajib_model');
		$this->load->model('Pengguna_model');
		

        // Panggil metode countAll() dari model Pegawai_model
        $data['jumlah_pegawai'] = $this->Pegawai_model->countAll();

        // Panggil metode countAll() dari model Pegawai_model
        $data['jumlah_anggota'] = $this->Anggota_model->countAll();

		// Panggil metode countAll() dari model Pegawai_model
		$data['jumlah_pinjaman'] = $this->Pinjaman_model->countAll();

		// Panggil metode countAll() dari model Pegawai_model
		$data['jumlah_angsuran'] = $this->Angsuran_model->countAll();

		// Panggil metode countAll() dari model Pegawai_model
		$data['jumlah_simpanan_pokok'] = $this->SimpananPokok_model->countAll();

		// Panggil metode countAll() dari model Pegawai_model
		$data['jumlah_simpanan_sukarela'] = $this->SimpananSukarela_model->countAll();

		// Panggil metode countAll() dari model Pegawai_model
		$data['jumlah_simpanan_wajib'] = $this->SimpananWajib_model->countAll();

		// Panggil metode countAll() dari model Pegawai_model
		$data['jumlah_pengguna'] = $this->Pengguna_model->countAll();



		
		$this->load->view('admin/dashboard', $data);
	}

	public function petunjuk() {
		$this->load->view('admin/petunjuk');
	}

}

/* End of file Controllername.php */

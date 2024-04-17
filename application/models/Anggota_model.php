<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Anggota_model extends CI_Model
{
	
	private $_table= "anggota";

	public $id_anggota;
	public $nia;
	public $nama;
	public $jenis_kelamin;
	public $alamat;

	public function rules()
	{
		return [
			['field' => 'nia',
			'label' => 'nia',
			'rules' => 'required'],

			['field' => 'nama',
			'label' => 'nama',
			'rules' => 'required'],

			['field' => 'jenis_kelamin',
			'label' => 'jenis_kelamin',
			'rules' => 'required'],

			['field' => 'alamat',
			'label' => 'alamat',
			'rules' => 'required']
		];
	}

	public function getALL(){
		return $this->db->get($this->_table)->result();
	}

	public function countAll() {
        // Hitung jumlah pegawai dalam tabel pegawai
        return $this->db->count_all('anggota');
    }

	public function getAnggotaById($id_anggota) {
        $this->db->where('id_anggota', $id_anggota);
        return $this->db->get('anggota')->row();
    }

	public function detail_anak($id){
		$this->db->select('*');
        $this->db->from('anak');
        $this->db->join('anggota', 'anak.id_anggota = anggota.id_anggota');
        $this->db->where('anggota.id_anggota', $id);
        $query = $this->db->get();
        return $query->result();
	}

	public function detail_pasangan($id){
		$this->db->select('*');
        $this->db->from('pasangan');
        $this->db->join('anggota', 'pasangan.id_anggota = anggota.id_anggota');
        $this->db->where('anggota.id_anggota', $id);
        $query = $this->db->get();
        return $query->result();
	}

	public function getById($id){
		return $this->db->get_where($this->_table, ["id_anggota" => $id])->row();
	}

	public function save(){
		$post = $this->input->post();
		$this->id_anggota = uniqid();
		$this->nia = $post["nia"];
		$this->nama = $post["nama"];
		$this->jenis_kelamin = $post["jenis_kelamin"];
		$this->alamat = $post["alamat"];
		$this->db->insert($this->_table, $this);
	}
	
	public function update($id){
		$data = array(
			"nia" => $this->input->post('nia'),
			"nama" => $this->input->post('nama'),
			"jenis_kelamin" => $this->input->post('jenis_kelamin'),
			"alamat" => $this->input->post('alamat')
		);

		$this->db->where('id_anggota', $id);
	    $this->db->update('anggota', $data); // Untuk mengeksekusi perintah update data
	}

	public function hide($id){
		$this->db->where('id_anggota', $id);
		$this->_table->update('set_aktif == False');

	}

	// Fungsi untuk melakukan menghapus data siswa berdasarkan NIS siswa
	public function delete($id){
		$this->db->where('id_anggota', $id);
    $this->db->delete('anggota'); // Untuk mengeksekusi perintah delete data
	}

	public function upload_file($filename){
		$this->load->library('upload'); // Load librari upload

		$config['upload_path'] = './excel/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']  = '2048';
		$config['overwrite'] = true;
		$config['file_name'] = $filename;

		$this->upload->initialize($config); // Load konfigurasi uploadnya
		if($this->upload->do_upload('file')){ // Lakukan upload dan Cek jika proses upload berhasil
			// Jika berhasil :
			$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
			return $return;
		}else{
			// Jika gagal :
			$error = $this->upload->display_errors('<div class="alert alert-danger">', '</div>');
			if (strpos($error, 'You did not select a file to upload.') !== false) {
				$error = '<div class="alert alert-danger">Anda tidak memilih file untuk diunggah.</div>';
			}
			$return = array('result' => 'failed', 'file' => '', 'error' => $error);
			return $return;
		}
	}

	// Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
	public function insert_multiple($data){
		$this->db->insert_batch('anggota', $data);
	}
}


?>
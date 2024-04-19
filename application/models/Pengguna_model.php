<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Pengguna_model extends CI_Model
{
	
	private $_table= "user";

	public $id_user;
	public $username;
	public $password;
	public $nama;
	public $level;

	public function rules()
	{
		return [
			['field' => 'username',
			'label' => 'username',
			'rules' => 'required'],

			['field' => 'password',
			'label' => 'password',
			'rules' => ''],

			['field' => 'nama',
			'label' => 'nama',
			'rules' => 'required'],

			['field' => 'level',
			'label' => 'level',
			'rules' => 'required']
		];
	}

	public function getALL(){
		return $this->db->get($this->_table)->result();
	}

	public function countAll() {
        // Hitung jumlah pengguna dalam tabel pengguna
        return $this->db->count_all('user');
    }
	
	public function getById($id){
		return $this->db->get_where($this->_table, ["id_user" => $id])->row();
	}

	public function save(){
		$post = $this->input->post();
		$this->username = $post["username"];
		$this->password = password_hash($post["password"], PASSWORD_DEFAULT);
		$this->nama = $post["nama"];
		$this->level = $post["level"];
		$this->db->insert($this->_table, $this);
	}
	
	public function update($id){
		$data = array(
			"username" => $this->input->post('username'),
			"nama" => $this->input->post('nama'),
			"level" => $this->input->post('level')
		);

		$this->db->where('id_user', $id);
	    $this->db->update('user', $data); // Untuk mengeksekusi perintah update data
	}

    public function update_password($id){
        $data = array(
            "password" => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
        );
    
        $this->db->where('id_user', $id);
        $this->db->update('user', $data); // Untuk mengeksekusi perintah update data
    }
    

	// Fungsi untuk melakukan menghapus data siswa berdasarkan NIS siswa
	public function delete($id){
		$this->db->where('id_user', $id);
    $this->db->delete('user'); // Untuk mengeksekusi perintah delete data
	}

	// Fungsi untuk melakukan proses upload file
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
			//ini kode benar // $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
			// return $return;
			// Jika gagal :
			$error = $this->upload->display_errors('<p>', '</p>');
			if (strpos($error, 'You did not select a file to upload.') !== false) {
				$error = 'Anda tidak memilih file untuk diunggah.';
			}
			$return = array('result' => 'failed', 'file' => '', 'error' => $error);
			return $return;
		}
	}

	// Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
	public function insert_multiple($data){
		$this->db->insert_batch('user', $data);
	}
}
?>

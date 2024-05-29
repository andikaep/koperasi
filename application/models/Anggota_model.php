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

	public function getAnggotaByFilterPokok($year = null, $month = null, $start_date = null, $end_date = null) {
		$this->db->select('anggota.id_anggota, anggota.*, simpanan_pokok.tanggal_dibayar');
		$this->db->from('anggota');
		$this->db->join('simpanan_pokok', 'anggota.id_anggota = simpanan_pokok.id_anggota', 'left');
	
		if (!empty($year) && !empty($month)) {
			// Filter berdasarkan tahun dan bulan
			$this->db->where('YEAR(simpanan_pokok.tanggal_dibayar)', $year);
			$this->db->where('MONTH(simpanan_pokok.tanggal_dibayar)', $month);
		} elseif (!empty($year) && empty($month)) {
			// Filter berdasarkan tahun saja
			$this->db->where('YEAR(simpanan_pokok.tanggal_dibayar)', $year);
		} elseif (!empty($start_date) && !empty($end_date)) {
			// Filter berdasarkan rentang tanggal
			$this->db->where('simpanan_pokok.tanggal_dibayar >=', $start_date);
			$this->db->where('simpanan_pokok.tanggal_dibayar <=', $end_date);
		}
	
		// Jika tidak ada filter yang diterapkan, ambil semua data anggota
		if (empty($year) && empty($month) && empty($start_date) && empty($end_date)) {
			$this->db->distinct();
			$this->db->group_by('anggota.id_anggota'); // Kelompokkan berdasarkan ID anggota
		}
	
		// Ambil data anggota berdasarkan filter
		return $this->db->get()->result();
	}

	public function getAnggotaByFilterSukarela($year = null, $month = null, $start_date = null, $end_date = null) {
		$this->db->select('anggota.id_anggota, anggota.*, simpanan_sukarela.tanggal_dibayar');
		$this->db->from('anggota');
		$this->db->join('simpanan_sukarela', 'anggota.id_anggota = simpanan_sukarela.id_anggota', 'left');
	
		if (!empty($year) && !empty($month)) {
			// Filter berdasarkan tahun dan bulan
			$this->db->where('YEAR(simpanan_sukarela.tanggal_dibayar)', $year);
			$this->db->where('MONTH(simpanan_sukarela.tanggal_dibayar)', $month);
		} elseif (!empty($year) && empty($month)) {
			// Filter berdasarkan tahun saja
			$this->db->where('YEAR(simpanan_sukarela.tanggal_dibayar)', $year);
		} elseif (!empty($start_date) && !empty($end_date)) {
			// Filter berdasarkan rentang tanggal
			$this->db->where('simpanan_sukarela.tanggal_dibayar >=', $start_date);
			$this->db->where('simpanan_sukarela.tanggal_dibayar <=', $end_date);
		}
	
		// Jika tidak ada filter yang diterapkan, ambil semua data anggota
		if (empty($year) && empty($month) && empty($start_date) && empty($end_date)) {
			$this->db->distinct();
			$this->db->group_by('anggota.id_anggota'); // Kelompokkan berdasarkan ID anggota
		}
	
		// Ambil data anggota berdasarkan filter
		return $this->db->get()->result();
	}

	public function getAnggotaByFilterWajib($year = null, $month = null, $start_date = null, $end_date = null) {
		$this->db->select('anggota.id_anggota, anggota.*, simpanan_wajib.tanggal_dibayar');
		$this->db->from('anggota');
		$this->db->join('simpanan_wajib', 'anggota.id_anggota = simpanan_wajib.id_anggota', 'left');
	
		if (!empty($year) && !empty($month)) {
			// Filter berdasarkan tahun dan bulan
			$this->db->where('YEAR(simpanan_wajib.tanggal_dibayar)', $year);
			$this->db->where('MONTH(simpanan_wajib.tanggal_dibayar)', $month);
		} elseif (!empty($year) && empty($month)) {
			// Filter berdasarkan tahun saja
			$this->db->where('YEAR(simpanan_wajib.tanggal_dibayar)', $year);
		} elseif (!empty($start_date) && !empty($end_date)) {
			// Filter berdasarkan rentang tanggal
			$this->db->where('simpanan_wajib.tanggal_dibayar >=', $start_date);
			$this->db->where('simpanan_wajib.tanggal_dibayar <=', $end_date);
		}
	
		// Jika tidak ada filter yang diterapkan, ambil semua data anggota
		if (empty($year) && empty($month) && empty($start_date) && empty($end_date)) {
			$this->db->distinct();
			$this->db->group_by('anggota.id_anggota'); // Kelompokkan berdasarkan ID anggota
		}
	
		// Ambil data anggota berdasarkan filter
		return $this->db->get()->result();
	}
	
	public function countAll() {
        // Hitung jumlah pegawai dalam tabel pegawai
        return $this->db->count_all('anggota');
    }

	public function getAnggotaById($id_anggota) {
    // Retrieve anggota data from the database based on the provided ID
    $this->db->where('id_anggota', $id_anggota);
    $query = $this->db->get('anggota');
}

public function getAnggotaById_export_detail($id_anggota) {
    // Retrieve anggota data from the database based on the provided ID
    $this->db->where('id_anggota', $id_anggota);
    $query = $this->db->get('anggota');

    // Check if any data is returned
    if ($query->num_rows() > 0) {
        // Return the result as an array of objects
        return $query->result();
    } else {
        // If no data is found, return an empty array
        return array();
    }
}

	// Model Anggota_model
	public function getByIds($filtered_anggota_ids) {
		// Pastikan $filtered_anggota_ids tidak kosong dan merupakan array
		if (!empty($filtered_anggota_ids) && is_array($filtered_anggota_ids)) {
			// Ekstrak ID anggota dari array multidimensi
			$anggota_ids = array();
			foreach ($filtered_anggota_ids as $anggota) {
				if (isset($anggota['id_anggota'])) {
					$anggota_ids[] = $anggota['id_anggota'];
				}
			}
	
			if (!empty($anggota_ids)) {
				// Gunakan ID anggota yang diekstrak dalam klausa where_in()
				$this->db->select('*');
				$this->db->from('anggota');
				$this->db->where_in('id_anggota', $anggota_ids);
				$query = $this->db->get();
				return $query->result();
			}
		}
		// Kembalikan array kosong jika tidak ada ID anggota yang valid
		return array();
	}
	


	public function detail_anak($id){
		$this->db->select('*');
        $this->db->from('anak');
        $this->db->join('anggota', 'anak.id_anggota = anggota.id_anggota');
        $this->db->where('anggota.id_anggota', $id);
        $query = $this->db->get();
        return $query->result();
	}

	public function detail_pinjaman($id){
		$this->db->select('*');
        $this->db->from('pinjaman');
        $this->db->join('anggota', 'pinjaman.id_anggota = anggota.id_anggota');
        $this->db->where('anggota.id_anggota', $id);
        $query = $this->db->get();
        return $query->result();
	}

	public function detail_simpanan_pokok($id){
		$this->db->select('*');
        $this->db->from('simpanan_pokok');
        $this->db->join('anggota', 'simpanan_pokok.id_anggota = anggota.id_anggota');
        $this->db->where('anggota.id_anggota', $id);
        $query = $this->db->get();
        return $query->result();
	}

	public function getAngsuranByIdAnggota($id_anggota){
		$this->db->select('a.*, p.*, ag.no_angsuran, ag.tanggal, ag.jumlah_angsuran');
		$this->db->from('anggota as a');
		$this->db->join('pinjaman as p', 'a.id_anggota = p.id_anggota');
		$this->db->join('angsuran as ag', 'p.id_pinjaman = ag.id_pinjaman');
		$this->db->where('a.id_anggota', $id_anggota);
		return $this->db->get()->result();
	}

	public function detail_angsuran($id){
		$this->db->select('a.*, p.*, ag.no_angsuran, ag.tanggal, ag.jumlah_angsuran, SUM(ag.jumlah_angsuran) as total_angsuran');
		$this->db->from('anggota as a');
		$this->db->join('pinjaman as p', 'a.id_anggota = p.id_anggota');
		$this->db->join('angsuran as ag', 'p.id_pinjaman = ag.id_pinjaman');
		$this->db->where('a.id_anggota', $id);
		$this->db->group_by('p.id_pinjaman'); // Grouping berdasarkan id_pinjaman untuk menghitung total angsuran per pinjaman
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
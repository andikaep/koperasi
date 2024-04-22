<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class SimpananPokok_model extends CI_Model
{
	
	private $_table= "simpanan_pokok";

	public $id_anggota;
	public $jumlah;
	public $tanggal_dibayar;

	public function rules()
	{
		return [
			['field' => 'id_anggota',
			'label' => 'id_anggota',
			'rules' => 'required'],

			['field' => 'jumlah',
			'label' => 'jumlah',
			'rules' => 'required|numeric']
		];
	}

	public function getALL(){
		return $this->db->get($this->_table)->result();
	}

	public function countAll() {
		// Hitung jumlah seluruh pinjaman pada kolom jumlah_pinjaman dalam tabel pinjaman
		$this->db->select_sum('jumlah');
		$query = $this->db->get('simpanan_pokok');
		$result = $query->row_array();
		return $result['jumlah'];
	}

	public function detail_simpanan_pokok($id){
		$this->db->select('*');
        $this->db->from('simpanan_pokok');
        $this->db->join('anggota', 'simpanan_pokok.id_anggota = anggota.id_anggota');
        $this->db->where('anggota.id_anggota', $id);
        $query = $this->db->get();
        return $query->result();
	}

	public function detail_simpanan_pokok_export_detail($id_anggota){
		$this->db->select('*');
		$this->db->from('simpanan_pokok');
		$this->db->join('anggota', 'simpanan_pokok.id_anggota = anggota.id_anggota');
		$this->db->where('anggota.id_anggota', $id_anggota);
		$query = $this->db->get();
		return $query->result();
	}

	public function getAllByAnggotaId($id_anggota) {
        // Lakukan query ke database untuk mendapatkan semua data simpanan pokok berdasarkan ID anggota
        $query = $this->db->get_where('simpanan_pokok', array('id_anggota' => $id_anggota));
        return $query->result(); // Mengembalikan hasil query dalam bentuk array dari objek
    }
	
	public function total_simpanan_pokok($id){
		$this->db->select_sum('s.jumlah');
        $this->db->from('simpanan_pokok as s');
        $this->db->join('anggota as a', 's.id_anggota = a.id_anggota');
        $this->db->where('a.id_anggota', $id);
        $query = $this->db->get();
        return $query->result();
	}

	public function total_simpanan_pokok_all(){
		$this->db->select_sum('s.jumlah');
		$this->db->from('simpanan_pokok as s');
		$query = $this->db->get();
		$result = $query->row_array(); // Mengambil hasil dalam bentuk array
		return $result['jumlah']; // Mengembalikan nilai jumlah
	}
	
	public function total_simpanan_pokok_per_anggota()
	{
    $this->db->select('id_anggota, SUM(jumlah) as total_simpanan_pokok');
    $this->db->from('simpanan_pokok');
    $this->db->group_by('id_anggota');
    $query = $this->db->get();
    return $query->result(); // Mengembalikan hasil dalam bentuk objek hasil query
	}

		// public function detail_simpanan_pokokall(){
		// 	$this->db->select('*');
	 //        $this->db->from('simpanan_pokok');
	 //        $this->db->join('anggota', 'simpanan_pokok.id_anggota = anggota.id_anggota');
	 //        // $this->db->where('anggota.id_anggota', $id);
	 //        $query = $this->db->get();
	 //        return $query->result();
		// }

		// public function detail_simpanan_pokok2($id){
		// 	$this->db->select('*');
	 //        $this->db->from('simpanan_pokok');
	 //        $this->db->join('anggota', 'simpanan_pokok.id_anggota = anggota.id_anggota');
	 //        $this->db->where('simpanan_pokok.id_simpanan_pokok', $id);
	 //        $query = $this->db->get();
	 //        return $query->result();
		// }

	public function detail_pasangan($id){
		$this->db->select('*');
        $this->db->from('pasangan');
        $this->db->join('anggota', 'pasangan.id_anggota = anggota.id_anggota');
        $this->db->where('anggota.id_anggota', $id);
        $query = $this->db->get();
        return $query->result();
	}

	public function getById($id){
		return $this->db->get_where($this->_table, ["id_simpanan_pokok" => $id])->row();
	}

	public function save(){
		$post = $this->input->post();
		$this->id_anggota = $post["id_anggota"];
		$this->jumlah = $post["jumlah"];
		$this->tanggal_dibayar = date('y-m-d');
		$this->db->insert($this->_table, $this);
	}
	
	public function update($id){
		$data = array(
			"id_anggota" => $this->input->post('id_anggota'),
			"jumlah" => $this->input->post('jumlah'),
			"tanggal_dibayar" => $this->tanggal_dibayar = date('y-m-d'),
		);

		$this->db->where('id_simpanan_pokok', $id);
	    $this->db->update('simpanan_pokok', $data); // Untuk mengeksekusi perintah update data
	}

	
	public function filterByDate($id, $year, $month){
		$this->db->select('*');
		$this->db->from('simpanan_pokok');
		$this->db->join('anggota', 'simpanan_pokok.id_anggota = anggota.id_anggota');
		$this->db->where('anggota.id_anggota', $id);
		
		// Filter berdasarkan tahun
		$this->db->where('YEAR(tanggal_dibayar)', $year);
		
		// Filter berdasarkan bulan jika bulan dipilih
		if($month != '') {
			$this->db->where('MONTH(tanggal_dibayar)', $month);
		}
		
		$query = $this->db->get();
		return $query->result();
	}
	
	public function filterByDateRange($id, $start_date, $end_date){
		$this->db->select('*');
		$this->db->from('simpanan_pokok');
		$this->db->join('anggota', 'simpanan_pokok.id_anggota = anggota.id_anggota');
		$this->db->where('anggota.id_anggota', $id);
		
		// Filter berdasarkan rentang tanggal
		$this->db->where('tanggal_dibayar >=', $start_date);
		$this->db->where('tanggal_dibayar <=', $end_date);
		
		$query = $this->db->get();
		return $query->result();
	}

	public function calculateTotalByDateRange($id, $start_date, $end_date) {
        $this->db->select_sum('jumlah');
        $this->db->from('simpanan_pokok');
        $this->db->where('id_anggota', $id);
        $this->db->where('tanggal_dibayar >=', $start_date);
        $this->db->where('tanggal_dibayar <=', $end_date);
        $query = $this->db->get();
        $result = $query->row();
        return $result->jumlah;
    }
    
    // Metode untuk menghitung total simpanan pokok berdasarkan tahun dan bulan
    public function calculateTotalByDate($id, $year, $month) {
        $this->db->select_sum('jumlah');
        $this->db->from('simpanan_pokok');
        $this->db->where('id_anggota', $id);
        $this->db->where('YEAR(tanggal_dibayar)', $year);
        if ($month != '') {
            $this->db->where('MONTH(tanggal_dibayar)', $month);
        }
        $query = $this->db->get();
        $result = $query->row();
        return $result->jumlah;
    }
	
	
	
	public function hide($id){
		$this->db->where('id_anggota', $id);
		$this->_table->update('set_aktif == False');

	}

	// Fungsi untuk melakukan menghapus data siswa berdasarkan NIS siswa
	public function delete($id){
		$this->db->where('id_simpanan_pokok', $id);
    $this->db->delete('simpanan_pokok'); // Untuk mengeksekusi perintah delete data
	}
}


?>
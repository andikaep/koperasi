<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class SimpananSukarela_model extends CI_Model
{
	
	private $_table= "simpanan_sukarela";

	public $id_simpanan_sukarela;
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
		$query = $this->db->get('simpanan_sukarela');
		$result = $query->row_array();
		return $result['jumlah'];
	}

	public function detail_simpanan_sukarela($id){
		$this->db->select('*');
        $this->db->from('simpanan_sukarela');
        $this->db->join('anggota', 'simpanan_sukarela.id_anggota = anggota.id_anggota');
        $this->db->where('anggota.id_anggota', $id);
        $query = $this->db->get();
        return $query->result();
	}

	public function total_simpanan_sukarela($id){
		$this->db->select_sum('s.jumlah');
        $this->db->from('simpanan_sukarela as s');
        $this->db->join('anggota as a', 's.id_anggota = a.id_anggota');
        $this->db->where('a.id_anggota', $id);
        $query = $this->db->get();
        return $query->result();
	}

	// public function detail_simpanan_pokokall(){
	// 	$this->db->select('*');
 //        $this->db->from('simpanan_wajib');
 //        $this->db->join('anggota', 'simpanan_wajib.id_anggota = anggota.id_anggota');
 //        // $this->db->where('anggota.id_anggota', $id);
 //        $query = $this->db->get();
 //        return $query->result();
	// }

	// public function detail_simpanan_pokok2($id){
	// 	$this->db->select('*');
 //        $this->db->from('simpanan_wajib');
 //        $this->db->join('anggota', 'simpanan_wajib.id_anggota = anggota.id_anggota');
 //        $this->db->where('simpanan_wajib.id_simpanan_pokok', $id);
 //        $query = $this->db->get();
 //        return $query->result();
	// }

	// public function detail_pasangan($id){
	// 	$this->db->select('*');
 //        $this->db->from('pasangan');
 //        $this->db->join('anggota', 'pasangan.id_anggota = anggota.id_anggota');
 //        $this->db->where('anggota.id_anggota', $id);
 //        $query = $this->db->get();
 //        return $query->result();
	// }

	public function getById($id){
		return $this->db->get_where($this->_table, ["id_simpanan_sukarela" => $id])->row();
	}

	public function save(){
		$post = $this->input->post();
		$this->id_simpanan_sukarela = uniqid();
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

		$this->db->where('id_simpanan_sukarela', $id);
	    $this->db->update('simpanan_sukarela', $data); // Untuk mengeksekusi perintah update data
	}

	public function total_simpanan_sukarela_all(){
		$this->db->select_sum('s.jumlah');
		$this->db->from('simpanan_sukarela as s');
		$query = $this->db->get();
		$result = $query->row_array(); // Mengambil hasil dalam bentuk array
		return $result['jumlah']; // Mengembalikan nilai jumlah
	}

	public function detail_simpanan_sukarela_export_detail($id_anggota){
		$this->db->select('*');
		$this->db->from('simpanan_sukarela');
		$this->db->join('anggota', 'simpanan_sukarela.id_anggota = anggota.id_anggota');
		$this->db->where('anggota.id_anggota', $id_anggota);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function total_simpanan_sukarela_by_filter($year = null, $month = null, $start_date = null, $end_date = null) {
		$this->db->select_sum('jumlah');
		$this->db->from('simpanan_sukarela as s');
		$this->db->join('anggota as a', 's.id_anggota = a.id_anggota');
		$this->db->where('a.id_anggota');
		
		// Filter berdasarkan tahun
		if ($year) {
			$this->db->where('YEAR(s.tanggal_dibayar)', $year);
		}
		
		// Filter berdasarkan bulan jika bulan dipilih
		if ($month) {
			$this->db->where('MONTH(s.tanggal_dibayar)', $month);
		}
		
		// Filter berdasarkan rentang tanggal
		if ($start_date && $end_date) {
			$this->db->where('s.tanggal_dibayar >=', $start_date);
			$this->db->where('s.tanggal_dibayar <=', $end_date);
		}
	
		$query = $this->db->get();
		$result = $query->row_array(); // Mengambil hasil dalam bentuk array
		return $result['jumlah']; // Mengembalikan nilai jumlah
	}

	public function total_simpanan_sukarela_per_anggota()
	{
    $this->db->select('id_anggota, SUM(jumlah) as total_simpanan_sukarela');
    $this->db->from('simpanan_sukarela');
    $this->db->group_by('id_anggota');
    $query = $this->db->get();
    return $query->result();
	}

	public function filterByDate($id, $year, $month){
		$this->db->select('*');
		$this->db->from('simpanan_sukarela');
		$this->db->join('anggota', 'simpanan_sukarela.id_anggota = anggota.id_anggota');
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
		$this->db->from('simpanan_sukarela');
		$this->db->join('anggota', 'simpanan_sukarela.id_anggota = anggota.id_anggota');
		$this->db->where('anggota.id_anggota', $id);
		
		// Filter berdasarkan rentang tanggal
		$this->db->where('tanggal_dibayar >=', $start_date);
		$this->db->where('tanggal_dibayar <=', $end_date);
		
		$query = $this->db->get();
		return $query->result();
	}

	public function calculateTotalByDateRange($start_date, $end_date) {
		$this->db->select_sum('jumlah');
		$this->db->from('simpanan_sukarela');
		$this->db->where('tanggal_dibayar >=', $start_date);
		$this->db->where('tanggal_dibayar <=', $end_date);
		$query = $this->db->get();
		$result = $query->row();
		return $result->jumlah;
    }
    
    // Metode untuk menghitung total simpanan sukarela berdasarkan tahun dan bulan
    public function calculateTotalByDate($id, $year, $month) {
        $this->db->select_sum('jumlah');
        $this->db->from('simpanan_sukarela');
        $this->db->where('id_anggota', $id);
        $this->db->where('YEAR(tanggal_dibayar)', $year);
        if ($month != '') {
            $this->db->where('MONTH(tanggal_dibayar)', $month);
        }
        $query = $this->db->get();
        $result = $query->row();
        return $result->jumlah;
    }
	// public function hide($id){
	// 	$this->db->where('id_anggota', $id);
	// 	$this->_table->update('set_aktif == False');

	// }

	public function total_simpanan_sukarela_all_export($year = null, $month = null, $start_date = null, $end_date = null) {
		if (!empty($year) && !empty($month)) {
			$this->db->where('YEAR(tanggal_dibayar)', $year);
			$this->db->where('MONTH(tanggal_dibayar)', $month);
		} elseif (!empty($year) && empty($month)) {
			$this->db->where('YEAR(tanggal_dibayar)', $year);
		} elseif (!empty($start_date) && !empty($end_date)) {
			$this->db->where('tanggal_dibayar >=', $start_date);
			$this->db->where('tanggal_dibayar <=', $end_date);
		}
	
		$this->db->select_sum('jumlah');
		$query = $this->db->get('simpanan_sukarela');
		$result = $query->row();
		
		return $result->jumlah;
	}

	public function total_simpanan_sukarela_all_detail($year = null, $month = null, $start_date = null, $end_date = null) {
		$this->db->select('anggota.id_anggota, SUM(simpanan_sukarela.jumlah) AS total_simpanan_sukarela');
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
	
		$this->db->group_by('anggota.id_anggota'); // Kelompokkan berdasarkan ID anggota
	
		// Ambil data total simpanan pokok masing-masing anggota
		$query = $this->db->get();
		$result = $query->result();
	
		// Ubah hasil menjadi array yang dapat diakses dengan ID anggota sebagai kunci
		$totals = array();
		foreach ($result as $row) {
			$totals[$row->id_anggota] = $row->total_simpanan_sukarela;
		}
	
		return $totals;
	}

	public function filterByYearMonthDetail($id, $year, $month){
		$this->db->select('*');
		$this->db->from('simpanan_sukarela');
		$this->db->join('anggota', 'simpanan_sukarela.id_anggota = anggota.id_anggota');
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

	public function filterByDateRangeDetail($id, $start_date, $end_date){
		$this->db->select('*');
		$this->db->from('simpanan_sukarela');
		$this->db->join('anggota', 'simpanan_sukarela.id_anggota = anggota.id_anggota');
		$this->db->where('anggota.id_anggota', $id);
		
		// Filter berdasarkan rentang tanggal
		$this->db->where('tanggal_dibayar >=', $start_date);
		$this->db->where('tanggal_dibayar <=', $end_date);
		
		$query = $this->db->get();
		return $query->result();
	}

	public function calculateTotalByDateRangeDetail($id, $start_date, $end_date) {
        $this->db->select_sum('jumlah');
        $this->db->from('simpanan_sukarela');
        $this->db->where('id_anggota', $id);
        $this->db->where('tanggal_dibayar >=', $start_date);
        $this->db->where('tanggal_dibayar <=', $end_date);
        $query = $this->db->get();
        $result = $query->row();
        return $result->jumlah;
    }

	// Metode untuk menghitung total simpanan pokok berdasarkan tahun dan bulan
    public function calculateTotalByYearMonthDetail($id, $year, $month) {
        $this->db->select_sum('jumlah');
        $this->db->from('simpanan_sukarela');
        $this->db->where('id_anggota', $id);
        $this->db->where('YEAR(tanggal_dibayar)', $year);
        if ($month != '') {
            $this->db->where('MONTH(tanggal_dibayar)', $month);
        }
        $query = $this->db->get();
        $result = $query->row();
        return $result->jumlah;
    }

	public function calculateTotalByYearMonth($year, $month) {
		$this->db->select_sum('jumlah');
		$this->db->from('simpanan_sukarela');
		$this->db->where('YEAR(tanggal_dibayar)', $year);
		if ($month != '') {
			$this->db->where('MONTH(tanggal_dibayar)', $month);
		}
		$query = $this->db->get();
		$result = $query->row();
		return $result->jumlah;
	}

	public function calculateTotalByYear($year) {
		$this->db->select_sum('jumlah');
		$this->db->from('simpanan_sukarela');
		$this->db->where('YEAR(tanggal_dibayar)', $year);
		$query = $this->db->get();
		$result = $query->row();
		return $result->jumlah;
	}

	// Model SimpananPokok_model
	public function getAnggotaIdsByDateRange($start_date, $end_date) {
		$this->db->select('id_anggota');
		$this->db->from('simpanan_sukarela');
		$this->db->where('tanggal_dibayar >=', $start_date);
		$this->db->where('tanggal_dibayar <=', $end_date);
		$this->db->group_by('id_anggota');
		$query = $this->db->get();
		return $query->result_array();
	}
	

	public function getAnggotaIdsByYearMonth($year, $month) {
		$this->db->select('id_anggota');
		$this->db->from('simpanan_sukarela');
		$this->db->where('YEAR(tanggal_dibayar)', $year);
		$this->db->where('MONTH(tanggal_dibayar)', $month);
		$this->db->group_by('id_anggota');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getAnggotaIdsByYear($year) {
		$this->db->select('id_anggota');
		$this->db->from('simpanan_sukarela');
		$this->db->where('YEAR(tanggal_dibayar)', $year);
		$this->db->group_by('id_anggota');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function total_simpanan_sukarela_per_anggota_by_date_range($start_date, $end_date) {
		$this->db->select('id_anggota, SUM(jumlah) AS total_simpanan_sukarela');
		$this->db->from('simpanan_sukarela');
		$this->db->where('tanggal_dibayar >=', $start_date);
		$this->db->where('tanggal_dibayar <=', $end_date);
		$this->db->group_by('id_anggota');
		$query = $this->db->get();
		return $query->result();
	}

	public function total_simpanan_sukarela_per_anggota_by_year_month($year, $month) {
		$this->db->select('id_anggota, SUM(jumlah) AS total_simpanan_sukarela');
		$this->db->from('simpanan_sukarela');
		$this->db->where('YEAR(simpanan_sukarela.tanggal_dibayar)', $year);
		$this->db->where('MONTH(simpanan_sukarela.tanggal_dibayar)', $month);
		$this->db->group_by('id_anggota');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function total_simpanan_sukarela_per_anggota_by_year($year) {
		$this->db->select('id_anggota, SUM(jumlah) AS total_simpanan_sukarela');
		$this->db->from('simpanan_sukarela');
		$this->db->where('YEAR(simpanan_sukarela.tanggal_dibayar)', $year);
		$this->db->group_by('id_anggota');
		$query = $this->db->get();
		return $query->result();
	}

	// Fungsi untuk melakukan menghapus data siswa berdasarkan NIS siswa
	public function delete($id){
		$this->db->where('id_simpanan_sukarela', $id);
    $this->db->delete('simpanan_sukarela'); // Untuk mengeksekusi perintah delete data
	}
}


?>
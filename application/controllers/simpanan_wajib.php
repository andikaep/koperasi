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
    $data['total'] = $this->SimpananWajib_model->total_simpanan_wajib_all();
    $data["anggota"] = $this->Anggota_model->getAll();
    
    // Ambil total simpanan wajib untuk setiap anggota
    $data['total_anggota'] = $this->SimpananWajib_model->total_simpanan_wajib_per_anggota();

    $this->load->view("simpanan_wajib/lihat_simpanan_wajib", $data);
    }

    public function detail($id){
        // $data['anggota'] = $this->SimpananWajib_model->detail_simpanan_wajiball();
        $data['id_anggota'] = $id;
        $data['simpanan_wajib'] = $this->SimpananWajib_model->detail_simpanan_wajib($id);
        $data['tot'] = $this->SimpananWajib_model->total_simpanan_wajib($id);
        $this->load->view("simpanan_wajib/detail_simpanan_wajib", $data);
    }

    public function filter_detail($id){
        // Tangkap nilai yang dikirimkan dari form
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        
        // Simpan nilai-nilai tersebut dalam session
        $this->session->set_userdata('filter_year', $year);
        $this->session->set_userdata('filter_month', $month);
        $this->session->set_userdata('filter_start_date', $start_date);
        $this->session->set_userdata('filter_end_date', $end_date);
        
        // Tangkap nilai id_anggota
        $data['id_anggota'] = $id;
        
        // Ambil total simpanan wajib
        $data['tot'] = $this->SimpananWajib_model->total_simpanan_wajib($id);
        
        // Periksa apakah rentang tanggal dipilih atau tidak
        if (!empty($start_date) && !empty($end_date)) {
            // Jika rentang tanggal dipilih, gunakan rentang tanggal
            $data['simpanan_wajib'] = $this->SimpananWajib_model->filterByDateRangeDetail($id, $start_date, $end_date);
            $data['total_simpanan_wajib'] = $this->SimpananWajib_model->calculateTotalByDateRangeDetail($id, $start_date, $end_date);
        } else {
            // Jika tidak, gunakan tahun dan bulan
            $data['simpanan_wajib'] = $this->SimpananWajib_model->filterByYearMonthDetail($id, $year, $month);
            $data['total_simpanan_wajib'] = $this->SimpananWajib_model->calculateTotalByYearMonthDetail($id, $year, $month);
        }
        
        // Load view dengan data yang diperlukan
        $this->load->view("simpanan_wajib/detail_simpanan_wajib", $data);
        
        // Bersihkan session setelah halaman dimuat kembali atau berpindah halaman
        $this->session->unset_userdata('filter_year');
        $this->session->unset_userdata('filter_month');
        $this->session->unset_userdata('filter_start_date');
        $this->session->unset_userdata('filter_end_date');
    }
    
    public function filter(){
        // Tangkap nilai yang dikirimkan dari form
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        
        // Simpan nilai-nilai tersebut dalam session
        $this->session->set_userdata('filter_year', $year);
        $this->session->set_userdata('filter_month', $month);
        $this->session->set_userdata('filter_start_date', $start_date);
        $this->session->set_userdata('filter_end_date', $end_date);
        
        $data['total'] = $this->SimpananWajib_model->total_simpanan_wajib_all();
    
        // Periksa apakah rentang tanggal dipilih atau tidak
        if (!empty($start_date) && !empty($end_date)) {
            // Jika rentang tanggal dipilih, gunakan rentang tanggal
            $filtered_anggota_ids = $this->SimpananWajib_model->getAnggotaIdsByDateRange($start_date, $end_date);
            $data['anggota'] = $this->Anggota_model->getByIds($filtered_anggota_ids);
            $data['total_anggota'] = $this->SimpananWajib_model->total_simpanan_wajib_per_anggota_by_date_range($start_date, $end_date);
            $data['total_anggota_'] = $this->SimpananWajib_model->calculateTotalByDateRange($start_date, $end_date);
        } elseif (!empty($year) && !empty($month)) {
            // Jika tahun dan bulan dipilih, gunakan fungsi getAnggotaIdsByYearMonth
            $filtered_anggota_ids = $this->SimpananWajib_model->getAnggotaIdsByYearMonth($year, $month);
            $data['anggota'] = $this->Anggota_model->getByIds($filtered_anggota_ids);
            $data['total_anggota'] = $this->SimpananWajib_model->total_simpanan_wajib_per_anggota_by_year_month($year, $month);
            $data['total_anggota_'] = $this->SimpananWajib_model->calculateTotalByYearMonth($year, $month);
        } elseif (!empty($year)) {
            // Jika hanya tahun yang dipilih, gunakan fungsi getAnggotaIdsByYear
            $filtered_anggota_ids = $this->SimpananWajib_model->getAnggotaIdsByYear($year);
            $data['anggota'] = $this->Anggota_model->getByIds($filtered_anggota_ids);
            $data['total_anggota'] = $this->SimpananWajib_model->total_simpanan_wajib_per_anggota_by_year($year);
            $data['total_anggota_'] = $this->SimpananWajib_model->calculateTotalByYear($year);
        } else {
            // Jika tidak ada yang dipilih, tampilkan semua anggota
            $data["anggota"] = $this->Anggota_model->getAll();
            // Ambil total simpanan pokok untuk setiap anggota
            $data['total_anggota'] = $this->SimpananWajib_model->total_simpanan_wajib_per_anggota();
        }
        
        // Load view dengan data yang diperlukan
        $this->load->view("simpanan_wajib/lihat_simpanan_wajib", $data);
        
        // Bersihkan session setelah halaman dimuat kembali atau berpindah halaman
        $this->session->unset_userdata('filter_year');
        $this->session->unset_userdata('filter_month');
        $this->session->unset_userdata('filter_start_date');
        $this->session->unset_userdata('filter_end_date');
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
            
           // Ambil nilai simpanan wajib baru setelah perubahan
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

    public function export(){
		// Load plugin PHPExcel nya
        $year = $this->input->get('year');
    $month = $this->input->get('month');
    $start_date = $this->input->get('start_date');
    $end_date = $this->input->get('end_date');
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		// Settingan awal fil excel
		$excel->getProperties()->setCreator('Andika')
			->setLastModifiedBy('Andika')
			->setTitle("Data Simpanan Wajib")
			->setSubject("Simpanan Wajib")
			->setDescription("Laporan Simpanan Wajib")
			->setKeywords("Data Simpanan Wajib");
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA SIMPANAN WAJIB KOPERASI DESA BEJI"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		// Buat header tabel nya pada baris ke 3

        $filter_text = '';
if (!empty($year) && !empty($month)) {
    // Ubah format angka bulan menjadi nama bulan dalam bahasa Indonesia
    $nama_bulan_en = DateTime::createFromFormat('!m', $month)->format('F');
    $nama_bulan_id = '';
    switch ($nama_bulan_en) {
        case 'January': $nama_bulan_id = 'Januari'; break;
        case 'February': $nama_bulan_id = 'Februari'; break;
        case 'March': $nama_bulan_id = 'Maret'; break;
        case 'April': $nama_bulan_id = 'April'; break;
        case 'May': $nama_bulan_id = 'Mei'; break;
        case 'June': $nama_bulan_id = 'Juni'; break;
        case 'July': $nama_bulan_id = 'Juli'; break;
        case 'August': $nama_bulan_id = 'Agustus'; break;
        case 'September': $nama_bulan_id = 'September'; break;
        case 'October': $nama_bulan_id = 'Oktober'; break;
        case 'November': $nama_bulan_id = 'November'; break;
        case 'December': $nama_bulan_id = 'Desember'; break;
    }
    $filter_text = 'Bulan ' . $nama_bulan_id . ', Tahun ' . $year;
} elseif (!empty($year) && empty($month)) {
    $filter_text = 'Tahun ' . $year;
} elseif (!empty($start_date) && !empty($end_date)) {
    // Ubah format tanggal menjadi dd-mm-yyyy
    $filter_text = 'Tanggal ' . date('d-m-Y', strtotime($start_date)) . ' sampai ' . date('d-m-Y', strtotime($end_date));
} else {
    $filter_text = 'Data tanpa filter';
}
$excel->getActiveSheet()->setCellValue('A2', $filter_text);
$excel->getActiveSheet()->mergeCells('A2:F2'); // Gabungkan sel untuk keterangan filter
$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Pusatkan teks secara horizontal


		$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "NIA"); // Set kolom B3 dengan tulisan "NIS"
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS KELAMIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "ALAMAT");
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "SIMPANAN WAJIB");
	
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

		// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
		// Panggil function view yang ada di Anggota_model untuk menampilkan semua data anggotanya
        $anggota = $this->Anggota_model->getAnggotaByFilterWajib($year, $month, $start_date, $end_date);
        $total_simpanan_wajib_per_anggota = $this->SimpananWajib_model->total_simpanan_wajib_all_detail($year, $month, $start_date, $end_date);

// Inisialisasi array untuk menyimpan ID anggota yang sudah ditampilkan
$anggota_ids = array();
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
    foreach($anggota as $data){
    // Cek apakah ID anggota sudah ditampilkan sebelumnya
        if (!in_array($data->id_anggota, $anggota_ids)) {
            // Tambahkan ID anggota ke array
            $anggota_ids[] = $data->id_anggota; // Lakukan looping pada variabel anggota
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
    $excel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$numrow, $data->nia, PHPExcel_Cell_DataType::TYPE_STRING); // Set kolom B sebagai teks eksplisit
    $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->nama);
    $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->jenis_kelamin);
    $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->alamat);

     // Menghitung jumlah simpanan pokok per anggota
     // Mengambil total simpanan pokok per anggota dari model
 // Menghitung jumlah simpanan pokok per anggota
 $total_simpanan_wajib_anggota = isset($total_simpanan_wajib_per_anggota[$data->id_anggota]) ? $total_simpanan_wajib_per_anggota[$data->id_anggota] : '';


 // Format jumlah simpanan pokok menjadi format Rupiah
;

     // Format jumlah simpanan pokok per anggota menjadi format Rupiah
     $total_simpanan_wajib_anggota_rp = '';
if (is_numeric($total_simpanan_wajib_anggota)) {
    // Format jumlah simpanan pokok per anggota menjadi format Rupiah
    $total_simpanan_wajib_anggota_rp = 'Rp ' . number_format(floatval($total_simpanan_wajib_anggota), 0, ',', '.');
}

     if (!empty($start_date) && !empty($end_date)) {
        $filtered_data = $this->SimpananWajib_model->getAnggotaIdsByDateRange($start_date, $end_date);
    } elseif (!empty($year) && !empty($month)) {
        $filtered_data = $this->SimpananWajib_model->getAnggotaIdsByYearMonth($year, $month);
    } elseif (!empty($year) && empty($month)) {
        // Menangani kasus saat hanya tahun yang dipilih tanpa bulan
        $filtered_data = $this->SimpananWajib_model->getAnggotaIdsByYear($year); // Menambahkan parameter $month dengan nilai null
    } else {
        $filtered_data = $this->SimpananWajib_model->getALL();
    }
     // Menambahkan jumlah simpanan pokok per anggota ke dalam kolom F
     $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $total_simpanan_wajib_anggota_rp);

    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
    $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);

    $no++; // Tambah 1 setiap kali looping
    $numrow++; // Tambah 1 setiap kali looping
}
    }

/// Hitung jumlah simpanan pokok
$total_simpanan_wajib = $this->SimpananWajib_model->total_simpanan_wajib_all_export($year, $month, $start_date, $end_date); // Sesuaikan dengan metode Anda untuk menghitung total simpanan pokok berdasarkan filter

// Format jumlah simpanan pokok menjadi format Rupiah
$total_simpanan_wajib_rp = 'Rp ' . number_format($total_simpanan_wajib, 0, ',', '.');

// Menambahkan jumlah simpanan pokok di bawah data anggota terakhir
$excel->getActiveSheet()->mergeCells('A'.$numrow.':D'.$numrow); // Merge cells untuk kolom A hingga D pada baris ke-$numrow
$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, 'Jumlah Simpanan Seluruh Anggota'); // Set nilai pada kolom A baris ke-$numrow

// Set nilai pada kolom E baris ke-$numrow dengan format Rupiah dan alignment horizontal ke kanan
$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $total_simpanan_wajib_rp); // Set nilai pada kolom E baris ke-$numrow dengan format Rupiah
$excel->getActiveSheet()->getStyle('F'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); // Set alignment horizontal ke kanan

// Apply style yang telah kita buat ke baris jumlah simpanan pokok
$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);

// Set width kolom
$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
$excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
$excel->getActiveSheet()->getColumnDimension('F')->setWidth(20); 

// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
// Set orientasi kertas jadi LANDSCAPE
$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
// Set judul file excel nya
$excel->getActiveSheet(0)->setTitle("Laporan Data Simpanan Wajib");
$excel->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Data Simpanan Wajib.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');
$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$write->save('php://output');

	}

    public function export_detail($id_anggota){
        // Load plugin PHPExcel nya

        $year = $this->input->get('year');
    $month = $this->input->get('month');
    $start_date = $this->input->get('start_date');
    $end_date = $this->input->get('end_date');
    
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        
        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Andika Eka')
            ->setLastModifiedBy('Andika Eka')
            ->setTitle("Data Simpanan Wajib")
            ->setSubject("Simpanan Wajib")
            ->setDescription("Laporan Simpanan Wajib")
            ->setKeywords("Data Simpanan Wajib");
    
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
    
        // Set active sheet
        $excel->setActiveSheetIndex(0);
    
        // Panggil function view yang ada di Anggota_model untuk menampilkan data anggota
        $anggota = $this->Anggota_model->getAnggotaById_export_detail($id_anggota);
    
        // Ambil nama anggota
        $nama_anggota = '';
        $nia_anggota = '';
        foreach ($anggota as $anggota_data) {
            $nama_anggota = $anggota_data->nama;
            $nia_anggota = $anggota_data->nia;
            break; // Ambil hanya satu data
        }
    
        // Tambahkan nama anggota di atas tabel
// Tambahkan nama anggota di atas tabel
$excel->getActiveSheet()->setCellValue('A1', 'Data Simpanan Wajib');
$excel->getActiveSheet()->mergeCells('A1:C1'); // Gabungkan sel untuk "Data Simpanan Pokok"
$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Pusatkan teks secara horizontal
$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true); // Beri gaya tebal untuk teks "Data Simpanan Pokok"

// Tambahkan keterangan hasil filter di bawah teks "Data Simpanan Pokok"
$filter_text = '';
if (!empty($year) && !empty($month)) {
    // Ubah format angka bulan menjadi nama bulan dalam bahasa Indonesia
    $nama_bulan_en = DateTime::createFromFormat('!m', $month)->format('F');
    $nama_bulan_id = '';
    switch ($nama_bulan_en) {
        case 'January': $nama_bulan_id = 'Januari'; break;
        case 'February': $nama_bulan_id = 'Februari'; break;
        case 'March': $nama_bulan_id = 'Maret'; break;
        case 'April': $nama_bulan_id = 'April'; break;
        case 'May': $nama_bulan_id = 'Mei'; break;
        case 'June': $nama_bulan_id = 'Juni'; break;
        case 'July': $nama_bulan_id = 'Juli'; break;
        case 'August': $nama_bulan_id = 'Agustus'; break;
        case 'September': $nama_bulan_id = 'September'; break;
        case 'October': $nama_bulan_id = 'Oktober'; break;
        case 'November': $nama_bulan_id = 'November'; break;
        case 'December': $nama_bulan_id = 'Desember'; break;
    }
    $filter_text = 'Bulan ' . $nama_bulan_id . ', Tahun ' . $year;
} elseif (!empty($year) && empty($month)) {
    $filter_text = 'Tahun ' . $year;
} elseif (!empty($start_date) && !empty($end_date)) {
    // Ubah format tanggal menjadi dd-mm-yyyy
    $filter_text = 'Tanggal ' . date('d-m-Y', strtotime($start_date)) . ' sampai ' . date('d-m-Y', strtotime($end_date));
} else {
    $filter_text = 'Data tanpa filter';
}
$excel->getActiveSheet()->setCellValue('A2', $filter_text);
$excel->getActiveSheet()->mergeCells('A2:C2'); // Gabungkan sel untuk keterangan filter
$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Pusatkan teks secara horizontal

// Tambahkan keterangan nama anggota dan NIA
$excel->getActiveSheet()->setCellValue('A3', 'Nama: ' . $nama_anggota);
$excel->getActiveSheet()->mergeCells('A3:C3'); // Gabungkan sel untuk keterangan filter
$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Pusatkan teks secara horizontal
$excel->getActiveSheet()->setCellValue('A4', 'NIA: ' . $nia_anggota);
$excel->getActiveSheet()->mergeCells('A4:C4'); // Gabungkan sel untuk keterangan filter
$excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Pusatkan teks secara horizontal

// Tambahkan spasi di bawah keterangan hasil filter
$excel->getActiveSheet()->mergeCells('A5:C5'); // Gabungkan sel untuk spasi
$excel->getActiveSheet()->getRowDimension(5)->setRowHeight(20); // Set tinggi baris untuk memberikan spasi

// Tambahkan kolom kosong di antara "NIA" dan "No"
// Insert satu kolom kosong sebelum kolom A

// Buat header tabel pada baris ke 6
$excel->getActiveSheet()->setCellValue('A6', 'No');
$excel->getActiveSheet()->setCellValue('B6', 'Tanggal Dibayarkan');
$excel->getActiveSheet()->setCellValue('C6', 'Jumlah');

// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$excel->getActiveSheet()->getStyle('A6')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('B6')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('C6')->applyFromArray($style_col);

$numrow = 7; // Set baris pertama untuk isi tabel adalah baris ke 7, setelah keterangan nama dan NIA serta spasi

// Ambil data simpanan pokok berdasarkan ID anggota
 // Fetch simpanan pokok data based on parameters
 if (!empty($start_date) && !empty($end_date)) {
    $filtered_data = $this->SimpananWajib_model->filterByDateRangeDetail($id_anggota, $start_date, $end_date);
} elseif (!empty($year) && !empty($month)) {
    $filtered_data = $this->SimpananWajib_model->filterByYearMonthDetail($id_anggota, $year, $month);
} elseif (!empty($year) && empty($month)) {
    // Menangani kasus saat hanya tahun yang dipilih tanpa bulan
    $filtered_data = $this->SimpananWajib_model->filterByYearMonthDetail($id_anggota, $year, null); // Menambahkan parameter $month dengan nilai null
} else {
    $filtered_data = $this->SimpananWajib_model->detail_simpanan_wajib_export_detail($id_anggota);
}

// Looping data simpanan pokok
foreach ($filtered_data as $simpanan_data) {
    // Set data dalam kolom
    $excel->getActiveSheet()->setCellValue('A' . $numrow, $numrow - 6); // Nomor urut
    $excel->getActiveSheet()->setCellValue('B' . $numrow, $simpanan_data->tanggal_dibayar); // Tanggal dibayarkan
    $excel->getActiveSheet()->setCellValue('C' . $numrow, 'Rp ' . number_format($simpanan_data->jumlah, 0, ',', '.')); // Jumlah dengan format rupiah

    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
    $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_col);

    $numrow++; // Tambah 1 setiap kali looping
}

    
        // Hitung total jumlah simpanan pokok
        $total_jumlah = array_sum(array_column($filtered_data, 'jumlah'));
    
        // Tambahkan total simpanan pokok di bawah tabel
        $numrow += 1;
        $excel->getActiveSheet()->setCellValue('A' . $numrow, 'Total Simpanan Sukarela');
        $excel->getActiveSheet()->mergeCells('A' . $numrow . ':B' . $numrow); // Gabungkan sel untuk total
        $excel->getActiveSheet()->setCellValue('C' . $numrow, 'Rp ' . number_format($total_jumlah, 0, ',', '.')); // Total dengan format rupiah
    
        // Apply style row yang telah kita buat tadi ke masing-masing baris (total)
        $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_col);
    
        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(20); // Set width kolom C
    
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
    
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Data Simpanan Wajib");
        $excel->setActiveSheetIndex(0);
    
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Detail Simpanan Wajib.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }
    
    
    

    public function export_pdf() {
    // Ambil parameter filter dari URL
    $year = $this->input->get('year');
    $month = $this->input->get('month');
    $start_date = $this->input->get('start_date');
    $end_date = $this->input->get('end_date');

    // Load library TCPDF
    $this->load->library('tcpdf/tcpdf');

    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Data Simpanan Wajib');
    $pdf->SetHeaderData('', '', 'Koperasi Desa Beji', '');

    // Add a page
    $pdf->AddPage();

    
    // Set some content to display including filter information
    $filter_text = '';
    if (!empty($year) && !empty($month)) {
        $nama_bulan_indonesia = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );
        $nama_bulan = $nama_bulan_indonesia[$month];
        $filter_text = 'Bulan ' . $nama_bulan . ', Tahun ' . $year;
    } elseif (!empty($year) && empty($month)) {
        $filter_text = 'Data yang difilter: Tahun '  . $year;
    } elseif (!empty($start_date) && !empty($end_date)) {
        $formatted_start_date = date('d-m-Y', strtotime($start_date));
        $formatted_end_date = date('d-m-Y', strtotime($end_date));
        $filter_text = 'Tanggal ' . $formatted_start_date . ' sampai ' . $formatted_end_date;
    } else {
        $filter_text = 'Data tanpa filter';
    }

    $html = '<h1 style="text-align:center">Data Simpanan Wajib</h1>';
    $html .= '<p>' . $filter_text . '</p>';
    $html .= '<table border="1">';
    $html .= '<tr>';
    $html .= '<th style="text-align:center; background-color: #d3d3d3; font-size: 12px; width: 30px;">No</th>';
    $html .= '<th style="text-align:center; background-color: #e0e0e0;">NIA</th>';
    $html .= '<th style="text-align:center; background-color: #e0e0e0;">Nama</th>';
    $html .= '<th style="text-align:center; background-color: #e0e0e0;">Jenis Kelamin</th>';
    $html .= '<th style="text-align:center; background-color: #e0e0e0;">Alamat</th>';
    $html .= '<th style="text-align:center; background-color: #e0e0e0; width: 150px;">Simpanan Sukarela</th>'; // Tambahkan kolom untuk simpanan pokok
    $html .= '</tr>';
    $no = 1;

    // Fetch anggota data based on parameters
    if (!empty($year) && !empty($month)) {
        $anggota = $this->SimpananWajib_model->getAnggotaIdsByYearMonth($year, $month);
    } elseif (!empty($year) && empty($month)) {
        $anggota = $this->SimpananWajib_model->getAnggotaIdsByYear($year);
    } elseif (!empty($start_date) && !empty($end_date)) {
        $anggota = $this->SimpananWajib_model->getAnggotaIdsByDateRange($start_date, $end_date);
    } else {
        $anggota = $this->SimpananWajib_model->getAll();
    }

   
    $anggota = $this->Anggota_model->getAnggotaByFilterWajib($year, $month, $start_date, $end_date);

    // Get total simpanan pokok per anggota
    // Ambil total simpanan pokok per anggota berdasarkan filter yang dipilih
$total_simpanan_wajib_per_anggota = $this->SimpananWajib_model->total_simpanan_wajib_all_detail($year, $month, $start_date, $end_date);

// Inisialisasi array untuk menyimpan ID anggota yang sudah ditampilkan
$displayed_ids = array();

// Iterate through each anggota and display their information
foreach ($anggota as $value) {
    // Periksa apakah ID anggota sudah ditampilkan sebelumnya
    if (!in_array($value->id_anggota, $displayed_ids)) {
        $html .= '<tr>';
        $html .= '<td style="text-align:center">' . $no++ . '</td>';
        $html .= '<td style="text-align:center">' . $value->nia . '</td>';
        $html .= '<td style="text-align:center">' . $value->nama . '</td>';
        $html .= '<td style="text-align:center">' . $value->jenis_kelamin . '</td>';
        $html .= '<td style="text-align:center">' . $value->alamat . '</td>';

        // Tandai ID anggota sebagai sudah ditampilkan
        $displayed_ids[] = $value->id_anggota;

        // Tampilkan jumlah simpanan pokoknya
        if (isset($total_simpanan_wajib_per_anggota[$value->id_anggota])) {
            $html .= '<td> ' .  'Rp ' . number_format($total_simpanan_wajib_per_anggota[$value->id_anggota], 0, ',', '.') . '</td>';
        } else {
            // Jika tidak ada jumlah simpanan pokok, tampilkan teks kosong
            $html .= '<td></td>';
        }
        
        $html .= '</tr>';
    }
}


    // Menambahkan jumlah simpanan pokok seluruh anggota
    $total_simpanan_wajib_all = $this->SimpananWajib_model->total_simpanan_wajib_all_export($year, $month, $start_date, $end_date); // Sesuaikan dengan metode Anda untuk menghitung total simpanan pokok berdasarkan filter
    $total_simpanan_wajib_all_rp = 'Rp ' . number_format($total_simpanan_wajib_all, 0, ',', '.');
    $html .= '<tr>';
    $html .= '<td colspan="5" style="text-align:center; background-color: #d3d3d3; font-weight:bold">Total Simpanan Wajib</td>'; // Gabung kolom 0-4
    $html .= '<td colspan   ="5" style="text-align:center">' . $total_simpanan_wajib_all_rp . '</td>'; // Tetap di posisinya sekarang, di bawah kolom "Simpanan Pokok"
    $html .= '</tr>';

    $html .= '</table>';

    $pdf->SetY(25);

    // Write HTML content to PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Close and output PDF document
    $pdf->Output('data_simpanan_wajib.pdf', 'I');
}


public function export_detail_pdf($id_anggota) {
    // Ambil parameter filter dari URL
    $year = $this->input->get('year');
    $month = $this->input->get('month');
    $start_date = $this->input->get('start_date');
    $end_date = $this->input->get('end_date');

    // Load library TCPDF
    $this->load->library('tcpdf/tcpdf');

    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Data Simpanan Wajib');
    $pdf->SetHeaderData('', '', 'Koperasi Desa Beji', '');

    // Add a page
    $pdf->AddPage();

    // Get data anggota
    $anggota = $this->Anggota_model->getAnggotaById_export_detail($id_anggota);

    if ($anggota) {
        foreach ($anggota as $anggota_item) {
            // Set some content to display including filter information
            $filter_text = '';
            if (!empty($year) && !empty($month)) {
                // Array untuk mencocokkan nomor bulan dengan nama bulan dalam bahasa Indonesia
                $nama_bulan_indonesia = array(
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember'
                );
                // Ambil nama bulan dalam bahasa Indonesia berdasarkan nomor bulan
                $nama_bulan = $nama_bulan_indonesia[$month];
                // Format teks untuk filter tahun dan bulan
                $filter_text = 'Bulan ' . $nama_bulan . ', Tahun ' . $year;
            } elseif (!empty($year) && empty($month)) {
                // Format teks untuk filter hanya tahun
                $filter_text = 'Data yang difilter: Tahun '  . $year;
            } elseif (!empty($start_date) && !empty($end_date)) {
                // Ubah format tanggal ke format yang diinginkan (dd-mm-yyyy)
                $formatted_start_date = date('d-m-Y', strtotime($start_date));
                $formatted_end_date = date('d-m-Y', strtotime($end_date));
                // Format teks untuk filter tanggal
                $filter_text = 'Tanggal ' . $formatted_start_date . ' sampai ' . $formatted_end_date;
            } else {
                // Teks untuk data tanpa filter
                $filter_text = 'Data tanpa filter';
            }
            

            $html = '<h1 style="text-align:center">Data Simpanan Wajib</h1>';
            $html .= '<p>' . $filter_text . '</p>';
            $html .= '<p style="font-weight:bold">Nama: ' . $anggota_item->nama . '</p>';
            $html .= '<p style="font-weight:bold">NIA: ' . $anggota_item->nia . '</p>';
            $html .= '<table border="1">';
            $html .= '<tr>';
            $html .= '<th style="text-align:center; background-color: #d3d3d3; font-size: 12px; width: 30px;">No</th>';
$html .= '<th style="text-align:center; background-color: #e0e0e0;">Tanggal Dibayarkan</th>';
$html .= '<th style="text-align:center; background-color: #e0e0e0; width: 300px;">Jumlah</th>';

// Tambahkan kolom untuk simpanan pokok
            $html .= '</tr>';
            $no = 1;

          // Fetch simpanan pokok data based on parameters
if (!empty($start_date) && !empty($end_date)) {
    $filtered_data = $this->SimpananWajib_model->filterByDateRangeDetail($id_anggota, $start_date, $end_date);
} elseif (!empty($year) && !empty($month)) {
    $filtered_data = $this->SimpananWajib_model->filterByYearMonthDetail($id_anggota, $year, $month);
} elseif (!empty($year) && empty($month)) {
    // Menangani kasus saat hanya tahun yang dipilih tanpa bulan
    $filtered_data = $this->SimpananWajib_model->filterByYearMonthDetail($id_anggota, $year, null); // Menambahkan parameter $month dengan nilai null
} else {
    $filtered_data = $this->SimpananWajib_model->detail_simpanan_wajib_export_detail($id_anggota);
}



            // Iterate through each simpanan pokok data
            foreach ($filtered_data as $wajib) {
                // Set nomor urut
                $html .= '<tr>';
                $html .= '<td style="text-align:center">' . $no++ . '</td>';
                $html .= '<td style="text-align:center">' . $wajib->tanggal_dibayar . '</td>';
                $html .= '<td> Rp ' . number_format($wajib->jumlah, 0, ',', '.') . '</td>'; // Format jumlah sebagai mata uang rupiah
                $html .= '</tr>';
            }

            // Calculate and display total jumlah
            $total_jumlah = array_sum(array_column($filtered_data, 'jumlah'));
            $html .= '<tr>';
            $html .= '<td colspan="2" style="text-align:center; background-color: #d3d3d3; font-weight:bold">Total Simpanan Wajib</td>';
            $html .= '<td style="text-align:center; font-weight:bold">Rp ' . number_format($total_jumlah, 0, ',', '.') . '</td>';
            $html .= '</tr>';

            $html .= '</table>';

            $pdf->SetY(25);

            // Write HTML content to PDF
            $pdf->writeHTML($html, true, false, true, false, '');

            // Close and output PDF document
            $pdf->Output('datail_simpanan_wajib.pdf', 'I');
        }
    }
}


}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* author
*/

class Simpanan_pokok extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Anggota_model");
        $this->load->model("SimpananPokok_model");
        $this->load->library('form_validation');
    }

    public function index()
    {
    $data['total'] = $this->SimpananPokok_model->total_simpanan_pokok_all();
    $data["anggota"] = $this->Anggota_model->getAll();
    
    // Ambil total simpanan pokok untuk setiap anggota
    $data['total_anggota'] = $this->SimpananPokok_model->total_simpanan_pokok_per_anggota();

    $this->load->view("simpanan_pokok/lihat_simpanan_pokok", $data);
    }

    public function detail($id){
        // $data['anggota'] = $this->SimpananPokok_model->detail_simpanan_pokokall();
        $data['tot'] = $this->SimpananPokok_model->total_simpanan_pokok($id);
        $data['simpanan_pokok'] = $this->SimpananPokok_model->detail_simpanan_pokok($id);
        $this->load->view("simpanan_pokok/detail_simpanan_pokok", $data);
    }

    public function add($id)
    {   
        $anggota = $this->Anggota_model->getById($id);
        $simpanan_pokok = $this->SimpananPokok_model;
        $validation = $this->form_validation;
        $validation->set_rules($simpanan_pokok->rules());

        if ($validation->run()) {
            $simpanan_pokok->save();
            // Format jumlah simpanan menjadi format Rupiah dengan tiga angka di belakang titik
            $jumlahFormatted = "Rp " . number_format($simpanan_pokok->jumlah, 0, ',', '.');

            // Set pesan sukses dalam session flashdata
            $this->session->set_flashdata('success', 'Tambah Simpanan Pokok <strong>' . $anggota->nama . '</strong> Sebesar ' . $jumlahFormatted . ' Berhasil Disimpan');

            redirect('simpanan_pokok/index');
        }
        $data['anggota'] = $this->Anggota_model->getById($id);
        $this->load->view("simpanan_pokok/tambah_simpanan_pokok", $data);
    }

   public function edit($id){
    $anggota = $this->Anggota_model->getById($id);
    $simpanan_pokok = $this->SimpananPokok_model->getById($id);
    if(!$simpanan_pokok) {
        show_404();
    }

    $anggota_id = $simpanan_pokok->id_anggota;
    $anggota = $this->Anggota_model->getById($anggota_id);
    if(!$anggota) {
        show_404();
    }

    $validation = $this->form_validation;
    $validation->set_rules($this->SimpananPokok_model->rules());



    if ($validation->run()) {
        $this->SimpananPokok_model->update($id);
        
        // Ambil nilai simpanan pokok baru setelah perubahan
        $new_jumlah = "Rp " . number_format(preg_replace("/[^0-9]/", "", $this->input->post('jumlah')), 0, ',', '.');
        $old_jumlah = "Rp " . number_format($simpanan_pokok->jumlah, 0, ',', '.');

        // Buat pesan dengan informasi yang diinginkan
        $message = 'Data Simpanan Pokok <strong>' . $anggota->nama . '</strong> sebesar <strong>' . $old_jumlah . '</strong> berhasil diubah menjadi <strong>' . $new_jumlah . '</strong>';
        
        $this->session->set_flashdata('success', $message);
        redirect('simpanan_pokok/detail/'.$anggota_id);
    }

    $data['simpanan_pokok'] = $simpanan_pokok;
    $data['anggota'] = $anggota;
    $this->load->view('simpanan_pokok/edit_simpanan_pokok', $data);
}

    public function hide($id){
    	$this->Anggota_model->update($id);
    	$this->session->set_flashdata('success', 'Data Simpanan Pokok Berhasil Dihapus');
    	redirect('anggota/index');
    }

    public function delete($id){
	    $this->SimpananPokok_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
        $jumlahFormatted = "Rp " . number_format($simpanan_pokok->jumlah, 0, ',', '.');
	    $this->session->set_flashdata('success', 'Data Simpanan Pokok Berhasil Dihapus');
	    redirect($_SERVER['HTTP_REFERER']);
	}

    public function export(){
		// Load plugin PHPExcel nya
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		// Settingan awal fil excel
		$excel->getProperties()->setCreator('Andika')
			->setLastModifiedBy('Andika')
			->setTitle("Data Simpanan Pokok")
			->setSubject("Simpanan Pokok")
			->setDescription("Laporan Simpanan Pokok")
			->setKeywords("Data Simpanan Pokok");
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
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA SIMPANAN POKOK KOPERASI DESA BEJI"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "NIA"); // Set kolom B3 dengan tulisan "NIS"
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS KELAMIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "ALAMAT");
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "SIMPANAN POKOK");
	
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

		// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
		// Panggil function view yang ada di Anggota_model untuk menampilkan semua data anggotanya
        $anggota = $this->Anggota_model->getAll();
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
    foreach($anggota as $data){ // Lakukan looping pada variabel anggota
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
    $excel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$numrow, $data->nia, PHPExcel_Cell_DataType::TYPE_STRING); // Set kolom B sebagai teks eksplisit
    $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->nama);
    $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->jenis_kelamin);
    $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->alamat);

     // Menghitung jumlah simpanan pokok per anggota
     // Mengambil total simpanan pokok per anggota dari model
$total_simpanan_pokok_anggota_result = $this->SimpananPokok_model->total_simpanan_pokok_per_anggota();

// Mencari total simpanan pokok per anggota yang sesuai dengan id anggota saat ini
$total_simpanan_pokok_anggota = 0;
foreach ($total_simpanan_pokok_anggota_result as $total) {
    if ($total->id_anggota == $data->id_anggota) {
        $total_simpanan_pokok_anggota = $total->total_simpanan_pokok;
        break;
    }
}
     // Format jumlah simpanan pokok per anggota menjadi format Rupiah
     $total_simpanan_pokok_anggota_rp = 'Rp ' . number_format($total_simpanan_pokok_anggota, 0, ',', '.');

     // Menambahkan jumlah simpanan pokok per anggota ke dalam kolom F
     $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $total_simpanan_pokok_anggota_rp);

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

/// Hitung jumlah simpanan pokok
$total_simpanan_pokok = $this->SimpananPokok_model->total_simpanan_pokok_all();

// Format jumlah simpanan pokok menjadi format Rupiah
$total_simpanan_pokok_rp = 'Rp ' . number_format($total_simpanan_pokok, 0, ',', '.');

// Menambahkan jumlah simpanan pokok di bawah data anggota terakhir
$excel->getActiveSheet()->mergeCells('A'.$numrow.':D'.$numrow); // Merge cells untuk kolom A hingga D pada baris ke-$numrow
$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, 'Jumlah Simpanan Pokok Seluruh Anggota'); // Set nilai pada kolom A baris ke-$numrow

// Set nilai pada kolom E baris ke-$numrow dengan format Rupiah dan alignment horizontal ke kanan
$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $total_simpanan_pokok_rp); // Set nilai pada kolom E baris ke-$numrow dengan format Rupiah
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
$excel->getActiveSheet(0)->setTitle("Laporan Data Simpanan Pokok");
$excel->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Data Simpanan Pokok.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');
$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$write->save('php://output');

	}

public function export_detail(){
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
    
        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Ino Galwargan')
            ->setLastModifiedBy('Ino Galwargan')
            ->setTitle("Data Simpanan Pokok")
            ->setSubject("Simpanan Pokok")
            ->setDescription("Laporan Simpanan Pokok")
            ->setKeywords("Data Simpanan Pokok");
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
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA SIMPANAN POKOK KOPERASI DESA BEJI"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "NIA"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS KELAMIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "TANGGAL");
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "JUMLAH");
    
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
    
        // Panggil function view yang ada di Anggota_model untuk menampilkan semua data anggotanya
        $anggota = $this->Anggota_model->getAll();
        // Panggil function view yang ada di SimpananPokok_model untuk mendapatkan data simpanan pokok
        $simpanan_pokok = $this->SimpananPokok_model->getAll(); 
    
        // Lakukan penggabungan data anggota dengan data simpanan pokok berdasarkan ID anggota
        $anggota_simpanan = array(); // Buat array kosong untuk menampung data anggota dan simpanan pokok
        foreach ($anggota as $anggota_data) {
            $anggota_simpanan[$anggota_data->id_anggota] = $anggota_data; // Masukkan data anggota ke dalam array dengan kunci ID anggota
        }
    
        // Looping data simpanan pokok
        foreach ($simpanan_pokok as $simpanan_data) {
            // Pastikan ID anggota terdapat dalam data anggota dan simpanan pokok
            if (isset($anggota_simpanan[$simpanan_data->id_anggota])) {
                // Tambahkan jumlah dan tanggal dibayar dari data simpanan pokok ke dalam data anggota
                $anggota_simpanan[$simpanan_data->id_anggota]->jumlah = $simpanan_data->jumlah;
                $anggota_simpanan[$simpanan_data->id_anggota]->tanggal_dibayar = $simpanan_data->tanggal_dibayar;
            }
        }
    
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($anggota_simpanan as $data){ // Lakukan looping pada variabel anggota
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$numrow, $data->nia, PHPExcel_Cell_DataType::TYPE_STRING); // Set kolom B sebagai teks eksplisit
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->nama);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->jenis_kelamin);
        
            $tanggal_dibayar = isset($data->tanggal_dibayar) ? $data->tanggal_dibayar : '';
            // Pastikan properti jumlah dan tanggal_dibayar ada sebelum mengaksesnya
            $jumlah = isset($data->jumlah) ? $data->jumlah : '';
            
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $tanggal_dibayar);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $jumlah);
            
        
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
        
    
        // Hitung jumlah simpanan pokok
        $total_simpanan_pokok = $this->SimpananPokok_model->total_simpanan_pokok_per_anggota();
        
        // Format jumlah simpanan pokok menjadi format Rupiah
        $total_simpanan_pokok_rp = 'Rp ' . number_format($total_simpanan_pokok, 0, ',', '.');        
    
        // Menambahkan jumlah simpanan pokok di bawah data anggota terakhir
        $excel->getActiveSheet()->mergeCells('A'.$numrow.':D'.$numrow); // Merge cells untuk kolom A hingga D pada baris ke-$numrow
        $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, 'Jumlah Simpanan Pokok Seluruh Anggota'); // Set nilai pada kolom A baris ke-$numrow
    
        // Set nilai pada kolom E baris ke-$numrow dengan format Rupiah dan alignment horizontal ke kanan
        $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $total_simpanan_pokok_rp); // Set nilai pada kolom E baris ke-$numrow dengan format Rupiah
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
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom F
    
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Data Simpanan Pokok");
        $excel->setActiveSheetIndex(0);
    
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Detail Simpanan Pokok.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function export_pdf() {
        // Load library TCPDF
        $this->load->library('tcpdf/tcpdf');
        
        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Data Anggota');
        $pdf->SetHeaderData('', '', 'Koperasi Desa Beji', '');
        
        // Add a page
        $pdf->AddPage();
        
        // Set some content to display
        $html = '<h1 style="text-align:center">Data Anggota Koperasi</h1>';
        $html .= '<table border="1">';
        $html .= '<tr>';
        $html .= '<th style="text-align:center">No</th>';
        $html .= '<th style="text-align:center">NIA</th>';
        $html .= '<th style="text-align:center">Nama</th>';
        $html .= '<th style="text-align:center">Jenis Kelamin</th>';
        $html .= '<th style="text-align:center">Alamat</th>';
        $html .= '<th style="text-align:center">Simpanan Pokok</th>'; // Tambahkan kolom untuk simpanan pokok
        $html .= '</tr>';
        $no = 1;
        
        // Get data anggota
        $anggota = $this->Anggota_model->getAll();
        
        foreach ($anggota as $value) {
            $html .= '<tr>';
            $html .= '<td style="text-align:center">' . $no++ . '</td>';
            $html .= '<td style="text-align:center">' . $value->nia . '</td>';
            $html .= '<td style="text-align:center">' . $value->nama . '</td>';
            $html .= '<td style="text-align:center">' . $value->jenis_kelamin . '</td>';
            $html .= '<td style="text-align:center">' . $value->alamat . '</td>';
    
            // Dapatkan total simpanan pokok per anggota menggunakan model
            $total_simpanan_pokok_anggota = $this->SimpananPokok_model->total_simpanan_pokok_per_anggota_q($value->id_anggota);
    
            // Format jumlah simpanan pokok per anggota menjadi format Rupiah
            $total_simpanan_pokok_anggota_rp = 'Rp ' . number_format((float)$total_simpanan_pokok_anggota, 0, ',', '.');
    
            $html .= '<td style="text-align:center">' . $total_simpanan_pokok_anggota_rp . '</td>'; // Tambahkan nilai simpanan pokok
            $html .= '</tr>';
        }
    
        // Menambahkan jumlah simpanan pokok seluruh anggota
        $total_simpanan_pokok_all = $this->SimpananPokok_model->total_simpanan_pokok_all();
        $total_simpanan_pokok_all_rp = 'Rp ' . number_format($total_simpanan_pokok_all, 0, ',', '.');
        $html .= '<tr>';
        $html .= '<td colspan="4"></td>'; // Kolom kosong untuk memisahkan total simpanan pokok seluruh anggota
        $html .= '<td style="text-align:center; font-weight:bold">Jumlah Simpanan Pokok Seluruh Anggota</td>';
        $html .= '<td style="text-align:center">' . $total_simpanan_pokok_all_rp . '</td>';
        $html .= '</tr>';
    
        $html .= '</table>';
    
        $pdf->SetY(25);
        
        // Write HTML content to PDF
        $pdf->writeHTML($html, true, false, true, false, '');
        
        // Close and output PDF document
        $pdf->Output('data_anggota.pdf', 'I');
    }
    

}

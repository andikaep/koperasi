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
    $data['total'] = $this->SimpananSukarela_model->total_simpanan_sukarela_all();
    $data["anggota"] = $this->Anggota_model->getAll();
    
    // Ambil total simpanan sukarela untuk setiap anggota
    $data['total_anggota'] = $this->SimpananSukarela_model->total_simpanan_sukarela_per_anggota();

    $this->load->view("simpanan_sukarela/lihat_simpanan_sukarela", $data);
    }

    public function detail($id){

        // $data['anggota'] = $this->SimpananSukarelamodel->detail_simpanan_sukarelall();
        $data['id_anggota'] = $id;
        $data['simpanan_sukarela'] = $this->SimpananSukarela_model->detail_simpanan_sukarela($id);
        $data['tot'] = $this->SimpananSukarela_model->total_simpanan_sukarela($id);
        $this->load->view("simpanan_sukarela/detail_simpanan_sukarela", $data);
    }

    public function filterByDate($id){
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
        
        // Ambil total simpanan sukarela
        $data['tot'] = $this->SimpananSukarela_model->total_simpanan_sukarela($id);
        
        // Periksa apakah rentang tanggal dipilih atau tidak
        if (!empty($start_date) && !empty($end_date)) {
            // Jika rentang tanggal dipilih, gunakan rentang tanggal
            $data['simpanan_sukarela'] = $this->SimpananSukarela_model->filterByDateRange($id, $start_date, $end_date);
            $data['total_simpanan_sukarela'] = $this->SimpananSukarela_model->calculateTotalByDateRange($id, $start_date, $end_date);
        } else {
            // Jika tidak, gunakan tahun dan bulan
            $data['simpanan_sukarela'] = $this->SimpananSukarela_model->filterByDate($id, $year, $month);
            $data['total_simpanan_sukarela'] = $this->SimpananSukarela_model->calculateTotalByDate($id, $year, $month);
        }
        
        // Load view dengan data yang diperlukan
        $this->load->view("simpanan_sukarela/detail_simpanan_sukarela", $data);
        
        // Bersihkan session setelah halaman dimuat kembali atau berpindah halaman
        $this->session->unset_userdata('filter_year');
        $this->session->unset_userdata('filter_month');
        $this->session->unset_userdata('filter_start_date');
        $this->session->unset_userdata('filter_end_date');
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
            
           // Ambil nilai simpanan sukarela baru setelah perubahan
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

    public function export(){
		// Load plugin PHPExcel nya
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		// Settingan awal fil excel
		$excel->getProperties()->setCreator('Ino Galwargan')
			->setLastModifiedBy('Ino Galwargan')
			->setTitle("Data Simpanan Sukarela")
			->setSubject("Simpanan Sukarela")
			->setDescription("Laporan Simpanan Sukarela")
			->setKeywords("Data Simpanan Sukarela");
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
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA SIMPANAN SUKARELA KOPERASI DESA BEJI"); // Set kolom A1 dengan tulisan "DATA SISWA"
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
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "SIMPANAN SUKARELA");
	
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

    $total_simpanan_sukarela_anggota_result = $this->SimpananSukarela_model->total_simpanan_sukarela_per_anggota();

// Mencari total simpanan pokok per anggota yang sesuai dengan id anggota saat ini
$total_simpanan_sukarela_anggota = 0;
foreach ($total_simpanan_sukarela_anggota_result as $total) {
    if ($total->id_anggota == $data->id_anggota) {
        $total_simpanan_sukarela_anggota = $total->total_simpanan_sukarela;
        break;
    }
}
     // Format jumlah simpanan pokok per anggota menjadi format Rupiah
     $total_simpanan_sukarela_anggota_rp = 'Rp ' . number_format($total_simpanan_sukarela_anggota, 0, ',', '.');

     // Menambahkan jumlah simpanan pokok per anggota ke dalam kolom F
     $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $total_simpanan_sukarela_anggota_rp);

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

/// Hitung jumlah simpanan sukarela
$total_simpanan_sukarela = $this->SimpananSukarela_model->total_simpanan_sukarela_all();

// Format jumlah simpanan sukarela menjadi format Rupiah
$total_simpanan_sukarela_rp = 'Rp ' . number_format($total_simpanan_sukarela, 0, ',', '.');

// Menambahkan jumlah simpanan sukarela di bawah data anggota terakhir
$excel->getActiveSheet()->mergeCells('A'.$numrow.':D'.$numrow); // Merge cells untuk kolom A hingga D pada baris ke-$numrow
$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, 'Jumlah Simpanan Sukarela Seluruh Anggota'); // Set nilai pada kolom A baris ke-$numrow

// Set nilai pada kolom E baris ke-$numrow dengan format Rupiah dan alignment horizontal ke kanan
$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $total_simpanan_sukarela_rp); // Set nilai pada kolom E baris ke-$numrow dengan format Rupiah
$excel->getActiveSheet()->getStyle('F'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); // Set alignment horizontal ke kanan

// Apply style yang telah kita buat ke baris jumlah simpanan sukarela
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
$excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom E


// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
// Set orientasi kertas jadi LANDSCAPE
$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
// Set judul file excel nya
$excel->getActiveSheet(0)->setTitle("Laporan Data Simpanan Sukarela");
$excel->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Data Simpanan Sukarela.xlsx"'); // Set nama file excel nya
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
        $pdf->SetTitle('Data Simpanan Sukarela');
        $pdf->SetHeaderData('', '', 'Koperasi Desa Beji', '');
    
        // Add a page
        $pdf->AddPage();
    
        // Set some content to display
        $html = '<h1 style="text-align:center">Data Simpanan Sukarela</h1>';
        $html .= '<table border="1">';
        $html .= '<tr>';
        $html .= '<th style="text-align:center">No</th>';
        $html .= '<th style="text-align:center">NIA</th>';
        $html .= '<th style="text-align:center">Nama</th>';
        $html .= '<th style="text-align:center">Jenis Kelamin</th>';
        $html .= '<th style="text-align:center">Alamat</th>';
        $html .= '<th style="text-align:center">Simpanan Sukarela</th>'; // Tambahkan kolom untuk simpanan pokok
        $html .= '</tr>';
        $no = 1;
    
        // Get data anggota
        // Get data anggota
    $anggota = $this->Anggota_model->getAll();
    
    // Get total simpanan pokok per anggota
    $total_simpanan_sukarela_per_anggota = array();
    $total_simpanan_sukarela_anggota = $this->SimpananSukarela_model->total_simpanan_sukarela_per_anggota();
    foreach ($total_simpanan_sukarela_anggota as $total) {
        $total_simpanan_sukarela_per_anggota[$total->id_anggota] = $total->total_simpanan_sukarela;
    }
    
    // Iterate through each anggota and display their information
    foreach ($anggota as $value) {
        $html .= '<tr>';
        $html .= '<td style="text-align:center">' . $no++ . '</td>';
        $html .= '<td style="text-align:center">' . $value->nia . '</td>';
        $html .= '<td style="text-align:center">' . $value->nama . '</td>';
        $html .= '<td style="text-align:center">' . $value->jenis_kelamin . '</td>';
        $html .= '<td style="text-align:center">' . $value->alamat . '</td>';
        // Periksa apakah kunci ada dalam array
        if (array_key_exists($value->id_anggota, $total_simpanan_sukarela_per_anggota)) {
        // Jika ada, tampilkan nilai total simpanan pokok
        $html .= '<td> ' .  'Rp ' . number_format($total_simpanan_sukarela_per_anggota[$value->id_anggota], 0, ',', '.') . '</td>';
        } else {
        // Jika tidak, tampilkan teks kosong
        $html .= '<td></td>';
        }
    
        $html .= '</tr>';
    }
    
    
        // Menambahkan jumlah simpanan pokok seluruh anggota
        $total_simpanan_sukarela_all = $this->SimpananSukarela_model->total_simpanan_sukarela_all();
        $total_simpanan_sukarela_all_rp = 'Rp ' . number_format($total_simpanan_sukarela_all, 0, ',', '.');
        $html .= '<tr>';
        $html .= '<td colspan="5" style="text-align:center; font-weight:bold">Total Simpanan Sukarela</td>'; // Gabung kolom 0-4
        $html .= '<td colspan="5" style="text-align:center">' . $total_simpanan_sukarela_all_rp . '</td>'; // Tetap di posisinya sekarang, di bawah kolom "Simpanan Pokok"
        $html .= '</tr>';
    
        $html .= '</table>';
    
        $pdf->SetY(25);
    
        // Write HTML content to PDF
        $pdf->writeHTML($html, true, false, true, false, '');
    
        // Close and output PDF document
        $pdf->Output('data_anggota.pdf', 'I');
    }

    public function export_detail($id_anggota){
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
    
        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('Ino Galwargan')
            ->setLastModifiedBy('Ino Galwargan')
            ->setTitle("Data Simpanan Sukarela")
            ->setSubject("Simpanan Pokok")
            ->setDescription("Laporan Simpanan Pokok")
            ->setKeywords("Data Simpanan Sukarela");
    
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
$excel->getActiveSheet()->setCellValue('A1', 'Data Simpanan Sukarela');
$excel->getActiveSheet()->setCellValue('A2', 'Nama: ' . $nama_anggota);
$excel->getActiveSheet()->setCellValue('A3', 'NIA: ' . $nia_anggota);

// Gabungkan sel untuk kolom "Data Simpanan Pokok", "Nama", dan "NIA"
$excel->getActiveSheet()->mergeCells('A1:C1'); // Data Simpanan Pokok
$excel->getActiveSheet()->mergeCells('A2:C2'); // Nama
$excel->getActiveSheet()->mergeCells('A3:C3'); // NIA

// Set align horizontal dan vertical untuk teks "Data Simpanan Pokok", "Nama", dan "NIA"
$alignment = $excel->getActiveSheet()->getStyle('A1:C3')->getAlignment();
$alignment->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Pusatkan teks secara horizontal
$alignment->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // Pusatkan teks secara vertikal

// Beri gaya tebal untuk teks "Nama" dan "NIA"
$excel->getActiveSheet()->getStyle('A2:C3')->getFont()->setBold(true);

// Tambahkan spasi di bawah NIA
$excel->getActiveSheet()->mergeCells('A4:C4'); // Gabungkan sel untuk spasi
$excel->getActiveSheet()->getRowDimension(4)->setRowHeight(20); // Set tinggi baris untuk memberikan spasi

// Tambahkan kolom kosong di antara "NIA" dan "No"
// Insert satu kolom kosong sebelum kolom A

// Buat header tabel pada baris ke 5
$excel->getActiveSheet()->setCellValue('A5', 'No');
$excel->getActiveSheet()->setCellValue('B5', 'Tanggal Dibayarkan');
$excel->getActiveSheet()->setCellValue('C5', 'Jumlah');

// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);

$numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 6

// Ambil data simpanan pokok berdasarkan ID anggota
$simpanan_sukarela = $this->SimpananSukarela_model->detail_simpanan_sukarela_export_detail($id_anggota); 

// Looping data simpanan pokok
foreach ($simpanan_sukarela as $simpanan_data) {
    // Set data dalam kolom
    $excel->getActiveSheet()->setCellValue('A' . $numrow, $numrow - 5); // Nomor urut
    $excel->getActiveSheet()->setCellValue('B' . $numrow, $simpanan_data->tanggal_dibayar); // Tanggal dibayarkan
    $excel->getActiveSheet()->setCellValue('C' . $numrow, 'Rp ' . number_format($simpanan_data->jumlah, 0, ',', '.')); // Jumlah dengan format rupiah

    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
    $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_col);
    $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_col);

    $numrow++; // Tambah 1 setiap kali looping
}

    
        // Hitung total jumlah simpanan pokok
        $total_jumlah = array_sum(array_column($simpanan_sukarela, 'jumlah'));
    
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
        $excel->getActiveSheet(0)->setTitle("Laporan Data Simpanan Sukarela");
        $excel->setActiveSheetIndex(0);
    
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Detail Simpanan Sukarela.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function export_detail_pdf($id_anggota) {
        // Load library TCPDF
        $this->load->library('tcpdf/tcpdf');
    
        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Data Simpanan Sukarela');
        $pdf->SetHeaderData('', '', 'Koperasi Desa Beji', '');
    
        // Add a page
        $pdf->AddPage();
        
        // Get data anggota
        $anggota = $this->Anggota_model->getAnggotaById_export_detail($id_anggota);
    
        if ($anggota) {
            foreach ($anggota as $anggota_item) {
                // Set some content to display
                $html = '<h1 style="text-align:center">Data Simpanan Sukarela</h1>';
                $html .= '<p style="text-align:center; font-weight:bold">Nama: ' . $anggota_item->nama . '</p>';
                $html .= '<p style="text-align:center; font-weight:bold">NIA: ' . $anggota_item->nia . '</p>';
                $html .= '<table border="1">';
                $html .= '<tr>';
                $html .= '<th style="text-align:center">No</th>';
                $html .= '<th style="text-align:center">Tanggal Dibayarkan</th>';
                $html .= '<th style="text-align:center">Jumlah</th>'; // Tambahkan kolom untuk simpanan pokok
                $html .= '</tr>';
                $no = 1;
    
                // Fetch simpanan pokok data for the current anggota
                $simpanan_sukarela = $this->SimpananSukarela_model->detail_simpanan_sukarela_export_detail($anggota_item->id_anggota);
    
                // Iterate through each simpanan pokok data
                foreach ($simpanan_sukarela as $sukarela) {
                    // Set nomor urut
                    $html .= '<tr>';
                    $html .= '<td style="text-align:center">' . $no++ . '</td>';
                    $html .= '<td style="text-align:center">' . $sukarela->tanggal_dibayar . '</td>';
                    $html .= '<td> Rp ' . number_format($sukarela->jumlah, 0, ',', '.') . '</td>';
                    $html .= '</tr>';
                }
    
                // Calculate and display total jumlah
                $total_jumlah = array_sum(array_column($simpanan_sukarela, 'jumlah'));
                $html .= '<tr>';
                $html .= '<td colspan="2" style="text-align:center; font-weight:bold">Total Simpanan Sukarela</td>';
                $html .= '<td style="text-align:center; font-weight:bold">Rp ' . number_format($total_jumlah, 0, ',', '.') . '</td>';
                $html .= '</tr>';
    
                $html .= '</table>';
    
                $pdf->SetY(25);
    
                // Write HTML content to PDF
                $pdf->writeHTML($html, true, false, true, false, '');
    
                // Close and output PDF document
                $pdf->Output('data_simpanan_sukarela.pdf', 'I');
            }
        }
    }


}

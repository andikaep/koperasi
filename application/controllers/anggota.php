<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
*
*/

class Anggota extends MY_Controller
{
    private $filename = "import_data"; // Kita tentukan nama filenya
	public function __construct()
    {
        parent::__construct();
        $this->load->model("Anggota_model");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["anggota"] = $this->Anggota_model->getAll();
        $this->load->view("anggota/lihat_anggota", $data);
    }

    public function detail($id){

        $anggota = $this->Anggota_model; 
        $data['anak'] = $this->Anggota_model->detail_anak($id);
		$data['pinjaman'] = $this->Anggota_model->detail_pinjaman($id);
		$data['simpanan_pokok'] = $this->Anggota_model->detail_simpanan_pokok($id);
        $data['pasangan'] = $this->Anggota_model->detail_pasangan($id);
        $data['anggota'] = $this->Anggota_model->getById($id);

        $this->load->view("anggota/detail_anggota", $data);
    }

    public function add()
    {
        $anggota = $this->Anggota_model;
        $validation = $this->form_validation;
        $validation->set_rules($anggota->rules());

        if ($validation->run()) {
            $anggota->save();
            $this->session->set_flashdata('success', 'Tambah Anggota '.$anggota->nama.' Berhasil Disimpan');
            redirect('anggota/index');
        }

        $this->load->view("anggota/tambah_anggota");
    }

    public function edit($id){

    	$anggota = $this->Anggota_model; //object model
        $validation = $this->form_validation; //object validasi
        $validation->set_rules($anggota->rules()); //terapkan rules di Anggota_model.php

        if ($validation->run()) { //lakukan validasi form
            $anggota->update($id); // update data
            $this->session->set_flashdata('success', 'Data Anggota '.$anggota->getById($id)->nama.' Berhasil Diubah');
            redirect('anggota/index');

        }
        $data['anggota'] = $this->Anggota_model->getById($id);
		if ($this->session->flashdata('success')) {
			$data['success_message'] = $this->session->flashdata('success');
			// Hapus flashdata setelah digunakan
			$this->session->unset_userdata('success');
		}
        $this->load->view('anggota/edit_anggota', $data);
    }

    public function hide($id){
    	$this->Anggota_model->update($id);
    	$this->session->set_flashdata('success', 'Data Anggota Berhasil Dihapus');
    	redirect('anggota/index');
    }

    public function delete($id){
	    $this->Anggota_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
	    $this->session->set_flashdata('success', 'Data Anggota Berhasil Dihapus');
	    redirect('anggota/index');
	}

	public function form(){
		$data = array(); // Buat variabel $data sebagai array

		if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form
			// lakukan upload file dengan memanggil function upload yang ada di SiswaModel.php
			$upload = $this->Anggota_model->upload_file($this->filename);

			if($upload['result'] == "success"){ // Jika proses upload sukses
				// Load plugin PHPExcel nya
				include APPPATH.'third_party/PHPExcel/PHPExcel.php';

				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang tadi diupload ke folder excel
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

				// Masukan variabel $sheet ke dalam array data yang nantinya akan di kirim ke file form.php
				// Variabel $sheet tersebut berisi data-data yang sudah diinput di dalam excel yang sudha di upload sebelumnya
				$data['sheet'] = $sheet;
			}else{ // Jika proses upload gagal
				$data['upload_error'] = $upload['error']; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
			}
		}

		$this->load->view('anggota/validasi_import', $data);
	}

	public function import(){
		// Load plugin PHPExcel nya
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

		// Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
		$data = array();

		$numrow = 1;
		foreach($sheet as $row){
			// Cek $numrow apakah lebih dari 1
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport
			if($numrow > 1){
				// Kita push (add) array data ke variabel data
				array_push($data, array(
					'id_anggota'=> uniqid(),
					'nia'=>$row['A'], // Insert data nis dari kolom A di excel
					'nama'=>$row['B'], // Insert data nama dari kolom B di excel
					'jenis_kelamin'=>$row['C'], // Insert data jenis kelamin dari kolom C di excel
					'alamat'=>$row['D'], // Insert data alamat dari kolom D di excel
				));
			}

			$numrow++; // Tambah 1 setiap kali looping
		}
		// Panggil fungsi insert_multiple yg telah kita buat sebelumnya di model
		$this->Anggota_model->insert_multiple($data);

		redirect("anggota"); // Redirect ke halaman awal (ke controller siswa fungsi index)
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
			$html .= '</tr>';
		}
		$html .= '</table>';

		$pdf->SetY(25);
		
		// Write HTML content to PDF
		$pdf->writeHTML($html, true, false, true, false, '');
		
		// Close and output PDF document
		$pdf->Output('data_anggota.pdf', 'I');
	}

	public function export(){
		// Load plugin PHPExcel nya
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		// Settingan awal fil excel
		$excel->getProperties()->setCreator('Ino Galwargan')
			->setLastModifiedBy('Ino Galwargan')
			->setTitle("Data Anggota")
			->setSubject("Anggota")
			->setDescription("Laporan Semua Data Anggota")
			->setKeywords("Data Anggota");
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
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA ANGGOTA KOPERASI"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "NIA"); // Set kolom B3 dengan tulisan "NIS"
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS KELAMIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "ALAMAT"); // Set kolom E3 dengan tulisan "ALAMAT"
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
		$anggota = $this->Anggota_model->getAll();
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($anggota as $data){ // Lakukan looping pada variabel siswa
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->nia);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->nama);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->jenis_kelamin);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->alamat);

			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);

			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Laporan Data Anggota");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data Anggota.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include APPPATH.'libraries/PHPExcel/PHPExcel.php';
class Excel extends CI_Controller {
	private $style_col;
	private $style_row;

	public function __construct() {
        parent::__construct();        
		if(!$this->session->userdata('kasir01')) 
			redirect(base_url() . "auth/login");
		$user = $this->session->userdata('kasir01');
        if($user->role == 'kasir')
			redirect(base_url() . "auth/login");
        $this->load->model('toko_m');
        $this->load->model('category_m');
		$this->load->model('menu_m');
		$this->load->model('bahan_m');
		$this->load->model('transaksi_m');
		$this->load->model('pembelian_m');
		$this->load->model('akun_m');
		$this->load->model('cashflow_m');

		$this->style_col = array(
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
		$this->style_row = array(
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
    }

    function excelTitle(&$excel,$nama_toko,$title,$description,$keywords){
    	$excel->getProperties()->setCreator($nama_toko)
             ->setLastModifiedBy($nama_toko)
             ->setTitle($title)
             ->setDescription($description)
             ->setKeywords($keywords);	
        return $excel;
    }

    function setformat(&$excel,$cell,$format="_-* #,##0.00"){
    	$excel->getActiveSheet()
			    ->getStyle($cell)
			    ->getNumberFormat()
			    ->setFormatCode($format);
        return $excel;
    }

    function convert_date($date_string){
	  $date = DateTime::createFromFormat('Y-m-d H:i', date("Y-m-d H:i",strtotime($date_string)) ); 
	  return $date;
	}

	function getStartAndEndDate($week, $year) {
		$dto = new DateTime();
		$dto->setISODate($year, $week);
		$ret['week_start'] = $dto->format('Y-m-d');
		$dto->modify('+6 days');
		$ret['week_end'] = $dto->format('Y-m-d');
		return $ret;
	}

	////////////////// PENJUALAN ///////////////
	function data_penjualan(&$excel,$data,$str,$end){
		$excel->getActiveSheet()->mergeCells('A1:F1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:F2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		
		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "TANGGAL");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "FAKTUR"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "TOTAL PENJUALAN"); 
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "METODE PEMBAYARAN"); 
		$excel->getActiveSheet()->setCellValue('F'.$coltitle, "KASIR"); 

		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->setTitle("Data Penjualan");
		$numrow = 5;
		$no=1;
		foreach ($data as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, PHPExcel_Shared_Date::PHPToExcel($this->convert_date( $d->date_add ) ) );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->faktur);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->total);
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->metode_bayar);
			$excel->getActiveSheet()->setCellValue('F'.$numrow, $d->nama_kasir);

			// $excel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$numrow, $d->faktur, PHPExcel_Cell_DataType::TYPE_STRING);
			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_row);
			// $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
			// $excel->getActiveSheet()->getRowDimension($numrow)->setAutoSize(true);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
		}

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$excel = $this->setformat($excel,'D4:D'.$numrow);
		$excel = $this->setformat($excel,'B4:B'.$numrow,'yyyy-mm-dd hh:mm');

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet()->setTitle("Data Penjualan");
	}

    function penjualan_daily($nama_toko,$str,$end){
    	$rekap = $this->transaksi_m->search_daily($str,$end);
    	$data = $this->transaksi_m->search_all($str,$end,1);
    	$excel = new PHPExcel();
    	$title = "Laporan Penjualan Harian - ".$nama_toko." tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)));
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Penjualan Harian","Data Transaksi");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Penjualan Harian - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:D1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:D2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "TANGGAL");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "JUMLAH TRANSAKSI"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "TOTAL PENJUALAN"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$total = 0;
		$jumlah = 0;
		foreach ($rekap as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, PHPExcel_Shared_Date::PHPToExcel( $this->convert_date( $d->tanggal ) ) );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->jumlah);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->total);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$total+=$d->total;
			$jumlah+=$d->jumlah;
		}
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'B'.$numrow); 
		$excel->getActiveSheet()->setCellValue('C'.$numrow, $jumlah);
		$excel->getActiveSheet()->setCellValue('D'.$numrow, $total);
		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel = $this->setformat($excel,'C4:C'.$numrow);
		$excel = $this->setformat($excel,'D4:D'.$numrow);
		$excel = $this->setformat($excel,'B4:B'.$numrow,'yyyy-mm-dd');

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap Data Penjualan Harian");
    	
    	//Detail Data//
    	$excel->createSheet(1);
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "Data Penjualan - ".$nama_toko); 
		$this->data_penjualan($excel,$data,$str,$end);
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();	
    }

    function penjualan_week($nama_toko,$str,$end){
    	$rekap = $this->transaksi_m->search_week2($str,$end);

    	$data = $this->transaksi_m->search_all($str,$end,1);
    	$excel = new PHPExcel();
    	$title = "Laporan Penjualan Mingguan - ".$nama_toko." tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)));
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Penjualan Mingguan","Data Transaksi");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Penjualan Mingguan - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:F1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:F2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "TAHUN");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "MINGGU");
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "TANGGAL");
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "JUMLAH TRANSAKSI"); 
		$excel->getActiveSheet()->setCellValue('F'.$coltitle, "TOTAL PENJUALAN"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$total = 0;
		$jumlah = 0;
		foreach ($rekap as $d) {
			$minggu = $this->getStartAndEndDate($d->minggu, $d->tahun);
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $d->tahun );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->minggu );
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $minggu['week_start'].' - '.$minggu['week_end'] );
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->jumlah);
			$excel->getActiveSheet()->setCellValue('F'.$numrow, $d->total);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$total+=$d->total;
			$jumlah+=$d->jumlah;
		}

		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'D'.$numrow); 
		$excel->getActiveSheet()->setCellValue('E'.$numrow, $jumlah);
		$excel->getActiveSheet()->setCellValue('F'.$numrow, $total);
		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$excel = $this->setformat($excel,'E4:E'.$numrow);
		$excel = $this->setformat($excel,'F4:F'.$numrow);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap Data Penjualan Mingguan");
    	
    	//Detail Data//
    	$excel->createSheet(1);
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "Data Penjualan - ".$nama_toko); 
		$this->data_penjualan($excel,$data,$str,$end);
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();	
    }

    function penjualan_month($nama_toko,$year){
    	$rekap = $this->transaksi_m->search_month($year);

    	$excel = new PHPExcel();
    	$title = "Laporan Penjualan Bulanan - ".$nama_toko." Tahun ".$year;
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Penjualan Bulanan","Data Transaksi");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Penjualan Bulanan - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:F1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tahun ".$year); 
		$excel->getActiveSheet()->mergeCells('A2:F2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "TAHUN");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "BULAN");
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "JUMLAH TRANSAKSI"); 
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "TOTAL PENJUALAN"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$total = 0;
		$jumlah = 0;
		foreach ($rekap as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $year );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->bulan );
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->item_jumlah );
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->item_total);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$total+=$d->item_total;
			$jumlah+=$d->item_jumlah;
		}
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'C'.$numrow); 
		$excel->getActiveSheet()->setCellValue('D'.$numrow, $jumlah);
		$excel->getActiveSheet()->setCellValue('E'.$numrow, $total);
		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel = $this->setformat($excel,'D4:D'.$numrow);
		$excel = $this->setformat($excel,'E4:E'.$numrow);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap Data Penjualan Bulanan");
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();	
    }

    function data_item_penjualan(&$excel,$data,$str,$end,$kategori="",$menu=""){
		$excel->getActiveSheet()->mergeCells('A1:H1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:H2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		if( !empty($kategori) || !empty($menu)   ){
			$subtitle = "";
			if(!empty($kategori))
				$subtitle .= " Kategori : ".$kategori;
			if( !empty($kategori) && !empty($menu)   )
				$subtitle .= " & ";
			if(!empty($menu))
				$subtitle .= " Menu : ".$menu;
			$excel->getActiveSheet()->setCellValue('A3',$subtitle); 
			$excel->getActiveSheet()->mergeCells('A3:H3'); 
			$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); 
			$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14); 
			$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 	
		}
		
		
		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "MENU"); 
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "KATEGORI"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "TANGGAL");
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "FAKTUR"); 
		$excel->getActiveSheet()->setCellValue('F'.$coltitle, "JUMLAH"); 
		$excel->getActiveSheet()->setCellValue('G'.$coltitle, "HARGA"); 
		$excel->getActiveSheet()->setCellValue('H'.$coltitle, "TOTAL"); 

		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('G'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('H'.$coltitle)->applyFromArray($this->style_col);
		$numrow = 5;
		$no=1;
		foreach ($data as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $d->menu);
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->kategori);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, PHPExcel_Shared_Date::PHPToExcel($this->convert_date( $d->date_add ) ) );
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->faktur);
			$excel->getActiveSheet()->setCellValue('F'.$numrow, $d->jumlah);
			$excel->getActiveSheet()->setCellValue('G'.$numrow, $d->harga);
			$excel->getActiveSheet()->setCellValue('H'.$numrow, ($d->jumlah * $d->harga) );

			// $excel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$numrow, $d->faktur, PHPExcel_Cell_DataType::TYPE_STRING);
			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($this->style_row);
			// $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
			// $excel->getActiveSheet()->getRowDimension($numrow)->setAutoSize(true);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
		}

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$excel = $this->setformat($excel,'F4:F'.$numrow);
		$excel = $this->setformat($excel,'G4:G'.$numrow);
		$excel = $this->setformat($excel,'H4:H'.$numrow);
		$excel = $this->setformat($excel,'D4:D'.$numrow,'yyyy-mm-dd hh:mm');

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet()->setTitle("Data Item Penjualan");
	}

    function penjualan_category($nama_toko,$str,$end){
    	$rekap = $this->transaksi_m->search_category($str,$end);
    	$data = $this->transaksi_m->search_all_item($str,$end,'kategori ASC');

    	$excel = new PHPExcel();
    	$title = "Laporan Penjualan per Kategori - ".$nama_toko." tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)));
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Penjualan per Kategori","Data Transaksi");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Penjualan per Kategori - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:F1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:F2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "KATEGORI");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "JUMLAH PENJUALAN ITEM"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "TOTAL HARGA PENJUALAN"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		foreach ($rekap as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $d->kategori );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->jumlah);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->total);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
		}
		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel = $this->setformat($excel,'C4:C'.$numrow);
		$excel = $this->setformat($excel,'D4:D'.$numrow);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap per Kategori");
    	
    	//Detail Data//
    	$excel->createSheet(1);
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "Data Penjualan - ".$nama_toko); 
		$this->data_item_penjualan($excel,$data,$str,$end);
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();	
    }

    function penjualan_menu($nama_toko,$str,$end,$idkategori){
    	$rekap = $this->transaksi_m->search_menu($str,$end,$idkategori);
    	$data = $this->transaksi_m->search_all_item($str,$end,'menu ASC',$idkategori);

    	$excel = new PHPExcel();
    	$title = "Laporan Penjualan per Menu - ".$nama_toko." tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)));
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Penjualan per Menu","Data Transaksi");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Penjualan per Menu - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:F1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:F2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$kategori = '';
		if($idkategori != ''){
			$kategori = $this->category_m->get_detail($idkategori)->kategori; 
			$subtitle = "";
			if(!empty($kategori))
				$subtitle .= " Kategori : ".$kategori;
			$excel->getActiveSheet()->setCellValue('A3',$subtitle); 
			$excel->getActiveSheet()->mergeCells('A3:F3'); 
			$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); 
			$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14); 
			$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 		
		}

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "MENU");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "KATEGORI");
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "JUMLAH PENJUALAN ITEM"); 
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "TOTAL HARGA PENJUALAN"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		foreach ($rekap as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $d->menu );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->kategori );
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->jumlah);
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->total);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
		}
		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel = $this->setformat($excel,'D4:D'.$numrow);
		$excel = $this->setformat($excel,'E4:E'.$numrow);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap per Menu");
    	
    	//Detail Data//
    	$excel->createSheet(1);
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "Data Penjualan - ".$nama_toko); 
		$this->data_item_penjualan($excel,$data,$str,$end,$kategori);
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();	
    }

    function penjualan_item_daily($nama_toko,$str,$end,$idkategori="",$idmenu=""){
    	$excel = new PHPExcel();
    	$kategori = '';
		$subtitle = "";
		$title = "";
		$menu = "";
		if($idkategori != ''){
    		$rekap = $this->transaksi_m->search_category_daily($str,$end,$idkategori);
    		$data = $this->transaksi_m->search_all_item($str,$end,'date_add ASC',$idkategori);
			$kategori = $this->category_m->get_detail($idkategori)->kategori; 
			if(!empty($kategori)){
				$subtitle .= " Kategori : ".$kategori;
				$title = " (Kategori - $kategori) ";
			}
		} else if($idmenu != ''){
			$rekap = $this->transaksi_m->search_menu_daily($str,$end,$idmenu);
    		$data = $this->transaksi_m->search_all_item($str,$end,'date_add ASC','',$idmenu);
			$menu = $this->menu_m->get_detail($idmenu)->menu; 
			if(!empty($menu)){
				$subtitle .= " Menu : ".$menu;	
				$title = " (Menu - $menu) ";
			}
		}

    	$title = "Laporan Item Penjualan Harian - $title - ".$nama_toko." tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)));
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Item Penjualan Harian","Data Transaksi");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Item Penjualan Harian - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:D1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:D2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$excel->getActiveSheet()->setCellValue('A3',$subtitle); 
		$excel->getActiveSheet()->mergeCells('A3:D3'); 
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 	
		

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "TANGGAL");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "JUMLAH PENJUALAN ITEM"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "TOTAL HARGA PENJUALAN"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$total = 0;
		$jumlah = 0;
		foreach ($rekap as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, PHPExcel_Shared_Date::PHPToExcel( $this->convert_date( $d->tanggal ) ) );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->jumlah);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->total);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$total+=$d->total;
			$jumlah+=$d->jumlah;
		}
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'B'.$numrow); 
		$excel->getActiveSheet()->setCellValue('C'.$numrow, $jumlah);
		$excel->getActiveSheet()->setCellValue('D'.$numrow, $total);
		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		
		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel = $this->setformat($excel,'C4:C'.$numrow);
		$excel = $this->setformat($excel,'D4:D'.$numrow);
		$excel = $this->setformat($excel,'B4:B'.$numrow,'yyyy-mm-dd');

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap per Tanggal");
    	
    	//Detail Data//
    	$excel->createSheet(1);
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "Data Penjualan - ".$nama_toko); 
		if($idkategori != ''){
			$this->data_item_penjualan($excel,$data,$str,$end,$kategori);
		} else if($idmenu != ''){
			$this->data_item_penjualan($excel,$data,$str,$end,'',$menu);
		}
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();	
    }

	public function penjualan(){        
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['tipe']='1';
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");
		$data['tahun'] = $this->input->get('tahun');
		$data['kategori'] = $this->input->get('kategori');
		$data['item_menu'] = $this->input->get('menu');
		if($this->input->get('str')){
			$data['str_date'] = $this->input->get('str');
		}
		if($this->input->get('end')){
			$data['end_date'] = $this->input->get('end');
		}
		if($this->input->get('tipe')){
			$data['tipe'] = $this->input->get('tipe');
		}
		if($data['tipe'] == '1'){
			$this->penjualan_daily($data['toko']->nama_toko,$data['str_date'],$data['end_date']);
		}	
		if($data['tipe'] == '2'){
			$this->penjualan_week($data['toko']->nama_toko,$data['str_date'],$data['end_date']);
		}
		if($data['tipe'] == '3'){
			$this->penjualan_month($data['toko']->nama_toko,$data['tahun']);
		}
		if($data['tipe'] == '4'){
			$this->penjualan_category($data['toko']->nama_toko,$data['str_date'],$data['end_date']);
		}
		if($data['tipe'] == '5'){
			$this->penjualan_menu($data['toko']->nama_toko,$data['str_date'],$data['end_date'],$data['kategori']);
		}
		if($data['tipe'] == '6'){
			$this->penjualan_item_daily($data['toko']->nama_toko,$data['str_date'],$data['end_date'],$data['kategori']);
		}
		if($data['tipe'] == '7'){
			$this->penjualan_item_daily($data['toko']->nama_toko,$data['str_date'],$data['end_date'],'',$data['item_menu']);
		}
	}

	////////////////// PEMBELIAN ///////////////
	function data_pembelian(&$excel,$data,$str,$end){
		$excel->getActiveSheet()->mergeCells('A1:E1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:E2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		
		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "TANGGAL PEMBELIAN");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "FAKTUR"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "BIAYA TAMBAHAN"); 
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "TOTAL TRANSAKSI"); 

		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->setTitle("Data Pembelian");
		$numrow = 5;
		$no=1;
		foreach ($data as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, PHPExcel_Shared_Date::PHPToExcel($this->convert_date( $d->tanggal ) ) );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->faktur_pembelian);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->biaya_tambahan);
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->total);

			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
		}

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel = $this->setformat($excel,'D4:D'.$numrow);
		$excel = $this->setformat($excel,'E4:E'.$numrow);
		$excel = $this->setformat($excel,'B4:B'.$numrow,'yyyy-mm-dd');

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet()->setTitle("Data Penjualan");
	}

	function pembelian_daily($nama_toko,$str,$end){
    	$rekap = $this->pembelian_m->search_daily($str,$end);
    	$data = $this->pembelian_m->search_all($str,$end);
    	$excel = new PHPExcel();
    	$title = "Laporan Pembelian Harian - ".$nama_toko." tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)));
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Pembelian Harian","Data Pembelian");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Pembelian Harian - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:D1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:D2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "TANGGAL");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "JUMLAH TRANSAKSI"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "TOTAL PEMBELIAN"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$total = 0;
		$jumlah = 0;
		foreach ($rekap as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, PHPExcel_Shared_Date::PHPToExcel( $this->convert_date( $d->tanggal ) ) );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->jumlah);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->total);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$total+=$d->total;
			$jumlah+=$d->jumlah;
		}
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'B'.$numrow); 
		$excel->getActiveSheet()->setCellValue('C'.$numrow, $jumlah);
		$excel->getActiveSheet()->setCellValue('D'.$numrow, $total);
		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel = $this->setformat($excel,'C4:C'.$numrow);
		$excel = $this->setformat($excel,'D4:D'.$numrow);
		$excel = $this->setformat($excel,'B4:B'.$numrow,'yyyy-mm-dd');

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap Data Pembelian Harian");
    	
    	//Detail Data//
    	$excel->createSheet(1);
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "Data Pembelian - ".$nama_toko); 
		$this->data_pembelian($excel,$data,$str,$end);
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();	
    }

    function pembelian_week($nama_toko,$str,$end){
    	$rekap = $this->pembelian_m->search_week2($str,$end);

    	$data = $this->pembelian_m->search_all($str,$end,1);
    	$excel = new PHPExcel();
    	$title = "Laporan Pembelian Mingguan - ".$nama_toko." tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)));
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Pembelian Mingguan","Data Pembelian");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Pembelian Mingguan - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:F1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:F2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "TAHUN");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "MINGGU");
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "TANGGAL");
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "JUMLAH TRANSAKSI"); 
		$excel->getActiveSheet()->setCellValue('F'.$coltitle, "TOTAL PEMBELIAN"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$total = 0;
		$jumlah = 0;
		foreach ($rekap as $d) {
			$minggu = $this->getStartAndEndDate($d->minggu, $d->tahun);
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $d->tahun );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->minggu );
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $minggu['week_start'].' - '.$minggu['week_end'] );
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->jumlah);
			$excel->getActiveSheet()->setCellValue('F'.$numrow, $d->total);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$total+=$d->total;
			$jumlah+=$d->jumlah;
		}

		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'D'.$numrow); 
		$excel->getActiveSheet()->setCellValue('E'.$numrow, $jumlah);
		$excel->getActiveSheet()->setCellValue('F'.$numrow, $total);
		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$excel = $this->setformat($excel,'E4:E'.$numrow);
		$excel = $this->setformat($excel,'F4:F'.$numrow);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap Data Pembelian Mingguan");
    	
    	//Detail Data//
    	$excel->createSheet(1);
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "Data Pembelian - ".$nama_toko); 
		$this->data_pembelian($excel,$data,$str,$end);
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();	
    }

    function pembelian_month($nama_toko,$year){
    	$rekap = $this->pembelian_m->search_month($year);

    	$excel = new PHPExcel();
    	$title = "Laporan Pembelian Bulanan - ".$nama_toko." Tahun ".$year;
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Pembelian Bulanan","Data Pembelian");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Pembelian Bulanan - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:F1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tahun ".$year); 
		$excel->getActiveSheet()->mergeCells('A2:F2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "TAHUN");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "BULAN");
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "JUMLAH TRANSAKSI"); 
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "TOTAL Pembelian"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$total = 0;
		$jumlah = 0;
		foreach ($rekap as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $year );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->bulan );
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->item_jumlah );
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->item_total);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$total+=$d->item_total;
			$jumlah+=$d->item_jumlah;
		}
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'C'.$numrow); 
		$excel->getActiveSheet()->setCellValue('D'.$numrow, $jumlah);
		$excel->getActiveSheet()->setCellValue('E'.$numrow, $total);
		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel = $this->setformat($excel,'D4:D'.$numrow);
		$excel = $this->setformat($excel,'E4:E'.$numrow);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap Data Pembelian Bulanan");
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();	
    }

    function data_item_pembelian(&$excel,$data,$str,$end,$bahan=""){
		$excel->getActiveSheet()->mergeCells('A1:G1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:G2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		if( !empty($bahan) ){
			$subtitle = " Bahan : ".$bahan;
			$excel->getActiveSheet()->setCellValue('A3',$subtitle); 
			$excel->getActiveSheet()->mergeCells('A3:G3'); 
			$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); 
			$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14); 
			$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 	
		}
		
		
		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "BAHAN"); 
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "SATUAN"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "TANGGAL");
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "FAKTUR"); 
		$excel->getActiveSheet()->setCellValue('F'.$coltitle, "JUMLAH"); 
		$excel->getActiveSheet()->setCellValue('G'.$coltitle, "HARGA TOTAL"); 

		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('G'.$coltitle)->applyFromArray($this->style_col);
		$numrow = 5;
		$no=1;
		foreach ($data as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $d->nama);
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->satuan);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, PHPExcel_Shared_Date::PHPToExcel($this->convert_date( $d->tanggal ) ) );
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->faktur_pembelian);
			$excel->getActiveSheet()->setCellValue('F'.$numrow, $d->jumlah);
			$excel->getActiveSheet()->setCellValue('G'.$numrow, $d->harga);

			// $excel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$numrow, $d->faktur, PHPExcel_Cell_DataType::TYPE_STRING);
			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($this->style_row);
			// $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
			// $excel->getActiveSheet()->getRowDimension($numrow)->setAutoSize(true);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
		}

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$excel = $this->setformat($excel,'F4:F'.$numrow);
		$excel = $this->setformat($excel,'G4:G'.$numrow);
		$excel = $this->setformat($excel,'D4:D'.$numrow,'yyyy-mm-dd');

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet()->setTitle("Data Item Pembelian");
	}

    function pembelian_bahan($nama_toko,$str,$end){
    	$rekap = $this->pembelian_m->search_bahan($str,$end);
    	$data = $this->pembelian_m->search_all_bahan($str,$end,'nama ASC');

    	$excel = new PHPExcel();
    	$title = "Laporan Pembelian per Bahan - ".$nama_toko." tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)));
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Pembelian per Bahan","Data Pembelian");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Pembelian per Bahan - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:F1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:F2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "BAHAN");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "JUMLAH PEMBELIAN ITEM"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "TOTAL HARGA PEMBELIAN"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		foreach ($rekap as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $d->bahan);
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->jumlah);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->total);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
		}
		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel = $this->setformat($excel,'C4:C'.$numrow);
		$excel = $this->setformat($excel,'D4:D'.$numrow);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap per Bahan");
    	
    	//Detail Data//
    	$excel->createSheet(1);
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "Data Pembelian - ".$nama_toko); 
		$this->data_item_pembelian($excel,$data,$str,$end);
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();	
    }

    function pembelian_bahan_daily($nama_toko,$str,$end,$idbahan=""){
    	$excel = new PHPExcel();
    	$bahan = '';
		$subtitle = "";
		$title = "";
		if($idbahan != ''){
    		$rekap = $this->pembelian_m->search_bahan_daily($str,$end,$idbahan);
    		$data = $this->pembelian_m->search_all_bahan($str,$end,'date_add ASC',$idbahan);
			$bahan = $this->bahan_m->get_detail($idbahan)->nama; 
			if(!empty($bahan)){
				$subtitle .= " Bahan : ".$bahan;
				$title = " (Bahan - $bahan) ";
			}
		}

    	$title = "Laporan Item Pembelian Harian - $title - ".$nama_toko." tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)));
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Item Pembelian Harian","Data Pembelian");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Item Pembelian Harian - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:D1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:D2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$excel->getActiveSheet()->setCellValue('A3',$subtitle); 
		$excel->getActiveSheet()->mergeCells('A3:D3'); 
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 	
		

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "TANGGAL");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "JUMLAH PEMBELIAN ITEM"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "TOTAL HARGA PEMBELIAN"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$total = 0;
		$jumlah = 0;
		foreach ($rekap as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, PHPExcel_Shared_Date::PHPToExcel( $this->convert_date( $d->tanggal ) ) );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->jumlah);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->total);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$total+=$d->total;
			$jumlah+=$d->jumlah;
		}
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'B'.$numrow); 
		$excel->getActiveSheet()->setCellValue('C'.$numrow, $jumlah);
		$excel->getActiveSheet()->setCellValue('D'.$numrow, $total);
		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		
		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel = $this->setformat($excel,'C4:C'.$numrow);
		$excel = $this->setformat($excel,'D4:D'.$numrow);
		$excel = $this->setformat($excel,'B4:B'.$numrow,'yyyy-mm-dd');

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap per Tanggal");
    	
    	//Detail Data//
    	$excel->createSheet(1);
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "Data Pembelian - ".$nama_toko); 
		if($idbahan != ''){
			$this->data_item_pembelian($excel,$data,$str,$end,$bahan);
		}
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();	
    }

	public function pembelian($cetak = ""){        
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Laporan Pembelian';
		$data['tipe']='1';
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");
		if($this->input->get('str')){
			$data['str_date'] = $this->input->get('str');
		}
		if($this->input->get('end')){
			$data['end_date'] = $this->input->get('end');
		}
		if($this->input->get('tipe')){
			$data['tipe'] = $this->input->get('tipe');
		}
		$data['tahun'] = $this->input->get('tahun');
		$data['bahan'] = $this->input->get('bahan');
		if($data['tipe'] == '1'){
			$data['data'] = $this->pembelian_daily($data['toko']->nama_toko,$data['str_date'],$data['end_date']);
		}
		if($data['tipe'] == '2'){
			$data['data'] = $this->pembelian_week($data['toko']->nama_toko,$data['str_date'],$data['end_date']);
		}
		if($data['tipe'] == '3'){
			$data['data'] = $this->pembelian_month($data['toko']->nama_toko,$data['tahun']);
		}
		if($data['tipe'] == '4'){
			$data['data'] = $this->pembelian_bahan($data['toko']->nama_toko,$data['str_date'],$data['end_date']);
		}
		if($data['tipe'] == '5'){
			$data['data'] = $this->pembelian_bahan_daily($data['toko']->nama_toko,$data['str_date'],$data['end_date'],$data['bahan']);
		}
	}

	//////////// CASHFLOW /////////////

	function data_cashflow(&$excel,$data,$str,$end,$akun=""){
		$excel->getActiveSheet()->mergeCells('A1:G1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:G2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		
		if( !empty($akun) ){
			$subtitle = " Akun : ".$akun;
			$excel->getActiveSheet()->setCellValue('A3',$subtitle); 
			$excel->getActiveSheet()->mergeCells('A3:G3'); 
			$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); 
			$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14); 
			$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 	
		}

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "TANGGAL");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "FAKTUR TRANSAKSI");
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "NAMA AKUN"); 
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "JENIS"); 
		$excel->getActiveSheet()->setCellValue('F'.$coltitle, "PEMASUKAN"); 
		$excel->getActiveSheet()->setCellValue('G'.$coltitle, "PENGELUARAN"); 

		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('G'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->setTitle("Data Cashflow");

		$debit=0;
		$kredit=0;
		$numrow = 5;
		$no=1;
		foreach ($data as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, PHPExcel_Shared_Date::PHPToExcel($this->convert_date( $d->tanggal ) ) );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->faktur);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->nama_akun);
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->jenis);
			$excel->getActiveSheet()->setCellValue('F'.$numrow, $d->debit);
			$excel->getActiveSheet()->setCellValue('G'.$numrow, $d->kredit);

			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$debit+=$d->debit;
			$kredit+=$d->kredit;
		}
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'E'.$numrow); 
		$excel->getActiveSheet()->setCellValue('F'.$numrow, $debit);
		$excel->getActiveSheet()->setCellValue('G'.$numrow, $kredit);

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($this->style_col);
		
		$numrow++;
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL (PEMASUKAN - PENGELUARAN)');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'E'.$numrow); 
		$excel->getActiveSheet()->setCellValue('F'.$numrow, ( $debit - $kredit) );
		$excel->getActiveSheet()->mergeCells('F'.$numrow.':'.'G'.$numrow); 

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($this->style_col);

		
		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

		$excel = $this->setformat($excel,'F4:F'.$numrow);
		$excel = $this->setformat($excel,'G4:G'.$numrow);
		$excel = $this->setformat($excel,'B4:B'.$numrow,'yyyy-mm-dd');

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet()->setTitle("Data Cashflow");
	}

	function cashflow_daily($nama_toko,$str,$end,$jenis=""){
		$rekap = $this->cashflow_m->search_daily($str,$end);
    	$data = $this->cashflow_m->search_all($str,$end,'tanggal ASC');
    	$excel = new PHPExcel();
    	$title = "Laporan Cashflow Harian - ".$nama_toko." tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)));
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Cashflow Harian","Data Cashflow");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Cashflow Harian - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:D1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:D2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "TANGGAL");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "PEMASUKAN"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "PENGELUARAN"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$pemasukan = 0;
		$pengeluaran = 0;
		foreach ($rekap as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, PHPExcel_Shared_Date::PHPToExcel( $this->convert_date( $d->tanggal ) ) );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->pemasukan);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->pengeluaran);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$pemasukan+=$d->pemasukan;
			$pengeluaran+=$d->pengeluaran;
		}
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'B'.$numrow); 
		$excel->getActiveSheet()->setCellValue('C'.$numrow, $pemasukan);
		$excel->getActiveSheet()->setCellValue('D'.$numrow, $pengeluaran);
		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);

		$numrow++;
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL (PEMASUKAN - PENGELUARAN)');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'B'.$numrow); 
		$excel->getActiveSheet()->setCellValue('C'.$numrow, ($pemasukan-$pengeluaran) );
		$excel->getActiveSheet()->mergeCells('C'.$numrow.':'.'D'.$numrow); 

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel = $this->setformat($excel,'C4:C'.$numrow);
		$excel = $this->setformat($excel,'D4:D'.$numrow);
		$excel = $this->setformat($excel,'B4:B'.$numrow,'yyyy-mm-dd');

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap Data Cashflow Harian");
    	
    	//Detail Data//
    	$excel->createSheet(1);
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "Data Cashflow - ".$nama_toko); 
		$this->data_cashflow($excel,$data,$str,$end);
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();		
	}

	function cashflow_week($nama_toko,$str,$end,$jenis=""){
    	$rekap = $this->cashflow_m->search_week2($str,$end);
    	$data = $this->cashflow_m->search_all($str,$end,' tanggal ASC ');
    	$excel = new PHPExcel();
    	$title = "Laporan Cashflow Mingguan - ".$nama_toko." tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)));
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Cashflow Mingguan","Data Cashflow");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Cashflow Mingguan - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:F1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:F2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "TAHUN");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "MINGGU");
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "TANGGAL");
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "PEMASUKAN"); 
		$excel->getActiveSheet()->setCellValue('F'.$coltitle, "PENGELUARAN"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$pemasukan = 0;
		$pengeluaran = 0;
		foreach ($rekap as $d) {
			$minggu = $this->getStartAndEndDate($d->minggu, $d->tahun);
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $d->tahun );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->minggu );
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $minggu['week_start'].' - '.$minggu['week_end'] );
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->pemasukan);
			$excel->getActiveSheet()->setCellValue('F'.$numrow, $d->pengeluaran);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$pemasukan+=$d->pemasukan;
			$pengeluaran+=$d->pengeluaran;
		}

		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'D'.$numrow); 
		$excel->getActiveSheet()->setCellValue('E'.$numrow, $pemasukan);
		$excel->getActiveSheet()->setCellValue('F'.$numrow, $pengeluaran);
		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_col);

		$numrow++;
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL (PEMASUKAN - PENGELUARAN)');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'D'.$numrow); 
		$excel->getActiveSheet()->setCellValue('E'.$numrow, ($pemasukan-$pengeluaran) );
		$excel->getActiveSheet()->mergeCells('E'.$numrow.':'.'F'.$numrow); 

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($this->style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$excel = $this->setformat($excel,'E4:E'.$numrow);
		$excel = $this->setformat($excel,'F4:F'.$numrow);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap Data Cashflow Mingguan");
    	
    	//Detail Data//
    	$excel->createSheet(1);
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "Data Cashflow - ".$nama_toko); 
		$this->data_cashflow($excel,$data,$str,$end);
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();	
    }

    function cashflow_month($nama_toko,$year,$jenis=""){
    	$rekap = $this->cashflow_m->search_month($year);

    	$excel = new PHPExcel();
    	$title = "Laporan Cashflow Bulanan - ".$nama_toko." Tahun ".$year;
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Cashflow Bulanan","Data Cashflow");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Cashflow Bulanan - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:F1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tahun ".$year); 
		$excel->getActiveSheet()->mergeCells('A2:F2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "TAHUN");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "BULAN");
		$excel->getActiveSheet()->setCellValue('E'.$coltitle, "PEMASUKAN"); 
		$excel->getActiveSheet()->setCellValue('F'.$coltitle, "PENGELUARAN"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$pemasukan = 0;
		$pengeluaran = 0;
		foreach ($rekap as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $year );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->bulan );
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->pemasukan );
			$excel->getActiveSheet()->setCellValue('E'.$numrow, $d->pengeluaran);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$pemasukan+=$d->pemasukan;
			$pengeluaran+=$d->pengeluaran;
		}
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'C'.$numrow); 
		$excel->getActiveSheet()->setCellValue('D'.$numrow, $pemasukan);
		$excel->getActiveSheet()->setCellValue('E'.$numrow, $pengeluaran);
		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_col);

		$numrow++;
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL (PEMASUKAN - PENGELUARAN)');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'C'.$numrow); 
		$excel->getActiveSheet()->setCellValue('D'.$numrow, ($pemasukan-$pengeluaran) );
		$excel->getActiveSheet()->mergeCells('D'.$numrow.':'.'E'.$numrow); 

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($this->style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$excel = $this->setformat($excel,'D4:D'.$numrow);
		$excel = $this->setformat($excel,'E4:E'.$numrow);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap Data Cashflow Bulanan");
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();	
    }

    function cashflow_akun($nama_toko,$str,$end,$jenis=""){
    	$rekap = $this->cashflow_m->search_akun($str,$end);
    	$data = $this->cashflow_m->search_all($str,$end,' tanggal ASC ');

    	$excel = new PHPExcel();
    	$title = "Laporan Cashflow per Bahan - ".$nama_toko." tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)));
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Cashflow per Bahan","Data Cashflow");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Cashflow per Bahan - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:F1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:F2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "AKUN");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "PEMASUKAN"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "PENGELUARAN"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$pemasukan = 0;
		$pengeluaran = 0;
		foreach ($rekap as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, $d->akun);
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->pemasukan);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->pengeluaran);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$pemasukan+=$d->pemasukan;
			$pengeluaran+=$d->pengeluaran;
		}
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'B'.$numrow); 
		$excel->getActiveSheet()->setCellValue('C'.$numrow, $pemasukan);
		$excel->getActiveSheet()->setCellValue('D'.$numrow, $pengeluaran);
		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);

		$numrow++;
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL (PEMASUKAN - PENGELUARAN)');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'B'.$numrow); 
		$excel->getActiveSheet()->setCellValue('C'.$numrow, ($pemasukan-$pengeluaran) );
		$excel->getActiveSheet()->mergeCells('C'.$numrow.':'.'D'.$numrow); 

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);

		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel = $this->setformat($excel,'C4:C'.$numrow);
		$excel = $this->setformat($excel,'D4:D'.$numrow);

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap per Akun");
    	
    	//Detail Data//
    	$excel->createSheet(1);
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "Data Cashflow - ".$nama_toko); 
		$this->data_cashflow($excel,$data,$str,$end);
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();	
    }

    function cashflow_akun_daily($nama_toko,$str,$end,$akun="",$jenis=""){
    	$excel = new PHPExcel();
    	$bahan = '';
		$subtitle = "";
		$title = "";
		if($akun != ''){
    		$rekap = $this->cashflow_m->search_akun_daily($str,$end,$akun);
    		$data = $this->cashflow_m->search_all($str,$end,' tanggal ASC ',$akun);
			$subtitle .= " Akun : ".$akun;
			$title = " (Akun - $akun) ";
		}

    	$title = "Laporan Akun Cashflow Harian - $title - ".$nama_toko." tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)));
    	$excel = $this->excelTitle($excel,$nama_toko,$title,"Laporan Akun Cashflow Harian","Data Cashflow");
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Rekap Akun Cashflow Harian - ".$nama_toko); 
		$excel->getActiveSheet()->mergeCells('A1:D1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->setCellValue('A2'," Tanggal ".(date("d-m-Y",strtotime($str)))." sd ".(date("d-m-Y",strtotime($end)))); 
		$excel->getActiveSheet()->mergeCells('A2:D2'); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$excel->getActiveSheet()->setCellValue('A3',$subtitle); 
		$excel->getActiveSheet()->mergeCells('A3:D3'); 
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14); 
		$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 	
		

		$coltitle = 4;
		$excel->getActiveSheet()->setCellValue('A'.$coltitle, "NO"); 
		$excel->getActiveSheet()->setCellValue('B'.$coltitle, "TANGGAL");
		$excel->getActiveSheet()->setCellValue('C'.$coltitle, "PEMASUKAN"); 
		$excel->getActiveSheet()->setCellValue('D'.$coltitle, "PENGELUARAN"); 
		$excel->getActiveSheet()->getStyle('A'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$coltitle)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$coltitle)->applyFromArray($this->style_col);

		$numrow = 5;
		$no=1;	
		$pemasukan = 0;
		$pengeluaran = 0;
		foreach ($rekap as $d) {
			$excel->getActiveSheet()->setCellValue('A'.$numrow, $no);
			$excel->getActiveSheet()->setCellValue('B'.$numrow, PHPExcel_Shared_Date::PHPToExcel( $this->convert_date( $d->tanggal ) ) );
			$excel->getActiveSheet()->setCellValue('C'.$numrow, $d->pemasukan);
			$excel->getActiveSheet()->setCellValue('D'.$numrow, $d->pengeluaran);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++;
			$pemasukan+=$d->pemasukan;
			$pengeluaran+=$d->pengeluaran;
		}
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'B'.$numrow); 
		$excel->getActiveSheet()->setCellValue('C'.$numrow, $pemasukan);
		$excel->getActiveSheet()->setCellValue('D'.$numrow, $pengeluaran);
		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);

		$numrow++;
		$excel->getActiveSheet()->setCellValue('A'.$numrow, 'TOTAL (PEMASUKAN - PENGELUARAN)');
		$excel->getActiveSheet()->mergeCells('A'.$numrow.':'.'B'.$numrow); 
		$excel->getActiveSheet()->setCellValue('C'.$numrow, ($pemasukan-$pengeluaran) );
		$excel->getActiveSheet()->mergeCells('C'.$numrow.':'.'D'.$numrow); 

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($this->style_col);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($this->style_col);
		
		$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$excel = $this->setformat($excel,'C4:C'.$numrow);
		$excel = $this->setformat($excel,'D4:D'.$numrow);
		$excel = $this->setformat($excel,'B4:B'.$numrow,'yyyy-mm-dd');

		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Rekap per Tanggal");
    	
    	//Detail Data//
    	$excel->createSheet(1);
		$excel->setActiveSheetIndex(1)->setCellValue('A1', "Data Cashflow - ".$nama_toko); 
		if($akun != ''){
			$this->data_cashflow($excel,$data,$str,$end,$akun);
		}
		$excel->setActiveSheetIndex(0);

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		if (ob_get_contents()) ob_end_clean();
		$write->save('php://output');
		exit();	
    }

	public function cashflow(){        
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['menu']='laporan-cashflow';
		$data['tipe']='1';
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");
		if($this->input->get('str')){
			$data['str_date'] = $this->input->get('str');
		}
		if($this->input->get('end')){
			$data['end_date'] = $this->input->get('end');
		}
		if($this->input->get('tipe')){
			$data['tipe'] = $this->input->get('tipe');
		}
		$data['jenis'] = $this->input->get('jenis');
		$data['tahun'] = $this->input->get('tahun');
		$data['akun'] = $this->input->get('akun');
		if($data['tipe'] == '1'){
			$data['data'] = $this->cashflow_daily($data['toko']->nama_toko,$data['str_date'],$data['end_date'],$data['jenis']);
		}
		if($data['tipe'] == '2'){
			$data['data'] = $this->cashflow_week($data['toko']->nama_toko,$data['str_date'],$data['end_date'],$data['jenis']);
		}
		if($data['tipe'] == '3'){
			$data['data'] = $this->cashflow_month($data['toko']->nama_toko,$data['tahun'],$data['jenis']);
		}
		if($data['tipe'] == '4'){
			$data['data'] = $this->cashflow_akun($data['toko']->nama_toko,$data['str_date'],$data['end_date'],$data['jenis']);
		}
		if($data['tipe'] == '5'){
			$data['data'] = $this->cashflow_akun_daily($data['toko']->nama_toko,$data['str_date'],$data['end_date'],$data['akun'],$data['jenis']);
		}
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
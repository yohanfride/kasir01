<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require __DIR__ . '/../vendor/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\RawbtPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;

class cetak extends CI_Controller {

	public function __construct() {
        parent::__construct();        
		$this->load->model('transaksi_m');
		$this->load->library("item");  
        $this->load->model('toko_m');
    }

    function tanggal_indo($tanggal){
		$bulan = array (1 =>   'Januari',
					'Feb',
					'Mar',
					'Apr',
					'Mei',
					'Jun',
					'Jul',
					'Agu',
					'Sep',
					'Okt',
					'Nov',
					'Des'
				);
		$split = explode(' ', $tanggal);
		return $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
	}

    public function index(){        
		$data=array();
		$this->load->view('print_test', $data);
	}

	function split_versi1($text){
		$catatan = explode("\n", $text);
		$list = array();
		foreach ($catatan as $val) {
			if(strlen($val)<31){
				$list[] = $val;
			} else {
				$list_item = explode(" ", $val);
				$partial = "";
				foreach ($list_item as $val_item) {
					if($partial==""){
						$partial = $val_item;
					} else {
						$cekpartial = $partial." ".$val_item;
						if(strlen($cekpartial)<32){
							$partial.=" ".$val_item;
						} else {
							$list[] = $partial;
							$partial = $val_item;
						}
					}		
				}
				$list[] = $partial;
			}	 
		}
		return $list;
	}

	function split_versi2($text){
		$catatan = preg_replace('~[\r\n]+~', ', ', $text);
		$list = array();
		$list_item = explode(" ", $catatan);
		$partial = "";
		foreach ($list_item as $val_item) {
			if($partial==""){
				$partial = $val_item;
			} else {
				$cekpartial = $partial." ".$val_item;
				if(strlen($cekpartial)<31){
					$partial.=" ".$val_item;
				} else {
					$list[] = $partial;
					$partial = $val_item;
				}
			}		
		}
		$list[] = $partial;
		return $list;
	}

	// public function cek($faktur){
	// 	$transaksi = $this->transaksi_m->get_detail($faktur);
	// 	// $toko = $this->toko_m->get();
	// 	// $footer = explode("\n", $toko->footer_struk);
	// 	// echo "<pre>";
	// 	// print_r($footer);
	// 	// echo "</pre>";
	// 	// foreach ($footer as $val) {
	//  //        echo strlen($val).'<br/>'; 	    		
	// 	$list = $this->split_versi1($transaksi->catatan);
	// 	echo "<pre>";
	// 	print_r($list);
	// 	echo "</pre>";
	// 	echo "<br/>";
	// 	$list = $this->split_versi2($transaksi->catatan);
	// 	echo "<pre>";
	// 	print_r($list);
	// 	echo "</pre>";
	// }

	public function ajax_transkasi($faktur){     
		$transaksi = $this->transaksi_m->get_detail($faktur);
		$toko = $this->toko_m->get();

		$profile = CapabilityProfile::load("POS-5890");

	    /* Fill in your own connector here */
	    // try {
	    // 	$connector = new WindowsPrintConnector("smb://LAPTOP-LLDFOTC6/POS58");
	    // 	$printer = new Printer($connector, $profile);
	    // } catch(Exception $e) {
	    	// $connector = new RawbtPrintConnector();
	    	// $printer = new Printer($connector, $profile);
	    // }

		try {
		    /* Information for the receipt */
		    $connector = new RawbtPrintConnector();
	    	$printer = new Printer($connector, $profile);
		    $items = array();
		    $total = 0;
		    $jumlah = 0;
		    $diskon = 0; $i=0;
		    $items_diskon = array();
		    foreach ($transaksi->item_penjualan as $d) {
		    	$items[] = new item($d->menu,$d->harga,$d->jumlah);
		    	$itemdiskon = $d->diskon;
		    	if(empty($itemdiskon))
		    		$itemdiskon = 0;
		    	if($itemdiskon > 0){
		    		$items_diskon[$i] = new item2('','(-'.number_format($d->diskon,0,'.',',').')');
		    	} else {
		    		$items_diskon[$i] = '';
		    	}
		    	$total += ($d->harga * $d->jumlah);
		    	$diskon+= $itemdiskon;
		    	$jumlah += $d->jumlah;
		    	$i++;
		    }
		    $pembulatan = 0;
		    $total_semua = $transaksi->total;
		    if($total_semua != ($total - $diskon) ){
		    	$pembulatan = ($total - $diskon) - $total_semua;
		    }
		    $subtotal = new item2('Subtotal', number_format($total,0,'.',',') );
		    $diskon = new item2('Diskon', number_format($diskon,0,'.',',') );
		    if($pembulatan>0){
		    	$pembulatans = new item2('Pembulatan', number_format($pembulatan,0,'.',',') );
		    } else {
		    	$pembulatans = '';
		    }
		    // $tax = new item('A local tax', '1.30');
		    $total = new item2('Total', number_format($total_semua,0,'.',','), false,18);
		    
		    /* Date is kept the same for testing */
			// $date = date('l jS \of F Y h:i:s A');
		    $logo = EscposImage::load("assets/upload/toko/".$toko->logo_struk, false);
		    $date = new item2($this->tanggal_indo( date_format(date_create($transaksi->date_add), 'd m Y') ), date_format(date_create($transaksi->date_add), 'H:i:s'),false,18);
		    $faktur = new item2('No. Faktur:', $transaksi->faktur, false,18);
		    $metode = new item2('Metode Pembayaran:', $transaksi->metode_bayar, false,14);
		    $order_by = new item2('Pelanggan:', $transaksi->order_by, false,14);
		    // $catatan1 = new item2('Catatan:','', false,14);
		    // $catatan2 = new item2($transaksi->catatan,'', false,14);
		    $catatan = $this->split_versi2($transaksi->catatan);
		    $footer = explode("\n", $toko->footer_struk);
		    /* Start the printer */

		    $printer->setJustification(Printer::JUSTIFY_CENTER);
		    /* Print top logo */
		    if ($profile->getSupportsGraphics()) {
		        $printer->graphics($logo);
		    }
		    if ($profile->getSupportsBitImageRaster() && !$profile->getSupportsGraphics()) {
		        $printer->bitImage($logo);
		    }
		    
		    // /* Name of shop */
		    $printer->setJustification(Printer::JUSTIFY_CENTER);
		    // $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
		    $printer->selectPrintMode();
		    $printer->setEmphasis(true);
		    $printer->text(strtoupper("$toko->nama_toko\n"));
		    $printer->setEmphasis(false);
		    $printer->text("$toko->alamat\n");
		    $printer->text("$toko->no_telepon\n");
		    $printer->text("--------------------------------\n");
		    $printer->feed();

		    $printer->setJustification(Printer::JUSTIFY_LEFT);
		    $printer->text($date->getAsString(32));
		    $printer->text($faktur->getAsString(32));
		    $printer->text($order_by->getAsString(32));
		    $printer->text($metode->getAsString(32));
		    $printer->text("Catatan:\n");
		    foreach ($catatan as $val) {
		        $printer->text($val."\n"); 
		    }
		    $printer->text("--------------------------------\n");
		   	$i=0;
		   	foreach ($items as $item) {
		        $printer->text($item->getAsString(32)); 
		        if($items_diskon[$i]){
		   			$printer->text($items_diskon[$i]->getAsString(32));
		        }
		        $i++;
		    }
		    $printer->setEmphasis(true);
		    $printer->text($subtotal->getAsString(32));
		    $printer->text($diskon->getAsString(32));
		    if($pembulatans){
		    	$printer->text($pembulatans->getAsString(32));
			}
		    $printer->setEmphasis(false);
		    $printer->text("--------------------------------\n");
		    $printer->feed();

		    /* Tax and total */
		    // $printer->text($tax->getAsString(32));
		    $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
		    // $printer->setEmphasis(true);
		    $printer->text($total->getAsString(32,true));
		    
		    // $printer->text($total->getAsStringLeft(32)."\n");
		    // $printer->setEmphasis(false);
		    // $printer->selectPrintMode();
		    // $printer->text($total->getAsStringRight(32,0,true,true)."\n");
		    $printer->selectPrintMode();

		    $printer->feed(2);
		    $printer->setJustification(Printer::JUSTIFY_CENTER);
		    foreach ($footer as $val) {
		        $printer->text($val."\n"); 
		    }
		    $printer->cut();
		    $printer->pulse();

		} catch (Exception $e) {
		    echo $e->getMessage();
		} finally {
		    $printer->close();
		}

	}

	public function ajax_print($f){     
		$this->load->library("item");  
		try {
		    $profile = CapabilityProfile::load("POS-5890");

		    /* Fill in your own connector here */
		    $connector = new RawbtPrintConnector();

		    /* Information for the receipt */
		    $items = array(
		        new item("Example item #1", "4.00"),
		        new item("Another thing", "3.50"),
		        new item("Something else", "1.00"),
		        new item("A final item", "4.45"),
		    );
		    $subtotal = new item('Subtotal', '12.95');
		    $tax = new item('A local tax', '1.30');
		    $total = new item('Total', '14.25', true);
		    /* Date is kept the same for testing */
			// $date = date('l jS \of F Y h:i:s A');
		    $date = "Monday 6th of April 2015 02:56:25 PM";

		    /* Start the printer */
		    $logo = EscposImage::load("assets/upload/toko/coffee-logo-png-7525.png", false);
		    $printer = new Printer($connector, $profile);

		    $printer->setJustification(Printer::JUSTIFY_CENTER);
		    /* Print top logo */
		    if ($profile->getSupportsGraphics()) {
		        $printer->graphics($logo);
		    }
		    if ($profile->getSupportsBitImageRaster() && !$profile->getSupportsGraphics()) {
		        $printer->bitImage($logo);
		    }
		    $printer->feed();
		    
		    // /* Name of shop */
		    $printer->setJustification(Printer::JUSTIFY_CENTER);
		    $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
		    $printer->text("ExampleMart Ltd.\n");
		    $printer->selectPrintMode();
		    $printer->text("Shop No. 42.\n");
		    $printer->feed();


		    // /* Title of receipt */
		    // $printer->setEmphasis(true);
		    // $printer->text("SALES INVOICE\n");
		    // $printer->setEmphasis(false);

		    // /* Items */
		    // $printer->setJustification(Printer::JUSTIFY_LEFT);
		    // $printer->setEmphasis(true);
		    // $printer->text(new item('', '$'));
		    // $printer->setEmphasis(false);
		    // foreach ($items as $item) {
		    //     $printer->text($item->getAsString(32)); // for 58mm Font A
		    // }
		    // $printer->setEmphasis(true);
		    // $printer->text($subtotal->getAsString(32));
		    // $printer->setEmphasis(false);
		    // $printer->feed();

		    // /* Tax and total */
		    // $printer->text($tax->getAsString(32));
		    // $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
		    // $printer->text($total->getAsString(32));
		    // $printer->selectPrintMode();

		    // /* Footer */
		    // $printer->feed(2);
		    // $printer->setJustification(Printer::JUSTIFY_CENTER);
		    // $printer->text("Thank you for shopping\n");
		    // $printer->text("at ExampleMart\n");
		    // $printer->text("For trading hours,\n");
		    // $printer->text("please visit example.com\n");
		    // $printer->feed(2);
		    // $printer->text($date . "\n");

		    /* Barcode Default look */
		    // $printer->barcode("ABC", Printer::BARCODE_CODE39);
		    // $printer->feed();
		    // $printer->feed();
			// Demo that alignment QRcode is the same as text
		    // $printer2 = new Printer($connector); // dirty printer profile hack !!
		    // $printer2->setJustification(Printer::JUSTIFY_CENTER);
		    // $printer2->qrCode("https://rawbt.ru/mike42", Printer::QR_ECLEVEL_M, 8);
		    // $printer2->text("rawbt.ru/mike42\n");
		    // $printer2->setJustification();
		    // $printer2->feed();

		    /* Cut the receipt and open the cash drawer */
		    $printer->cut();
		    $printer->pulse();

		} catch (Exception $e) {
		    echo $e->getMessage();
		} finally {
		    $printer->close();
		}

	}

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
// try {
		//     $profile = CapabilityProfile::load("POS-5890");

		//     ////Fill in your own connector here */
		//     $connector = new RawbtPrintConnector();

		//     ////Information for the receipt */
		//     $items = array(
		//         new item("Example item #1", "4.00"),
		//         new item("Another thing", "3.50"),
		//         new item("Something else", "1.00"),
		//         new item("A final item", "4.45"),
		//     );
		//     $subtotal = new item('Subtotal', '12.95');
		//     $tax = new item('A local tax', '1.30');
		//     $total = new item('Total', '14.25', true);
		//     ////Date is kept the same for testing */
		// 	// $date = date('l jS \of F Y h:i:s A');
		//     $date = "Monday 6th of April 2015 02:56:25 PM";

		//     ////Start the printer */
		//     $logo = EscposImage::load("assets/upload/toko/coffee-logo-png-7525.png", false);
		//     $printer = new Printer($connector, $profile);


		//     ////Print top logo */
		//     if ($profile->getSupportsGraphics()) {
		//         $printer->graphics($logo);
		//     }
		//     if ($profile->getSupportsBitImageRaster() && !$profile->getSupportsGraphics()) {
		//         $printer->bitImage($logo);
		//     }

		//     /// Name of shop */
		//     $printer->setJustification(Printer::JUSTIFY_CENTER);
		//     $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
		//     $printer->text("ExampleMart Ltd.\n");
		//     $printer->selectPrintMode();
		//     $printer->text("Shop No. 42.\n");
		//     $printer->feed();


		//     ////Title of receipt 
		//     $printer->setEmphasis(true);
		//     $printer->text("SALES INVOICE\n");
		//     $printer->setEmphasis(false);

		//     //// Items 
		//     $printer->setJustification(Printer::JUSTIFY_LEFT);
		//     $printer->setEmphasis(true);
		//     $printer->text(new item('', '$'));
		//     $printer->setEmphasis(false);
		//     foreach ($items as $item) {
		//         $printer->text($item->getAsString(32)); // for 58mm Font A
		//     }
		//     $printer->setEmphasis(true);
		//     $printer->text($subtotal->getAsString(32));
		//     $printer->setEmphasis(false);
		//     $printer->feed();

		//     //// Tax and total */
		//     $printer->text($tax->getAsString(32));
		//     $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
		//     $printer->text($total->getAsString(32));
		//     $printer->selectPrintMode();

		//     //// Footer */
		//     $printer->feed(2);
		//     $printer->setJustification(Printer::JUSTIFY_CENTER);
		//     $printer->text("Thank you for shopping\n");
		//     $printer->text("at ExampleMart\n");
		//     $printer->text("For trading hours,\n");
		//     $printer->text("please visit example.com\n");
		//     $printer->feed(2);
		//     $printer->text($date . "\n");

		//     //// Barcode Default look */

		//     $printer->barcode("ABC", Printer::BARCODE_CODE39);
		//     $printer->feed();
		//     $printer->feed();


		// 	// Demo that alignment QRcode is the same as text
		//     $printer2 = new Printer($connector); // dirty printer profile hack !!
		//     $printer2->setJustification(Printer::JUSTIFY_CENTER);
		//     $printer2->qrCode("https://rawbt.ru/mike42", Printer::QR_ECLEVEL_M, 8);
		//     $printer2->text("rawbt.ru/mike42\n");
		//     $printer2->setJustification();
		//     $printer2->feed();


		//     //// Cut the receipt and open the cash drawer */
		//     $printer->cut();
		//     $printer->pulse();
		// } catch (Exception $e) {
		//     echo $e->getMessage();
		// } finally {
		//     $printer->close();
		// }

		/* A wrapper to do organise item names & prices into columns */

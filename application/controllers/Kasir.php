<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kasir extends CI_Controller {

	public function __construct() {
        parent::__construct();   
		if(!$this->session->userdata('kasir01')) 
			redirect(base_url() . "auth/login");
		$user = $this->session->userdata('kasir01');
        if($user->role != 'kasir')
			redirect(base_url() . "auth/login");
        $this->load->model('toko_m');
        $this->load->model('category_m');
		$this->load->model('menu_m');
		$this->load->model('transaksi_m');
		$this->load->model('cashflow_m');
    }

    function randomString($n) { 
	    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
	    $randomString = ''; 
	    for ($i = 0; $i < $n; $i++) { 
	        $index = rand(0, strlen($characters) - 1); 
	        $randomString .= $characters[$index]; 
	    } 
	    return $randomString; 
	}

	public function index()
	{        
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Kasir';
		$data['transaksi'] = $this->session->userdata('cart');
		if(!isset($data['transaksi']->faktur)){
			$firstday = date('Y-m-1'); // hard-coded '01' for first day
			$lastday  = date('Y-m-t');
			$faktur = $this->transaksi_m->get_faktur($firstday,$lastday);
			///Faktur, tahun(2), bulan(2), '-'total transaksi(5), huruf Random (1)
			if($faktur){
				$total_transaksi = (int) substr($faktur->faktur, -6, -1);
				$total_transaksi++;
				$total_transaksi  =  sprintf("%05d", $total_transaksi);
			} else {
				$total_transaksi = '00001';
			}
			$tahun = substr(date('Y'), -2);
			$bulan = sprintf("%02d", (int)date('m'));
			$random = $this->randomString(1);
			$cart = array(
				'faktur' =>  $tahun.$bulan.'-'.$total_transaksi.$random,
				'item_penjualan' => array(),
				'catatan' =>'', 
				'meja' => ''
			);
			$data['transaksi'] = (object) $cart;
			$this->session->set_userdata('cart',$cart);
		}
		$data['transaksi'] = (object) $data['transaksi'];		
		$data['menu'] = $this->menu_m->search('','',1);
		$data['kategori'] = $this->menu_m->get_kategori(1);
		$this->load->view('kasir/index_v', $data);
	}	


	public function api_menu(){
		$data=array();
		$data['s'] = $this->input->post('s'); 
		$data['kategori'] = $this->input->post('kategori'); 
		$data['menu'] = $this->menu_m->search($data['s'],$data['kategori'],1);
		$this->load->view('kasir/api_menu_v', $data);
	}

	public function api_tambah_menu($id){
		$data=array();
		$data['transaksi'] = (object)$this->session->userdata('cart');
		if($data['transaksi']){
			$menu = $this->menu_m->get_detail($id);
			if($menu){
				if(!isset($data['transaksi']->item_penjualan)){
					$data['transaksi']->item_penjualan = array(); 
				}

				if(!isset($data['transaksi']->item_penjualan[$id])){
				 	$data['transaksi']->item_penjualan[$id] = array(
				 		'nama' => $menu->menu,
				 		'harga' => $menu->harga,
				 		'jumlah' => 1
				 	); 	
				} else {
				 	$data['transaksi']->item_penjualan[$id]['jumlah']++; 	
				}
			}	
		}
		$this->session->set_userdata('cart',$data['transaksi']);
		$this->load->view('kasir/api_cart_v', $data);
	}

	public function api_kurang_menu($id){
		$data=array();
		$data['transaksi'] = (object)$this->session->userdata('cart');
		if($data['transaksi']){
			$menu = $this->menu_m->get_detail($id);
			if($menu){
				if(isset($data['transaksi']->item_penjualan)){
					if(isset($data['transaksi']->item_penjualan[$id])){
						$data['transaksi']->item_penjualan[$id]['jumlah']--;
						if($data['transaksi']->item_penjualan[$id]['jumlah'] == 0){
							unset($data['transaksi']->item_penjualan[$id]);
						}  
					}	
				} 	
			}	
		}
		$this->session->set_userdata('cart',$data['transaksi']);
		$this->load->view('kasir/api_cart_v', $data);
	}


	public function pembayaran(){
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Pembayaran';
		$data['transaksi'] = $this->session->userdata('cart');
		if($this->input->post('save')){
			$data['transaksi']->catatan = $this->input->post('catatan');
			$data['transaksi']->meja = $this->input->post('meja');
			$this->session->set_userdata('cart',$data['transaksi']);
		}
		$data['transaksi'] = (object) $data['transaksi'];
		if(!isset($data['transaksi']->faktur))
			redirect(base_url());
		$this->load->view('kasir/pembayaran_v', $data);
	}

	public function pembayaran_ajax(){
		$data=array();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['transaksi'] = $this->session->userdata('cart');
		$input = array(
    		"faktur" => $data['transaksi']->faktur,
    		"total" => preg_replace("/[^0-9 ]/", "", $this->input->post('total') ),
    		"bayar" => preg_replace("/[^0-9 ]/", "", $this->input->post('bayar') ),
    		"status_bayar" => 1,
			"catatan" => $this->input->post('catatan'),
			"meja" => $this->input->post('meja'),
			"metode_bayar" => $this->input->post('metode_bayar'),
			"nama_kasir" => $data['user_now']->name,
			"add_by" => $data['user_now']->user_id
    	);
    	$respo = $this->transaksi_m->insert('penjualan',$input);
        if($respo){             
        	$item_penjualan = $data['transaksi']->item_penjualan; 
        	foreach ($item_penjualan as $key => $value) {
        		$input = array(
        			'faktur' => $data['transaksi']->faktur,
        			'idmenu' => $key,
        			'harga' => $value['harga'],
        			'jumlah' => $value['jumlah']
        		);
    			$respo = $this->transaksi_m->insert('item_penjualan',$input);
        	}
        	$this->session->unset_userdata('cart');
        	$input = array(
        		'tanggal' => date('Y-m-d H:i:s'),
        		'faktur' => $data['transaksi']->faktur,
        		'nama_akun' => 'PENJUALAN',
        		'jenis' => 'PEMASUKAN',
        		'debit' =>  preg_replace("/[^0-9 ]/", "", $this->input->post('total') ),
        		'add_by' => $data['user_now']->user_id
        	);
    		$insert = $this->cashflow_m->insert('keuangan',$input);
            //Tambahkan Fungsi untuk Cetak struck////
            $data['success']='Data berhasil ditambahkan';
            $data['status'] = true;
        } else {                
            $data['status'] = false;
            $data['error']='Data gagal ditambahkan';
        } 
        header('Content-Type: application/json');
		echo json_encode($data); 
	}

	public function batalkan(){
        $this->session->unset_userdata('cart');
		redirect(base_url()) ; 			
	}

	public function riwayat(){
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Riwayat Transkasi';
		$data['menu']='transaksi';
		$data['success']='';
		$data['error']='';
		$data['dateform']='true';
		$data['select2']='true';
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");
		if($this->input->get('str')){
			$data['str_date'] = $this->input->get('str');
		}
		if($this->input->get('end')){
			$data['end_date'] = $this->input->get('end');
		}
		if($this->input->get('alert')=='success') $data['success']='Data transaksi berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data transaksi gagal dihapus";
		$data['s'] = $this->input->get('s'); 
		////Paginator////
		$dataPerhalaman=20;
		$hal = $this->input->get('hal');
		($hal=='')?$nohalaman = 1:$nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs( (int) $offset);
        $data['offset']=$offset;
		$jmldata=$this->transaksi_m->search_count($data['s'],$data['str_date'],$data['end_date']);
        $data['paginator']=$this->transaksi_m->page($jmldata, $dataPerhalaman, $hal);
		////End Paginator////
		$data['data'] = $this->transaksi_m->search($data['s'],$data['str_date'],$data['end_date'],'','',$dataPerhalaman,$off);
		$data['user_now'] = $this->session->userdata('kasir01');		        
		$this->load->view('kasir/riwayat_v', $data);
	}

	public function cetak_ajax($faktur){

	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

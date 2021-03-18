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
		$this->load->model('user_m');
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
				'order_by' => ''
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
				 		'diskon' => $menu->diskon,
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
			$data['transaksi']->order_by = $this->input->post('order_by');
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
    		"diskon" => preg_replace("/[^0-9 ]/", "", $this->input->post('diskon') ),
    		"total" => preg_replace("/[^0-9 ]/", "", $this->input->post('total') ),
    		"bayar" => preg_replace("/[^0-9 ]/", "", $this->input->post('bayar') ),
    		"real_total" => preg_replace("/[^0-9 ]/", "", $this->input->post('real_total') ),
    		"status_bayar" => 1,
			"catatan" => $this->input->post('catatan'),
			"order_by" => $this->input->post('order_by'),
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
        			'jumlah' => $value['jumlah'],
        			'diskon' => ($value['harga'] * $value['jumlah']) * ($value['diskon'] / 100 )
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
        $data['paginator']=$this->transaksi_m->page_2($jmldata, $dataPerhalaman, $hal);
		////End Paginator////
		$data['data'] = $this->transaksi_m->search($data['s'],$data['str_date'],$data['end_date'],'','',$dataPerhalaman,$off);
		$data['user_now'] = $this->session->userdata('kasir01');		        
		$this->load->view('kasir/riwayat_v', $data);
	}

	public function detail($faktur){
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Detail';
		$data['menu']='transaksi';
		$data['success']='';
		$data['error']='';
		$data['transaksi'] = $this->transaksi_m->get_detail($faktur);
		$this->load->view('kasir/detail_v', $data);
	}

	public function profil(){       
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Profil Saya';
		$data['success']='';
		$data['error']='';
		$data['menu']='';
		if($this->input->post('save')){        	
        	$input = array(
        		"username" => $this->input->post('username'),
        		"name" => $this->input->post('name'),
				"phone" => $this->input->post('phone'),
				"email" => $this->input->post('email')
        	);
        	$respo = $this->user_m->update('users','user_id',$data['user_now']->user_id,$input);
            if($respo){
            	$data['user_now'] = $this->user_m->get_single('users','user_id',$data['user_now']->user_id);
                $this->session->set_userdata('kasir01',$data['user_now']);             
                $data['success']='Ubah profile berhasil';                  
            } else {                
                $data['error']='Ubah profile gagal';
            }                       
        }
        $data['data']=$this->user_m->get_single('users','user_id',$data['user_now']->user_id);                
		$this->load->view('kasir/profile_v', $data);
	}


	public function setting(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Ubah Password';
		$data['menu']='';

		if($this->input->post('save')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('old_password', 'Password Lama', 'required');
			$this->form_validation->set_rules('password', 'Password Baru', 'required|matches[passconf]|min_length[6]');
			$this->form_validation->set_rules('passconf', 'Konfirmasi password', 'required');
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			$this->form_validation->set_message('matches', '%s tidak sama dengan %s');
			// $this->form_validation->set_message('valid_email', 'Alamat email tidak valid');
			if ($this->form_validation->run() == FALSE){
				$data['error'] = trim(validation_errors());
			}
		    else{
				$cek_password=$this->user_m->cek_password($data['user_now']->user_id, md5($this->input->post('old_password')));
		    	if($cek_password){
		    		$ganti=$this->user_m->update('users', 'user_id', $data['user_now']->user_id, array('password'=>md5($this->input->post('password'))));
		    		if($ganti){
		    			$data['success']='Ubah password berhasil.';
		    		} else {
		    			$data['error']='Ubah password gagal';
		    		}
		    	} else {
		    		$data['error']= 'Ubah password gagal. Password lama tidak cocok';
		    	}						
		    }
		}
		$this->load->view('kasir/user_setting_v', $data);
	}


}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

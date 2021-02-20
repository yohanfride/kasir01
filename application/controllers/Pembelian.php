<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pembelian extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		if(!$this->session->userdata('kasir01')) 
			redirect(base_url() . "auth/login");
		$user = $this->session->userdata('kasir01');
        if($user->role == 'kasir')
			redirect(base_url() . "auth/login");
        $this->load->model('toko_m');
        $this->load->model('bahan_m');
		$this->load->model('pembelian_m');
		$this->load->model('cashflow_m');
    }

	public function index(){        
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Pembelian';
		$data['menu']='pembelian';
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
		if($this->input->get('alert')=='success') $data['success']='Data pembelian berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data pembelian gagal dihapus";
		$data['s'] = $this->input->get('s'); 
		////Paginator////
		$dataPerhalaman=20;
		$hal = $this->input->get('hal');
		($hal=='')?$nohalaman = 1:$nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs( (int) $offset);
        $data['offset']=$offset;
		$jmldata=$this->pembelian_m->search_count($data['s'],$data['str_date'],$data['end_date']);
        $data['paginator']=$this->pembelian_m->page($jmldata, $dataPerhalaman, $hal);
		////End Paginator////
		$data['data'] = $this->pembelian_m->search($data['s'],$data['str_date'],$data['end_date'],$dataPerhalaman,$off);
		$data['user_now'] = $this->session->userdata('kasir01');		        
		////
		$params = $_GET;
		unset($params['alert']);
		$data['params'] = http_build_query($params);
		$last_params = array(
			'params' => $data['params'],
			'menu' => $data['menu']
		);
		$this->session->set_userdata('lastparams',$last_params);
		/////
		$this->load->view('pembelian_v', $data);
	}

	public function tambah(){
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Tambah Pembelian';
		$data['menu']='pembelian';
		$data['success']='';
		$data['error']='';
		$data['dateform']='true';
		$data['select2']='true';
		if($this->input->post('save')){
			$input = array(
        		"faktur_pembelian" => $this->input->post('faktur'),
        		"total" => preg_replace("/[^0-9 ]/", "", $this->input->post('total') ),
        		"biaya_tambahan" => preg_replace("/[^0-9 ]/", "", $this->input->post('biaya') ),
				"catatan" => $this->input->post('catatan'),
            	'tanggal' => $this->input->post('tanggal'),
				"add_by" => $data['user_now']->user_id
        	);
        	$item_pembelian = json_decode($this->input->post('item'));
        	$insert = $this->pembelian_m->insert('pembelian',$input);
            if($insert){             
            	foreach ($item_pembelian as $value) {
            		$bahan = $this->bahan_m->get_detail($value->key); 
					if($bahan){
	            		$input = array(
	            			'idpembelian' => $insert,
	            			'idstok' => $value->key,
	            			'harga' =>  preg_replace("/[^0-9 ]/", "", $value->harga),
	            			'jumlah' =>  preg_replace("/[^0-9 ]/", "", $value->jumlah)
	            		);
	        			$respo = $this->pembelian_m->insert('item_pembelian',$input);
	        			if($respo){
	        				$input = array(
		            			'jumlah_stok' => $bahan->jumlah_stok + $input['jumlah']
			            	);
		        			$respo = $this->bahan_m->update('stok','idstok',$value->key,$input);
	        			}
	        		}
            	}
            	$this->session->unset_userdata('item-pembelian');
            	$input = array(
            		'tanggal' => $this->input->post('tanggal'),
            		'faktur' => $this->input->post('faktur'),
            		'nama_akun' => 'PEMBELIAN',
            		'jenis' => 'PENGELUARAN',
            		'idpembelian' => $insert,
            		'kredit' =>  preg_replace("/[^0-9 ]/", "", $this->input->post('total') ),
            		'add_by' => $data['user_now']->user_id
            	);
        		$insert = $this->cashflow_m->insert('keuangan',$input);
                $data['success']='Data berhasil ditambahkan';
            } else {                
                $data['error']='Data gagal ditambahkan';
            }  
		}
		$data['pembelian'] = (object)$this->session->userdata('item-pembelian');
		$data['bahan'] = $this->bahan_m->search('');

		$data['params'] = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == $data['menu']){
			$data['params'] = '&'.$lastparams->params;
		}

		$this->load->view('pembelian_add_v', $data);
	}

	public function detail($id){
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Detail';
		$data['menu']='pembelian';
		$data['success']='';
		$data['error']='';
		$data['pembelian'] = $this->pembelian_m->get_detail($id);

		$data['params'] = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == $data['menu']){
			$data['params'] = '&'.$lastparams->params;
		}

		$this->load->view('pembelian_detail_v', $data);
	}

	public function delete($id){
        $user = $this->session->userdata('kasir01');
        
        $params = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == 'pembelian'){
			$params = '&'.$lastparams->params;
		}

        if($user->role == 'kasir' || $user->role == 'pegawai')
			redirect(base_url().'pembelian/?alert=failed2'.$params) ; 		

		$pembelian = $this->pembelian_m->get_detail($id);
		$bahan = $pembelian->item;
		$del=$this->pembelian_m->delete('item_pembelian','idpembelian',$id);
		if($del){
			foreach ($bahan as $value) {
				$input = array(
        			'jumlah_stok' => $value->jumlah_stok - $value->jumlah
            	);
    			$respo = $this->bahan_m->update('stok','idstok',$value->idstok,$input);
        	}
			$respo = $this->pembelian_m->delete('pembelian','idpembelian',$id);
			$respo = $this->cashflow_m->delete('keuangan','idpembelian',$id);
			redirect(base_url().'pembelian/?alert=success'.$params) ; 			
		} 
		redirect(base_url().'pembelian/?alert=failed'.$params) ; 			
	}

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

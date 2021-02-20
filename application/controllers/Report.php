<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class report extends CI_Controller {

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

	public function penjualan(){        
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Laporan Penjualan';
		$data['menu']='laporan-penjualan';
		$data['tipe']='1';
		$data['dateform']='true';
		$data['select2']='true';
		$data['chart'] = 'true';
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
		$data['kategori'] = $this->input->get('kategori');
		$data['item_menu'] = $this->input->get('menu');
		if($data['tipe'] == '1'){
			$data['data'] = $this->transaksi_m->search_daily($data['str_date'],$data['end_date']);
		}
		if($data['tipe'] == '2'){
			$data['data'] = $this->transaksi_m->search_week($data['str_date'],$data['end_date']);
		}
		if($data['tipe'] == '3'){
			$data['data'] = $this->transaksi_m->search_month($data['tahun']);
		}
		if($data['tipe'] == '4'){
			$data['data'] = $this->transaksi_m->search_category($data['str_date'],$data['end_date']);
		}
		if($data['tipe'] == '5'){
			$data['data'] = $this->transaksi_m->search_menu($data['str_date'],$data['end_date'],$data['kategori']);
		}
		if($data['tipe'] == '6'){
			$data['data'] = $this->transaksi_m->search_category_daily($data['str_date'],$data['end_date'],$data['kategori']);
		}
		if($data['tipe'] == '7'){
			$data['data'] = $this->transaksi_m->search_menu_daily($data['str_date'],$data['end_date'],$data['item_menu']);
		}
		$data['list_tahun'] = $this->transaksi_m->get_tahun();
		$data['list_kategori'] = $this->category_m->search('');
		$data['list_menu'] = $this->menu_m->search('');
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
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();

		$this->load->view('report_penjualan_v', $data);
	}

	public function pembelian(){        
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Laporan Pembelian';
		$data['menu']='laporan-pembelian';
		$data['tipe']='1';
		$data['dateform']='true';
		$data['select2']='true';
		$data['chart'] = 'true';
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
			$data['data'] = $this->pembelian_m->search_daily($data['str_date'],$data['end_date']);
		}
		if($data['tipe'] == '2'){
			$data['data'] = $this->pembelian_m->search_week($data['str_date'],$data['end_date']);
		}
		if($data['tipe'] == '3'){
			$data['data'] = $this->pembelian_m->search_month($data['tahun']);
		}
		if($data['tipe'] == '4'){
			$data['data'] = $this->pembelian_m->search_bahan($data['str_date'],$data['end_date']);
		}
		if($data['tipe'] == '5'){
			$data['data'] = $this->pembelian_m->search_bahan_daily($data['str_date'],$data['end_date'],$data['bahan']);
		}

		$data['list_tahun'] = $this->pembelian_m->get_tahun();
		$data['list_bahan'] = $this->bahan_m->search('');
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
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();

		$this->load->view('report_pembelian_v', $data);
	}

	public function cashflow(){        
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Laporan Pembelian';
		$data['menu']='laporan-cashflow';
		$data['tipe']='1';
		$data['dateform']='true';
		$data['select2']='true';
		$data['chart'] = 'true';
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
			$data['data'] = $this->cashflow_m->search_daily($data['str_date'],$data['end_date'],$data['jenis']);
		}
		if($data['tipe'] == '2'){
			$data['data'] = $this->cashflow_m->search_week($data['str_date'],$data['end_date'],$data['jenis']);
		}
		if($data['tipe'] == '3'){
			$data['data'] = $this->cashflow_m->search_month($data['tahun'],$data['jenis']);
		}
		if($data['tipe'] == '4'){
			$data['data'] = $this->cashflow_m->search_akun($data['str_date'],$data['end_date'],$data['jenis']);
		}
		if($data['tipe'] == '5'){
			$data['data'] = $this->cashflow_m->search_akun_daily($data['str_date'],$data['end_date'],$data['bahan'],$data['jenis']);
		}

		$data['list_tahun'] = $this->cashflow_m->get_tahun();
		$data['list_akun'] = $this->akun_m->search('');
		////
		$params = $_GET;
		unset($params['alert']);
		$data['params'] = http_build_query($params);
		$last_params = array(
			'params' => $data['params'],
			'menu' => $data['menu']
		);
		$this->session->set_userdata('lastparams',$last_params);
		
		if($data['jenis'] == 'PEMASUKAN'){
			$data['ykeys'] =  ['pemasukan'];
			$data['yLabels'] = ['Pemasukan (IDR)'];
			$data['colors'] = ['#26dad2']; 
		} else if($data['jenis'] == 'PENGELUARAN'){
			$data['ykeys'] =  ['pengeluaran'];
			$data['yLabels'] = ['Pengeluaran (IDR)'];
			$data['colors'] = ['#ef5350']; 
		} else {
			$data['ykeys'] =  ['pemasukan','pengeluaran'];
			$data['yLabels'] = ['Pemasukan (IDR)', 'Pengeluaran (IDR)'];
			$data['colors'] = ['#26dad2','#ef5350']; 
		}
		/////
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();
		$this->load->view('report_cashflow_v', $data);
	}
}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

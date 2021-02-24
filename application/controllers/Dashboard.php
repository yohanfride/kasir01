<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends CI_Controller {

	public function __construct() {
        parent::__construct();   
		if(!$this->session->userdata('kasir01')) 
			redirect(base_url() . "auth/login");
		$user = $this->session->userdata('kasir01');
        if($user->role == 'kasir')
			redirect(base_url() . "auth/login");
        $this->load->model('toko_m');
        $this->load->model('transaksi_m');
		$this->load->model('akun_m');
		$this->load->model('cashflow_m');
    }

	public function index()
	{        
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['menu']='dashboard';
		$data['chart']=true;
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Dashboard Page';
		$data['end_week'] = date( 'Y-m-d', strtotime( 'saturday this week' ) );
		$data['str_week'] = date( 'Y-m-d', strtotime("-6 days",strtotime($data['end_week'])));
		/// Fav menu bulanan//
		$strmonth = date("Y-m-1");
		$endmonth = date("Y-m-t");
		$data['list_favmenu'] = $this->transaksi_m->search_fav_menu($strmonth,$endmonth,'',10);
		/// End Fav menu bulanan//
		$today = date("Y-m-d");
		//Transaction Today//
		$today_transaksi = $this->transaksi_m->search_daily($today,$today);
		if($today_transaksi){
			$data['today_transaksi'] = $today_transaksi[0];
		} else {
			$data['today_transaksi'] = (object) array(
				'jumlah' => 0,
				'total' => 0
			);
		}
		///End Transaction Today///
		//Transaction Yesterday///
		$yesterday = date( 'Y-m-d', strtotime("-1 days",strtotime($today)));
		$yesterday_transaksi = $this->transaksi_m->search_daily($yesterday,$yesterday);
		if($yesterday_transaksi){
			$data['yesterday_transaksi'] = $yesterday_transaksi[0];
		} else {
			$data['yesterday_transaksi'] = (object) array(
				'jumlah' => 0,
				'total' => 0
			);
		}
		//End Transaction Yesterday///
		//Casflow Today//
		$today_cashflow = $this->cashflow_m->search_daily($today,$today);
		if($today_cashflow){
			$data['today_cashflow'] = $today_cashflow[0];
		} else {
			$data['today_cashflow'] = (object) array(
				'tanggal' => $today,
				'pemasukan' => 0,
				'pengeluaran' => 0
			);
		}
		///End Casflow Today///
		//Casflow Yesterday//
		$yesterday_cashflow = $this->cashflow_m->search_daily($yesterday,$yesterday);
		if($yesterday_cashflow){
			$data['yesterday_cashflow'] = $yesterday_cashflow[0];
		} else {
			$data['yesterday_cashflow'] = (object) array(
				'tanggal' => $yesterday,
				'pemasukan' => 0,
				'pengeluaran' => 0
			);
		}
		///End Casflow Yesterday///
		//Casflow Last 7 Day //
		$end_week = date( 'Y-m-d', strtotime( 'saturday this week' ) );
		$str_week = date( 'Y-m-d', strtotime("-6 days",strtotime($end_week)));
		$data['last_cashflow'] = $this->cashflow_m->search_daily($str_week,$end_week);
		$last_cashflow = array();
		$last_cashflow[$today] = $data['today_cashflow'];
		$last_cashflow[$yesterday] = $data['yesterday_cashflow'];
		for($i=2; $i<=6; $i++){
			$tgl = date( 'Y-m-d', strtotime('-'.$i.' days',strtotime($today)));
			$last_cashflow[$tgl] = (object) array(
				'tanggal' => $tgl,
				'pemasukan' => 0,
				'pengeluaran' => 0
			);
		}
		$last_cashflow_tgl = array();
		$last_cashflow_luar = array();
		$last_cashflow_masuk = array();

		foreach($data['last_cashflow'] as $d){
			$last_cashflow[$d->tanggal] = $d;			
		}
		foreach(array_reverse($last_cashflow) as $d){
			$last_cashflow_tgl[] = $d->tanggal;
			$last_cashflow_luar[] = $d->pengeluaran;
			$last_cashflow_masuk[] = $d->pemasukan;			
		}
		$data['last_cashflow'] = (object) array(
			'tanggal' => $last_cashflow_tgl,
			'pemasukan' => $last_cashflow_masuk,
			'pengeluaran' => $last_cashflow_luar
		);
		//End Casflow Last 7 Day //
		/// Pichart per Kategori///
		$data['list_category'] = $this->transaksi_m->search_category($strmonth,$endmonth);
		$data['color'] = ['#5c4ac7','#26dad2','#1976d2','#ffb22b','#ef5350','#67757c','#1e7e34','#007bff','#138496','#ffc107','#c82333','#f1c40f','#e67e22','#27ae60','#2980b9','#1abc9c','#2ecc71','#16a085','#c0392b','#bdc3c7','#7f8c8d'];
		/// End Pichart per Kategori///

		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();
		$this->load->view('dashboard_v', $data);
		/// Menu Paling Laris
		/// Jumlah Transkasi Hari ini
		/// Jumlah Pemasukan Hari Ini
		/// Jumlah pembelian bahan hari ini
		/// Cash flow keseluaran hari ini (keluar, masuk)
		/// Grafik Pemasukan dan Pengeluaran Seminggu terakhir.  --> file:///D:/Assets/html-template/adminpress-30/adminpress-30/main/index3.html
		/// Pie Chart PEnjualan per Kategori Menu
	}	
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

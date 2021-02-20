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
    }

	public function index()
	{        
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['menu']='dashboard';
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Dashboard Page';
		$this->load->view('dashboard_v', $data);
		/// Menu Paling Laris
		/// Jumlah Transkasi Hari ini
		/// Jumlah Pemasukan Hari Ini
		/// Jumlah pembelian bahan hari ini
		/// Cash flow keseluaran hari ini (keluar, masuk)
		/// Grafik jam pemasukan
		/// Pie Chart PEnjualan per Kategori Menu
	}	
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pengurangan extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		if(!$this->session->userdata('kasir01')) 
			redirect(base_url() . "auth/login");
		$user = $this->session->userdata('kasir01');
        if($user->role == 'kasir')
			redirect(base_url() . "auth/login");
        $this->load->model('toko_m');
		$this->load->model('bahan_m');
		$this->load->model('pengurangan_m');
    }

	public function index(){        
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Pengurangan Stok Bahan';
		$data['menu']='pengurangan';
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
		if($this->input->get('alert')=='success') $data['success']='Data pengurangan berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data pengurangan gagal dihapus";
		$data['s'] = $this->input->get('s'); 
		////Paginator////
		$dataPerhalaman=15;
		$hal = $this->input->get('hal');
		($hal=='')?$nohalaman = 1:$nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs( (int) $offset);
        $data['offset']=$offset;
		$jmldata=$this->pengurangan_m->search_count($data['s'],$data['str_date'],$data['end_date']);
        $data['paginator']=$this->pengurangan_m->page($jmldata, $dataPerhalaman, $hal);
		////End Paginator////
		$data['data'] = $this->pengurangan_m->search($data['s'],$data['str_date'],$data['end_date'],'',$dataPerhalaman,$off);
		$data['user_now'] = $this->session->userdata('kasir01');		        
		$data['bahan'] = $this->bahan_m->search('');
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
		$this->load->view('pengurangan_v', $data);
	}

	public function delete($id){
        $user = $this->session->userdata('kasir01');

		$params = '';
		$lastparams = (object)$this->session->userdata('lastparams');
		if($lastparams->menu == 'pembelian'){
			$params = '&'.$lastparams->params;
		}

        if($user->role == 'kasir' || $user->role == 'pegawai')
			redirect(base_url().'pengurangan/?alert=failed') ; 			

        $data = $this->pengurangan_m->get_detail($id);        
		if($data){
			$del=$this->pengurangan_m->delete('pengurangan_stok','idpengurangan_stok',$id);
			if($del){
				$input = array(
            		'jumlah_stok' => $data->jumlah + $data->jumlah_stok
            	);
    			$respo = $this->bahan_m->update('stok','idstok',$data->idstok,$input);
				redirect(base_url().'pengurangan/?alert=success') ; 			
			} 
		}
		redirect(base_url().'pengurangan/?alert=failed') ; 			
	}

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

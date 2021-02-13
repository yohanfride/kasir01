<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rate extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('transaction_m');
		$this->load->model('rate_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
    }

	public function index()
	{        
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']='Rate List';
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");
		if($this->input->get('str')){
			$data['str_date'] = $this->input->get('str');
		}
		if($this->input->get('end')){
			$data['end_date'] = $this->input->get('end');
		}
		$query = array(
			"str_date" => $data['str_date'],
			"end_date" => $data['end_date'],
			"detail" => true
		);
		$data['user_now'] = $this->session->userdata('easy_admin');		        
		$data['data'] = $this->rate_m->search($query)->data;
		$this->load->view('rate_v', $data);
	}
	
	public function detail($id){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Rate Detail';		
		$data['user_now'] = $this->session->userdata('easy_admin');				
        $query = array(
				"id" => $id,
				"detail" => true,
				"detail_trans" => true,
				"take" => 1
			);
		$data['data'] = $this->rate_m->search($query)->data[0];      
        $data['id'] = $id;
		$this->load->view('rate_detail_v', $data);
	}	
}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

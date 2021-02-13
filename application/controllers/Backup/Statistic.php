<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistic extends CI_Controller {

	public function __construct() {

        parent::__construct();       
		$this->load->model('metabaselink_m');
		$this->load->model('customer_m');
		$this->load->model('cardriver_m');
		$this->load->model('car_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
    }

	public function index()
	{        
		$data=array();
		$data['title']='Statistic Page';	
		$data['statistic_page'] = true;
		$data['user_now'] = $this->session->userdata('easy_admin');
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();
		$this->load->view('statistic_v', $data);
	}	

	public function  fuelcosumption(){
		$data['title']='Statistic Page - Fuel Cosumption Behaviour';
		$data['statistic_page'] = true;
		$data['user_now'] = $this->session->userdata('easy_admin');
		$data['metabase'] = array(
			'maps1' => $this->metabaselink_m->get_detail_code("MAPS-01-1")->data[0],
			'maps2' => $this->metabaselink_m->get_detail_code("MAPS-01-2")->data[0]
		);
		$this->load->view('statictic_fuelcosumption_v', $data);
	}
	public function  dailyfuelsalesboard(){
		$data['title']='Statistic Page - Daily data of fuel sales and remain onboard which linked to each area';
		$data['statistic_page'] = true;
		$data['user_now'] = $this->session->userdata('easy_admin');
		$data['metabase'] = array(
			'maps1-1' => $this->metabaselink_m->get_detail_code("MAPS-02-1")->data[0],
			'maps1-2' => $this->metabaselink_m->get_detail_code("MAPS-02-2")->data[0],
			'maps2' => $this->metabaselink_m->get_detail_code("MAPS-03")->data[0],
			'maps2-1' => $this->metabaselink_m->get_detail_code("MAPS-03-1")->data[0],
			'maps2-2' => $this->metabaselink_m->get_detail_code("MAPS-03-1")->data[0]
		);
		$this->load->view('statictic_dailyfuelsalesboard_v', $data);
	}

	public function  personalcostumer($id=''){
		if(empty($id)){
			$data['title']='Statistic Page - Personalize Customer’s Data';
			$data['statistic_page'] = true;
			$data['success']='';
			$data['error']='';
			if($this->input->get('alert')=='failed') $data['error']="Customer data not found";	
			$data['data'] = $this->customer_m->search(array())->data;
			$data['user_now'] = $this->session->userdata('easy_admin');
			$this->load->view('statictic_personalcostumer_v', $data);
		} else {
			$detail = $this->customer_m->get_detail($id);
			if(!$detail->data){
				redirect(base_url().'statistic/personalcostumer') ; 
			}
			$data['data'] = $detail->data[0];
			$data['title']='Statistic Page - Personalize Customer’s Data - '.$data['data']->name;
			$data['statistic_page'] = true;
			$data['metabase'] = array(
				'chart1' => $this->metabaselink_m->get_detail_code("PC-01")->data[0],
				'circle1' => $this->metabaselink_m->get_detail_code("PC-02-1")->data[0],
				'circle2' => $this->metabaselink_m->get_detail_code("PC-02-2")->data[0],
				'circle3' => $this->metabaselink_m->get_detail_code("PC-03-1")->data[0],
				'circle4' => $this->metabaselink_m->get_detail_code("PC-03-2")->data[0]
			);
			$data['id'] = $id;
			$data['user_now'] = $this->session->userdata('easy_admin');
			$this->load->view('statictic_personalcostumer_detail_v', $data);
		}
	}

	public function  dailytankcar($id=''){
		if(empty($id)){
			$data['title']='Statistic Page - Volumes on Daily Tank of Each-Car';
			$data['statistic_page'] = true;
			$data['success']='';
			$data['error']='';
			if($this->input->get('alert')=='failed') $data['error']="Car/Truck data not found";	
			$data['data'] = $this->car_m->search(array())->data;
			$data['user_now'] = $this->session->userdata('easy_admin');
			$this->load->view('statictic_dailytankcar_v', $data);
		} else {
			$detail = $this->car_m->get_detail($id);
			if(!$detail->data){
				redirect(base_url().'statistic/dailytankcar') ; 
			}
			$data['data'] = $detail->data[0];
			$data['title']='Statistic Page - Volumes on Daily Tank of Each-Car - Car : '.$data['data']->vehicle_number;
			$data['statistic_page'] = true;
			$data['metabase'] = array(
				'chart1' => $this->metabaselink_m->get_detail_code("DAILY-01")->data[0],
				'chart2' => $this->metabaselink_m->get_detail_code("TROPX-01")->data[0]
			);
			$data['id'] = $id;
			$data['user_now'] = $this->session->userdata('easy_admin');
			$this->load->view('statictic_dailytankcar_detail_v', $data);
		}
	}

	public function  maintenancecost($id=''){
		$data['title']='Cost of maintenance, extracting from operation data';
		$data['statistic_page'] = true;
		$data['metabase'] = array(
			'chart1' => $this->metabaselink_m->get_detail_code("MNT-1-1")->data[0],
			'chart2' => $this->metabaselink_m->get_detail_code("MNT-1-2")->data[0],
			'maps1' => $this->metabaselink_m->get_detail_code("MNT-2-1")->data[0],
			'maps2' => $this->metabaselink_m->get_detail_code("MNT-2-1")->data[0],
			'table1' => $this->metabaselink_m->get_detail_code("MNT-3")->data[0]
		);
		$data['id'] = $id;
		$data['user_now'] = $this->session->userdata('easy_admin');
		$this->load->view('statictic_maintenancecost_v', $data);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class operational extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('car_m');
		$this->load->model('cartank_m');
		$this->load->model('cardriver_m');
		$this->load->model('customer_m');
		$this->load->model('transaction_m');
		$this->load->model('driver_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
    }

	public function index()
	{        
		$data=array();
		$data['title']='Operational Page';
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");
		$data['user_now'] = $this->session->userdata('easy_admin');
		$this->load->view('operational_v', $data);
	}

	public function active()
	{        
		$data=array();
		$data['title']='Operational Page';
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");

		///--------------- Only Active Car -------------///
		$data['car'] = $this->cardriver_m->search( 
			array(
			"str_date" => $data['str_date'],
			"end_date" => $data['end_date'],
			"detail" => true
		))->data;
		$data['total_car'] = count($data['car']);
		
		///--------------- Get Temperature ---------------///
		$car_id = array();
		foreach ($data['car'] as $value) {
			$car_id[] = number_format($value->car_id,0,'','');
		}
		$data['temp'] = array();
		$temp = $this->cartank_m->searchIn('car_id',$car_id);
		if($temp->code == "A00"){
			foreach ($temp->data as $value) {
				$temp_item = array();
				foreach ($value->fuel as $fuel_item) {
					$temp_item[] = $fuel_item->atg->temp;
				}
				$data['temp'][$value->car_id] = $temp_item;
			}	
		}

		///-----Car Income----///
		$car_income = $this->transaction_m->search_group(array(
			"str_date" => $data['str_date'],
			"end_date" => $data['end_date'],
			"groupby" => "car",
			"status" => 1
		))->data;
		$data['car_income'] = array();
		foreach ($car_income as $value) {
			$data['car_income'][number_format($value->car_id,0,'','')] = $value;
		}
		$data['user_now'] = $this->session->userdata('easy_admin');
		$this->load->view('operational_car_v', $data);
	}		
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

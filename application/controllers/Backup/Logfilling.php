<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logfilling extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('cardriver_m');
		$this->load->model('logfilling_m');
		$this->load->model('fuel_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
    }

	public function index()
	{        
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Log Filling data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Log Filling data deleted failed";	
		$data['title']='Log Filling List';
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
		$data['data'] = $this->logfilling_m->search($query)->data;
		$this->load->view('logfilling_v', $data);
	}

	public function add(){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Log Filling Add';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	
        	$input = array(
        		"car_id" => $this->input->post('car'),
				"driver_id" => $this->input->post('driver'),
				"fuel_type" => $this->input->post('fuel_type'),
				"total_fuel" => $this->input->post('total_fuel'),
				"status" => ($this->input->post('done'))?1:0,
				"note" => $this->input->post('note'),
        	);
        	$respo = $this->logfilling_m->add($input);
            if($respo->code == "H00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$query_cardriver = array(
			"str_date" => date("Y-m-d"),
			"end_date" => date("Y-m-d"),
			"detail" => true
		);
		$data['cardriver'] = $this->cardriver_m->search($query_cardriver)->data;		
		$data['fuel'] = $this->fuel_m->search(array("status" => 1))->data;
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();
		$this->load->view('logfilling_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Log Filling Update';		
		$data['user_now'] = $this->session->userdata('easy_admin');				
		if($this->input->post('save')){        	
        	$input = array(
        		"car_id" => $this->input->post('car'),
				"driver_id" => $this->input->post('driver'),
				"fuel_type" => $this->input->post('fuel_type'),
				"total_fuel" => $this->input->post('total_fuel'),
				"status" => ($this->input->post('done'))?1:0,
				"note" => $this->input->post('note'),
        	);
        	$respo = $this->logfilling_m->edit($id,$input);
            if($respo->code == "H00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data['data'] = $this->logfilling_m->get_detail($id)->data[0];       
        $query_cardriver = array(
			"str_date" => date("Y-m-d"),
			"end_date" => date("Y-m-d"),
			"detail" => true
		);
		$data['cardriver'] = $this->cardriver_m->search($query_cardriver)->data;		
		$data['id'] = $id;
		$data['fuel'] = $this->fuel_m->search(array("status" => 1))->data;
		$this->load->view('logfilling_edit_v', $data);
	}	

	public function delete($id=''){					
		//if(!$this->antrian_m->cek_hapus_g($data->NIP)){
			$del=$this->logfilling_m->del($id);
			if($del->code == "H00"){
				redirect(base_url().'logfilling/?alert=success') ; 			
			} 
		//}
		redirect(base_url().'logfilling/?alert=failed') ; 			
	}
	
}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

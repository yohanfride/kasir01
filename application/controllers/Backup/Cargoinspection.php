<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cargoinspection extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('car_m');
		$this->load->model('cargoinspection_m');
		$this->load->model('fuel_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
    }

	public function index()
	{        
		$data=array();
		$data['operational_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Cargo Inspection data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Cargo Inspection data deleted failed";	
		$data['title']='Cargo Inspection List';
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
		$data['data'] = $this->cargoinspection_m->search($query)->data;
		$this->load->view('cargoinspection_v', $data);
	}

	public function add(){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Cargo Inspection Add';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	$input = array(
        		"car_id" => $this->input->post('car'),
				"note" => $this->input->post('note'),
				"tank" => $this->input->post('tank'),
				"atg" => $this->input->post('atg'),
				"flow_meter" => $this->input->post('flow_meter'),
				"pump" => $this->input->post('pump'),
				"power_system" => $this->input->post('power_system'),
				"pipeline" => $this->input->post('pipeline'),
				"hose" => $this->input->post('hose'),
				"box" => $this->input->post('box'),
				"add_by" => $data['user_now']->admin_id
        	);
        	$respo = $this->cargoinspection_m->add($input);
            if($respo->code == "M00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$data['car'] = $this->car_m->search(array())->data;		
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();
		$this->load->view('cargoinspection_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Cargo Inspection Update';		
		$data['user_now'] = $this->session->userdata('easy_admin');				
		if($this->input->post('save')){        	
        	$input = array(
        		"car_id" => $this->input->post('car'),
				"note" => $this->input->post('note'),
				"tank" => $this->input->post('tank'),
				"atg" => $this->input->post('atg'),
				"flow_meter" => $this->input->post('flow_meter'),
				"pump" => $this->input->post('pump'),
				"power_system" => $this->input->post('power_system'),
				"pipeline" => $this->input->post('pipeline'),
				"hose" => $this->input->post('hose'),
				"box" => $this->input->post('box'),
				"add_by" => $data['user_now']->admin_id
        	);
        	$respo = $this->cargoinspection_m->edit($id,$input);
            if($respo->code == "M00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data['data'] = $this->cargoinspection_m->get_detail($id)->data[0];       
		$data['car'] = $this->car_m->search(array())->data;		
		$data['id'] = $id;
		$this->load->view('cargoinspection_edit_v', $data);
	}	

	public function delete($id=''){					
		$del=$this->cargoinspection_m->del($id);
		if($del->code == "M00"){
			redirect(base_url().'cargoinspection/?alert=success') ; 			
		} 
		redirect(base_url().'cargoinspection/?alert=failed') ; 			
	}
	
}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CustomerCar extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('cardriver_m');
		$this->load->model('customercar_m');
		//$this->load->model('aes_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
    }

	public function index()
	{        
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Customer Car data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Customer Car data deleted failed";	
		$data['title']='Customer Car';
		$data['data'] = $this->customercar_m->search(array("detail"=>true))->data;
		$data['user_now'] = $this->session->userdata('easy_admin');		        
		$this->load->view('customer_car_v', $data);
	}

	public function customer($id,$link='',$idcar='')
	{   
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['user_now'] = $this->session->userdata('easy_admin');	
		$data['title']='Customer Car';

		if(!$link) {    
			if($this->input->get('alert')=='success') $data['success']='Customer Car data deleted successfully';	
			if($this->input->get('alert')=='failed') $data['error']="Customer Car data deleted failed";	
			$data['customer_id']  = $id;
			$data['data'] = $this->customercar_m->search(array("customer_id"=>$id,"detail"=>true))->data;
			$this->load->view('customer_car_v', $data);
		} else {
			if($link=="detail"){
				$data['customer_id']  = $id;
				$data['data'] = $this->customercar_m->get_detail($idcar)->data[0];  
				$this->load->view('customer_car_detail_v', $data);
			}
		}
	}

	public function detail($id)
	{        
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Customer Car data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Customer Car data deleted failed";	
		$data['title']='Customer Car';
        $data['data'] = $this->customercar_m->get_detail($id)->data[0];        
		$data['user_now'] = $this->session->userdata('easy_admin');		        
		$this->load->view('customer_car_detail_v', $data);
	}

	public function add(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Customer Car Add';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	$input = array(
        		"customer_id" => $this->input->post('customer'),
				"vehicle_number" => $this->input->post('vnumber'),
				"brand" => $this->input->post('brand'),
				"model" => $this->input->post('model'),
				"body_machine" => $this->input->post('body-machine'),
				"year" => $this->input->post('year'),
        		"fuel_tank_capacity" => $this->input->post('capacity'),
				"fuel_type" => $this->input->post('fuel_type')
        	);
        	$respo = $this->customercar_m->add($input);
        	       	
            if($respo->code == "G00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$this->load->view('car_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Customer Car Update';		
		$data['user_now'] = $this->session->userdata('easy_admin');				
		if($this->input->post('save')){        	
        	$input = array(
        		"customer_id" => $this->input->post('customer'),
        		"vehicle_number" => $this->input->post('vnumber'),
				"brand" => $this->input->post('brand'),
				"model" => $this->input->post('model'),
				"body_machine" => $this->input->post('body-machine'),
				"year" => $this->input->post('year'),
        		"fuel_tank_capacity" => $this->input->post('capacity'),
				"fuel_type" => $this->input->post('fuel_type')
        	);
        	$respo = $this->customercar_m->edit($id,$input);
            if($respo->code == "G00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data['data'] = $this->customercar_m->get_detail($id)->data[0];        
		$data['id'] = $id;
		$this->load->view('car_edit_v', $data);
	}		

	public function delete($id=''){					
		//if(!$this->antrian_m->cek_hapus_g($data->NIP)){
			$del=$this->customercar_m->del($id);
			if($del->code == "G00"){
				redirect(base_url().'customercar/?alert=success') ; 			
			} 
		//}
		redirect(base_url().'customercar/?alert=failed') ; 			
	}
	
	public function getcar($id){   
		$data =  $this->customercar_m->search(array("customer_id"=>$id))->data;
		header('Content-Type: application/json');
    	echo json_encode( $data );  		
	}

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

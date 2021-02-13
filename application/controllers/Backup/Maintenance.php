<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('car_m');
		$this->load->model('maintenance_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
    }

	public function index()
	{        
		$data=array();
		$data['operational_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Maintenance data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Maintenance data deleted failed";	
		$data['title']='Maintenance List';
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
		$data['data'] = $this->maintenance_m->search($query)->data;
		$this->load->view('maintenance_v', $data);
	}

	public function add(){       
		$data=array();
		$data['operational_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Maintenance Add';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	
        	$input = array(
        		"car_id" => $this->input->post('car'),
				"pic" => $this->input->post('pic'),
				"note" => $this->input->post('note'),
				"date_start" => $this->input->post('date_start'),
				"maintenance_location" => $this->input->post('maintenance_location'),
				"maintenance_type" => $this->input->post('maintenance_type'),
				"cost" => $this->input->post('cost')
        	);
        	
        	if($this->input->post('done')){
        		$input+=['status'=>1,'date_finish'=>$this->input->post('date_finish'),'date_next'=>$this->input->post('date_next')];
        	}
        	$respo = $this->maintenance_m->add($input);
            if($respo->code == "G00"){         
            	if($this->input->post('done')){
            		$update = array(
            			'last_service_date' => $this->input->post('date_finish'),
            			'next_service_date' => $this->input->post('date_next')            			
            		);
        			$respon = $this->car_m->edit($this->input->post('car'),$update);
            	}    
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$data['car'] = $this->car_m->search(array("status" => 1))->data;		
		$this->load->view('maintenance_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['operational_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Maintenance Update';		
		$data['user_now'] = $this->session->userdata('easy_admin');				
		if($this->input->post('save')){        	
        	$input = array(
        		"car_id" => $this->input->post('car'),
				"pic" => $this->input->post('pic'),
				"note" => $this->input->post('note'),
				"date_start" => $this->input->post('date_start'),
				"maintenance_location" => $this->input->post('maintenance_location'),
				"maintenance_type" => $this->input->post('maintenance_type'),
				"cost" => $this->input->post('cost')
        	);
        	
        	if($this->input->post('done')){
        		$input+=['status'=>1,'date_finish'=>$this->input->post('date_finish'),'date_next'=>$this->input->post('date_next')];
        	}

        	$respo = $this->maintenance_m->edit($id,$input);
            if($respo->code == "G00"){             
                $data['success']=$respo->message;   
                if($this->input->post('done')){
            		$update = array(
            			'last_service_date' => $this->input->post('date_finish'),
            			'next_service_date' => $this->input->post('date_next')            			
            		);
        			$respon = $this->car_m->edit($this->input->post('car'),$update);
            	}               
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data['data'] = $this->maintenance_m->get_detail($id)->data[0];       
        $data['car'] = $this->car_m->search(array("status" => 1))->data;		
		$data['id'] = $id;
		$this->load->view('maintenance_edit_v', $data);
	}	

	public function getcar($id){
		$data = $this->car_m->get_detail($id)->data[0]->next_service_date;
		header('Content-Type: application/json');
    	echo json_encode( $data );  
	}
	
	public function delete($id=''){					
		//if(!$this->antrian_m->cek_hapus_g($data->NIP)){
			$del=$this->maintenance_m->del($id);
			if($del->code == "G00"){
				redirect(base_url().'maintenance/?alert=success') ; 			
			} 
		//}
		redirect(base_url().'maintenance/?alert=failed') ; 			
	}
	
}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

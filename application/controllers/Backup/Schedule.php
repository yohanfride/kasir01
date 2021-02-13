<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('cardriver_m');
		$this->load->model('driver_m');
		$this->load->model('car_m');
		$this->load->model('sector_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
    }

	public function index()
	{        
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Schedule data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Schedule  data deleted failed";
		$data['title']='Schedule Car History';
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
		if($data['user_now']->user_role == "Driver"){
			$query["driver_id"] = number_format($data['user_now']->driver_id,0,'','');
			$data['title'] = 'Schedule Car History';
		}

		$data['data'] = $this->cardriver_m->search($query)->data;
		
		$this->load->view('schedule_v', $data);
	}

	public function add(){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Schedule Add';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	$input = array(
        		"driver_id" => $this->input->post('driver'),
				"car_id" => $this->input->post('car'),
				"status" => $this->input->post('status'),
				"sector" => $this->input->post('sector')
        	);
        	
        	if($this->input->post('paid')){
        		$input+=['status'=>1,'date_finish'=>$this->input->post('date-add')];
        	}
        	$respo = $this->cardriver_m->add($input);
        	
        	
            if($respo->code == "E00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$data['driver'] = $this->driver_m->search(array("status" => 1))->data;
		$data['car'] = $this->car_m->search(array("status" => 1))->data;
		$data['sector'] = $this->sector_m->search(array("status" => 1))->data;
		$this->load->view('schedule_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['title']= 'Schedule Update';		
		$data['user_now'] = $this->session->userdata('easy_admin');				
		if($this->input->post('save')){        	
        	$input = array(
        		"driver_id" => $this->input->post('driver'),
				"car_id" => $this->input->post('car'),
				"status" => $this->input->post('status'),
				"sector" => $this->input->post('sector')
        	);
        	
        	if($this->input->post('paid')){
        		$input+=['status'=>1,'date_finish'=>$this->input->post('date-add')];
        	}

        	$respo = $this->cardriver_m->edit($id,$input);
            if($respo->code == "E00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data['data'] = $this->cardriver_m->get_detail($id)->data[0];       
        $data['driver'] = $this->driver_m->search(array("status" => 1))->data;
		$data['car'] = $this->car_m->search(array("status" => 1))->data;
		$data['sector'] = $this->sector_m->search(array("status" => 1))->data;
		$data['id'] = $id;
		$this->load->view('schedule_edit_v', $data);
	}	

	public function getcar($id){       
        $data = $this->car_m->get_detail($id)->data[0];  
        $res = array(
        	'tank' => $data->tank,
        	'capacity' => $data->capacity,
        	'km' => $data->total_km,
        	'owner' => $data->owner
        );      
		header('Content-type: application/json');
		echo json_encode($res);
	}

	public function getdriver($id){       
        $data = $this->driver_m->get_detail($id)->data[0];  
        $res = array(
        	'phone' => $data->phone,
        	'name' => $data->name,
        	'photo' => $data->photo
        );       
		header('Content-type: application/json');
		echo json_encode($res);
	}


	public function delete($id=''){					
		//if(!$this->antrian_m->cek_hapus_g($data->NIP)){
			$del=$this->cardriver_m->del($id);
			if($del->code == "E00"){
				redirect(base_url().'schedule/?alert=success') ; 			
			} 
		//}
		redirect(base_url().'schedule/?alert=failed') ; 			
	}

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

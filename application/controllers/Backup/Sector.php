<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sector extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('sector_m');
		//$this->load->model('aes_m');
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
    }

	public function index()
	{        
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Sector data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Sector data deleted failed";	
		$data['title']='Sector List';
		$data['data'] = $this->sector_m->search(array())->data;
		$data['user_now'] = $this->session->userdata('easy_admin');		        
		
		$this->load->view('sector_v', $data);
	}

	public function add(){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Sector Add';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	$input = array(
        		"sector" => $this->input->post('sector'),
				"group" => $this->input->post('group'),
				"city" => $this->input->post('city'),
				"province" => $this->input->post('province'),
				"type" => $this->input->post('type'),
				"coordinates" => $this->input->post('coordinates'),
				"update_by" => $data['user_now']->admin_id
        	);
        	$respo = $this->sector_m->add($input);
        	
        	
            if($respo->code == "J00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$this->load->view('sector_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Sector Update';		
		$data['user_now'] = $this->session->userdata('easy_admin');				
		if($this->input->post('save')){        	
        	$input = array(
        		"sector" => $this->input->post('sector'),
				"group" => $this->input->post('group'),
				"city" => $this->input->post('city'),
				"province" => $this->input->post('province'),
				"type" => $this->input->post('type'),
				"coordinates" => $this->input->post('coordinates'),
				"status" => ($this->input->post('active'))?1:0,
				"update_by" => $data['user_now']->admin_id
        	);
        	$respo = $this->sector_m->edit($id,$input);
            if($respo->code == "J00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data['data'] = $this->sector_m->get_detail($id)->data[0];        
		$data['id'] = $id;
		$this->load->view('sector_edit_v', $data);
	}			

	public function delete($id=''){					
		//if(!$this->antrian_m->cek_hapus_g($data->NIP)){
			$del=$this->sector_m->del($id);
			if($del->code == "J00"){
				redirect(base_url().'sector/?alert=success') ; 			
			} 
		//}
		redirect(base_url().'sector/?alert=failed') ; 			
	}
	
	public function cretegeojson(){       
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Sector Add';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	$respo = $this->sector_m->create_geojson($this->input->post('group'));
            $data['group_current'] = $this->input->post('group');
            if($respo->code == "J00"){             
                $data['success'] = $respo->message;  
                $data['filename'] = $respo->data->filename;
                $data['link_backend'] = $this->config->item('url_node');           
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data['group_list'] =  $this->sector_m->get_group()->data;
		$this->load->view('sector_create_geojson_v', $data);
	}
	
}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

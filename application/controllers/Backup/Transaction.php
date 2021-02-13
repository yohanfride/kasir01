<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('transaction_m');
		$this->load->model('customer_m');
		$this->load->model('customercar_m');
		$this->load->model('driver_m');
		$this->load->model('car_m');
		$this->load->model('fuel_m');
		$this->load->model('cardriver_m');
		$this->load->model('ebmoney_m');
    }

	public function index()
	{        
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Transaction data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Transaction data deleted failed";	
		if($this->input->get('alert')=='success2') $data['success']='Process successfully';	
		if($this->input->get('alert')=='failed2') $data['error']="Process paid failed";
		$data['title']='Transaction List';
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
		if($data['user_now']->user_role == "Driver")
			$query["driver_id"] = number_format($data['user_now']->driver_id,0,'','');
		$data['data'] = $this->transaction_m->search($query)->data;
		if($data['user_now']->user_role == "Driver")
			$this->load->view('transaction_v_driver', $data);
		else
			$this->load->view('transaction_v', $data);
	}

	public function time()
	{        
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Transaction data deleted successfully';	
		if($this->input->get('alert')=='failed') $data['error']="Transaction data deleted failed";	
		if($this->input->get('alert')=='success2') $data['success']='Process successfully';	
		if($this->input->get('alert')=='failed2') $data['error']="Process paid failed";
		$data['title']='Transaction List';
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
			"status" => 1,
			"detail" => true
		);
		$data['user_now'] = $this->session->userdata('easy_admin');		        
		if($data['user_now']->user_role == "Driver")
			$query["driver_id"] = number_format($data['user_now']->driver_id,0,'','');
		$data['data'] = $this->transaction_m->search($query)->data;
		$this->load->view('transaction_time_v', $data);
	}

	public function add(){       
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Transaction Add';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	$input = array(
        		"customer_id" => $this->input->post('customer'),
				"driver_id" => $this->input->post('driver'),
				"car_id" => $this->input->post('car'),
				"customer_car" => $this->input->post('customer-car'),
				"sector" => $this->input->post('sector'),
				"total_fuel" => $this->input->post('fuel-total'),
				"fuel_type" => $this->input->post('fuel-type'),
				"price" => $this->input->post('price'),
				"pay" => $this->input->post('pay'),
				"location_lat" => $this->input->post('location-lat'),
				"location_lng" => $this->input->post('location-lng'),
				"location_address" => $this->input->post('address'),
				"note" => $this->input->post('note')
        	);
        	
        	if($this->input->post('paid')){
        		$input+=['status'=>1,'date_finish'=>$this->input->post('date-add')];
        	}
        	$respo = $this->transaction_m->add($input);
        	
        	
            if($respo->code == "E00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$data['customer'] = $this->customer_m->search(array("status" => 1))->data;
		$data['driver'] = $this->driver_m->search(array("status" => 1))->data;
		$data['car'] = $this->car_m->search(array("status" => 1))->data;		
		$data['fuel'] = $this->fuel_m->search(array("status" => 1))->data;
		
		$this->load->view('transaction_add_v', $data);
	}

	public function searchcar(){       
		$input = array(
    		"fuel_type" => $this->input->post('fuel-type'),
			"location_lat" => $this->input->post('location-lat'),
			"location_lng" => $this->input->post('location-lng')
    	);
        $respo = $this->transaction_m->search_car($input);
        if(isset($respo->data->sector)){
    		$sector = $respo->data->sector;
    	} else {
    		$sector = 'Not Found';
    	}  
        if($respo->code == "A00"){             
            $data = array(
            	'status' => true,
            	'sector' => $sector,
            	'idcar' => $respo->data->car_id,
            	'iddriver' => $respo->data->driver_id,
            	'vehicle_number' => $respo->data->car->vehicle_number,
            	'tank' => $respo->data->car->tank,
            	'driver_name' => $respo->data->driver->name,
            	'driver_code' => $respo->data->driver->driver_code

            );                 
        } else {  
        	          
            $data = array(
            	'status'=>false,
            	'sector' => $sector
            );
        }
        header('Content-Type: application/json');
    	echo json_encode( $data );                       
	}

	public function add_old(){       
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Transaction Add';		
		$data['user_now'] = $this->session->userdata('easy_admin');		
		if($this->input->post('save')){        	
        	$input = array(
        		"customer_id" => $this->input->post('customer'),
				"driver_id" => $this->input->post('driver'),
				"car_id" => $this->input->post('car'),
				"total_fuel" => $this->input->post('fuel-total'),
				"fuel_type" => $this->input->post('fuel-type'),
				"price" => $this->input->post('price'),
				"pay" => $this->input->post('pay'),
				"date_add" => $this->input->post('date-add')
        	);
        	
        	if($this->input->post('paid')){
        		$input+=['status'=>1,'date_finish'=>$this->input->post('date-add')];
        	}
        	$respo = $this->transaction_m->add($input);
        	
        	
            if($respo->code == "E00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
		$data['customer'] = $this->customer_m->search(array("status" => 1))->data;
		$data['driver'] = $this->driver_m->search(array("status" => 1))->data;
		$data['car'] = $this->car_m->search(array("status" => 1))->data;		
		$data['fuel'] = $this->fuel_m->search(array("status" => 1))->data;
		
		$this->load->view('transaction_add_v', $data);
	}

	public function new(){       
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['error2'] = '';
		$data['title']= 'New Order Transaction';		
		$data['user_now'] = $this->session->userdata('easy_admin');	
		$query = array(
			"str_date" => date("Y-m-d"),
			"end_date" => date("Y-m-d"),
			"driver_id" => number_format($data['user_now']->driver_id,0,'',''),
			"detail" => true,
			"status" => 1
		);	
		$data['car'] = $this->cardriver_m->search($query)->data;
		if($data['car']){
			$data['car'] = $data['car'][0];
			if($this->input->post('save')){        	
	        	$input = array(
	        		"customer_id" => $this->input->post('customer'),
	        		"driver_id" => number_format($data['user_now']->driver_id,0,'',''),
	        		"car_id" => $this->input->post('car'),
					"total_fuel" => $this->input->post('fuel-total'),
					"fuel_type" => $this->input->post('fuel-type'),
					"price" => $this->input->post('price'),
					"pay" => $this->input->post('pay'),
					"location_lat" => $this->input->post('location-lat'),
					"location_lng" => $this->input->post('location-lng'),
					"location_address" => $this->input->post('address'),
					"note" => $this->input->post('note'),
					"date_add" => $this->input->post('date-add'),
					"customer_add"=>true
	        	);        	
	        	if($this->input->post('paid')){
	        		$input+=['status'=>1,'date_finish'=>$this->input->post('date-add')];
	        	}
	        	$respo = $this->transaction_m->add($input);    	
	            if($respo->code == "E00"){             
	                $data['success']=$respo->message;                  
	            } else {                
	                $data['error']=$respo->message;
	            }                       
	        }
		} else {
			$data['error2'] = "You don't have schedule today";	
		}
		$data['customer'] = $this->customer_m->search(array("status" => 1))->data;		
		$data['fuel'] = $this->fuel_m->search(array("status" => 1))->data;
		$ebmoney = 	$this->ebmoney_m->search(array("customer_id" => number_format($data['customer'][0]->customer_id,0,'','')))->data;	
		if($ebmoney){
			$data['ebmoney'] =  $ebmoney[0]->money;
		} else {
			$data['ebmoney'] =  0;
		}		
		$this->load->view('transaction_add_v_driver', $data);
	}

	public function get_ebmoney(){
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
		$customer_id = $this->input->post('id');
		$ebmoney = 	$this->ebmoney_m->search(array("customer_id" => $customer_id))->data;	
		if($ebmoney){
			echo $ebmoney[0]->money;
		} else {
			echo '0';	
		}
	}

	public function edit($id){       
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
		$data=array();
		$data['user_now'] = $this->session->userdata('easy_admin');				
		if($data['user_now']->role != 'god-admin'){
        	redirect(base_url().'transaction');
		}
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Transaction Update';		
		if($this->input->post('save')){        	
        	$input = array(
        		"customer_id" => $this->input->post('customer'),
				"driver_id" => $this->input->post('driver'),
				"car_id" => $this->input->post('car'),
				"customer_car" => $this->input->post('customer-car'),
				"sector" => $this->input->post('sector'),
				"total_fuel" => $this->input->post('fuel-total'),
				"fuel_type" => $this->input->post('fuel-type'),
				"price" => $this->input->post('price'),
				"pay" => $this->input->post('pay'),
				"location_lat" => $this->input->post('location-lat'),
				"location_lng" => $this->input->post('location-lng'),
				"location_address" => $this->input->post('address'),
				"note" => $this->input->post('note'),
				"status" => $this->input->post('status')
        	);
        	if($this->input->post('paid')){
        		$input+=['paid'=>1,'date_finish'=>date("Y-m-d H:i:s")];
        	}
        	$respo = $this->transaction_m->edit($id,$input);
            if($respo->code == "E00"){             
                $data['success']=$respo->message;                  
            } else {                
                $data['error']=$respo->message;
            }                       
        }
        $data['status'] = ['In Order List','','Driver on The Way','Driver Arrives on Location','Fuel Refill', 'Finished'];
        $query = array(
				"id" => $id,
				"detail" => true,
				"take" => 1
			);
		$data['data'] = $this->transaction_m->search($query)->data[0];       
        $data['customer'] = $this->customer_m->search(array("status" => 1))->data;
		$data['driver'] = $this->driver_m->search(array("status" => 1))->data;
		$data['car'] = $this->car_m->search(array("status" => 1))->data;		
		$data['fuel'] = $this->fuel_m->search(array("status" => 1))->data;
		$data['id'] = $id;

		$this->load->view('transaction_edit_v', $data);
	}	

	public function detail($id){       
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
		$data=array();
		$data['administration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['title']= 'Transaction Detail';		
		$data['user_now'] = $this->session->userdata('easy_admin');				
		if($this->input->post('save')){        	
        	$input = array(
        		'status'=>$this->input->post('status')
        	);
        	if($input['status'] == 1){        	
				$input['date_finish'] = date("Y-m-d H:i:s");
				$input['paid'] = true;
        	}
        	$respo = $this->transaction_m->edit($id,$input);
            if($respo->code == "E00"){             
                $data['success']='Process successfully';                  
            } else {                
                $data['error']="Process failed";
            }                       
        }
        $query = array(
				"id" => $id,
				"detail" => true,
				"take" => 1
			);
		$data['data'] = $this->transaction_m->search($query)->data[0];
		if($data['data']->customer_car){
			$data['customercar'] = 	$this->customercar_m->search( array("customer_car_id" => $data['data']->customer_car)  )->data;	
			if($data['customercar'])
				$data['customercar'] = $data['customercar'][0];
		}
        $data['id'] = $id;
		$this->load->view('transaction_detail_v', $data);
	}	

	public function delete($id=''){					
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
		//if(!$this->antrian_m->cek_hapus_g($data->NIP)){
			$del=$this->transaction_m->del($id);
			if($del->code == "E00"){
				redirect(base_url().'transaction/?alert=success') ; 			
			} 
		//}
		redirect(base_url().'transaction/?alert=failed') ; 			
	}
	
	public function paid($id=''){
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
		$input=array(
			'status'=>1,
			'date_finish'=> date("Y-m-d H:i:s")
		);
        $del = $this->transaction_m->edit($id,$input);
        if($del->code == "E00"){         
            redirect(base_url().'transaction/?alert=success2');
        }
        redirect(base_url().'transaction/?alert=failed2');
    }

    public function take($id=''){
		if(!$this->session->userdata('easy_admin')) redirect(base_url() . "auth/login");
		$input=array(
			'status'=>2
		);
        $del = $this->transaction_m->edit($id,$input);
        if($del->code == "E00"){         
            redirect(base_url().'transaction/?alert=success2');
        }
        redirect(base_url().'transaction/?alert=failed2');
    }
}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

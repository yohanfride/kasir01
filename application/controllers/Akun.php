<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class akun extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		if(!$this->session->userdata('kasir01')) 
			redirect(base_url() . "auth/login");
		$user = $this->session->userdata('kasir01');
        if($user->role == 'kasir')
			redirect(base_url() . "auth/login");
        $this->load->model('toko_m');
		$this->load->model('akun_m');
		if(!$this->session->userdata('kasir01')) redirect(base_url() . "auth/login");
    }

	public function index(){        
		$data=array();
		$data['menu']='cashflow';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Akun Cashflow';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data akun berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data akun gagal dihapus";	
		$data['s'] = $this->input->get('s'); 
		$data['data'] = $this->akun_m->search($data['s']);
		$data['user_now'] = $this->session->userdata('kasir01');		        
		$this->load->view('akun_v', $data);
	}

	public function tambah(){       
		$data=array();
		$data['menu']='cashflow';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Akun Cashflow Add';
		$data['success']='';
		$data['error']='';
		if($this->input->post('save')){        	
        	$input = array(
        		"akun" =>  strtoupper($this->input->post('akun')),
        	);
        	$respo = $this->akun_m->insert('akun',$input);
            if($respo){             
                $data['success']='Data berhasil ditambahkan';                  
            } else {                
                $data['error']='Data gagal ditambahkan';
            }                       
        }
		$this->load->view('akun_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['menu']='cashflow';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Edit Akun Cashflow';
		$data['success']='';
		$data['error']='';
		if($this->input->post('save')){        	
        	$input = array(
        		"akun" => strtoupper($this->input->post('akun'))
        	);
        	$respo = $this->akun_m->update('akun','idakun',$id,$input);
            if($respo){             
                $data['success']='Data berhasil diubah';                  
            } else {                
                $data['error']='Data gagal diubah';
            }                       
        }
        $data['data'] = $this->akun_m->get_detail($id);        
		$data['id'] = $id;
		$this->load->view('akun_edit_v', $data);
	}		

	public function tambah_api(){       
		$data=array();
    	$input = array(
    		"akun" =>  strtoupper($this->input->post('nama_akun')),
    	);
    	$respo = $this->akun_m->insert('akun',$input);
        if($respo){             
            $data['status']=true; 
            $data['akun_baru'] = strtoupper($this->input->post('nama_akun'));
			$data['data'] = $this->akun_m->search_api('');
        } else {                
            $data['status']=false;
        }                       
        header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function delete($id){					
		if(!$this->akun_m->cek_hapus($id)){
			$del=$this->akun_m->delete('akun','idakun',$id);
			if($del){
				redirect(base_url().'akun/?alert=success') ; 			
			} 
		}
		redirect(base_url().'akun/?alert=failed') ; 			
	}
	

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

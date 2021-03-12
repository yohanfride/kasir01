<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		$this->load->model('user_m');
		$this->load->model('toko_m');
		if(!$this->session->userdata('kasir01')) 
			redirect(base_url() . "auth/login");
		$user = $this->session->userdata('kasir01');
		if($user->role == 'kasir')
			redirect(base_url() . "auth/login");
    }

    public function myprofile(){       
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Profil Saya';
		$data['success']='';
		$data['error']='';
		$data['menu']='';
		if($this->input->post('save')){        	
        	$input = array(
        		"username" => $this->input->post('username'),
        		"name" => $this->input->post('name'),
				"phone" => $this->input->post('phone'),
				"email" => $this->input->post('email')
        	);
        	$respo = $this->user_m->update('users','user_id',$data['user_now']->user_id,$input);
            if($respo){
            	$data['user_now'] = $this->user_m->get_single('users','user_id',$data['user_now']->user_id);
                $this->session->set_userdata('kasir01',$data['user_now']);             
                $data['success']='Ubah profile berhasil';                  
            } else {                
                $data['error']='Ubah profile gagal';
            }                       
        }
        $data['data']=$this->user_m->get_single('users','user_id',$data['user_now']->user_id);                
		$this->load->view('profile_v', $data);
	}

	public function setting(){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Ubah Password';
		$data['menu']='';

		if($this->input->post('save')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('old_password', 'Password Lama', 'required');
			$this->form_validation->set_rules('password', 'Password Baru', 'required|matches[passconf]|min_length[6]');
			$this->form_validation->set_rules('passconf', 'Konfirmasi password', 'required');
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			$this->form_validation->set_message('matches', '%s tidak sama dengan %s');
			// $this->form_validation->set_message('valid_email', 'Alamat email tidak valid');
			if ($this->form_validation->run() == FALSE){
				$data['error'] = trim(validation_errors());
			}
		    else{
				$cek_password=$this->user_m->cek_password($data['user_now']->user_id, md5($this->input->post('old_password')));
		    	if($cek_password){
		    		$ganti=$this->user_m->update('users', 'user_id', $data['user_now']->user_id, array('password'=>md5($this->input->post('password'))));
		    		if($ganti){
		    			$data['success']='Ubah password berhasil.';
		    		} else {
		    			$data['error']='Ubah password gagal';
		    		}
		    	} else {
		    		$data['error']= 'Ubah password gagal. Password lama tidak cocok';
		    	}						
		    }
		}
		$this->load->view('user_setting_v', $data);
	}

	public function index()
	{        

		$data=array();
		$data['success']='';
		$data['error']='';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		if($data['user_now']->role == 'pegawai')
			redirect(base_url() . "auth/login");

		$data['title'] = $data['toko']->nama_toko.' - Data Pengguna';
		$data['menu']='user';

		if($this->input->get('alert')=='success') $data['success']='Hapus data pengguna berhasil';	
		if($this->input->get('alert')=='failed') $data['error']="Hapus data pengguna gagal";	
		if($this->input->get('alert')=='success2') $data['success']='Aktivasi akun pengguna berhasil';	
		if($this->input->get('alert')=='failed2') $data['error']="Aktivasi akun pengguna gagal";
		if($this->input->get('alert')=='success3') $data['success']='Suspend akun pengguna berhasil';	
		if($this->input->get('alert')=='failed3') $data['error']="Suspend akun pengguna gagal";
		$data['title']='User List';
		$data['data'] = $this->user_m->search('');
		$data['user_now'] = $this->session->userdata('kasir01');		        
		$this->load->view('user_v', $data);
	}

	public function tambah(){       
		$data=array();
		$data['useristration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		if($data['user_now']->role == 'pegawai')
			redirect(base_url() . "auth/login");
		$data['title'] = $data['toko']->nama_toko.' - Tambah Pengguna Baru';
		$data['menu']='user';
        if($this->input->post('save')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
			$this->form_validation->set_rules('email', 'Alamat Email', 'required|valid_email|is_unique[users.email]');			
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');			
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			$this->form_validation->set_message('valid_email', 'Alamat email tidak valid');
			$this->form_validation->set_message('is_unique', '%s sudah terdaftar'); 	
			if ($this->form_validation->run() == FALSE){
				$data['error'] = trim(validation_errors());
			} else{
				$input = array(
	        		"name" => $this->input->post('name'),
					"phone" => $this->input->post('phone'),
					"username" => $this->input->post('username'),
					"password" => md5($this->input->post('password')),
					"email" => $this->input->post('email'),
					"role" => $this->input->post('role'),
					"status" => 1,
					"add_by" => $data['user_now']->user_id
	        	);
				$insert=$this->user_m->insert('users',$input);
		    	if($insert){
		    		$data['success']='Data pengguna berhasil ditambahkan';
		    	} else {
		    		$data['error']= 'Data pengguna gagal ditambahkan';
		    	}						
		    }
		}
		$this->load->view('user_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['useristration_page'] = true;
		$data['success']='';
		$data['error']='';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Ubah Pengguna Baru';	
		$data['menu']='user';
		if($data['user_now']->role == 'pegawai')
			redirect(base_url() . "auth/login");

		if($this->input->post('save')){   
			$this->load->library('form_validation');
			$this->form_validation->set_rules('email', 'Alamat Email', 'required|valid_email');			
			$this->form_validation->set_rules('username', 'Username', 'required');			
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			$this->form_validation->set_message('valid_email', 'Alamat email tidak valid');
			$this->form_validation->set_message('is_unique', '%s sudah terdaftar'); 	
			if ($this->form_validation->run() == FALSE){
				$data['error'] = trim(validation_errors());
			} else{
				$input = array(
	        		"name" => $this->input->post('name'),
					"phone" => $this->input->post('phone'),
					"email" => $this->input->post('email'),
					"role" => $this->input->post('role')
	        	);
	        	$respo = $this->user_m->update('users','user_id',$id,$input);
	            if($respo){
	                $data['success']='Ubah data pengguna berhasil';                  
	            } else {                
	                $data['error']='Ubah data pengguna gagal';
	            }        
			}
        }
        $data['data'] = $this->user_m->get_detail($id);        
		$data['id'] = $id;
		$this->load->view('user_edit_v', $data);
	}	

	public function reset_pass($id){       
		$data=array();
		$data['success']='';
		$data['error']='';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Reset Password';
		$data['menu']='';
		if($data['user_now']->role == 'pegawai')
			redirect(base_url() . "auth/login");

		if($this->input->post('save')){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('password', 'Password Baru', 'required|min_length[6]');
			$this->form_validation->set_message('required', '%s tidak boleh kosong');
			$this->form_validation->set_message('matches', '%s tidak sama dengan %s');
			// $this->form_validation->set_message('valid_email', 'Alamat email tidak valid');
			if ($this->form_validation->run() == FALSE){
				$data['error'] = trim(validation_errors());
			}
		    else{
	    		$ganti=$this->user_m->update('users', 'user_id', $id, array('password'=>md5($this->input->post('password'))));
	    		if($ganti){
	    			$data['success']='Reset password berhasil.';
	    		} else {
	    			$data['error']='Reset password gagal';
	    		}
		    }
		}
		$data['data'] = $this->user_m->get_detail($id);        
		$data['id'] = $id;
		$this->load->view('user_reset_pass_v', $data);
	}	

	public function delete($id=''){					
		$del=$this->user_m->delete('users', 'user_id', $id);
		if($del){
			redirect(base_url().'user/?alert=success') ; 			
		} 
		redirect(base_url().'user/?alert=failed') ; 			
	}
	
	public function active($id=''){

        $del = $this->user_m->update('users', 'user_id', $id, array('status'=>1));
        if($del){         
            redirect(base_url().'user/?alert=success2');
        }
        redirect(base_url().'user/?alert=failed2');
    }

    public function nonactive($id=''){

        $del = $this->user_m->update('users', 'user_id', $id, array('status'=>2));
        if($del){           
            redirect(base_url().'user/?alert=success3');
        }
        redirect(base_url().'user/?alert=failed3');
    }

    
}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

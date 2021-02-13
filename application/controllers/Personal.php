<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Personal extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		if(!$this->session->userdata('kasir01')) 
			redirect(base_url() . "auth/login");
		$user = $this->session->userdata('kasir01');
        if($user->role == 'kasir' || $user->role == 'pegawai')
			redirect(base_url() . "auth/login");
        $this->load->model('toko_m');
    }

	public function index(){        
		$data=array();
		$data['menu']='personal';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Identitas Toko';
		$data['success']='';
		$data['error']='';
		if($this->input->post('save')){    
			$logo = $this->input->post('logo_curr');
			if(!empty($_FILES['logo']['name'])){				
				$logo = $this->_doupload_file('logo','assets/upload/toko/','');
				if(!empty($this->input->post('logo_curr'))){
					$file= "assets/upload/toko/".$this->input->post('logo_curr');					
					unlink($file);	
				}
			}
			$icon = $this->input->post('icon_curr');
			if(!empty($_FILES['icon']['name'])){				
				$icon = $this->_doupload_file('icon','assets/upload/toko/','');
				if(!empty($this->input->post('icon_curr'))){
					$file= "assets/upload/toko/".$this->input->post('icon_curr');					
					unlink($file);	
				}
			}
			$logo_struk = $this->input->post('logo_struk_curr');
			if(!empty($_FILES['logo_struk']['name'])){				
				$logo_struk = $this->_doupload_file('logo_struk','assets/upload/toko/','');
				if(!empty($this->input->post('logo_struk_curr'))){
					$file= "assets/upload/toko/".$this->input->post('logo_struk_curr');					
					unlink($file);	
				}
			}	
        	$input = array(
        		"nama_toko" => $this->input->post('nama'),
        		"nama_pemilik" => $this->input->post('pemilik'),
        		"no_telepon" => $this->input->post('phone'),
        		"alamat" => $this->input->post('alamat'),
        		"footer_struk" => $this->input->post('note'),
				"logo" => $logo,
				"icon" => $icon,
				"logo_struk" => $logo_struk
        	);
        	$respo = $this->toko_m->update('toko','id',$data['toko']->id,$input);
            if($respo){             
                $data['success']='Data berhasil diubah';                  
            } else {                
                $data['error']='Data gagal diubah';
            }                       
        }
        $data['data'] = $this->toko_m->get();        
		$data['toko'] = $data['data'];
		$this->load->view('identitas_v', $data);
	}		
	
	public function _doupload_file($name,$target,$file_name="",$i=0){
		if(empty($file_name)){
			$file_name = preg_replace('/(.*)\\.[^\\.]*/', '$1', $_FILES[$name]['name']);
			$file_name = date('dmYHis').'_'.preg_replace("/[^0-9a-zA-Z ]/", "", $file_name );
		}
		$img						= $name;
		$config['file_name']  		= $file_name;
		$config['upload_path'] 		= $target;
		$config['overwrite'] 		= FALSE;
		$config['allowed_types'] 	= '*';
		$config['max_size']			= '2000000';
		$config['remove_spaces']  	= TRUE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($img)){
			$return['file_name'] = '';
		}else{
			$data = array('upload_data' => $this->upload->data());
			$return['message'] 	 = '-';
			$return['file_name'] = $data['upload_data']['file_name'];
		}

		$this->upload->file_name = '';
		if($return['file_name']==''){
			//return $return['message'];
			return '-';
		}else{
			return $return['file_name'];
		}
	}

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

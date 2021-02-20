<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		if(!$this->session->userdata('kasir01')) 
			redirect(base_url() . "auth/login");
		$user = $this->session->userdata('kasir01');
        if($user->role == 'kasir')
			redirect(base_url() . "auth/login");
        $this->load->model('toko_m');
        $this->load->model('category_m');
		$this->load->model('menu_m');
    }

	public function index(){        
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Menu';
		$data['menu']='menu';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data menu berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data menu gagal dihapus";	
		$data['s'] = $this->input->get('s'); 
		$data['kategori'] = $this->input->get('kategori'); 
		$data['status'] = $this->input->get('status'); 
		$data['data'] = $this->menu_m->search($data['s'],$data['kategori'],$data['status']);
		$data['user_now'] = $this->session->userdata('kasir01');
		$this->load->view('menu_v', $data);
	}

	public function tambah(){       
		$data=array();
		$data['menu']='menu';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Menu';
		$data['success']='';
		$data['error']='';
		if($this->input->post('save')){        	
        	$pict = "";
			if(!empty($_FILES['photo']['name'])){				
				$pict = $this->_doupload_file('photo','assets/upload/menu/','');
			}
        	$input = array(
        		"menu" => $this->input->post('menu'),
        		"harga" => preg_replace("/[^0-9 ]/", "", $this->input->post('price') ),
        		"idkategori" => $this->input->post('category'),
        		"status" => $this->input->post('status'),
				"keterangan_menu" => $this->input->post('detail'),
				"foto" => $pict,
				"add_by" => $data['user_now']->user_id
        	);
	    	$respo = $this->menu_m->insert('menu',$input);
            if($respo){             
                $data['success']='Data berhasil ditambahkan';                  
            } else {                
				unlink('assets/upload/menu/'.$pict);
                $data['error']='Data gagal ditambahkan';
            }                       
        }
		$data['kategori'] = $this->category_m->search('');
		$this->load->view('menu_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['menu']='menu';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Menu';
		$data['success']='';
		$data['error']='';
		if($this->input->post('save')){    
			$pict = $this->input->post('img_curr');
			if(!empty($_FILES['photo']['name'])){				
				$pict = $this->_doupload_file('photo','assets/upload/menu/','');
				if(!empty($this->input->post('img_curr'))){
					$file= "assets/upload/menu/".$this->input->post('img_curr');					
					unlink($file);	
				}
			}	
        	$input = array(
        		"menu" => $this->input->post('menu'),
        		"harga" => preg_replace("/[^0-9 ]/", "", $this->input->post('price') ),
        		"idkategori" => $this->input->post('category'),
        		"status" => $this->input->post('status'),
				"keterangan_menu" => $this->input->post('detail'),
				"foto" => $pict,
				"add_by" => $data['user_now']->user_id
        	);
        	$respo = $this->menu_m->update('menu','idmenu',$id,$input);
            if($respo){             
                $data['success']='Data berhasil diubah';                  
            } else {                
                $data['error']='Data gagal diubah';
            }                       
        }
        $data['data'] = $this->menu_m->get_detail($id);        
		$data['id'] = $id;
		$data['kategori'] = $this->category_m->search('');
		$this->load->view('menu_edit_v', $data);
	}		

	public function delete($id){					
		if(!$this->menu_m->cek_hapus($id)){
        	$data= $this->menu_m->get_detail($id);        
			$del=$this->menu_m->delete('menu','idmenu',$id);
			if($del){
				$file= "assets/upload/menu/".$data->foto;					
				unlink($file);	
				redirect(base_url().'menu/?alert=success') ; 			
			} 
		}
		redirect(base_url().'menu/?alert=failed') ; 			
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

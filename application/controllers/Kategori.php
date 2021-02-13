<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kategori extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		if(!$this->session->userdata('kasir01')) 
			redirect(base_url() . "auth/login");
		$user = $this->session->userdata('kasir01');
        if($user->role == 'kasir')
			redirect(base_url() . "auth/login");
        $this->load->model('toko_m');
		$this->load->model('category_m');
		if(!$this->session->userdata('kasir01')) redirect(base_url() . "auth/login");
    }

	public function index(){        
		$data=array();
		$data['menu']='kategori';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Kategori';
		$data['success']='';
		$data['error']='';
		if($this->input->get('alert')=='success') $data['success']='Data kategori berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data kategori gagal dihapus";	
		$data['s'] = $this->input->get('s'); 
		$data['data'] = $this->category_m->search($data['s']);
		$data['user_now'] = $this->session->userdata('kasir01');		        
		$this->load->view('category_v', $data);
	}

	public function tambah(){       
		$data=array();
		$data['menu']='kategori';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Kategori Add';
		$data['success']='';
		$data['error']='';
		if($this->input->post('save')){        	
        	$input = array(
        		"kategori" => $this->input->post('category'),
				"keterangan_kategori" => $this->input->post('detail'),
				"add_by" => $data['user_now']->user_id
        	);
        	$respo = $this->category_m->insert('kategori',$input);
            if($respo){             
                $data['success']='Data berhasil ditambahkan';                  
            } else {                
                $data['error']='Data gagal ditambahkan';
            }                       
        }
		$this->load->view('category_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['menu']='kategori';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Edit Kategori';
		$data['success']='';
		$data['error']='';
		if($this->input->post('save')){        	
        	$input = array(
        		"kategori" => $this->input->post('category'),
				"keterangan_kategori" => $this->input->post('detail'),
				"add_by" => $data['user_now']->user_id
        	);
        	$respo = $this->category_m->update('kategori','idkategori',$id,$input);
            if($respo){             
                $data['success']='Data berhasil diubah';                  
            } else {                
                $data['error']='Data gagal diubah';
            }                       
        }
        $data['data'] = $this->category_m->get_detail($id);        
		$data['id'] = $id;
		$this->load->view('category_edit_v', $data);
	}		

	public function delete($id){					
		if(!$this->category_m->cek_hapus($id)){
			$del=$this->category_m->delete('kategori','idkategori',$id);
			if($del){
				redirect(base_url().'kategori/?alert=success') ; 			
			} 
		}
		redirect(base_url().'kategori/?alert=failed') ; 			
	}
	

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

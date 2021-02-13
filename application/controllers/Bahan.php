<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bahan extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		if(!$this->session->userdata('kasir01')) 
			redirect(base_url() . "auth/login");
		$user = $this->session->userdata('kasir01');
        if($user->role == 'kasir')
			redirect(base_url() . "auth/login");
        $this->load->model('toko_m');
		$this->load->model('bahan_m');
		if(!$this->session->userdata('kasir01')) redirect(base_url() . "auth/login");
    }

	public function index(){        
		$data=array();
		$data['menu']='bahan';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Bahan';
		$data['success']='';
		$data['error']='';
		$data['dateform']='true';
		if($this->input->get('alert')=='success') $data['success']='Data stok bahan berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data stok bahan gagal dihapus";	
		$data['s'] = $this->input->get('s'); 
		$data['data'] = $this->bahan_m->search($data['s']);
		$data['user_now'] = $this->session->userdata('kasir01');		        
		$this->load->view('bahan_v', $data);
	}

	public function tambah(){       
		$data=array();
		$data['menu']='bahan';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Tambah Data Bahan';
		$data['success']='';
		$data['error']='';
		if($this->input->post('save')){        	
        	$input = array(
        		"nama" => $this->input->post('nama'),
        		"satuan" => $this->input->post('satuan'),
        		"jumlah_stok" => preg_replace("/[^0-9 ]/", "", $this->input->post('stok_awal') ),
				"keterangan_stok" => $this->input->post('detail'),
				"add_by" => $data['user_now']->user_id
        	);
        	$respo = $this->bahan_m->insert('stok',$input);
            if($respo){             
                $data['success']='Data berhasil ditambahkan';                  
            } else {                
                $data['error']='Data gagal ditambahkan';
            }                       
        }
		$this->load->view('bahan_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['menu']='bahan';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Edit Data Bahan';
		$data['success']='';
		$data['error']='';
        $data['status'] = $this->bahan_m->cek_hapus($id);
		if($this->input->post('save')){        	
        	$input = array(
        		"nama" => $this->input->post('nama'),
        		"satuan" => $this->input->post('satuan'),
				"keterangan_stok" => $this->input->post('detail')
        	);
        	if(!$data['status']){
        		$input["jumlah_stok"] = preg_replace("/[^0-9 ]/", "", $this->input->post('stok_awal') );
        	}
        	$respo = $this->bahan_m->update('stok','idstok',$id,$input);
            if($respo){             
                $data['success']='Data berhasil diubah';                  
            } else {                
                $data['error']='Data gagal diubah';
            }                       
        }
        $data['data'] = $this->bahan_m->get_detail($id);        
		$data['id'] = $id;
		$this->load->view('bahan_edit_v', $data);
	}
	public function delete($id){					
		if(!$this->bahan_m->cek_hapus($id)){
			$del=$this->bahan_m->delete('stok','idstok',$id);
			if($del){
				redirect(base_url().'bahan/?alert=success') ; 			
			} 
		}
		redirect(base_url().'bahan/?alert=failed') ; 			
	}

	public function api_pengurangan(){
		$data=array();
    	$this->load->library('form_validation');
		$this->form_validation->set_rules('bahan', 'Bahan', 'required');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
		$this->form_validation->set_rules('date_add', 'Tanggal', 'required');
		$this->form_validation->set_message('required', '%s tidak boleh kosong');
		if ($this->form_validation->run() == FALSE){
			$data['status'] = false;
			$data['error'] = trim(validation_errors());
		} else {
			$bahan = $this->bahan_m->get_detail($this->input->post('bahan')); 
			if($bahan){
				$sisa_stok = $bahan->jumlah_stok - preg_replace("/[^0-9 ]/", "", $this->input->post('jumlah') );
				if($sisa_stok>-1){
					$input = array(
		        		"idstok" => $this->input->post('bahan'),
		        		"date_add" => $this->input->post('date_add'),
		        		"jumlah" => preg_replace("/[^0-9 ]/", "", $this->input->post('jumlah') ),
						"keterangan" => $this->input->post('detail'),
						"add_by" => $this->input->post('uid')
		        	);
		        	$respo = $this->bahan_m->insert('pengurangan_stok',$input);
		            if($respo){
		            	$input = array(
		            		'jumlah_stok' => $sisa_stok
		            	);
	        			$respo = $this->bahan_m->update('stok','idstok',$this->input->post('bahan'),$input);
						$data['stok'] =  number_format($sisa_stok,0,',','.');
						$data['id'] = $this->input->post('bahan');
						$data['status'] = true;
		                $data['success']='Data berhasil ditambahkan';                  
		            } else {                
						$data['status'] = false;
		                $data['error']='Data gagal ditambahkan';
		            }	
		        } else {
		        	$data['status'] = false;
               		$data['error']='Jumlah pengurangan stok lebih besar dari jumlah stok';	
		        }
			} else {                
				$data['status'] = false;
                $data['error']='Data bahan tidak ditemukan';
            }	
		}
		header('Content-Type: application/json');
		echo json_encode($data);
	}		

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

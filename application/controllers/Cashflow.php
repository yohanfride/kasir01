<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cashflow extends CI_Controller {

	public function __construct() {

        parent::__construct();        
		if(!$this->session->userdata('kasir01')) 
			redirect(base_url() . "auth/login");
		$user = $this->session->userdata('kasir01');
        if($user->role == 'kasir')
			redirect(base_url() . "auth/login");
        $this->load->model('toko_m');
		$this->load->model('akun_m');
		$this->load->model('cashflow_m');
    }

	public function index(){        
		$data=array();
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Cashflow';
		$data['menu']='cashflow';
		$data['success']='';
		$data['error']='';
		$data['dateform']='true';
		$data['select2']='true';
		$data['str_date'] = date("Y-m-d");
		$data['end_date'] = date("Y-m-d");
		if($this->input->get('str')){
			$data['str_date'] = $this->input->get('str');
		}
		if($this->input->get('end')){
			$data['end_date'] = $this->input->get('end');
		}
		if($this->input->get('alert')=='success') $data['success']='Data <i>Cashflow</i> berhasil dihapus';	
		if($this->input->get('alert')=='failed') $data['error']="Data <i>Cashflow</i> gagal dihapus";
		$data['s'] = $this->input->get('s'); 
		$data['akun'] = $this->input->get('akun'); 
		$data['jenis'] = $this->input->get('jenis'); 
		////Paginator////
		$dataPerhalaman=15;
		$hal = $this->input->get('hal');
		($hal=='')?$nohalaman = 1:$nohalaman = $hal;
        $offset = ($nohalaman - 1) * $dataPerhalaman;
        $off = abs( (int) $offset);
        $data['offset']=$offset;
		$jmldata=$this->cashflow_m->search_count($data['s'],$data['str_date'],$data['end_date'],$data['akun'],$data['jenis']);
        $data['paginator']=$this->cashflow_m->page($jmldata, $dataPerhalaman, $hal);
		////End Paginator////
		$data['data'] = $this->cashflow_m->search($data['s'],$data['str_date'],$data['end_date'],$data['akun'],$data['jenis'],$dataPerhalaman,$off);
		$data['total'] = $this->cashflow_m->search_total($data['s'],$data['str_date'],$data['end_date'],$data['akun'],$data['jenis']);
		$data['user_now'] = $this->session->userdata('kasir01');	
		$data['list_akun'] = $this->akun_m->search('');
		$this->load->view('cashflow_v', $data);
	}

	public function tambah(){       
		$data=array();
		$data['menu']='cashflow';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Tambah Data Cashflow';
		$data['dateform']='true';
		$data['success']='';
		$data['error']='';
		if($this->input->post('save')){        	
        	$input = array(
        		'tanggal' => $this->input->post('tanggal'),
        		'faktur' => $this->input->post('faktur'),
        		'nama_akun' => $this->input->post('akun'),
        		'jenis' => $this->input->post('jenis'),
        		'catatan' => $this->input->post('catatan'),
        		'add_by' => $data['user_now']->user_id
        	);
        	if($input['jenis'] == 'PENGELUARAN'){
        		$input['kredit'] = preg_replace("/[^0-9 ]/", "", $this->input->post('total') );
        	} else if($input['jenis'] == 'PEMASUKAN'){
        		$input['debit'] = preg_replace("/[^0-9 ]/", "", $this->input->post('total') );
        	}
    		$insert = $this->cashflow_m->insert('keuangan',$input);
            if($insert){             
                $data['success']='Data berhasil ditambahkan';                  
            } else {                
                $data['error']='Data gagal ditambahkan';
            }                       
        }
		$data['list_akun'] = $this->akun_m->search_api();
		$this->load->view('cashflow_add_v', $data);
	}

	public function edit($id){       
		$data=array();
		$data['menu']='cashflow';
		$data['toko'] = $this->toko_m->get();
		$data['user_now'] =  $this->session->userdata('kasir01');
		$data['title'] = $data['toko']->nama_toko.' - Update Data Cashflow';
		$data['success']='';
		$data['error']='';
		if($this->input->post('save')){    
        	$input = array(
        		'tanggal' => $this->input->post('tanggal'),
        		'faktur' => $this->input->post('faktur'),
        		'nama_akun' => $this->input->post('akun'),
        		'jenis' => $this->input->post('jenis'),
        		'catatan' => $this->input->post('catatan'),
        		'update_by' => $data['user_now']->user_id
        	);
        	if($input['jenis'] == 'PENGELUARAN'){
        		$input['kredit'] = preg_replace("/[^0-9 ]/", "", $this->input->post('total') );
        	} else if($input['jenis'] == 'PEMASUKAN'){
        		$input['debit'] = preg_replace("/[^0-9 ]/", "", $this->input->post('total') );
        	}
        	$update = $this->cashflow_m->update('keuangan','idkeuangan',$id,$input);
            if($update){             
                $data['success']='Data berhasil diubah';                  
            } else {                
                $data['error']='Data gagal diubah';
            }                       
        }
        $data['data'] = $this->cashflow_m->get_detail($id);        
		$data['id'] = $id;
		$data['list_akun'] = $this->akun_m->search_api();
		$this->load->view('cashflow_edit_v', $data);
	}

	public function delete($id){
        $user = $this->session->userdata('kasir01');
        if($user->role == 'kasir' || $user->role == 'pegawai')
			redirect(base_url().'cashflow/?alert=failed') ; 			

        $data = $this->cashflow_m->cekhapus($id);        
		if(!$data){
			$del=$this->cashflow_m->delete('keuangan','idkeuangan',$id);
			if($del){
				redirect(base_url().'cashflow/?alert=success') ; 			
			} 
		}
		redirect(base_url().'cashflow/?alert=failed') ; 			
	}

}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */

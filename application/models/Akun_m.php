<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class akun_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function search($s){
		$sql = "SELECT * FROM akun  WHERE  akun LIKE '%$s%' ORDER by akun ASC";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_count($s){
		$sql = "SELECT * FROM akun  WHERE  akun LIKE '%$s%' ORDER by akun ASC";
		$res = $this->db->query($sql);
		$r = $res->num_rows;
		$res->free_result();
		return $r;
	}
	
	function get_detail($id){
		$sql = "SELECT * FROM akun  WHERE  idakun= $id";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}

	function cek_hapus($id){
		$sql = "SELECT * FROM akun  WHERE  hapus = 0 and idakun = $id ";
		$res = $this->db->query($sql);
		$r=$res->num_rows;
		$res->free_result();
		return $r;
	}
	
	function search_api(){
		$sql = "SELECT * FROM akun  WHERE hapus <> 0 ORDER by akun ASC";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

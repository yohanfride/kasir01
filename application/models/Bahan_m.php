<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bahan_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function search($s){
		$sql = "SELECT * FROM stok WHERE  nama LIKE '%$s%' ORDER by nama ASC";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_count($s){
		$sql = "SELECT * FROM stok WHERE  nama LIKE '%$s%' ORDER by nama ASC";
		$res = $this->db->query($sql);
		$r = $res->num_rows;
		$res->free_result();
		return $r;
	}

	function get_detail($id){
		$sql = "SELECT * FROM stok WHERE idstok= $id";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}

	function cek_hapus($id){
		$sql = "SELECT * FROM item_pembelian  WHERE idstok=$id";
		$res = $this->db->query($sql);
		$r=$res->num_rows;
		if(!$r){
			$sql = "SELECT * FROM pengurangan_stok  WHERE idstok=$id";
			$res = $this->db->query($sql);
			$r=$res->num_rows;	
		}
		$res->free_result();
		return $r;
	}
	
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

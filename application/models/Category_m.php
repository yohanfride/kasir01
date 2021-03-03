<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Category_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function search($s){
		$sql = "SELECT * FROM kategori  WHERE  kategori LIKE '%$s%' ORDER by kategori ASC";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_count($s){
		$sql = "SELECT * FROM kategori  WHERE  kategori LIKE '%$s%' ORDER by kategori ASC";
		$res = $this->db->query($sql);
		$r = $res->num_rows;
		$res->free_result();
		return $r;
	}

	
	function get_detail($id){
		$sql = "SELECT * FROM kategori  WHERE  idkategori= $id";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}

	function cek_hapus($id){
		$sql = "SELECT * FROM menu  WHERE  idkategori= $id";
		$res = $this->db->query($sql);
		$r=$res->num_rows();
		$res->free_result();
		return $r;
	}
	
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

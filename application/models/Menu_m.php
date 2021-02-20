<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function search($s,$kat="",$status=''){
		$sql = "SELECT * FROM menu a join kategori b on a.idkategori = b.idkategori WHERE  menu LIKE '%$s%' ";
		if($kat){
			$sql.= " AND a.idkategori = $kat ";
		}
		if($status != ''){
			$sql.= " AND status = $status ";
		}
		$sql.= " ORDER by menu ASC";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_count($s,$kat=""){
		$sql = "SELECT * FROM menu a join kategori b on a.idkategori = b.idkategori WHERE  menu LIKE '%$s%' ";
		if($kat){
			$sql.= " AND a.idkategori = $kat ";
		}
		if($status != ''){
			$sql.= " AND status = $status ";
		}
		$res = $this->db->query($sql);
		$r = $res->num_rows;
		$res->free_result();
		return $r;
	}

	function get_detail($id){
		$sql = "SELECT * FROM menu a join kategori b on a.idkategori = b.idkategori  WHERE idmenu= $id";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}

	function cek_hapus($id){
		$sql = "SELECT * FROM item_penjualan  WHERE idmenu=$id";
		$res = $this->db->query($sql);
		$r=$res->num_rows;
		$res->free_result();
		return $r;
	}
	
	function get_kategori($status = ''){
		$sql = "SELECT a.*,COUNT(b.idmenu) AS total FROM kategori a left join menu b on a.idkategori = b.idkategori ";
		if($status != ''){
			$sql.= " WHERE b.status = $status ";
		}
		$sql.= " GROUP BY a.idkategori ORDER by kategori ASC";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

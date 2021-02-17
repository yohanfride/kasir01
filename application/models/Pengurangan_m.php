<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pengurangan_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function search($s,$awal,$akhir,$id="",$lim=20,$off=0){
		$sql = "SELECT a.*,b.nama,b.jumlah_stok,b.satuan FROM pengurangan_stok a join stok b on a.idstok = b.idstok WHERE nama LIKE '%$s%' 
				AND a.date_add BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ";
		if($id){
			$sql.= " AND a.idstok = $id ";
		}
		$sql.= " ORDER by date_add DESC LIMIT $off, $lim";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_count($s,$awal,$akhir,$id=""){
		$sql = "SELECT * FROM pengurangan_stok a join stok b on a.idstok = b.idstok WHERE nama LIKE '%$s%' 
				AND a.date_add BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ";
		if($id){
			$sql.= " AND a.idstok = $id ";
		}
		$res = $this->db->query($sql);
		$r = $res->num_rows();
		$res->free_result();
		return $r;
	}

	function get_detail($id){
		$sql = "SELECT * FROM pengurangan_stok a join stok b on a.idstok = b.idstok  WHERE idpengurangan_stok= $id";
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
	
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

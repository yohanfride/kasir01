<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pembelian_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function search($s,$awal,$akhir,$lim=20,$off=0){
		$sql = "SELECT * from pembelian a WHERE faktur_pembelian LIKE '%$s%' 
				AND a.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ";
		$sql.= " ORDER by a.tanggal DESC LIMIT $off, $lim";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_count($s,$awal,$akhir){
		$sql = "SELECT * from pembelian a WHERE faktur_pembelian LIKE '%$s%' 
				AND a.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ";
		$res = $this->db->query($sql);
		$r = $res->num_rows();
		$res->free_result();
		return $r;
	}

	function get_detail($id){
		$sql = "SELECT * FROM pembelian WHERE idpembelian = '$id'";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();

		$sql2 = "SELECT * FROM item_pembelian a join stok b on a.idstok = b.idstok  
				 WHERE idpembelian = '$id'";
		$res2 = $this->db->query($sql2);
		$r2=$res2->result();
		$res2->free_result();
		$r->item = $r2;
		return $r;
	}

	function search_item($s,$awal,$akhir,$idstok="",$lim=20,$off=0){
		$sql = "SELECT * from item_pembelian a join penjualan d on a.idpembelian = d.idpembelian
				join stok b on a.idstok = b.idstok				
				WHERE b.nama LIKE '%$s%' AND d.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ";
		if($idmenu != ''){
			$sql.= " AND a.idmenu = $idmenu ";
		}
		$sql.= " ORDER by date_add DESC LIMIT $off, $lim";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}
	
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

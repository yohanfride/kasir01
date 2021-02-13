<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class transaksi_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function search($s,$awal,$akhir,$status_bayar="",$status_dilayanani="",$lim=20,$off=0){
		$sql = "SELECT * from penjualan a WHERE faktur LIKE '%$s%' 
				AND a.date_add BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ";
		if($status_bayar != ''){
			$sql.= " AND a.status_bayar = $status_bayar ";
		}
		if($status_dilayanani != ''){
			$sql.= " AND a.status_dilayanani = $status_dilayanani ";
		}
		$sql.= " ORDER by date_add DESC LIMIT $off, $lim";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_count($s,$awal,$akhir,$status_bayar="",$status_dilayanani=""){
		$sql = "SELECT * from penjualan a WHERE faktur LIKE '%$s%' 
				AND a.date_add BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ";
		if($status_bayar != ''){
			$sql.= " AND a.status_bayar = $status_bayar ";
		}
		if($status_dilayanani != ''){
			$sql.= " AND a.status_dilayanani = $status_dilayanani ";
		}
		$res = $this->db->query($sql);
		$r = $res->num_rows();
		$res->free_result();
		return $r;
	}

	function get_detail($id){
		$sql = "SELECT * FROM penjualan WHERE faktur = '$id'";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();

		$sql2 = "SELECT * FROM item_penjualan a join menu b on a.idmenu = b.idmenu left join kategori c on b.idkategori = c.idkategori  
				 WHERE faktur = '$id'";
		$res2 = $this->db->query($sql2);
		$r2=$res2->result();
		$res2->free_result();
		$r->item_penjualan = $r2;

		return $r;
	}

	function search_item($s,$awal,$akhir,$idmenu="",$lim=20,$off=0){
		$sql = "SELECT * from item_penjualan a join penjualan d on a.faktur = d.faktur
				join menu b on a.idmenu = b.idmenu left join kategori c on b.idkategori = b.idkategori				
				WHERE b.menu LIKE '%$s%' AND d.date_add BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ";
		if($idmenu != ''){
			$sql.= " AND a.idmenu = $idmenu ";
		}
		$sql.= " ORDER by date_add DESC LIMIT $off, $lim";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function get_faktur($awal,$akhir){
		$sql = "SELECT faktur from penjualan WHERE date_add BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ORDER by idpenjualan DESC";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}
	
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

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
		$sql = "SELECT * from item_pembelian a join pembelian d on a.idpembelian = d.idpembelian
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


	function search_daily($awal,$akhir){
		$sql = "SELECT date(a.tanggal) as tanggal, SUM(total) as total from pembelian a 
				WHERE  a.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' 
				GROUP BY date(a.tanggal) ORDER by tanggal ASC ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_week($awal,$akhir){
		$sql = "SELECT CONCAT( year(a.tanggal),' W', week(a.tanggal) ) AS minggu, SUM(total) as total from pembelian a 
				WHERE  a.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' 
				GROUP BY week(a.tanggal) ORDER by tanggal ASC ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_month($year){
		$sql = " SELECT IFNULL(total, 0) AS item_total, c.id as bulan FROM bulan c LEFT JOIN 
			( SELECT month(a.tanggal) AS bulan, SUM(total) as total, year(a.tanggal) AS tahun from pembelian a 
			WHERE year(a.tanggal) = '$year' 
			GROUP BY month(a.tanggal) ORDER by bulan ASC ) b ON b.bulan = c.id";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function get_tahun(){
		$sql = "SELECT year(a.tanggal) as tahun from pembelian a 
				GROUP BY year(a.tanggal) ORDER by tahun DESC ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_bahan($awal,$akhir){
		$sql = "SELECT c.nama as bahan, IFNULL(e.total, 0) AS total, IFNULL(e.jumlah, 0) AS jumlah FROM stok c LEFT JOIN 
				( SELECT a.idstok, SUM(a.harga) as total, SUM( a.jumlah) as jumlah from item_pembelian a JOIN pembelian b ON a.idpembelian = b.idpembelian  
				WHERE b.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' GROUP BY a.idstok ) e ON e.idstok = c.idstok"; 		
		$sql.= " ORDER BY total DESC";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_bahan_daily($awal,$akhir,$bahan){
		$sql = "SELECT date(b.tanggal) as tanggal, c.nama, SUM(a.harga) as total, SUM(a.jumlah) as jumlah from item_pembelian a 
				JOIN pembelian b ON a.idpembelian = b.idpembelian JOIN stok c ON a.idstok = c.idstok
				WHERE b.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' AND c.idstok = $bahan
				GROUP BY date(b.tanggal) ORDER by tanggal ASC ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}
	
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

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

	function search_daily($awal,$akhir){
		$sql = "SELECT date(a.date_add) as tanggal, SUM(total) as total from penjualan a WHERE a.status_bayar = 1  
				AND a.date_add BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' 
				GROUP BY date(a.date_add) ORDER by date_add ASC ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_week($awal,$akhir){
		$sql = "SELECT CONCAT( year(a.date_add),' W', week(a.date_add) ) AS minggu, SUM(total) as total from penjualan a WHERE a.status_bayar = 1  
				AND a.date_add BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' 
				GROUP BY week(a.date_add) ORDER by date_add ASC ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_month($year){
		$sql = " SELECT IFNULL(total, 0) AS item_total, c.id as bulan FROM bulan c LEFT JOIN 
			( SELECT month(a.date_add) AS bulan, SUM(total) as total, year(a.date_add) AS tahun from penjualan a 
			WHERE a.status_bayar = 1  AND year(a.date_add) = '$year' 
			GROUP BY month(a.date_add) ORDER by bulan ASC ) b ON b.bulan = c.id";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
		///CONCAT('$year M',c.id )
	}

	function get_tahun(){
		$sql = "SELECT year(a.date_add) as tahun from penjualan a WHERE a.status_bayar = 1  
				GROUP BY year(a.date_add) ORDER by tahun DESC ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}
	
	function search_category($awal,$akhir){
		$sql = "SELECT IFNULL(SUM(b.harga * b.jumlah), 0) as total, IFNULL(SUM( b.jumlah), 0) as jumlah, 
				d.kategori as kategori from penjualan a JOIN item_penjualan b ON a.faktur = b.faktur 
				JOIN menu c ON b.idmenu = c.idmenu JOIN kategori d ON c.idkategori = d.idkategori
				WHERE a.status_bayar = 1 AND a.date_add BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' 
				GROUP BY d.kategori ORDER BY total ASC";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_menu($awal,$akhir,$kat=""){
		$sql = "SELECT c.menu as menu, d.kategori as kategori, IFNULL(e.total, 0) AS total, IFNULL(e.jumlah, 0) AS jumlah  FROM menu c
				JOIN kategori d ON c.idkategori = d.idkategori LEFT JOIN 
				( SELECT a.idmenu, SUM(a.harga * a.jumlah) as total, SUM( a.jumlah) as jumlah from item_penjualan a JOIN penjualan b ON a.faktur = b.faktur  
				WHERE b.status_bayar = 1  AND b.date_add BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' GROUP BY a.idmenu ) e ON e.idmenu = c.idmenu"; 		
		if($kat){
			$sql.= " WHERE c.idkategori = $kat ";
		}
		$sql.= " ORDER BY total DESC";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_category_daily($awal,$akhir,$kat){
		$sql = "SELECT date(b.date_add) as tanggal, d.kategori, SUM(a.harga * a.jumlah) as total, SUM( a.jumlah) as jumlah from item_penjualan a 
				JOIN penjualan b ON a.faktur = b.faktur JOIN menu c ON a.idmenu = c.idmenu JOIN kategori d ON c.idkategori = d.idkategori 
				WHERE b.status_bayar = 1  AND b.date_add BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' AND c.idkategori = $kat
				GROUP BY date(b.date_add) ORDER by tanggal ASC ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_menu_daily($awal,$akhir,$menu){
		$sql = "SELECT date(b.date_add) as tanggal, c.menu, SUM(a.harga * a.jumlah) as total, SUM( a.jumlah) as jumlah from item_penjualan a 
				JOIN penjualan b ON a.faktur = b.faktur JOIN menu c ON a.idmenu = c.idmenu
				WHERE b.status_bayar = 1  AND b.date_add BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' AND c.idmenu = $menu
				GROUP BY date(b.date_add) ORDER by tanggal ASC ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */


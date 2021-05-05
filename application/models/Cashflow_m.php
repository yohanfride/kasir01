<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class cashflow_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function search($s,$awal,$akhir,$akun="",$jenis="",$lim=20,$off=0){
		$sql = "SELECT * from keuangan a WHERE ( faktur LIKE '%$s%')
				AND a.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ";
		if($akun != ''){
			$sql.= " AND nama_akun = '$akun' ";
		}
		if($jenis != ''){
			$sql.= " AND a.jenis = '$jenis' ";
		}
		$sql.= " ORDER by date_add DESC LIMIT $off, $lim";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_count($s,$awal,$akhir,$akun="",$jenis=""){
		$sql = "SELECT * from keuangan a WHERE ( faktur LIKE '%$s%')
				AND a.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ";
		if($akun != ''){
			$sql.= " AND nama_akun = '$akun' ";
		}
		if($jenis != ''){
			$sql.= " AND a.jenis = '$jenis' ";
		}
		$res = $this->db->query($sql);
		$r = $res->num_rows();
		$res->free_result();
		return $r;
	}

	function search_total($s,$awal,$akhir,$akun="",$jenis=""){
		$sql = "SELECT SUM(debit) as pemasukan, SUM(kredit) as pengeluaran from keuangan a WHERE ( faktur LIKE '%$s%' or nama_akun LIKE '%$s%' or jenis LIKE '%$s%')
				AND a.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ";
		if($akun != ''){
			$sql.= " AND nama_akun = '$akun' ";
		}
		if($jenis != ''){
			$sql.= " AND a.jenis = '$jenis' ";
		}
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}

	function get_detail($id){
		$sql = "SELECT * FROM keuangan WHERE idkeuangan = '$id'";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}

	function cekhapus($id){
		$sql = "SELECT * FROM keuangan WHERE idkeuangan = '$id' AND ( nama_akun = 'PENJUALAN' OR nama_akun = 'PEMBELIAN' ) ";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}

	function search_daily($awal,$akhir, $jenis=""){
		$sql = "SELECT date(a.tanggal) as tanggal, IFNULL(SUM(debit),0) as pemasukan, IFNULL(SUM(kredit),0) as pengeluaran from keuangan a 
				WHERE  a.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ";
		if($jenis != ''){
			$sql.= " AND a.jenis = '$jenis' ";
		}
		$sql.= "GROUP BY date(a.tanggal) ORDER by tanggal ASC ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_week($awal,$akhir, $jenis=""){
		$sql = "SELECT CONCAT( year(a.tanggal),' W', week(a.tanggal) ) AS minggu, IFNULL(SUM(debit),0) as pemasukan, IFNULL(SUM(kredit),0) as pengeluaran 
				from keuangan a WHERE  a.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ";
		if($jenis != ''){
			$sql.= " AND a.jenis = '$jenis' ";
		}
		$sql.= "GROUP BY week(a.tanggal) ORDER by tanggal ASC ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_week2($awal,$akhir, $jenis=""){
		$sql = "SELECT week(a.tanggal) AS minggu, year(a.tanggal) as tahun, IFNULL(SUM(debit),0) as pemasukan, IFNULL(SUM(kredit),0) as pengeluaran 
				from keuangan a WHERE  a.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ";
		if($jenis != ''){
			$sql.= " AND a.jenis = '$jenis' ";
		}
		$sql.= "GROUP BY week(a.tanggal) ORDER by tanggal ASC ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_month($year, $jenis=""){
		$sql = "SELECT pemasukan, pengeluaran, c.id as bulan FROM bulan c LEFT JOIN 
				( SELECT month(a.tanggal) AS bulan, IFNULL(SUM(debit),0) as pemasukan, IFNULL(SUM(kredit),0) as pengeluaran,
			 	year(a.tanggal) AS tahun from keuangan a  WHERE year(a.tanggal) = '$year' ";
		if($jenis != ''){
			$sql.= " AND a.jenis = '$jenis' ";
		}
		$sql.= "GROUP BY month(a.tanggal) ORDER by bulan ASC ) b ON b.bulan = c.id";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function get_tahun(){
		$sql = "SELECT year(a.tanggal) as tahun from keuangan a 
				GROUP BY year(a.tanggal) ORDER by tahun DESC ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_akun($awal,$akhir, $jenis=""){
		$sql = "SELECT c.akun as akun, IFNULL(pemasukan, 0) as pemasukan, IFNULL(pengeluaran, 0) as pengeluaran FROM akun c LEFT JOIN 
				( SELECT a.nama_akun,  IFNULL(SUM(debit),0) as pemasukan, IFNULL(SUM(kredit),0) as pengeluaran from keuangan a 
				WHERE a.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' GROUP BY a.nama_akun ) e ON e.nama_akun = c.akun"; 		
		$sql.= " ORDER BY (pemasukan + pengeluaran) DESC";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_akun_daily($awal,$akhir,$akun, $jenis=""){
		$sql = "SELECT date(a.tanggal) as tanggal, IFNULL(SUM(debit),0) as pemasukan, IFNULL(SUM(kredit),0) as pengeluaran from keuangan a 
				WHERE  a.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' AND a.nama_akun = '$akun' ";
		if($jenis != ''){
			$sql.= " AND a.jenis = '$jenis' ";
		}
		$sql.= "GROUP BY date(a.tanggal) ORDER by tanggal ASC ";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}
	
	function search_all($awal,$akhir,$order='date_add DESC',$akun="",$jenis=""){
		$sql = "SELECT * from keuangan a WHERE a.tanggal BETWEEN '$awal 00:00:00' AND '$akhir 23:59:59' ";
		if($akun != ''){
			$sql.= " AND nama_akun = '$akun' ";
		}
		if($jenis != ''){
			$sql.= " AND a.jenis = '$jenis' ";
		}
		$sql.= " ORDER by $order";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

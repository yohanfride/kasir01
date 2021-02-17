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

}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

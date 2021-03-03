<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class user_m extends My_Model{
	protected $table = "tbl_user";

	public function __construct(){
		parent ::__construct();
	}

	function cek_password($id='', $pass=''){
		$sql="SELECT COUNT(*) as jumlah FROM users WHERE user_id='".$id."' AND password='".$pass."' ";
		$q=$this->db->query($sql);
		$data = $q->row();
		$q->free_result();
		return $data->jumlah;
	}

	function search($s,$role="",$status=""){
		$sql = "SELECT * FROM users WHERE  ( username LIKE '%$s%' or name LIKE '%$s%' )";
		if($role){
			$sql.= " AND role = '$role' ";
		}
		if($status != ''){
			$sql.= " AND status = $status ";
		}
		$sql.= " ORDER by user_id ASC";
		$res = $this->db->query($sql);
		$r=$res->result();
		$res->free_result();
		return $r;
	}

	function search_count($s,$role="",$status=""){
		$sql = "SELECT * FROM users WHERE  ( username LIKE '%$s%' or name LIKE '%$s%' )";
		if($kat){
			$sql.= " AND role = '$role' ";
		}
		if($status != ''){
			$sql.= " AND status = $status ";
		}
		$sql.= " ORDER by user_id ASC";
		$res = $this->db->query($sql);
		$r = $res->num_rows();
		$res->free_result();
		return $r;
	}

	function get_detail($id){
		$sql = "SELECT * FROM users WHERE user_id= $id";
		$res = $this->db->query($sql);
		$r=$res->row();
		$res->free_result();
		return $r;
	}

}

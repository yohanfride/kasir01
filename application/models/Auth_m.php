<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class auth_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			

	function login($user,$pass){
		$sql = "SELECT * FROM users WHERE (username='$user' AND password = '$pass')";
		$res = $this->db->query($sql);
		$r='';
		if ($res->num_rows() > 0) {
            $r = $res->row();
        }else {
        	$r = false;
        }
		$res->free_result();
		return $r;
	}

}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

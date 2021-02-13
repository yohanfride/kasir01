<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class toko_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			

	function get(){
		$sql = "SELECT * FROM toko WHERE id=1";
		$res = $this->db->query($sql);
        $r = $res->row();
		$res->free_result();
		return $r;
	}

}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cartank_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function get_detail($id){
		$data = array(
			"id" => $id,
			"take" => 1
		);
		$url = $this->config->item('url_node')."cartank/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function search($data){
		$url = $this->config->item('url_node')."cartank/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function searchIn($key,$id){
		$data = array(
			'query' => array(
				"$key" => array(
					"in" => $id
				)
			)
		);
		$url = $this->config->item('url_node')."cartank/get/";				
		//$url = "http://apps.easybensin.com:7610/cartank/get";
		return json_decode($this->sendPostJson($url,$data));
	}

}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

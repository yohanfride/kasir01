<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class cargoinspection_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function get_detail($id){
		$data = array(
			"id" => $id,
			"take" => 1
		);
		$url = $this->config->item('url_node')."cargoinspection/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function add($data){
		$url = $this->config->item('url_node')."cargoinspection/insert/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit($id,$data){
		$data+=["id" => $id];
		$url = $this->config->item('url_node')."cargoinspection/update/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."cargoinspection/delete/";				
		return json_decode($this->sendPost($url,$data));
	}	

	function search($data){
		$url = $this->config->item('url_node')."cargoinspection/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function search_count($data){
		$url = $this->config->item('url_node')."cargoinspection/total/";				
		return json_decode($this->sendPost($url,$data));
	}

	function status($id,$status){
		$data = array(
			"id" => $id,
			"status" => $status
		);
		$url = $this->config->item('url_node')."cargoinspection/status/";				
		return json_decode($this->sendPost($url,$data));
	}

}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

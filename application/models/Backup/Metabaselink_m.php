<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class metabaselink_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function get_detail($id){
		$data = array(
			"id" => $id,
			"take" => 1
		);
		$url = $this->config->item('url_node')."metabaselink/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function get_detail_code($id){
		$data = array(
			"code" => $id,
			"take" => 1
		);
		$url = $this->config->item('url_node')."metabaselink/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function add($data){
		$url = $this->config->item('url_node')."metabaselink/insert/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit($id,$data){
		$data+=["id" => $id];
		$url = $this->config->item('url_node')."metabaselink/update/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."metabaselink/delete/";				
		return json_decode($this->sendPost($url,$data));
	}	

	function search($data){
		$url = $this->config->item('url_node')."metabaselink/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function search_count($data){
		$url = $this->config->item('url_node')."metabaselink/total/";				
		return json_decode($this->sendPost($url,$data));
	}


}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

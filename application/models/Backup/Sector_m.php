<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sector_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			
	
	function get_detail($id){
		$data = array(
			"id" => $id,
			"take" => 1
		);
		$url = $this->config->item('url_node')."sector/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function get_group(){
		$data = array(
			"groupby" => "group"
		);
		$url = $this->config->item('url_node')."sector/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function add($data){
		$url = $this->config->item('url_node')."sector/insert/";				
		return json_decode($this->sendPost($url,$data));
	}

	function edit($id,$data){
		$data+=["id" => $id];
		$url = $this->config->item('url_node')."sector/update/";				
		return json_decode($this->sendPost($url,$data));
	}
	
	function del($id){
		$data = array(
			"id" => $id
		);
		$url = $this->config->item('url_node')."sector/delete/";				
		return json_decode($this->sendPost($url,$data));
	}	

	function search($data){
		$url = $this->config->item('url_node')."sector/get/";				
		return json_decode($this->sendPost($url,$data));
	}

	function search_count($data){
		$url = $this->config->item('url_node')."sector/total/";				
		return json_decode($this->sendPost($url,$data));
	}

	function create_geojson($group){
		$data = array(
			"group" => $group
		);
		$url = $this->config->item('url_node')."sector/creategeojson/";				
		return json_decode($this->sendPost($url,$data));
	}

}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

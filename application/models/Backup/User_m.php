<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class user_m extends My_Model{
	private $aes;
	
	function __construct() {
		parent::__construct();		
	}			

	function get_detail($user){
		$url = $this->config->item('url_node')."user/detail/".$user;				
		return json_decode($this->getData($url));
	}

	function edit($user,$data){
		$url = $this->config->item('url_node')."user/edit/".$user;				
		return json_decode($this->sendPost($url,$data));
	}

	function pass($user,$data){
		$url = $this->config->item('url_node')."user/pass/".$user;				
		return json_decode($this->sendPost($url,$data));
	}

	function login($username, $pass){
		$data = array(
			"username" => $username,
			"password" => $pass
		);
		$url = $this->config->item('url_node')."user/login/";				
		return json_decode($this->sendPost($url,$data));
	}

	function reset_password($data){
		$url = $this->config->item('url_node')."user/resetpassword/";				
		return json_decode($this->sendPost($url,$data));
	}
}

/* End of file admin_model.php */
/* Location: ./application/models/admin_Model.php */

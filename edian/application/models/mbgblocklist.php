<?php
//其中的所有的函数已经转移到了user.php中了
class Mbgblocklist extends Ci_Model{
	function __construct()				{
		parent::__construct()				;
	}
	function showBlockAll(){
		$res=$this->db->query("select * from user where block = 1");
		return $res->result();
	}
	function enable_user($user_id){
		return $this->db->query("update user set block = '0' where user_id = '$user_id'");
	}

}
?>	

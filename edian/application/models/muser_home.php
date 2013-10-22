<?php

/*******************************************
 *目前已经没有用处了，它被user.php取代`
 *这里对应的控制器是user——home，主要是为了用户空间服务的，
 */
class Muser_home extends Ci_Model{
	function __construct(){
		parent::__construct();
	}
	function getInfo($id){
		//通过用户id得到用户信息的函数
		$sql="select * from  user where user_id = '$id' ";
		$res=$this->db->query($sql);
		return $res->result();
	}
}
?>	

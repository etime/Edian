<?php
//目前其中的函数已经被转移到了user.php
class Mbgnewreg extends Ci_Model{
		function __construct()				{
				parent::__construct()				;
		}
		function newget(){
				//选择刚刚注册的初始值为-1 	的用户,只有通过检查的可以赋值为0以上
				$res=$this->db->query("select * from user where user_level = -1");
				return $res->result();
		}
}
?>	

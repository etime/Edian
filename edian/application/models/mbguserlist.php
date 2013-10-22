<?php
//目前这个函数已经没有了用处
		class Mbguserlist extends Ci_Model{
				function __construct()				{
						parent::__construct()				;
				}
				function showuser_all(){
						$sql="select * from user "				;
						$res=$this->db->query($sql);
						return $res->result();
				}
				function user_del($id){
						$res=$this->db->query("delete from user where user_id = '$id'");
						return $res;
				}
				function  user_Block($id){
						$res=$this->db->query("update user set block = 1 where user_id = '$id'")				;
						return $res;
				}
		}
?>	

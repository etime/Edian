<?php
		class Mreg extends Ci_Model{//目前应该算是被放弃的文件了吧，虽说删除后又找回来，只是功能已经差不多被代替了
				function __construct()				{
						parent::__construct()				;
				}
				function checkname($name){
						$sql="select user_name,user_id,user_passwd from user where user_name = '$name'";
						$res=$this->db->query($sql);
						return $res->result();
				}
				public function newreg($name,$passwd)
				{
					$sql="insert into user(user_name,user_passwd,reg_time,user_level) values('$name','$passwd',now(),'1')";
					$res=$this->db->query($sql);
					return $res;//我记得这里应该是返回true或者是失败吧。因为0级算是root的用户了，所以不能够给出来，通过这里 注册的都是一级用户，也就是普通的用户
					return $res->result();
				}
		}
?>	

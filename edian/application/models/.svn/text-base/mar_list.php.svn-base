<?php//需要将其中的art整理到art.php
		class Mar_list extends Ci_Model{
				function __construct()				{
						parent::__construct();
				}
				/********** 罗列出所有关于ｓｅｓｓｉｏｎ ｉｄ的东西***********/
				function listall($id){
						$res=$this->db->query("select time,title from art where author_id = '$id'")	;
						return $res->result();
				}
				function list_perpage($user_id,$from,$per_page){
						$res=$this->db->query("select time,title from art where author_id = $user_id limit $from,$per_page");
						return $res->result();
				}
		}
?>	

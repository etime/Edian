<?php
class Bghome extends Ci_Model{
		function __construct(){
				parent::__construct()		;
		}		
		function artlist_all(){
				$res=$this->db->query("select time,author_id,title,art_id from art ");
				return $res->result();
		}
		function artdel($id){
			$res=$this->db->query("delete  from art where art_id = '$id'");
		return $res->result();
		}
		function getArtById($id){
				$res=$this->db->query("select * from art where art_id = '$id'")	;
				return $res->result();
		}
}
?>	

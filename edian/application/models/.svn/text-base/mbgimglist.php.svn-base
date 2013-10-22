<?php
class Mbgimglist extends Ci_Model{
	function __construct()				{
		parent::__construct()			;
	}
	function showimg_all(){
		/*$sql="select * from img where user_id = $user_id"				;
		 *将来根据需要，使用上面的功能
		 */
		$sql="select * from img";
		$res=$this->db->query($sql);
		return $res->result();
	}
	function imgdel($name){
		$sql="delete  from img where img_name  = '$name'"				;
		$res=$this->db->query($sql);
		return $res;
	}
}	
?>	

<?php
/* ***************************************
 *这里是为user_photo的控制器服务的
 *
 * */
class Mphoto extends Ci_Model{
	function __construct(){
		parent::__construct();
	}
	function getimg_id($user_id){
		/*
		 * 通过用户的id，得到该用户所有的图片的id的函数
		 *
		 */
		$sql="select img_id from img where user_id = '$user_id'";
		$res=$this->db->query($sql);
		return $res->result();
	}
	function img_name($img_id){
		/*
		 * 通过img——id得到图片名称的函数
		 */
		$sql="select img_name from img where img_id = '$img_id'";
		$res=$this->db->query($sql);
		return $res->result();
	}
	function img_info(){
		/****************************
		 * 通过img_id得到图片信息的函数
		 */
		$sql="select * from img where img_id = '$img_id'";
		$res=$this->db->query($sql);
		return $res->result();
	}      
}



?>	

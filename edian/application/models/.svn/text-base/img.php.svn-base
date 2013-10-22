<?php
/**
 * 这个文件存贮了所有关于img的操作
 **/
class Img extends Ci_Model
{

	function __construct()
	{
		parent::__construct();
	}
	function mupload($name,$upload_name,$id){
		//向数据库中添加上传的图片的信息
		$res=$this->db->query("insert into img(img_id,user_id,img_name,upload_name,upload_time) values('','$id','$name','$upload_name',now())");
		return $res;
		//return $res->result();
		//如果使用$res->result的话,会报错,说没办法转为string,而直接return $res答案是正确的
	}
	function getImgName($user_id){
		//获得该用户所有上传的图片的服务器名称
		$res = $this->db->query("select img_name from img where user_id  = $user_id");
		return $res->result();
	}

	function user_photo($name,$user_id){        
		//这个是为用户上传头像的函数
		$sql="update user set user_photo = '$name' where user_id = '$user_id'";
		return $this->db->query($sql);
	}  
	function judgesame($name){
		//检查是否有相同的图片名字,存在的函数
		$sql="select img_id from img where upload_name = '$name'";
		$res=$this->db->query($sql);
		return $res->result();
	}   
	function showimg_all(){
		/*$sql="select * from img where user_id = $user_id"				;
		 *将来根据需要，使用上面的功能,其实下面的很不科学，应该加上一个from
		 */
		$sql="select * from img";
		$res=$this->db->query($sql);
		return $res->result_array();
	}
	function imgdel($name){
		$sql="delete  from img where img_name  = '$name'"				;
		$res=$this->db->query($sql);
		return $res;
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

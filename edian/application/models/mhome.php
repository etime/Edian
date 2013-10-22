<?php
//该函数关于img的操作已经被转移到了img.php中
class Mhome extends Ci_Model {
	function __construct(){
		parent::__construct();
	}
	function home_title(){
		$res = $this->db->query("select art_title,reg_time,art_id from art where user_id = 2 limit 0,10");
		return $res->result();
	}
	function mupload($name,$upload_name,$id){
		$res=$this->db->query("insert into img(img_id,user_id,img_name,upload_name,upload_time) values('','$id','$name','$upload_name',now())");
		return $res;
		//return $res->result();
		//如果使用$res->result的话,会报错,说没办法转为string,而直接return $res答案是正确的
	}
	function getImgName($user_id){
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
}
?>	

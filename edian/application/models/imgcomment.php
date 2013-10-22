<?php
/*
author:			unasm
email:			douunasm@gmail.com
last_modefied:	2013/04/16 01:03:47 AM
 */
/**
 * 这里的函数对应mysql imgComment，集中了所有的关于这个表的操作
 **/
class Imgcomment extends Ci_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
	public function insert($imgId,$content,$userId)
	{
		return $this->db->query("insert into imgComment(imgId,comment,userId,time) values('$imgId','$content','$userId',now())");
	}
	public function getByImgId($imgId)
	{
		//通过imgId获得所有关于imgId的评论的函数
		$res = $this->db->query("select time,comment,userId from imgComment where imgId = '$imgId'");
		return $res->result_array();
	}
}
?>

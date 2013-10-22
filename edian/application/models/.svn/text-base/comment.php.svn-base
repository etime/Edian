<?php
	/**
	 * 这个文件是处理评论这个表/mysql/blog/comment／它的各种操作都在这里
	 **/
	class Comment extends Ci_Model
	{
		
		function __construct()
		{
			parent::__construct();
			session_start();
		}
		public function getInfoById($id)
		{
			$sql="select * from comment where comment_id = '$id'";
			$res=$this->db->query($sql);
			return $res->result();
		}
		public function insertComment($user_id,$comment)
		{
			//这个是函数是插入评论的函数，表示还没有经过测试，性能未知，需要用户的id和评论的内容，时间由系统生成，表示我现在大量使用timestamp，或许兼容有问题
			$sql="insert into comment(user_id,comment,reg_time) values('$user_id',$comment,'now()')";
			return $this->db->query($sql);
		}
		public function delCommentById($id)
		{
			//通过comment的id删除评论的函数，尚未经过测试，
			return $this->db->query("delete from comment where where comment_id = '$id'");
		}
		public function upComment($id,$comment)
		{
			//通过id修改用户评论的函数，但是通过qq的来看，貌似不需要修改comment呢，为通过测试
			return $this->db->query("update comment set comment = '$comment',reg_time = 'now()' where comment_id  = '$id'");
		}
		public function getCommentId($artId)
		{
			//通过文章的id得到所有的这个文章的评论，未通过测试
			$sql="select comment_id from comment where art_id = '$artId'";
			$res=$this->db->query($sql);
			return $res->result();
		}
	}
?>

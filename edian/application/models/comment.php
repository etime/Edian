<?php
/*
 * author:			unasm
 * email:			douunasm@gmail.com
 > Last_modified:	2013-05-14 00:28:16
 *
 * comment 评论的正文，主体
 * reg_time 呵呵，不规范的老习惯，就是评论的时间
 * user_id 评论者的id
 * comment_id 主键，就是作为评论单独存在的id
 * art_id 为某一个商品信息评论
 * 这个文件是处理评论这个表/mysql/edian/comment／它的各种操作都在这里
 **/
	class Comment extends Ci_Model
	{

		function __construct()
		{
			parent::__construct();
		}
		public function getInfoById($id)
		{
			$sql="select * from comment where comment_id = '$id' ";
			$res=$this->db->query($sql);
			return $res->result();
		}
		private  function dataFb($array)
		{
			//对comment中有可能出现的功能字符进行转意
			if(count($array)==0)return $array;
			if(array_key_exists("comment",$array[0])){
				for($i = 0; $i < count($array);$i++){
					$array[$i]["comment"] = stripslashes($array[$i]["comment"]);
				}
			}
			return $array;
		}

		public function insertComment($art_id,$user_id,$comment)
		{
			//这个是函数是插入评论的函数,需要返回插入的comId,失败则返回0，需要用户的id和评论的内容，时间由系统生成，表示我现在大量使用timestamp，
			$comment = addslashes($comment);
			$sql="insert into comment(art_id,user_id,comment,reg_time) values($art_id,'$user_id','$comment',now())";
			if($this->db->query($sql))
			{
				//$ans = $this->db->query("select last_insert_id()")	;
				$ans = mysql_query("select last_insert_id()");
				$ans = mysql_fetch_array($ans);//获取刚刚插入的id
				if(count($ans))return $ans[0];
				return 0;
			}
			else $ans = 0;
			return $ans;
		}
		public function delCommentById($id)
		{
			//通过comment的id删除评论的函数，尚未经过测试，
			return $this->db->query("delete from comment where where comment_id = '$id'");
		}
        public function delAllArt($artId)
        {
            //删除artId相对应的全部评论
            $this->db->query("delete from comment where art_id = $artId");
        }
		public function upComment($id,$comment)
		{
			//通过id修改用户评论的函数，但是通过qq的来看，貌似不需要修改comment呢，为通过测试
			return $this->db->query("update comment set comment = '$comment',reg_time = 'now()' where comment_id  = '$id'");
		}
		public function getCommentById($artId)
		{
			//通过文章的id得到所有的这个文章的评论，未通过测试
			$sql="select comment_id,user_id,comment,reg_time from comment where art_id = '$artId' order by comment_id";
			$res=$this->db->query($sql);
			return $res->result_array();
		}
		public function getByUserId($userId)
		{
			$res = $this->db->query("select art_id from comment where user_id = '$userId'");
			return $res->result_array();
		}
		private function getArray($array)
		{//因为mysql对于数据的处理是返回$array[0][content]的形式，但是对于很多单独数据的情况下不是这个样子的，只是有一条的情况，则处理为返回content
			//处理只有单独一条的情况
			if(count($array)==1){
				$array = $this->dataFb($array);
				return $array[0];
			}
			return false;
		}
	}
?>

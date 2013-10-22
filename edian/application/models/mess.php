<?php
/**
 * author:			unasm
 * email:			douunasm@gmail.com
 * Last_modified:	2013-06-20 00:16:16
 * 这个文件是为message服务的，集成了所有的message的操作,所谓的message，就是站内信的函数
 
 * 尚未检查测试;
 *
 *
 *
 * senderId 索引，发送者的id
 * geterId 添加索引，接受者的id
 * title 邮件的标题，不能为空
 * body 可以为空，time 发送时间，以服务器时间为准，read_already,是否读取过
 * ，replyTo 因为有快捷回复的功能，当快捷回复的时候，只有内容，replyTo，表示是某个信息的回复
 **/
class Mess extends Ci_Model
{
	var $showNum;//每次显示的信息数	
	function __construct()
	{
		$this->showNum=15;
		parent::__construct();
	}
	public function getAllunread($user_id)
	{
		//获得一个用户所有的没有阅读过的信息
		$sql="select * from message where geterId = $user_id && read_already = 'N'";
		$res=$this->db->query($sql);
		return $this->dataFb($res->result_array());
	}
	private function dataFb($res)
	{//对body，title反转义
		for($i = 0; $i < count($res);$i++){
			$res[$i]["title"] = stripslashes($res[$i]["title"]);
			$res[$i]["body"] = stripslashes($res[$i]["body"]);
		}
		return $res;
	}
	private function getArray($arr)
	{
		if(count($arr))return $arr[0];
		return false;
	}
	private function titleFb($res)
	{//仅仅对title转义
		for($i = 0; $i < count($res);$i++){
			$res[$i]["title"] = stripslashes($res[$i]["title"]);
		}
		return $res;
	}
	public function isNewMessage($user_id)
	{
		//根据user_id判断是否有新的信息收到
		$sql="select 1 from message where geterId = $user_id && read_already = 'N' limit 1";
		$res=$this->db->query($sql);
		return $this->db->result();//这里的结果有待判断
	}
	public function getAll($userId)
	{
		$res = $this->db->query("select * from message where senderId = '$userId' && replyTo  = 0");
		return $this->dataFb($res->result_array());
	}
	public function getInMess($userId)
	{
		$res = $this->db->query("select senderId,geterId,title,time,read_already,messageId from message where geterId = '$userId' && replyTo  = 0");
		return $this->titleFb($res->result_array());
	}
	public function sendInMess($userId)
	{//目前是为sendBoxData提供后台服务的，为发件箱服务
		$res = $this->db->query("select senderId,geterId,title,time,read_already,messageId from message where senderId = '$userId' && replyTo  = 0");
		return $this->titleFb($res->result_array());
	}
	public function getById($messId)
	{
		$ans = $this->db->query("select body,senderId,geterId,title,time,read_already from message where messageId = '$messId' || replyTo  = '$messId' order by time");
		return $this->dataFb($ans->result_array());
	}
	public function getFirById($messId)
	{
		$ans = $this->db->query("select body,senderId,geterId,title,time,read_already from message where messageId = '$messId'");
		return $this->getArray($this->dataFb($ans->result_array()));
	}
	public function getRepById($messId)
	{//通过id获得所有的快捷回复,这里虽说有messId，但是结果集合却不是一个
		$ans = $this->db->query("select body,senderId,geterId,title,time,read_already from message where replyTo  = '$messId' order by time");
		return $this->dataFb($ans->result_array());
	}
	public function add($data)
	{
		//需要$data[sender],$data[geterId],$data[body],$data[title]
		$data["title"] = addslashes($data["title"]);
		$data["body"] = addslashes($data["body"]);
		$sql="insert message(senderId,geterId,body,title,time) values('$data[sender]','$data[geterId]','$data[body]','$data[title]',now())";
		return $this->db->query($sql);
	}
	public function readA($messId)
	{//将状态更改为已读
		$this->db->query("update message set read_already = 1 where messageId = '$messId'");
	}
	public function quickAdd($data)
	{
		$data["body"] = addslashes($data["body"]);//在model进行数据处理
		return $this->db->query("insert message(senderId,body,time,replyTo) values('$data[user_id]','$data[body]',now(),'$data[replyTo]')");
	}
	public function changeRead($message_id)
	{
		//修改message是否修改为已阅的标志,如果为false是成功，否则失败
		return $this->db->query("update message set read_already = 1 where messageId = $message_id");
	}
	public function deleteById($message_id)
	{
		//通过id删除信息
		return $this->db->query("delete from message where messageId = $message_id");
	}
	public function getpart($messId)
	{
		//根据messid获得参与双方的id
		$res = $this->db->query("select senderId,geterId from message where messageId = '$messId'");
		$res = $res->result_array();
		if(count($res))return $res[0];
		return false;
	}
}
?>

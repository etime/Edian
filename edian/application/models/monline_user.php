<?php
/**
 * 这个文件是对应的数据库monline_user
 **/
class Monline_user extends CI_Model
{
	var $sessionTime;	
	function __construct()
	{
		$this->sessionTime = 7200;//应该是2个小时的意思，时间戳应该是计算的秒数
		parent::__construct();
	}
	function check_online($user_id){
		//检查用户是否登陆
		$sql = "select * from online_user where user_id  = $user_id";
		$res = $this->db->query("$sql");
		return $res->result_array();
	}
	function delete($sessionId){
		$sql = "delete from online_user where session_id = $sessionId"	;
		$res = $this->db->query($sql);
		var_dump($res)	;
		echo "<br/>";
		var_dump("here is the model/monline_user/delete");
		die;
		return $res;
	}
	public function denglu($data)
	{
		//这个函数是为了登陆而设置的，增加用户的状态
		$res = $this->db->query("insert into online_user(user_id,user_name,passwd,denglu_time) VALUE($data['user_id'],$data['user_name'],$data['passwd'],$data['time'])");

		var_dump($res);
		die;
		return $res;
	}
	public function checkOnline($sessionId)
	{//超过session就删除，然后返回false，否侧返回用户信息数组
		$res = $this->db->query("select * from online_user where session_id  = $sessionId")	;
		//失败的情况返回false，成功可以if成功，，有待检测
		var_dump($res);
		var_dump("model/monline_user需要检验");
		die;
		if($res){
			$res = $res->result_array();
			if(now()-$res[0]["last_activity"]>$this->sessionTime)
			{
				$this->delete($res[0]["session_id"]);//之所以不选择使用数据库函数是因为担心消耗的问题，不过，数据库删除不是安全性能更好吗
				return false;
			}
			return $res;
		}
		return false;
	}
	public function changeTime($userId)
	{
		//修改最后的活动时间，一旦用户有任何活动，就更改last_activity;，因为int更快，所以选择了id作为索引
		$res = $this->db->query("update online_user set last_activity  = 'now()' where user_id  = $userId" );
		//正确的返回值是true吗？
		var_dump($res);
		echo "<br/>";
		var_dump("正确的返回值是true吗/Monline_user/changTime");
		die;
		return $res;
	}
}
?>

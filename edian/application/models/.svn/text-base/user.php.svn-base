<?php
/**
 * 这个文件是作为user这个表的操作类来使用的，所有关于user的函数，都在这里使用
 * 目前还是需要删除用户的选项，就到以后吧
 **/
class User extends Ci_Model
{

	function __construct()
	{
		parent::__construct();
		session_start();

	}
	private function author_check($permit_level)
	{
		//check the author of the user
		$level=$_SESSION["user_level"];//这里需要将来修改
		if($level<$permit_level)
			return false;
		return true;
	}
	public function getInfoById($id)
	{
		//这个函数是通过用户的id得到用户的信息的函数
		$sql="select * from user where user_id = $id";
		$res=$this->db->query($sql);
		return $res->result_array();
	}
	function checkname($name){
						$sql="select user_name,user_id,user_passwd from user where user_name = '$name'";
						$res=$this->db->query($sql);
						return $res->result_array();
				}
	public function showUserAll()

	{
		//这个函数的作用是输出数据库中所有的用户列表的函数
		$sql="select * from user";
		$res=$this->db->query($sql);
		return $res->result();
	}
	public function delUserById($id)
	{
		//这个函数是通过用户的id删除用户信息的
		$res=$this->db->query("delete from user where user_id = '$id'");
		return $res;
	}
	public function userBlockById($id)
	{
		//通过用户的id冻结用户帐号的函数
		return $this->db->query("update user set block = 1  where user_id = '$id'");
	}
	public function userEnbleById($id)
	{
		//通过用户的id解冻的函数
		return $this->db->query("update user set block = 0 where user_id = '$id'");
	}
	public function showBlockAll()
	{
		//输出所有的冻结了的用户
		$res=$this->db->query("select * from user where block = 1" );
		return $res->result();
	}
	public function updateUser()
	{//这个函数的作用是更新用户的文章的函数，还没有通过验证
		$this->title = $_POST['title'];
		$this->content=$_POST['content'];
		$this->date=time();
		$this->db->update('user',array('id'=>$_POST['id']));
	}
	public function getNew()
	{
		//选择刚刚注册的初始值为-1，通过验证才可以复制为0以上，标志这个是一个很鸡肋的选择，大概不需要吧，只要通过了验证，就可以了
		$res=$this->db->query("select * from user where user_level = -1");
		return $res->result();
	}
	public function insertUser($name,$passwd)
	{
		//插入用户的时候的函数
		$res=$this->db->query("insert into user(user_name,user_passwd,reg_time) values('$name','$passwd',now()");
		return $res;
	}
}
?>

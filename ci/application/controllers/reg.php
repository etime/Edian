<?php
//该文件的作用是处理登录和注册的，包含了所有的关于用户注册登陆的操作
class Reg extends Ci_Controller{
	function __construct(){
		parent::__construct()				;
		session_start();
	}
	function process()	{
		if($_POST['sub']){
			$sql="insert into user values('$_POST[user_name]','','$_POST[passwd]',now())";
			//$res= mysql_query($sql);
			if(mysql_query($sql)){
				$sql="select user_id,user_passwd from user where user_name='$_POST[user_name]'";
				$res=mysql_query($sql);
				$res=mysql_fetch_row($res);
				setcookie("user_id",$res[0],3600+time());
				setcookie("user_passwd",$res[1],3600+time());
				echo "<script language=javascript>window.location='./index.html'</script>";
			}
			else {
				echo "<script language=javascript> alert('很遗憾，注册失败')</script>";
			}
			//echo "here is a test from reg.php";
		}
	}
	public function index()
	{
		$this->load->view("reg");
	}
	function  denglu(){
		$data['attention']="";
		if(@$_POST['sub']){
			;	
		}
		$this->load->view("userDengLu",$data);
	}
	function get_user_name($name){
		//该函数是为前段的js服务的
		header("Content-Type: text/xml; charset=utf-8");
		$this->load->model("mreg");
		/*
		 * 预设中 checkname就是根据$name再数据库中比对，然后返回密码的。如果没有返回密码，则返回false；
		 */
		$res=$this->mreg->checkname($name);
		$ans="<root>";
		if($res)	
		{
			$ans.="<id>".$res[0]->user_id."</id>";
			$ans.="<passwd>".$res[0]->user_passwd."</passwd>";
			/*
			 * 生成xml然后通过js接受
			 */
		}
		else {
			$ans.="<id>0</id>";
		}
		$ans.="</root>";
		echo $ans;
	}
	function denglu_check(){
		/*
		 *之前的函数的作用是通过js判断用户的信息对否正确，这里为了安全，通过js判断另一次
		 在函数中进行userid和name的对比，保存cookie和session；
		 */	
		if($_POST['sub']){
			$this->load->model("mreg");
			$this->load->library("session");
			$res=$this->mreg->checkname($this->input->post("user_name"));//这里只是提取出了name,passwd,id,个人觉得，应该有很多东西值得做的事情，而不止是对比一下而已
			$res = $res[0];
			if($res->user_passwd==$this->input->post("passwd")){
				$this->session->set_userdata("user_id",$res->user_id);
				$this->session->set_userdata("user_name",$res->user_name);
				$this->session->set_userdata("passwd",$res->user_passwd);
				//因为无法读取session的缘故，取消这种方式，将来添加cookie
				//$this->id->alert("恭喜您登陆了");
				$data["uri"]=site_url("mainpage?".$res->user_id);
				$data["uriName"]="主页";
				$data["time"]=5;
				$data["title"]="登陆成功";
				$data["atten"] = "恭喜您，登陆成功";
				$this->load->view("jump",$data);
			}
			else {
				echo "<script type='text/javascript'>history.back()</script>";
			}
		}
	}
	public function dc($userName,$passwd)
	{
		header("Content-Type: text/xml; charset=utf-8");
//这个函数其实是对denglu_check的补充，这个是不需要form表单，通过ajax get的方式发送到这里进行判断，和session的操作，一切都是为了不再刷新	
		$this->load->model("mreg");
		$this->load->library("session");
		$res=$this->mreg->checkname($userName);//这里只是提取出了name,passwd,id,个人觉得，应该有很多东西值得做的事情，而不止是对比一下而已
		$res = $res[0];//I will check is  it work?
		$flag = 0;
		if($res->user_passwd == $passwd){
			$this->session->set_userdata("user_id",$res->user_id);
			$this->session->set_userdata("user_name",$res->user_name);
			$this->session->set_userdata("passwd",$res->user_passwd);
			$flag = 1;
		}
		$re = "<root>".$flag."</root>";
		echo $re;
	}
}	
?>	

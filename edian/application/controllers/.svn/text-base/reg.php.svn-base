<?php
//该文件的作用是处理登录和注册的，
class Reg extends Ci_Controller{
	function __construct(){
		parent::__construct()				;
				session_start();
	}
	function index()	{
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
		header("Cache-Control: no-cache");
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
			$res=$this->mreg->checkname($this->input->post("user_name"));
			if($res[0]->user_passwd==$this->input->post("passwd")){
				$this->load->library("id");
				$_SESSION['user_id']=$res[0]->user_id;
				$_SESSION['user_name']=$res[0]->user_name;
				$this->session->set_userdata("user_id",$res[0]->user_id);
				$this->session->set_userdata("user_name",$res[0]->user_name);
				var_dump($this->session->all_userdata());
				echo "<br/>".$_SESSION['user_id'];
				//因为无法读取session的缘故，取消这种方式，将来添加cookie
				$this->id->alert("恭喜您登陆了");
			}
			else {
				echo "<script type='text/javascript'>history.back()</script>";
			}
		}
	}
}	
?>	

<?php
class User_home  extends Ci_Controller{
	function __construct()				{
		parent::__construct() ;
		$this->load->model("muser_home");
		$this->load->library('id');
	}
	function index(){
		$data['title']="用户空间";
		$id=$this->uri->segment(4,-1);//在目前的情况下是四个uri段，以后或许会改吧
		/*********************下面是对$id的获得,没有用户id是无法登录******************************/
		if($id==-1){
		//	$id=$this->user_id_get();
			if($id==false){
				echo "请先登录";
				exit(-1);
			}
		}
		/***********************************************************/
		$res=$this->muser_home->getInfo($id);
		$data['user_name']=$res[0]->user_name;
		$data['reg_time']=$res[0]->reg_time;
		$data['user_photo']=$res[0]->user_photo;
		$this->load->view("homeUserspace",$data);
		$this->load->view("common_foot");
	}
	/*
	function user_id_get(){
	* 这个函数目前因为tianyi认为很实用，所以已经移动到了 library中的id类中了,如果出现了什么问题，将注释去掉，然后去掉__construct中的library id，就可以了
	 */
	/********************************************************
	 * 通过cookie和session的方式获得用户的id
	 ********************************************************/
	/*
		if(isset($this->session->userdata['user_id'])){
			return $this->session->userdata['user_id'];
		}
		else if(isset($_SESSION['user_id'])){
			return $_SESSION['user_id'];
		}
		return false ;
	}
	 */
}
?>	

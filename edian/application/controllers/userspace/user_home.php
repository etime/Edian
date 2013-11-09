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
}
?>

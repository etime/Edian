<?php
		class Userlist extends Ci_Controller{
				function __construct(){
						parent::__construct()				;
						$this->load->model("mbguserlist");
				}
				function index(){
						//显示ｍｙｓｑｌ中所有的用户,并且保存在userall中
						$data['userall']=$this->mbguserlist->showuser_all();
						$this->load->view("m-bg-userlist",$data);
				}
				function userDel($user_id){
						//通过用户名删除用户,并且重定向到bg/userlist/那个u页面
						$this->mbguserlist->user_del($user_id);
						redirect(site_url("bg/userlist"));
				}
				function  userBlock($user_id){
						$res=$this->mbguserlist->user_block($user_id);
						redirect(site_url("bg/userlist"));
				}
		}
?>	

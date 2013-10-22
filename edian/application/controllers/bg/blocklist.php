<?php
/*
 * 该文件的作用是显示/bg/home中冻结用户列表的显示操作等,对应的显示页面是m-bg-blocklist m的意思是model 只是一个模块页面,并不可以独立显示, bg表示他属于ｂｇ文件夹的一部分,blocklist表示对应的控制器blocklist 
 * 对应的后台页面是mbgblocklist m 
 */
		class Blocklist extends Ci_Controller{
				function  __construct()				{
						parent::__construct();
						$this->load->model("mbgblocklist");
				}
				function index(){
						$data['blockAll']=$this->mbgblocklist->showBlockAll()			;	
						$this->load->view("m-bg-blocklist",$data);
				}
				function enable($user_id){
						//该函数的作用是解冻用户,使用户成为正常用户				
						$res=$this->mbgblocklist->enable_user($user_id);
						redirect(site_url("bg/blocklist"));
				}
		}
?>	

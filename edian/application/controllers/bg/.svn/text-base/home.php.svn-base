<?php
		class Home extends Ci_Controller{
				function __construct()				{
						parent::__construct()				;
						$this->load->model("bghome");
				}
				function  index(){
						//echo "hello ,here is the bg/home.php ";
						//这里显示的应该是第三版本的后台的页面,通过div布局和iframe的页面
						$this->load->view("bghome");
				}
				function index_test(){
						//这里显示的是第二版本的页面，使用framset实现的大致还让人满意的布局
						$this->load->view("bghome_test");
				}
				function head(){
						$this->load->view("m-bghead");
						//echo "<h1>这里是管理员后台,正在建设中,请加油!!</h1>";
				}
				function leftdiruser(){
						$this->load->view("m-bg-home-leftdir-user");
				}
				function leftdirimg(){
						$this->load->view("m-bg-home-leftdir-img");
				}
				function leftdirart(){
						$this->load->view("m-bg-home-leftdir-art");
				}
				function content(){
						$this->load->view("m-bg-home-content");
				}
				function artlist(){
						$data['title']="文章列表";
						$data['allart']=$this->bghome->artlist_all();
						$this->load->view("m-bg-artlist2",$data);
						//$this->load->view("m-bg-home-artlist3",$data);
				}
				function  artdelete($id){
						$this->bghome->artdel($id);
						return $this->db->affected_rows();
						/*
						 * 依照我本意,期望能够能够有一个返回值 ,不过后期可以通过使用affect_num决定给前端一个提醒
						 */
				}
				function artchange($id){
						$this->load->library("ckeditor")	;
						$this->ckeditor->basePath=base_url().'ckeditor/';
						$this->ckeditor->Width="100";
						$this->ckeditor->Height="400";
						$data['cont']=$this->bghome->getArtById($id);
						$data['cke']=$this->ckeditor;
						$this->load->view("bgeditor",$data);
				}
				function  reditor($id){
						$this->load->model("meditor");
						$this->meditor->artchange($id);
						redirect(site_url('bg/home/artlist'));
				}
				function artshow($id){
						$data['art']=$this->bghome->getArtById($id);
					//	var_dump($data);
						$this->load->view("m-bg-artshow",$data);
				}
				function artadd(){
						$data['title']="添加文章";
						$this->load->view("m-bg-artadd",$data)					;
				}
				function comment(){
						$data['title']="评论模块";
						$this->load->view("m-comment",$data)				;
				}
		}
?>	

<?php
/*
 * 在下面的thumb函数中有一处使用了绝对路径的地方，将来更改的时候要注意，如果学会了如何读取config的话，可以替换掉。
 * 下面包括的函数包括上传处理，编辑器使用以及插入文章，分页，和缩小图片的生成
 * 上传的内容要从这里拆分出去，独立成一个class
 * */
class Chome extends Ci_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper(array('form'));
		$this->load->model('mhome');
		$this->load->library('id');
		session_start();
	}
	function index(){
		$data['title'] = $this->mhome->home_title();
		$this->load->view('home',$data);
	}
	function bubble(){
		$this->load->view("bubble")				;
	}
	function editor(){
		//这个函数是和edian数据库项符合的
		$this->load->library("ckeditor");
		$this->ckeditor->basePath=base_url().'ckeditor/';
		$this->ckeditor->Width="100";
		$this->ckeditor->Height="100";
		//$this->load->view("veditor");
		$cont="hello,here is ckeditor /chome/eidtor/";
		$data["cke"]=$this->ckeditor;
		$this->load->view("veditor",$data);
		//	$this->ckeditor->editor('content',$cont);
	}
	function reditor(){
		//这个函数是和edian数据库项符合的
		$title=$this->input->post("title");
		$cont=$this->input->post("content");
		$part_id=$this->input->post("part_id");
		$user_id=$this->input->post("user_id");//user_id不能这麽取得
		$time=$this->input->post("time");
		$this->load->model("art");
		$value=time();
		for($i = 0; $i < $time ;$i++){
			$re=$this->art->insert_art($title,$cont,$part_id,$user_id,$value);
			if($re)echo "<br/>insert into success;<br/>";
			else echo "<br/>发表失败``<br/>";
		}
	}
	function listart(){
		/*
		 * 这个应该是分页函数
		 */
		$this->load->library("pagination");
		$config['base_url']='http://localhost/index.php/chome/config/';
		$config['per_page']=2;
		$config['first_link']="首页";
		$config['prev_link']="上一页";
		$config['next_link']="下一页";
		$config['last_link']="尾页";
		$config['num_links']=3;
		$id=$this->uri->segment(3);
		if(!$id){
			$id=1;
		}
		$id--;
		$this->load->model("mar_list");
		$cont_page=$this->mar_list->list_perpage(2,$id,2);
		foreach($cont_page as $temp){
			echo $temp->title."  --------------".$temp->time."<br/>";
		}
		$ans=$this->mar_list->listall(2);
		$config['total_rows']=count($ans);
		//$config['total_rows']=20;
		//$config['use_page_numbers']=true;
		$this->pagination->initialize($config);
		echo $this->pagination->create_links();
		$this->load->view("artlist");
	}
	function ans_upload(){       
		//对上传进行处理的类	
		$config['max_size']='5000000';
		$config['max_width']='1224';
		$config['max_height']='900';
		$config['allowed_types']='gif|jpg|png|jpeg';//即使在添加PNG JEEG之类的也是没有意义的，这个应该是通过php判断的，而不是后缀名
		$config['upload_path']='./upload/';
		$config['file_name']=time().".jpg";    
		//$this->load->library('id');
		$this->upload->initialize($config);
		$user_id=$this->id->user_id_get();
		$this->id->alert($user_id);
		if($user_id==false){
			redirect(site_url("reg/denglu"));
		}
		$data['title']="图片";
		$data['attention']="";
		if($this->input->post("sub")){

			//   $this->load->model("mhome");
			$upload_name=$_FILES['userfile']['name'];        // 当图片名称超过100的长度的时候，就会出现问题，为了系统的安全，所以需要在客户端进行判断
			if($this->mhome->judgesame($upload_name)){
				$data['attupention']="您已经提交过同名图片了";
			}
			else {
				if(!$this->upload->do_upload()){
					$data['attention'] = $this->upload->display_errors()."请选择图片文件，保持宽度在1024高度在800之间，大小请不要超过2M";
				}
				else {
					$temp=$this->upload->data();
					$this->thumb_add($temp['full_path'],$temp['file_name']);
					$res=$this->mhome->mupload($temp['file_name'],$upload_name,$user_id);//这里的2将来要修改成为用户的id ,目前已经实现，但是还未经测试
					//因为担心用户的图片的名称会造成路径不支持的问题，所以决定增加同一名称，并且，保存原来的名称
					$data['attention']= "上传成功";
				}
			}
		}
		//		$this->load->view("vupload.php",$data);
	}   
	function thumb_add($path,$name){
		//生成缩小图的函数
		$config['image_library']='gd2';
		$config['source_image']=$path;
		$config['new_image']="/var/www/ci/user_photo/";//这个是复制新的图片使用的参数，保留原来的图片，然后使用新的图片。
		$config['create_thumb']=true;
		$config['maintain_ratio']=true;//保持原来的比例
		$config['width']=600;
		$config['height']=750;//我希望得到的效果是一个宽度最大为600，但是如果宽度超过一个屏幕也是不可以的，也是不必要的，一旦超过一个屏幕的时候，即使宽度已经小于600也要缩小
		$config['thumb_marker']="";//禁止自动添加后缀名
		//$config['master_dim']="auto";//自动设置定轴,目前觉得好无用处
		$this->load->library('image_lib',$config);
		if(!$this->image_lib->resize()){
			echo $this->image_lib->display_errors();
		}
	}               
	//下面该函数的作用是显示图片在m-showimg上面
	function showimg($id){
		//  $this->load->model("mhome")	;
		$data['name']=$this->mhome->getImgName($id);
		$data['id']=$id;
		$this->load->view('m-showimg',$data);
	}
	function test(){
		$this->load->view("common_head");
		$this->showimg(8);
		$this->load->view("common_foot");
	}
}
?>	

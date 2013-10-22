<?php
//在这个文件中有一个使用了绝对路径，就是/var/www/ci/这个将来是要更改的
//像session就应该在construct的时候直接开启，
class User_photo extends Ci_Controller{
	var $user_id="";
	//这个user_id是作为用户的id使用的，定义为全局变量，没有登录的时候，会成为false
	function __construct()				{
		parent::__construct();
		$this->load->model(array("mphoto",'mhome'));
		$this->load->helper('form');
		$this->load->library(array("id","upload"));
		session_start();
		$this->user_id=$this->id->user_id_get();
	}
	function index(){
		$data['title']="相册";
		$host_id=$this->uri->segment(4,-1);//这里的uri是index之后的东西
		$this->id->alert($host_id);
		if($host_id == -1)
			$host_id=$this->user_id;//默认情况下选择访问用户自己的id
		$this->id->alert($host_id);
		if($host_id){
			if(!isset($imgInfo))			{
				//echo "<script type='text/javascript'>alert('imginfo还没有设置')</script>";
				$data['img_all']=$this->mphoto->getimg_id($host_id);
				$data['img_num']=count($data['img_all']);
			}
		}
		else {
			$this->id->alert("您尚未登录");
			//  redirect(site_url("reg/denglu/"));
			//这种方法实在是太粗暴了，应该像新浪一样，给出一个弹窗，或者是新开一个tab
		}
		$this->load->view("homeUserphoto",$data);	
		$this->load->view("common_foot");
	}
	function photo(){
		//这个函数的作用是处理上传头像的
		$data['title']="上传头像";
		$data['attention']="这里是没有update之前 ";
		//if($this->input->post("sub")&&isset($this->session->userdata['user_id'])){//在user_id没有定义为全局变量之前的废弃的方法，一段时间发现没有用处之后，删除
		if($this->input->post("sub")&&($this->user_id)){
			$config['max_size']='20000000';
			$config['max_width']='10240';
			$config['max_height']='8000';
			$config['allowed_types']='gif|jpg|png';//即使在添加PNG JEEG之类的也是没有意义的，这个应该是通过php判断的，而不是后缀名
			$config['upload_path']='./upload/';
			// 当图片名称超过100的长度的时候，就会出现问题，为了系统的安全，所以需要在客户端进行判断,目前已经判断了，但是没有强制执行
			$this->upload->initialize($config);
			if($this->mhome->judgesame($_FILES['userfile']['name'])){
				$data['attention']="您已经提交过同名图片了";
			}          
			else{
				if(!$this->upload->do_upload()){
					$data['attention'] = $this->upload->display_errors()."请选择图片文件，保持宽度在1024高度在800之间，大小请不要超过2M";
				}
				else {
					$temp=$this->upload->data();
					/*$res=$this->mhome->mupload($temp['file_name'],$_SESSION['user_id']);
					 * 上面的语句是为了以后扩展使用的，一旦用户禁用了cookie，就使用session，不清楚仅用了cookie是否还可以使用ci的session
					 */
					if($this->shrink($temp['full_path'],$temp['file_name'],93,100)){
						$data['attention']= "上传成功";
						/*这里的shrink需要三个参数一个是包含了路径的$name，一个是生成的小图的宽度和高度
						 * 根据在前段的设置，宽度应该是93px，高度应该是100px
						 */
						if($this->mhome->user_photo($temp['file_name'],$this->session->userdata['user_id'])){
							/*
							 * 这里就留给将来扩展使用吧
							 */				
						}
						else {
							echo "<script type='text/javascript'>alert('很遗憾，头像更新失败了');</script>";
						}
					}
					else {
						$data['attention']="压缩图失败";
						//这里的操作是删除文件，因为产生缩小图失败所以。。
					}
				}
			}
		}
		$this->load->view("homeUserManPhoto.php",$data);
		$this->load->view("common_foot");
	}
	function shrink($path,$name,$width,$height) {
		/*这里的shrink需要三个参数一个是包含了路径的$name，一个是生成的小图的宽度和高度
		 * 这里的参数的意义是$PATH 指的是包含文件名在内的路径,$name图片的名称，不包含路径, $width,$height希望压缩的宽度和高度
		 */
		$img=getimagesize($path);
		switch($img[2]){
		case 1:$imgcode=imagecreatefromgif($path);
		break;
		case 2:$imgcode=imagecreatefromjpeg($path);
		break;
		case 3:$imgcode=imagecreatefrompng($path);
		break;                             
		}
		$new=imagecreatetruecolor($width,$height);
		imagecopyresized($new,$imgcode,0,0,0,0,$width,$height,$img[0],$img[1]);
		return imagejpeg($new,$path);
	}
	function img_show(){
		$id=$this->uri->segment(4,0);
		//   $this->load-library("id");
		//	$this->id->alert($id);
		$data['img']=$this->mphoto->img_name($id);
		$this->load->view("oneMainImg",$data);
	}
}
?>	      

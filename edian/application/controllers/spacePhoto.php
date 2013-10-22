<?php
/**
 * 这个是space的controller的操作集合，尚未完成
 * author:			unasm
 * email:			douunasm@gmail.com
 * last_modefied:	2012/12/04 02:24:06 CST
 * 
 **/
class SpacePhoto extends MY_Controller
{
	var $user_id,$user_name;	
	function __construct()
	{
		parent::__construct();
		$this->user_id=$this->user_id_get();
		$this->load->model("imgcomment");//comment要改变，下面有利用了这个model的函数
		$this->load->model("user");
	}
	public function index($mastId = -1)
	{
		if($mastId == -1)$mastId = $this->user_id;
		if(!$mastId)show_404();//其实可以提示登陆了
		$this->load->model("user");
		$temp = $this->user->getNess($mastId);
		if($temp == false){
			var_dump("tse");
			show_404();
			return ;
		}
		$data["title"] = $temp["user_name"];
		$data["masterId"] = $mastId;
		$data["photo"] = $temp["user_photo"];
		$this->load->view("spacePhoto",$data);
	}
	public function judge($imgId)
	{
		//这里对应的是用户的评价添加函数，将用户的添加数据保存到数据库，并将他们返回？或者是只返回一个标志位，然后在客户端添加数据
		if(!$this->user_id)$re["mark"] = -1;
		elseif ($this->judgeData($imgId))$re["mark"] = 1;
		else $re["mark"] = 0;
		if($re["mark"] == 1){
			$temp = $this->user->getNess($this->user_id);
			if($temp == false){
				//report("error");向管理员报错，目前算了，以后扩张
			}
			$re["photo"] = $temp["user_photo"];
		}
		echo json_encode($re);
	}
	public function getJudge($imgid = -1)
	{
		if($imgid == -1){
			echo "-1";
			return;
		}
		$ans["judge"] = $this->imgcomment->getByImgId($imgid);
		$this->load->model("img");
		for($i = 0; $i < count($ans["judge"]);$i++){
			$temp = $this->user->getNess($ans["judge"][$i]["userId"]);
			$ans["judge"][$i]["photo"] = $temp["user_photo"];
			$ans["judge"][$i]["name"] = $temp["user_name"];
		}
		$ans["main"] = $this->img->getDetail($imgid);
		echo json_encode($ans);
	}
	public function getThumb($user_id = -1)
	{
		//根据用户的Id获得所有的图片的缩略图，现在只是提供名称，将根据用户的点击不断添加缩略图
		if($user_id == -1){
			echo "0";
			return;
		}
		$this->load->model("img");
		$ans = $this->img->getUserImg($user_id);
		echo json_encode($ans);
	}
	public function getMainImg($imgId)
	{//根据imgId获得图片信息的函数，包括评价，简介，名称等等
	
	}
	private  function judgeData($imgId)
	{//对用户评价的数据处理部分，针对php和ajax两种不同方式，需要不同的回复
		if(!$this->user_id)exit("请登陆后评论");
		$content = $this->input->post("content");
		if($content == "")return false;
		$flag = $this->imgcomment->insert($imgId,$content,$this->user_id);
		if($flag)return $flag;
		else return false;
	}
	public function judgePhp($imgId)
	{
		if($_POST["sub"])
		$flag = $this->judgeData($imgId);
		if($flag)echo "发表成功";
		else echo "失败了";
	}
}
?>

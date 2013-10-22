<?php
/**
 * 这里对应的是mainpage2.php，操作包括为前段的js提供数据，对应的xml,逻辑上的各种操作，目前还不准备继承上层的类
 **/
class mainpage extends CI_Controller		
{
	//var $userInfo;	
	function __construct()
	{
		parent::__construct();
		$this->load->model("art");
		$this->load->model("user");
		/*
			session_start();
		 */
	}
	public function index()
	{
		//这里准备只是画面框架的内容，没有具体的信息，其他的，由js申请
		$this->load->view("mainpage2");
	}
	public function infoDel()
	{//处理显示消息的函数，为js服务,$part表示热区，其他的1,2,3表示分版块
		$part=$this->uri->segment(3,-1);
		if($part=="-1"){
			exit("part不正确，请根据链接浏览");
		}
		$id=$this->uri->segment(4,-1);
		if($id=="-1"){
			exit("mainpage->id不正确，请检查");
		}
		header("Content-Type: text/xml");
		if($part=="0")
			$re=$this->delHotInfo($id);
		else {
			$re=$this->delPartInfo($part,$id);
		}
		$re=$this->xmlData($re);
		echo $re;
		//显示热门消息的函数，$id的作用是提供显示的页数,貌似除了热门消息之外，其他的都是可以同一个函数和model处理的
	}
	private function delPartInfo($part_id,$id)
	{
		$data["part_id"]=$part_id;
		$data["id"]=$id;
		//处理其他版块的信息提供,part，表示版块号码，id表示页数
		return $this->art->getTop($data);
	}
	private function delHotInfo($id)
	{
		//$id,表示页数,
		$data["id"]=$id;
		return $this->art->getHot($data);
	}
	private function xmlData($ans){
		//将数据进行xml处理，因为gethot和partInfo其实数据类型一致为了将来修改方便，将原始数据的处理统一化
		$re="<root>";
		foreach ($ans  as $key) {
			$re.="<art_id>$key[art_id]</art_id>";
			$re.="<title>$key[art_title]</title>";
			$re.="<user_id>$key[user_id]</user_id>";
			$re.="<reg_time>$key[reg_time]</reg_time>";
			$author=$this->user->getInfoById($key["user_id"]);
			$author=$author[0]["user_name"];
			$re.="<author>$author</author>";
		}
		$re.="</root>";
		return $re;
	}
	public function getTotal($part_id)
	{
		header("Content-Type: text/xml");
		//根据part_id得到所有的本part_id的总数
		if(!isSet($part_id))
		{
			exit("请输入版块名");
		}
		$re="<root>";
		if($part_id==0){
			$num=$this->art->allTotal();
		}
		else {
			$num=$this->art->getTotal($part_id);
		}
		$re.="<total>".$num[0]["count(*)"]."</total>";
		$re.="</root>";
		echo $re;

	}
}
?>

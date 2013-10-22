<?php
/*************************************************************************
    > File Name :     controllers/map.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-06-24 15:50:47
 ************************************************************************/
class Map extends MY_Controller{
	var $pageNum;
	function __construct()
	{
		parent::__construct();
		$this->pageNum = 24;
		$this->load->model("art");
		$this->load->model("user");
	}
	public function index()
	{
		$this->load->view("msea");
	}
	public function keyd()
	{
		$key = trim($_GET["key"]);//keyword
		$temp = trim($_GET["p"]);//p position,前面为右上角的位置，后面为坐下的位置
		$page = @trim($_GET["page"]);//page 页数,要申请地几页的内容
		if(strlen($page)== 0)$page = 0;
		$temp = preg_split("/\|/",$temp);
		$pos["st"]["lng"] = $temp[0];
		$pos["st"]["lat"] = $temp[1];
		$pos["en"]["lng"] = $temp[2];
		$pos["en"]["lat"] = $temp[3];
		$seller = $this->user->getSeller($pos);//其他的内容，通过getness读取，没有办法，不准被读取第三次的，但是又不愿意进行数组中查找
		if(!$seller){
			echo "0";
			return false;
		}
		$key = preg_split("/[^\x{4e00}-\x{9fa5}0-9a-zA-Z]+/u",$key);//以非汉字，数字，字母为分界点开始分割;
		$sql = "";
		for($i = 0,$len = count($seller); $i < $len;$i++){
			if($i != 0)$sql.=" OR ";
			$sql.=" author_id = ".$seller[$i]["user_id"];
		}
		$id = array();
		for($i = 0,$len = count($key); $i < $len;$i++){
			if(mb_strlen($key[$i],"UTF8")< 2)continue;
			$temp = $this->art->getIdMap($key[$i],$sql);
			$id = array_merge($temp,$id);
		}
		$id = $this->uniqueSort($id);//整理排序，成单独的序列
		$data = array();
		$timer = 0;
		for($i = max(0,$page*$this->pageNum),$len = min(count($id),($page+1)*$this->pageNum);$i < $len;$i++){
			$temp= $this->art->getSeaResById($id[$i]);
			$temp["user"] = $this->user->getNess($temp["author_id"]);
			$temp["art_id"] = $id[$i];
			$fornow = preg_split("/ /",$temp["time"]);
			$temp["time"] = $fornow[0];
			$data[$timer++]=$temp;
			//$data = array_merge($temp,$data);
		}
		echo json_encode($data);
	}
}
?>

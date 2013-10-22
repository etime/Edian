<?php
/*
 *author:			unasm
 email:			douunasm@gmail.com
 Last_modified:	2013-06-20 12:46:56
 考虑到效率的问题，两次http请求肯定不如一次快，所以最初打开邮箱的时候，通过php的方式给出内容，之后切换到其他的连接，通过ajax的方式给出数据,考虑的容易维护，将view和ajax的方式func放在一起
 read_already 的状态需要更改
 //messout要不要轮番查询呢？比如两个人通过这种方式聊天，可以优化下，比如1分钟查询一次，应该可以吧
 //考虑到机器人的因素，要不要判断下，连续一定时间内超过多少封要输入验证码
 //像新浪邮箱那样的快速预览其实相当重要，不是吗？要不要做一个呢
 */
class Message extends MY_Controller{
	var $user_id;
	function  __construct(){
		parent::__construct();
		$this->user_id = $this->user_id_get();
		$this->load->model("mess");
		$this->load->model("user");
	}				
	public  function login()
	{
		$atten["atten"] = "请首先登录";
		$atten["time"] = 5;
		$atten["uriName"] = "登录";
		$atten["uri"] = site_url("reg/login");
		$atten["title"] = "请首先登录";
		$this->load->view("jump",$atten);
	}
	function index($ajax = false){
		//$ajax和直接浏览提供不同数据;
	//收件箱的显示,我感觉，收件箱发件箱应该同一个rul才好吧
		if(!$this->user_id){
			$this->login();
			return;
		}
		$data["cont"] = $this->mess->getInMess($this->user_id);
		for($i = 0; $i < count($data["cont"]);$i++){
		//	$data[""][$i] = $this->user->getNess($data["cont"][$i]["senderId"])[0];
			$data["cont"][$i]["sender"] = $this->user->getNess($data["cont"][$i]["senderId"]);
		}
		$data["get"] = "index";//这个是为了ajax提供目标函数
		if($ajax){
			echo json_encode($data);
			return;
		}
		$this->load->view('message',$data);
		$this->user->cleMail($this->user_id);//用户浏览列表页的时候，将新增邮件数目清空
	}
	public function sendbox($ajax = false)
	{
		//显示html的内容,发件箱
		if(!$this->user_id){
			$this->login();
			return;
		}	
		$data["cont"] = $this->mess->sendInMess($this->user_id);
		for($i = 0,$len = count($data["cont"]); $i < $len;$i++){
			$data["cont"]["$i"]["geter"] = $this->user->getNess($data["cont"][$i]["geterId"]);
			//$data["geter"][$i] = $this->user->getNess($data["cont"][$i]["geterId"])[0];//其实在这里对应的sender已经是收件人了，只是为了方便，才不更改的
		}//发件箱显示收件人图片信息，收件箱显示发件人图片信息,但是都保存在sedner中，方便管理
		$data["get"] = "sendbox";//这个是为了ajax提供目标函数
		if($ajax){
			echo json_encode($data);
		}else
			$this->load->view("message",$data);
	}
	private function det($messId  )
	{
		//查看邮件内容的地方，发件箱改称其他名字
		$ans = $this->mess->getById($messId);
		count($ans)?($ans = $ans[0]):(show_404());
		$data["cont"] = $ans;
		if(($data["cont"]["senderId"] != $this->user_id) &&($data["cont"]["geterId"] != $this->user_id)){
			exit("他人邮件，请勿浏览");//目前这个if还没有测试到过
		}
		$data["sender"] = $this->user->getNess($data["cont"]["senderId"]);
		$data["geter"] = $this->user->getNess($data["cont"]["geterId"]);
		$data["reply"] = $this->mess->getRepById($messId);
		for($i = 0; $i < count($data["reply"]);$i++){
			//$data["reply"][$i] = preg_replace("/\[face\:(\d+)\]/","/\<img src \= ".base_url("face/")."\(1\)\>/",$data["reply"][$i]);
			$data["reply"][$i] = preg_replace("/\[face\:(\d+)\]/","<img src = ".base_url("face/\\1.gif")." />",$data["reply"][$i]);
		}
		return $data;
	}
	function send($messId = -1)
	{//send 发送,浏览邮件的具体内容的函数，对应发件箱
		if(!$this->user_id){
			$this->login();
			return;
		}
		$data = $this->detailShow($messId);
		$data["get"] = "sendbox";//这里之所以选择sendbox是因为和列表页面一致，send为发件箱的func
		$this->load->view("messout",$data);
	}
	public function get($messId = -1)
	{//get 收到，对应收件箱的内容显示，
		if(!$this->user_id){
			$this->login();
			return;
		}
		$data = $this->detailShow($messId);
		if($data["cont"]["read_already"]==0){
			$this->mess->readA($messId);
		}
		//在这里清除read_already状态
		$data["get"] = "index";//这里之所以选择index是因为和列表页面一致，index标示收件箱的func
		$this->load->view("messout",$data);
		//一会将这个和send合并,只是修改控制的部分
	}
	private function detailShow($messId)
	{//为上面的get和send函数提供数据支持，因为他们功用view/message.php相似程度太大，所以这里提供相似部分的数据
		if($messId == -1)show_404();
		$data = $this->det($messId);//data["cont"]为主要内容，$data["reply"]为回复内容;
		//var_dump($data);//目前reply还没有正确显示
		$data["messId"] = $messId;
		$temp = $this->user->getNess($this->user_id);
		$data["photo"] = $temp["user_photo"];
		return $data;
	}
	public function write($id = -1)
	{//很多的字符不能在url中出现，所以不可以使用get的方式传递字符
		if ($this->user_id == false) {
			$this->login();
			return;
		}
		if($id == -1){
			$this->load->view("messwrite");
			return;
		}
		$name = $this->user->getNameById($id);
		if($name){
			$data["name"] = $name["user_name"];
			$data["id"] = $id;
			$this->load->view("messwrite",$data);
		}
		else $this->load->view("messwrite");
	}
	public function add($ajax  = 0){
		//这里是添加用户发送信息的函数
		$error = false;
		if($this->user_id == false){
			$error = "请登陆后发送站内信";
		}
		$data["sender"]	 = $this->user_id;
		$temp = trim($this->input->post("geter"));//名字的接收两种情况，一种是直接的用户名，一种是夹杂了id的，第一种要向数据库查找，大部分情况下为第二种，直接读出来其中的id就可以了
		$ans = preg_split("/[\(\)]/",$temp);
		if(count($ans)==3){//包含了id就直接发送过去，没有包含则需要从列表中搜索
			$data["geterId"] = $ans[1];
		}else{
			$ans = $this->user->checkname($temp);
			$ans?($data["geterId"] = $ans["user_id"]):($error = "当前用户不存在");//突然发现，使用ifelse太消耗地方了
		}
		$data["title"] = trim($this->input->post("title"));
		if(strlen($data["title"])==0){
			$error = "标题不能为空";
		}
		$data["body"] = $this->input->post("cont");//addslashes交给model处理吧
		if($error){
			if($ajax)echo json_encode($error);
			else  echo $error;
			return;
		}
		$flag = 1;
		if($this->mess->add($data) == true){			
		$this->user->addMailNum($data["geterId"]);//增加收件人的收件数目
			if($ajax){
				echo json_encode($flag);
				return;
			}
			redirect(site_url("message/sendbox"));
		}
		else {
			if($ajax){
				$flag = 0;
				echo json_encode($flag);
				return;
			}
			$atten["atten"] = "保存失败，请检查数据是否正确，无误请联系管理员douunasm@gmail.com，对您造成的不便表示歉意";
			$atten["time"] = 3;
			$atten["uriName"] = "发件箱";
			$atten["uri"] = site_url("message/sendBox");
			$atten["title"] = "很遗憾，发送失败";
			$this->load->view("jump",$atten);
		}
	}
	public function quickAdd($messId = -1,$ajax = false)
	{
		//对应ajax提交，同时提供失效方案
		if($messId == -1){
			exit("错误，请联系管理员".$this->adminMail);
		}
		$com = trim($this->input->post("com"));
		if(strlen($com) == 0){
			exit("请输入内容");
		}
		if(!$this->user_id){
			exit("请首先登陆");
		}
		$flag = 0;
		$data["body"] = $com;
		$data["replyTo"] = $messId;
		$data["user_id"] = $this->user_id;
		$res = $this->mess->quickAdd($data);
		if($res){
			$flag = 1;
			$part = $this->mess->getpart($messId);//向对方通知有更新
			$geter = ($this->user_id == $part["senderId"])?$part["geterId"]:$part["senderId"];
			$this->user->addMailNum($geter);//增加收件人的收件数目
		}
		if($ajax){
			echo json_encode($flag);
		}else{
			if($flag)
				echo "回复成功,请点击后退返回";
			else echo "回复失败";
		}
	}
}
?>	

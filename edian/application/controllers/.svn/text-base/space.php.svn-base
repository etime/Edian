<?php
/**
* 这个是用户空间的设计页面，因为对之前的userspace不满意，所以第二次开始设计
*
 **/
class Space extends MY_Controller
//class Space extends MY_Common
{
	var $user_id,$user_name;//空间主人的一些信息，保存到这里，就是为了在以后直接调用比较方便。	
	function __construct()
	{
		$this->user_id=$this->idGet();
		parent::__construct();
	}
	public function index()
	{
		$this->load->view("userSpace");
	}
}
?>

<?php
/**
 * 这是注销登陆使用的文件，将来或许添加其他功能吧
 **/
class Destory extends MY_Controller
{
	var $user_id;
	function __construct()
	{
		parent::__construct();
	}
	public function zhuxiao()
	{
		$ans = session_destroy();
		$this->session->sess_destroy();
		echo $ans;
		//将来或许添加从数据库删除登陆状态的句子
	}
}
?>

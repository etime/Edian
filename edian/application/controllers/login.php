<?php
/**
 * 处理所有和登录有关的操作
 * @since 2013-11-27 11:34:14
 * @author farmerjian <chengfeng1992@hotmail.com>
 */
class Login extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('user');
		$this->load->model('boss');
		$this->load->model('mwrong');
	}
	
	/**
	 * 用户登录的管理窗口，验证是否一致，供外界调用的接口
	 * @todo 用户登录名与密码匹配的时候，完成登录后跳转到哪个页面，在函数的最后 $this->load-view('') 中添加
	 */
	public function checkLogin() {
		$val = $this->input->post('val');
		$password = $this->input->post('password');
		// 输入不能为空
		if ($val == '' || $password == '') {
			echo 'false';
			return;
		}
		// 当用户的输入是 phoneNum 时
		if (preg_match("/^1[\d]{10}$/", $val)) {
			$ans = $this->user->getUserByEmail($val);
		}
		// 当用户的是如是 loginName 时
		else if (preg_match("/[~!@#$%^&*()_+`-={}:\">?<\[\];',./|\\]/", $val)) {
			$ans = $this->user->getUserByLoginName($val);
		}
		// 其他情况
		else {
			echo 'false';
			return;
		}
		
		if (count($ans) == 0 || $ans['password'] != $password) {
			echo 'false';
			return;
		}
		else {
			echo 'true';
			$this->load->view('');
			return;
		}
	}
	
	/**
	 * 用于向外界提供访问的登录页面
	 */
	public function userlogin() {
		$this->load->view('');
	}
}
?>
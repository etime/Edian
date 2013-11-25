<?php
/**
 * 处理所有注册有关的操作
 * 
 * @since 2013-11-25 22:43:21
 * @author farmerjian
 *
 */
class Register extends CI_Controller {
	
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct();
		$this->load->library('sms');
		$this->load->model('user');
		$this->load->model('boss');
	}
	
	/**
	 * 当用户填写的信息出错时，自动跳转，跳转前，返回给 view 出错的信息
	 * 
	 * @param string $content  出错时，返回给 view 的信息
	 * @param string $url      出错时，跳转到的页面的 url
	 * @param string $urlName  出错时，跳转到的页面的 title
	 */
	public function errorJump($content, $url, $urlName) {
		echo $content;
	
		$data['atten'] = $content;
		$data['uri'] = $url;
		$data['uriName'] = $urlName;
		$this->load->view("jump", $data);
	}
	
	/**
	 * 用于判断用户提交的注册表单的内容是否为空，如果为空，跳转到相应的注册页面
	 * 
	 * @param string $val      需要判断的变量
	 * @param string $content  出错时，返回给 view 的信息
	 * @param string $url      出错时，跳转到的页面的 url
	 * @param string $urlName  出错时，跳转到的页面的 title
	 * @return boolean         变量不为空，返回 false，否则返回 true
	 */
	public function isInputNull($val, $content, $url, $urlName) {
		if ($val != '') return false;
		$this->errorJump($content, $url, $urlName);
		return true;
	}
	
	public function bossRegisterCheck() {
		$url = site_url() . '/register/bossRegister';
		$urlName = '老板注册页面';
		
		$data['phoneNum'] = $this->input->get('phone');
		if ($this->isInputNull($data['phoneNum'], '请输入正确的手机号码', $url, $urlName)) return;
// 		/**
// 		 * 生成及发送 4 位验证码
// 		 */
// 		$content = '';
// 		for ($i = 0; $i < 4; $i ++) {
// 			$content .= rand(0, 10);
// 		}
// 		$flag = $this->sms->send($content, $data['phoneNum']);
// 		if ($flag == 0) {
// 			$this->errorJump('请输入正确的验证码', $url, $urlName);
// 			return;
// 		}
// 		echo $content;
		
		$data['name'] = $this->input->post('name');
		$data['password'] = $this->input->post('password');
		$data['confirm'] = $this->input->post('confirm');
		$data['email'] = $this->input->post('email');
		$data['phoneNum'] = $this->input->post('phoneNum');
		$data['checkNum'] = $this->input->post('checkNum');
		
		if ($this->isInputNull($data['name'], '请输入姓名', $url, $urlName)) return;
		if ($this->isInputNull($data['password'], '请输入密码', $url, $urlName)) return;
		if ($this->isInputNull($data['confirm'], '请确认您的密码', $url, $urlName)) return;
		if ($this->isInputNull($data['phoneNum'], '请输入手机号码', $url, $urlName)) return;
		if ($this->isInputNull($data['checkNum'], '请输入验证码', $url, $urlName)) return;
		
// 		if ($data['checkNum'] != $content) {
// 			$this->errorJump('验证码错误', $url, $urlName);
// 			return;
// 		}
		if ($data['confirm'] != $data['password']) {
			$this->errorJump('两次输入的密码不匹配', $url, $urlName);
			return;
		}
		if (eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,4}$", $data['email'])) {
			$this->errorJump('请输入正确的邮箱格式', $url, $urlName);
			return;
		}
		if (count($data['name'] > 10)) {
			$this->errorJump('姓名不可以超过 10 个字', $url, $urlName);
			return;
		}
		$ans = $this->user->getUserByPhone($data['phoneNum']);
		if (count($ans) != 0) {
			$this->errorJump('该用户已经存在', $url, $urlName);
			return;
		}
		if ($ans == false) {
			$this->load->config("edian");
			$data['credit'] = $this->config->item("bossCredit");
			$this->user->addUser($data);
			$this->boss->addUser($data);
		}
	}
	
	public function bossRegister() {
		$this->load->view('reg/bossreg');
	}
}
?>
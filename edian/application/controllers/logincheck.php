<?php
/**
 * 用于处理所有和登录有感的操作和信息反馈
 * 
 * @todo 处理所有和登录有关的操作
 * @since 2013-11-25 17:04:05
 * @author farmerjian <chengfeng1992@hotmail.com>
 *
 */
class LoginCheck extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * 用于匹配用户的登录信息
	 * 
	 * 目前暂时将用户的手机号码作为他的登录名;如果用户输入的登录名不存在，返回相关信息；如果登录名和密码不匹配，输出相应信息；如果登录名和密码匹配，登录成功
	 * 
	 * @author farmerjian <chengfeng1992@hotmail.com>
	 * @todo 处理所有和用户登录有关的信息，完成相应的内容
	 */
	function match() {
		
	}
}
?>
<?php
/**
 * 处理所有注册有关的操作
 * unasm 2013-11-28 18:57:03
 * 1:虽然看起来public和protected没有什么区别，但是如果从用户的角度来说，是有的，
 * 每一个public都可以通过服务器链接找到，但是protected却不能通过访问读取到
 * 所以根据最小权限法则，如果不是和用户交互的接口的话，还是尽量使用protected
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
        $this->load->model("wrong");
    }

    /**
     * 当用户填写的信息出错时，自动跳转，跳转前，返回给 view 出错的信息
     *
     * @param string $content  出错时，返回给 view 的信息
     * @param string $url      出错时，跳转到的页面的 url
     * @param string $urlName  出错时，跳转到的页面的 title
     */
    public function errorJump($content, $url, $urlName) {
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

    /**
     * 判断用户输入 loginName 是否合法，是否存在，供 ajax 调用
     *
     * @param $loginName 用户将要注册的用户名
     * @return boolean 如果用户名合法且不存在，返回 true，否则返回 false
     */
    public function checkLoginName($loginName) {
        echo $loginName;
        if (preg_match("/[~!@#$%^&*()_+`-={}:\">?<\[\];',./|\\]/", $loginName)) {
            $this->errorJump('您的用户名中含有非法字符，请重新输入', $url, $urlName);
            echo 'false';
            return false;
        }
        $ans = $this->user->getUserByLoginName($data['loginName']);
        if ($ans != false) {
            $this->errorJump('该用户已经存在', $url, $urlName);
            echo 'false';
            return false;
        }
        echo 'true';
        return true;
    }

    /**
     * 检验手机号码的合法性和唯一性，供 ajax 调用
     *
     * @param int $phoneNum 用户将要注册的手机号码
     * @return boolean 如果该手机号码合法且不存在，返回 true，否则返回 false
     */
    public function checkPhoneNum($phoneNum) {
        if (!preg_match("/^1[\d]{10}$/", $phoneNum)) {
            echo 'false';
            return false;
        }
        $ans = $this->user->getUserByPhone($data['phoneNum']);
        if ($ans != false) {
            echo 'false';
            return false;
        }
        echo 'true';
        return true;
    }

    /**
     * 发送短信验证码，供 ajax 调用
     */
    function smsSend() {
        $curTime = time();
        $lstTime = $this->session->userdata("lstTime");
        if ($lstTime != '' || $curTime - $lstTime < 30) {
            echo 'too often';
            return false;
        }
        $this->session->set_userdata('lstTime', $curTime);
        $phoneNum = $_GET['phoneNum'];
        // 检查手机号码格式是否正确
        if (!preg_match("/^1[\d]{10}$/", $phoneNum)) {
            echo 'error';
            return false;
        }
        // 生成四位短信验证码
        $phoneCheck = '';
        for ($i = 0; $i < 4; $i ++) {
            $phoneCheck .= rand(0, 10);
        }
        $flag = $this->sms->send($phoneCheck, $data['phoneNum']);
        if ($flag == 1) {
            $this->session->set_userdata("phoneCheck", $phoneCheck);
            echo $phoneCheck;
            return;
        } else if ($flag == 0) {
            $this->mwrong->insert("手机号码为" . $phoneNum . "发送出现意外，返回值为:" . $flag);
            echo 0;
            return;
        }
        echo $phoneCheck;
    }

    /**
     * 检测客户端是否频繁注册，默认 2 小时之内只能注册 5 次
     * @return boolean
     */
    public function checkRegisterTimes() {
        $cnt = $this->session->userdata("cnt");
        if ($cnt == '') {
            $this->session->set_userdata("cnt", 4);
            return true;
        } else if ($cnt === 0) {
            $this->errorJump('您的注册次数太频繁，请稍候再试', $url, $urlName);
            $this->wrong->inset("有人注册了五次，现在默认禁止再注册，其输入内容为loginName = ".$data["loginName"].",phoneNum = ".$data["phoneNum"]);
            return false;
        } else {
            $this->session->set_userdata("cnt", $cnt - 1);
            return true;
        }
        return false;
    }

    /**
     * 注册页面的后台处理函数
     */
    public function bossRegisterCheck() {
        // 检测客户端是否频繁注册
        if (!$this->checkRegisterTimes()) return;

        $url = site_url() . '/register/bossRegister';
        $urlName = '老板注册页面';

        $data['loginName']  = $this->input->post('loginName');
        $data['nickname']   = $this->input->post('nickname');
        $data['password']   = $this->input->post('password');
        $data['confirm']    = $this->input->post('confirm');
        $data['email']      = $this->input->post('email');
        $data['phoneNum']   = $this->input->post('phoneNum');
        $data['checkNum']   = $this->input->post('checkNum');

        // 检测必选输入是否为空
        if ($this->isInputNull($data['loginName'], '请输入登录名', $url, $urlName)) return;
        if ($this->isInputNull($data['nickname'], '请输入姓名', $url, $urlName)) return;
        if ($this->isInputNull($data['password'], '请输入密码', $url, $urlName)) return;
        if ($this->isInputNull($data['confirm'], '请确认您的密码', $url, $urlName)) return;
        if ($this->isInputNull($data['phoneNum'], '请输入手机号码', $url, $urlName)) return;
        if ($this->isInputNull($data['checkNum'], '请输入验证码', $url, $urlName)) return;

        // 检测输入的短信验证码是否相符
        if ($data["checkNum"] != $this->session->userdata("phoneCheck")){
            $this->errorJump('请输入正确的短信验证码', $url, $urlName);
        }

        // 检测手机号码和登录名
        if (!$this->checkLoginName($data['loginName'])) return;
        if (!$this->checkPhoneNum($data['phoneNum'])) return;

        // 检测输入的邮箱格式是否合法
        if ($data['email'] != '' && preg_match("/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+$/", $data['email'])) {
            $this->errorJump('请输入正确的邮箱格式', $url, $urlName);
            return;
        }
        if (strlen($data['nickname'] > 10)) {
            $this->errorJump('姓名不可以超过 10 个字', $url, $urlName);
            return;
        }
        $this->load->config("edian");
        $data['credit'] = $this->config->item("bossCredit");
        $this->user->addUser($data);
        $this->boss->addBoss($data);
        $this->errorJump('恭喜！您已经成功注册！', site_url(), '首页');
    }

    public function bossRegister() {
        $this->load->view('reg/bossreg');
    }
}
?>

<?php
/**
 * 处理所有注册有关的操作
 * @since   2013-11-25 22:43:21
 * @author  farmerjian
 * @package controller
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
        $this->load->model("mwrong");
    }

    /**
     * 当用户填写的信息出错时，自动跳转，跳转前，返回给 view 出错的信息
     *
     * @param string $content  出错时，返回给 view 的信息
     * @param string $url      出错时，跳转到的页面的 url
     * @param string $urlName  出错时，跳转到的页面的 title
     */
    private function _errorJump($content, $url, $urlName) {
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
    private function _isInputNull($val, $content, $url, $urlName) {
        if ($val != '') return false;
        $this->_errorJump($content, $url, $urlName);
        return true;
    }

    /**
     * 检测客户端是否频繁注册，默认 2 小时之内只能注册 5 次
     * @return boolean
     */
    private function _checkRegisterTimes($url = '', $urlName = '') {
        $cnt = $this->session->userdata('cnt');
        if ($cnt == false) {
            $this->session->set_userdata("cnt", 4);
            return true;
        } else if ($cnt === 0) {
            $this->_errorJump('您的注册次数太频繁，请稍候再试', $url, $urlName);
            $this->mwrong->insert("有人注册了五次，现在默认禁止再注册，其输入内容为loginName = ".$data["loginName"].",phoneNum = ".$data["phoneNum"]);
            return false;
        } else {
            $this->session->set_userdata("cnt", $cnt - 1);
            return true;
        }
        return false;
    }

    /**
     * 检测 loginName 的合法性和唯一性，供 ajax 和内部检查调用
     *
     * @param $loginName 用户将要注册的用户名
     * @return boolean 如果用户名合法且不存在，返回 true，否则返回 false
     */
    public function checkLoginName($loginName = false, $url = '', $urlName = '') {
        if ($loginName == false) {
            $loginName = @$_GET["loginName"];
        }

        // 判断用户输入的登录名是否含有非法字符
        if (preg_match("/[~!@#$%^&*()_+`\\=\\|\\{\\}:\\\">\\?<\\[\\];',\/\\.\\-\\\\]/", $loginName)) {
            if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == 'xmlhttprequest') {
                echo "false";
            } else {
                $this->_errorJump('您输入的用户名中含有非法字符，请重新输入', $url, $urlName);
            }
            return false;
        }

        // 判断 loginName 是否为长度为 [1, 20] 的字符串
        if (strlen($loginName) == 0 || strlen($loginName) > 20) {
            if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == 'xmlhttprequest') {
                echo "false";
            } else {
                $this->_errorJump('您输入的用户名长度不合法，请重新输入', $url, $urlName);
            }
            return false;
        }

        // 判断用户的登录名是否已经存在
        $ans = $this->user->isUserExistByLoginName($loginName);
        if ($ans) {
            if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == 'xmlhttprequest') {
                echo "false";
            } else {
                $this->_errorJump('您输入的用户名已经存在，请重新输入', $url, $urlName);
            }
            return false;
        }
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == 'xmlhttprequest') {
            echo "true";
        }
        return true;
    }

    /**
     * 检验手机号码的合法性和唯一性，供 ajax 和内部检查调用
     *
     * @param int $phoneNum 用户将要注册的手机号码
     * @return boolean 如果该手机号码合法且不存在，返回 true，否则返回 false
     */
    public function checkPhoneNum($phoneNum = false, $url = '', $urlName = '') {
        echo "1234";
        return;
        if ($phoneNum == false) {
            $phoneNum = @$_GET['phoneNum'];
        }
        // 判断用户输入的手机号码是否合法
        if (! preg_match("/^1[\d]{10,10}$/", $phoneNum)) {
            if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == 'xmlhttprequest') {
                echo "false";
            } else {
                $this->_errorJump('您输入的手机号码格式非法，请重新输入', $url, $urlName);
            }
            return false;
        }

        // 判断用户输入的手机号码是否已经被注册
        $ans = $this->user->isUserExistByPhone($phoneNum);
        if ($ans) {
            if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == 'xmlhttprequest') {
                echo "false";
            } else {
                $this->_errorJump('您输入的手机号码已被注册，请重新输入', $url, $urlName);
            }
            return false;
        }
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == 'xmlhttprequest') {
            echo "true";
        }
        return true;
    }

    /**
     * 发送短信验证码，供 ajax 调用
     * 错误代码：
     * -1               : 两次调用短信发送函数的时间间隔小于 30 秒
     * -2               : 手机号码格式不正确
     *  0               : 手机验证码发送出现意外情况，记录在 wrong 信息中
     *  长度为 4 的数字串  : 短信发送成功，这个数字串是发送的短信验证码
     *  上面的约定可以讨论，这只是一个临时版本
     */
    public function smsSend() {
        $curTime = time();
        $lstTime = $this->session->userdata("lstTime");
        if ($lstTime != '' || $curTime - $lstTime < 30) {
            $this->session->set_userdata('lstTime', $curTime);
            echo '-1';
            return;
        }
        $this->session->set_userdata('lstTime', $curTime);
        $phoneNum = @$_GET['phoneNum'];
        // 检查手机号码格式是否正确
        if (!preg_match("/^1[\d]{10}$/", $phoneNum)) {
            echo '-2';
            return;
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
    }

    /**
     * 商家注册页面的后台处理函数
     * 包括各种检测，基本的顺序是对照着注册表，一个一个检测，先判断必备信息是否填写，再从上往下的判断每个信息的合法性和唯一信息的唯一性
     * 暂时关闭了短信验证的功能
     */
    public function bossRegisterCheck() {
        $url = site_url('register/bossRegister');
        $urlName = '商家注册';

        // 检测客户端是否频繁注册
        if (! $this->_checkRegisterTimes($url, $urlName)) return;

        $data['loginName']  = $this->input->post('loginName');
        $data['nickname']   = $this->input->post('nickname');
        $data['password']   = $this->input->post('password');
        $data['confirm']    = $this->input->post('confirm');
        $data['phoneNum']   = $this->input->post('phoneNum');
        $data['checkNum']   = $this->input->post('checkNum');
        $data['email']      = $this->input->post('email');

        // 检测必选输入是否为空
        if ($this->_isInputNull($data['loginName'], '请输入登录名', $url, $urlName)) return;
        if ($this->_isInputNull($data['nickname'], '请输入姓名', $url, $urlName)) return;
        if ($this->_isInputNull($data['password'], '请输入密码', $url, $urlName)) return;
        if ($this->_isInputNull($data['confirm'], '请确认您的密码', $url, $urlName)) return;
        if ($this->_isInputNull($data['phoneNum'], '请输入手机号码', $url, $urlName)) return;
        // 暂时关闭短信验证码的功能
        //if ($this->_isInputNull($data['checkNum'], '请输入验证码', $url, $urlName)) return;

        // 检测登录名的合法性和唯一性
        if (! $this->checkLoginName($data['loginName'], $url, $urlName)) return;

        // 检测姓名输入是否合法
        if (strlen($data['nickname'] > 10)) {
            $this->_errorJump('姓名不要超过 10 个字，如果实在太长，请用昵称取代', $url, $urlName);
            return;
        }

        $len = strlen($data['password']);
        // 检测密码的合法性
        if ($len < 6 || $len > 20) {
            $this->_errorJump('请输入正确长度的密码', $url, $urlName);
            return;
        }

        // 检测密码和确认密码是否一致
        if ($data['password'] != $data['confirm']) {
            $this->_errorJump('您两次输入的密码不一致', $url, $urlName);
            return;
        }

        // 检测手机的合法性和唯一性
        if (! $this->checkPhoneNum($data['phoneNum'], $url, $urlName)) return;

        /* 暂时关闭短信验证功能

        // 检测输入的短信验证码是否相符
        if ($data["checkNum"] != $this->session->userdata("phoneCheck")) {
            $this->_errorJump('请输入正确的短信验证码', $url, $urlName);
            return;
        }
        */

        // 检测输入的邮箱格式是否合法 "/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+$/"
        if ($data['email'] != '' && ! preg_match("/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+.([a-zA-Z0-9_-])+$/", $data['email'])) {
            $this->_errorJump('请输入正确的邮箱格式', $url, $urlName);
            return;
        }

        // 通过了以上的检验，用户的输入已经合法能够注册了，先设置用户的权限
        $this->load->config("edian");
        $data['credit'] = $this->config->item("bossCredit");

        // 对密码进行转义，防止攻击
        $data['password'] = mysql_real_escape_string($data['password']);

        // 删除 session 中的 lstTime 信息，减小 session 的开销
        $this->session->unset_userdata('lstTime');

        // 向数据表中添加相应的信息
        $this->user->addUser($data);
        $this->boss->addBoss($data);

        // 存储用户的 usrId，便于检验用户是否登录及一系列和登录用户有关的信息
        $this->session->set_userdata('userId', $this->user->getUserIdByLoginName($data['loginName']));

        // 跳转到商店设置的主页面，目前为止，商店后台管理的首页还存在问题
        $this->errorJump('恭喜！您已经成功注册！', site_url('bg/home'), '首页');
    }

    public function bossRegister() {
        $this->load->view('reg/bossreg');
    }

    public function userRegisterCheck() {
        $url = site_url() . '/register/userRegister';
        $urlName = '用户注册页面';

        // 检测客户端是否频繁注册
        if (! $this->_checkRegisterTimes($url, $urlName)) return;

        $data['email'] = '';
        $data['nickname'] = '';
        $data['loginName']  = $this->input->post('loginName');
        $data['password']   = $this->input->post('password');
        $data['confirm']    = $this->input->post('confirm');
        $data['phoneNum']   = $this->input->post('phoneNum');
        $data['checkNum']   = $this->input->post('checkNum');

        // 检测必选输入是否为空
        if ($this->_isInputNull($data['loginName'], '请输入登录名', $url, $urlName)) return;
        if ($this->_isInputNull($data['password'], '请输入密码', $url, $urlName)) return;
        if ($this->_isInputNull($data['confirm'], '请确认您的密码', $url, $urlName)) return;
        if ($this->_isInputNull($data['phoneNum'], '请输入手机号码', $url, $urlName)) return;
        if ($this->_isInputNull($data['checkNum'], '请输入验证码', $url, $urlName)) return;

        // 检测输入的短信验证码是否相符
        if ($data["checkNum"] != $this->session->userdata("phoneCheck")) {
            $this->_errorJump('请输入正确的短信验证码', $url, $urlName);
        }

        // 检测手机号码和登录名
        if (!$this->checkLoginName($data['loginName'], $url, $urlName)) return;
        if (!$this->checkPhoneNum($data['phoneNum'], $url, $urlName)) return;

        $this->load->config("edian");
        $data['credit'] = 0;

        // 对密码进行转义，防止攻击
        $data['password'] = mysql_real_escape_string($data['password']);

        $this->user->addUser($data);

        $this->session->set_userdata('userId', $this->user->getUserIdByLoginName($data['loginName']));

        // 跳转到最后一次访问的页面
        $this->errorJump('恭喜！您已经成功注册！', $originUrl, '回到刚才浏览的页面');
    }

    public function userRegister() {
        $this->load->view('reg/userreg');
    }
}
?>

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
        $this->load->model('mwrong');
    }

    /**
     * 检测用户的登录名是否是 loginName
     * @param string $userName
     * @return boolean
     */
    private function _isLoginName($userName) {
        if (preg_match("/[~!@#$%^&*()_+`\\=\\|\\{\\}:\\\">\\?<\\[\\];',\/\\.\\-\\\\]/", $userName)) {
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * 检测用户的登录名是否是 phoneNum
     * @param string $userName
     * @return boolean
     */
    private function _isPhoneNum($userName) {
        if (preg_match("/^1[\d]{10,10}$/", $userName)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 用于用户登录的各种检测，供 ajax 和内部调用
     * 我是这样想的，不管用户登录出现什么样的错误，只返回一个错误信息：您的登录名和密码不匹配
     */
    public function checkMatch($userName = false, $password = '') {
        if ($userName == false) {
            $userName = $this->input->post('userName');
            $password = $this->input->post('password');
        }

        // 先假定用户的登录情况合法
        $ans = true;

        // 输入不能为空
        if ($userName == '' || $password == '') {
            $ans = false;
        }

        // 对用户的 userName 进行分类讨论
        if ($this->_isPhoneNum($userName) == true) {
            if (! $this->user->isUserExistByPhone($userName)) {
                // 用户不存在
                $ans = false;
            } else {
                $expectPassword = $this->user->getUserPasswordByPhone($userName);
                // 用户输入密码与其登陆密码不符
                if ($password != $expectPassword) {
                    $ans = false;
                }
            }
        } else if ($this->_isLoginName($userName) == true) {
            if (! $this->user->isUserExistByLoginName($userName)) {
                // 用户不存在
                $ans = false;
            } else {
                $expectPassword = $this->user->getUserPasswordByLoginName($userName);
                // 用户输入密码与其登陆密码不符
                if ($password != $expectPassword) {
                    $ans = false;
                }
            }
        } else {
            // $loginName 是其他情况
            $ans = false;
        }

        if (! $ans) {
            if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == 'xmlhttprequest') {
                echo "false";
            } else {
                return false;
            }
        } else {
            if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == 'xmlhttprequest') {
                echo "true";
            } else {
                return true;
            }
        }
    }

    /**
     * 处理用户登录的情况，是 view 中 action 的接口
     * 如果用户登录成功，记录其 userId 到 session 中并返回最近浏览页面，否则直接返回最近浏览页面
     * @todo 用户登陆失败的返回信息的 style 修饰
     */
    public function loginCheck() {
        $userName = $this->input->post('userName');
        $password = $this->input->post('password');
        $url = $this->input->post('target');
        if ($this->checkMatch($userName, $password)) {
            // 用户登录成功，只可能是两种情况：loginName 登录和 phoneNum 登录
            if ($this->_isLoginName($userName)) {
                $this->session->set_userdata('userId', $this->user->getUserIdByLoginName($userName));
            }
            else if ($this->_isPhoneNum($userName)) {
                $this->sesion->set_userdata('userId', $this->user->getuserIdByPhone($userName));
            }
            // 跳转到用户登录之前访问的页面
			header("Location: $url");
        } else {
            // 用户登录失败，返回用户登陆失败的信息，怎么调整这个信息的显示方式，我使用了 span，具体到时候设计稿出来了再修改
            $message = "<span>用户名或密码错误！</span>";
            echo $message;
            $this->load->view('login');
        }
    }

    /**
     * 用于向外界提供访问的登录页面
     */
    public function userlogin() {
        $this->load->view('login');
    }
}
?>

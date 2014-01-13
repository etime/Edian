<?php
/**
 * 向后台插入错误的情况
 * 一般情况下可以直接调用model的wrong插入错误情况，这里是方便前端js向服务器报错
 * @name      ../application/controllers/wrong.php
 * @author    unasm < 1264310280@qq.com >
 * @since     2013-12-02 22:00:45
 * @package   controllers
 */
class Wrong extends MY_Controller {
    // 管理员邮箱
    var $adminMail;

    /**
     * 构造函数
     */
    function __construct() {
        parent::__construct();
        $this->load->model('mwrong');
        $this->config->load('edian');
        $this->load->model('user');
        $this->load->library('help');
        $this->adminMail = $this->config->item('adminMail');
    }

    /**
     * 如果没有登录，调出登录窗口
     */
    public function noLogin($url = false) {
        if ($url === false) {
            $url = site_url();
        }
        $data['url'] = $url;
        $this->load->view('login', $data);
    }

    /**
     * 检查用户是否登陆以及权限是否为管理员
     * 如果用户未登录，跳转到登陆页面，如果权限不够，跳转到 404 页面
     * @param string $url 如果用户未登录，登陆之后需要跳转的页面
     * @return boolean 如果用户登陆了并且权限足够，返回 true，否则返回 false
     * @author farmerjian<chengfeng1992@hotmail.com>
     */
    protected function _checkAuthority($url = false) {
        if ($url === false) {
            $url = site_url();
        }
        $userId = $this->getUserId();
        // 未登录
        if ($userId === -1) {
            $this->noLogin($url);
            return false;
        }
        $credit = $this->user->getCredit($userId);
        // 不是管理员权限
        if ($credit != $this->config->item('adminCredit')) {
            show_404();
            return false;
        }
        return true;
    }

    /**
     * 测试邮件发送功能
     */
    public function test() {
        if ($this->_checkAuthority(site_url('wrong/test')) === false) {
            return;
        }
        $to = $this->adminMail;
        $subject = "Test mail";
        $message = "Hello! This is a simple email message.";
        $from = "chengfeng1992@hotmail.com";
        $headers = "From: $from";
        mail($to, $subject, $message, $headers);
        echo "Mail Sent.";
    }

    /*
     * 对应的，一定是ajax请求
     * 只能包含中文，不能出现任何的空格和特殊符号,不然一定不能插入
     */
    public function index() {
        if ($this->_checkAuthority(site_url('wrong/index')) === false) {
            return;
        }
        $temp['text'] = $this->input->post('text');
        if (! preg_match("/[ ~!@#$%^&*()_+`\\=\\|\\{\\}:\\\">\\?<\\[\\];',\/\\.\\-\\\\]/", $temp["text"])) {
            $this->mwrong->insert($temp);
        } else {
            error_log($temp['text'], $this->adminMail, "from:edian/wrong");
        }
    }
    /**
     *  这里是显示网站运行错误的函数
     *  需要管理员权限才可以进行浏览的地方
     */
    public function showError() {
/*
        if ($this->_checkAuthority(site_url('wrong/showError')) === false) {
            return;
        }
 */
        $data['wrong'] = $this->mwrong->getAll();
        //header("Content-type: text/html; charset=utf-8");
        //$this->help->showArr($data);
        $this->load->view("bgWrong" , $data);
    }
    /**
     *  将来添加ajax操作吧。算是对性能的一个优化了
     */
    public function deleteLog($logId = 0) {
        if ($this->_checkAuthority(site_url('wrong/deleteLog/') . $logId) === false) {
            return;
        }
        $logId = (int)$logId;
        $this->mwrong->deleteLog($logId);
        //这个，呵呵，倒是不用跳转了，暂时这么处理
        $this->showError();
    }
}
?>

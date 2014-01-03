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

    private function _checkAuthority() {
        $userId = $this->getUserId();
        // 未登录
        if ($userId === -1) {
            $this->noLogin(site_url('wrong/showError'));
            return;
        }
        $credit = $this->user->getCredit($userId);
        // 不是管理员权限
        if ($credit != $this->config->item('adminCredit')) {
            show_404();
            return;
        }
    }

    /**
     * 测试邮件发送功能
     */
    public function test() {
        $this->_checkAuthority();
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
        $this->_checkAuthority();
        $temp['text'] = $this->input->post('text');
        if (! preg_match("/[ ~!@#$%^&*()_+`\\=\\|\\{\\}:\\\">\\?<\\[\\];',\/\\.\\-\\\\]/", $temp["text"])) {
            $this->mwrong->insert($temp);
        } else {
            error_log($temp['text'], $this->adminMail, "from:edian/wrong");
        }
    }

    public function showError() {
        $this->_checkAuthority();
        $data = $this->mwrong->getAll();
        header("Content-type: text/html; charset=utf-8");
        $this->help->showArr($data);
    }

    public function deleteLog($logId) {
        $this->_checkAuthority();
        $logId = (int)$logId;
        $this->mwrong->deleteLog($logId);
        $this->showError();
    }
}
?>

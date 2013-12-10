<?php
/**
 * 向后台插入错误的情况
 * 一般情况下可以直接调用model的wrong插入错误情况，这里是方便前端js向服务器报错
 * @name      ../application/controllers/wrong.php
 * @author    unasm < 1264310280@qq.com >
 * @since     2013-12-02 22:00:45
 * @package   controllers
 */
class Wrong extends CI_Controller
{
    var $myMail;
    function __construct()
    {
        parent::__construct();
        $this->myMail = "1264310280@qq.com";
        $this->load->model("mwrong");
    }
    /**
     * 发送邮件的测试
     */
    public function test()
    {
        //error_log("测试邮件报错" , 1, $this->myMail ,"From: edian/wrong");
        /*
        $flag = mail($this->myMail ,"标题：测试邮件发送",  "邮件报错的正文" , "From: edian/wrong");
        echo $flag;
        echo "send message";
        */
        //$to = "douunasm@gmail.com";
        $to = $this->myMail;
        $subject = "Test mail";
        $message = "Hello! This is a simple email message.";
        //$from = "someonelse@example.com";
        //$from = $this->myMail;
        $from = "douunasm@gmail.com";
        $headers = "From: $from";
        mail($to,$subject,$message,$headers);
        echo "Mail Sent.";
    }
    /*
     * 对应的，一定是ajax请求
     * 只能包含中文，不能出现任何的空格和特殊符号,不然一定不能插入
     */
    public function index()
    {
        $temp["text"] = $this->input->post("text");
        if ( ! preg_match("/[ ~!@#$%^&*()_+`\\=\\|\\{\\}:\\\">\\?<\\[\\];',\/\\.\\-\\\\]/", $temp["text"])) {
            $this->mwrong->insert($temp);
        }else{
            error_log($temp["text"] ,$this->myMail,"from:edian/wrong");
        }
    }
}
?>

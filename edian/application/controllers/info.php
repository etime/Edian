<?php
/**
 * 这里对应的用户空间中的info页面
 **/
class Info extends MY_Controller
{
    var $user_id;
    function __construct()
    {
        parent::__construct();
        $this->load->model("user");
        $this->user_id = $this->user_id_get();
    }
    private function pre($mastId)
    {
        //对用户的id进行检查，因为这个函数的所有都必须有一个id才可以进行，因此必须先检查id
        if($mastId == -1)$mastId = $this->user_id;
        if(!$mastId){
            show_404();
        }
        return $mastId;
    }
    public function index($mastId = -1){
        $mastId = $this->pre($mastId);
        $data["user_id"] = 0;
        if($this->user_id){
            $data["user_id"] = $this->user_id;
        }
        $data["masterId"] = $mastId;
        $data["name"] = "我的名片";
        $data["res"] = $this->user->getPubToAll($mastId);
        $data["photo"] = $data["res"]["user_photo"];//photo是为header设计的，兼容之前的设计
        $this->load->view("info",$data);
    }
    public function change()
    {//使对用户的信息修改的函数
        if(!$this->user_id){
            $atten["title"] = "请首先登录";
            $atten["atten"] = "请登录后修改个人信息";
            $atten["uri"] = site_url("reg/login");
            $atten["uriName"] = "登录";
            $this->load->view("jump",$atten);
            return;
        }
        $data = $this->user->getPubToAll($this->user_id);
        $this->load->view("changeInfo",$data);
    }
}
?>

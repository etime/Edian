<?php
/*************************************************************************
    > File Name :     art.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-08-21 21:54:56
 ************************************************************************/
/**
 * 这个是处理二手商品的地方
 */
class Bgart extends MY_Controller
{
    var $user_id,$type;
    /*
     * 权限验证是必须的
     */
    public function __construct()
    {
        parent::__construct();
        $this->user_id = $this->user_id_get();
        $this->load->model("user");
        $this->type = $this->user->getType($this->user_id);
        if($this->type != 3){
            //非管理员不得进入
            echo "管理员可以哦";
            die;
        }
        $this->load->model("art");
    }
    public function index()
    {
        $data["art"] = $this->art->getHotRecet();
        $this->load->view("bgart",$data);
    }
    public function del($artId)
    {
        //管理员才可以删除哦，具体删除某一个二手的东西
        $this->art->delById($artId);
        redirect(site_url("bg/bgart/index"));
    }
}
?>

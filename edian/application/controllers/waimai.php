<?php
/*************************************************************************
    > File Name :     controllers/waimai.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-08-01 01:10:46
 ************************************************************************/
/**
 * 这里是外卖的controller，将来或许可以成为显示店铺的区域吧
 */
class Waimai extends My_Controller
{
    var $user_id;
    /**
     * 方便起见，还是加上user_id
     */
     function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $this->load->model("user");
        $data["shop"]= $this->user->allWaiMai();
        //var_dump($data["shop"][0]);
        //$this->load->view("waimai",$data);//waimai.php目前遭到废弃
        $this->load->view("waimai2",$data);
    }
}
?>

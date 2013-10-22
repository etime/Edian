<?php
/*************************************************************************
    > File Name :     ../controllers/bg/order.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-08-06 10:15:54
 ************************************************************************/
/**
 * 这里处理后台的订单，订单的结算和处理
 */
class Order extends MY_Controller
{
    var $user_id;
    /**
     *
     */
     function __construct()
    {
        parent::__construct();
    }
    public function index(){
        $this->load->view("onTimeOrder");
    }
}
?>

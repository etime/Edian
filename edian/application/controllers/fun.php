<?php
/*************************************************************************
    > File Name :     controllers/fun.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-09-19 16:11:18
 ************************************************************************/
/**
 * 这里的东西都是闹着玩的
 */
class Fun extends My_Controller
{

    /**
     * 没有什么全局变量吧
     */
     function __construct()
    {
        parent::__construct();
    }
     public function index()
     {
         $this->load->view("fun");
     }
}
?>

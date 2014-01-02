<?php
/**
 * 这里是店铺的页面，对数据的操作和添加
 * @name        controllers/store.php
 * @since       2014-01-02 16:57:04
 */
class Store extends MY_Controller
{
     function __construct()
    {
        parent::__construct();
    }
     public function index($store = -1)
    {
        if($store === -1){
            show_404();
            return false;
        }
        $this->load->view("store.php");
    }
}
?>

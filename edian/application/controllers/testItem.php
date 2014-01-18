<?php
/**
 * 对item进行测试
 * @name        ../controllers/testItem.php
 * @author      unasm < 1264310280@qq.com >
 * @since       2014-01-17 23:55:45
 */
class testItem extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library("help");
    }
    public function addComment()
    {
        $data['context'] = "这里是第er条回复";
        $data['score'] = 23;
        $this->help->curl($data , site_url("item/addComment/56"));
    }
    public function index()
    {
        echo "index";
    }
}
?>

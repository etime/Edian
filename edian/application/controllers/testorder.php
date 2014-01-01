<?php
/**
 * 这个函数是为了测试order中的内容逻辑而添加的
 * @name        ../controllers/testorder.php
 * @author      unasm < 1264310280@qq.com >
 * @since       2013-12-28 20:46:54
 */

class Testorder extends MY_Controller
{

    function __construct() {
        parent::__construct();
    }

    /**
     * 测试order/add的函数
     *
     * @author unasm
     */
    public function testAdd() {
        $this->load->library('help');
        //构造的否定的add get方式的数据,主要是info的问题
        $url = array(
            site_url('order/add/1'),
            site_url('order/add/0'),
            site_url('order/add/absd'),
            site_url('order/add/55'),
            site_url('order/add/-1')    //这个例子证明了不能通过get的方式提交数据
        );
        //构造的输入的post信息
        $arr = Array(
            array('info' => '这里是info，attr的内容','buyNum' => '2'),
            array('info' => 'attr,内容','buyNum' => '2'),
            array('info' => 'attr\",内容','buyNum' => '2')
        );
        foreach ($url as $key) {
            foreach ($arr as $post) {
                $this->help->curl($post , $key);
                echo "<br/>";
                echo "<br/>";
            }
        }
    }
    /**
     * 测试下面的ontime的函数
     * @author unasm
     */
    public function testOntime()
    {
        $this->load->library("help");
        $this->help->curl($data);
    }
}
?>

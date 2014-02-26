<?php
/**
 * @author farmerjian<chengfeng1992@hotmail.com>
 * @since 2014-2-21 14:03:39
 * Class Home
 */
class Home extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('morder');
    }

    /**
     * 显示用户的所有以确认订单
     */
    public function myOrder() {
        $userId = $this->getUserId();
        if ($userId == -1) {
            $this->noLogin(site_url('userspace/home/myOrder'));
            return;
        }
        $data['order'] = $this->morder->getMyOrder($userId);
        if ($data['order'] == false) {
            $data['order'] = array();
        }
        //$this->help->showArr($data);
        $this->load->view("uMyOrder" , $data);
    }
}
?>

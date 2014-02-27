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
     * 处理用户的购物车中的商品信息
     * 需要注意的情况：购物车中无商品，此时 $order === false
     * @param array $order 购物车中的商品
     * @return array  整理后的购物车
     */
    protected function _dealCart($order) {
        // 订单中无信息
        if ($order === false) {
            return false;
        }
        $seller = array();
        for ($i = 0, $len = count($order); $i < $len; $i++) {
            $cart = $order[$i];
            $seller[$i] = $cart['seller'];
            $this->load->model('store');
            $ownerId = $this->store->getOwnerIdByStoreId($cart['seller']);
            $this->load->model('boss');
            $loginName = $this->boss->getLoginNameByBossId($ownerId);
            $bossUserId = $this->user->getUserIdByLoginName($loginName);
            $order[$i]['selinf'] = $this->user->getPubById($bossUserId);
            $order[$i]['item'] = $this->mitem->getOrder($cart['item_id']);
        }
        //对店家进行排序,方便分组
        return $order;
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
        $tmp = $this->morder->getMyOrder($userId);
        $data['order'] = $this->_dealCart($tmp);
        if ($data['order'] == false) {
            $data['order'] = array();
        }
        $this->help->showArr($data);
        $this->load->view("uMyOrder" , $data);
    }
}
?>

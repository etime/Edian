<?php
/**
 * 这里是店铺的页面，对数据的操作和添加
 * @name        controllers/store.php
 * @since       2014-01-02 16:57:04
 */
class Shop extends MY_Controller {
    /**
     * 构造函数
     */
    function __construct() {
        parent::__construct();
        $this->load->model('store');
        $this->load->model('mitem');
        $this->load->library('help');
    }

    /**
     * 商店首页入口
     * @param int $store 商店编号
     * @return boolean
     */
    public function index($store = -1) {
        if ($store === -1) {
            show_404();
            return false;
        }
        header("Content-type: text/html; charset=utf-8");
        $data1 = $this->store->getShopInfo($store);
        $data2 = $this->mitem->getItemByStoreId($store);
        if ($data1 === false || $data2 === false) {
            show_404();
            return false;
        }
        $data1['itemlist'] = $data2;
        $this->help->showArr($data1);
        $this->load->view('store.php', $data1);
    }

    /**
     * 呈现商店的百度地图
     * @param int $storeId 商店的编号
     */
    public function storeMap($storeId) {
        $storeId = (int)$storeId;
        $res = $this->store->getStoreMap($storeId);
        if ($res === false) {
            show_404();
            return;
        } else {
            header("Content-type: text/html; charset=utf-8");
            $this->help->showArr($res);
            $this->load->view('storeMap', $res);
        }
    }
}
?>

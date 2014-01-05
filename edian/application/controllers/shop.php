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
        $this->load->config('edian');
        $this->load->library('help');
        $this->load->library('pagesplit');
    }

    /**
     * 商店首页入口
     * @param int $store 商店编号
     * @return boolean
     */
    public function index($store, $pageId = 1) {
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
        // 通过 get 的方式获取 pageId
        if (isset($_GET['pageId'])) {
            $pageId = $_GET['pageId'];
        }
        if ($data1['itemlist']) {
            $temp = $this->pagesplit->split($data1['itemlist'], $pageId, $this->config->item('pageSize'));
            $data1['itemlist'] = $temp['newData'];
            $commonUrl = site_url('shop/index/' . $store);
            $data1['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount']);
        }
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

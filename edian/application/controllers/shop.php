<?php

require 'basesearch.php';

/**
 * 这里是店铺的页面，对数据的操作和添加
 * @name        controllers/store.php
 * @since       2014-01-02 16:57:04
 */
class Shop extends BaseSearch {

    function __construct() {
        parent::__construct();
    }

    /**
     * 商店首页入口
     * @param int $store 商店编号
     * @return boolean
     */
    public function index($storeId, $pageId = 1) {
        header("Content-type: text/html; charset=utf-8");
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            show_404();
            return false;
        }
        $ans = $this->mitem->getItemByStoreId($storeId);
        if ($ans === false) {
            show_404();
            return false;
        }
        $temp = $this->pagesplit->split($ans, $pageId, $this->config->item('pageSize'));
        $ans = array();
        $ans['item'] = $temp['newData'];
        $ans['key'] = false;
        $commonUrl = site_url('shop/index/' . $storeId);
        $ans['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount']);
        //$this->help->showArr($ans);
        $this->showView($ans, $storeId);
    }

    /**
     * 呈现商店的百度地图地址和基本信息
     * @param int $storeId 商店的编号
     * @todo 以后加强地图，增加定位，路径等等
     */
    public function storeMap($storeId = 0) {
        $storeId = (int)$storeId;
        $res = $this->store->getStoreMap($storeId);
        if ($res === false) {
            show_404();
            return;
        } else {
            $this->load->view('storeMap', $res);
        }
    }

    public function testSearchInStore() {
        $this->load->view('farmerjian');
    }

    /**
     * 本店搜索，需要用户输入关键字并且提供商店编号
     */
    public function searchInStore($storeId, $pageId = 1) {
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            show_404();
            return;
        }
        // 通过 GET 的方式获得用户输入的关键字，并设置 url 中的 GET 字段
        if (isset($_GET['key'])) {
            $key = trim($_GET['key']);
            $getString = '?key=' . $key;
        } else {
            $key = '';
            $getString = '';
        }
        // 存储用户输入的原始关键字
        $keyBackUp = $key;
        // 将所有的关键字字符串过滤掉非法字符并拆分成关键字数组
        echo('key = ' . $key . '<br>');
        $key = $this->_filterKeywords($key);
        $this->help->showArr($key);
        echo('<br>');
        // 对关键字数组中的所有关键字进行搜索，搜索的范围是：指定商店编号，在商品的 title 和 category 中搜索
        $data = array();
        for ($i = 0, $len = (int)count($key); $i < $len; $i ++) {
            $temp = $this->mitem->searchInStore($key[$i], $storeId);
            if ($temp != false) {
                array_push($data, $temp);
            }
        }

        // 将所有的搜索结果去重
        $ans = $this->_mergeDimensionalArray($data);

        // 根据商品编号获取所有商品的详细信息
        if ($ans == false) {
            $ans = array();
        } else {
            for ($i = 0, $len = (int)count($ans); $i < $len; $i ++) {
                $ans[$i] = $this->mitem->getItemByItemId($ans[$i]);
            }
        }

        // 将所得的结果进行分页
        $temp = $this->pagesplit->split($ans, $pageId, $this->config->item('pageSize'));
        $ans = array();
        $ans['item'] = $temp['newData'];
        $ans['key'] = $keyBackUp;
        $commonUrl = site_url('shop/searchInStore/' . $storeId);
        $ans['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount'], $getString);

        $this->help->showArr($ans);
        // 调出相关页面进行显示
        $this->showView($ans, $storeId);
    }

    /**
     * 本店筛选，筛选的是本店的分类，对应商品标签中的第四个标签
     * @param $storeId
     * @param int $pageId
     */
    public function selectInStore($storeId, $pageId = 1) {
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            show_404();
            return;
        }
        // 通过 GET 的方式获得关键字
        if (isset($_GET['name'])) {
            $key = trim($_GET['name']);
            $categoryName = $this->_filterKeywords($key);
            $getString = '?key=' . $categoryName;
        } else {
            $categoryName = '';
            $getString = '?key=';
        }
        // 获取筛选得到的所有商品的编号
        $ans = $this->mitem->selectInStore($categoryName, $storeId);
        // 通过商品编号获取所有商品的详细信息
        if ($ans == false) {
            $ans = array();
        } else {
            for ($i = 0, $len = (int)count($ans); $i < $len; $i ++) {
                $ans[$i] = $this->mitem->getItemByItemId($ans[$i]);
            }
        }
        // 将所得的结果进行分页
        $temp = $this->pagesplit->split($ans, $pageId, $this->config->item('pageSize'));
        $ans = array();
        $ans['item'] = $temp['newData'];
        $ans['key'] = $categoryName;
        $commonUrl = site_url('shop/selectInStore/' . $storeId);
        $ans['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount'], $getString);

        // 调出相关页面进行显示
        $this->showView($ans, $storeId);
    }

    /**
     *  显示上面view,select,index三个的页面显示
     *  将三个页面都应该有的数据进行索引，添加，同时传入原来三个页面的不同的数据
     *  @param  array   $good   商品的列表，来源有三个不同的函数
     *  @param  int     $store  商店的id
     *  @param  string  $page   商店的分页内容
     */
    protected function showView($good , $store)
    {
        $data1 = $this->store->getShopInfo($store);
        //$data1['itemlist'] = $good;
        //$data1['pageNumFooter'] = $page;
        $data1['storeId'] = $store;
        $data1 = array_merge($good , $data1);
        //$this->help->showArr($data1);
        $this->load->view('store' , $data1);
    }
}
?>

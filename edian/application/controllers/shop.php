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
        $this->load->model('comstore');
        $this->load->model('morder');
    }

    /**
     *  显示上面view,select,index三个的页面显示
     *  将三个页面都应该有的数据进行索引，添加，同时传入原来三个页面的不同的数据
     *  @param  array   $good   商品的列表，来源有三个不同的函数
     *  @param  int     $store  商店的id
     *  @param  string  $page   商店的分页内容
     */
    protected function _showView($good, $store) {
        $data1 = $this->store->getShopInfo($store);
        //$data1['itemlist'] = $good;
        //$data1['pageNumFooter'] = $page;
        $data1['storeId'] = $store;
        $data1 = array_merge($good , $data1);
        $data['dir'] = $this->part;
        //$this->help->showArr($data1);
        $this->load->view('store' , $data1);
    }

    /**
     * 商店首页入口
     * @param int $store 商店编号
     * @return boolean
     */
    public function index($storeId, $pageId = 1) {
        $storeId = (int)$storeId;
        if (isset($_GET['pageId'])) {
            $pageId = (int)$_GET['pageId'];
        } else {
            $pageId = (int)$pageId;
        }
        if ($storeId == 0) {
            show_404();
            return false;
        }
        $ans = $this->mitem->getItemByStoreId($storeId);
        if ($ans === false) {
            $ans = array();
        }
        $temp = $this->pagesplit->split($ans, $pageId, $this->config->item('pageSize'));
        $ans = array();
        $ans['item'] = $temp['newData'];

        $ans['key'] = false;
        $commonUrl = site_url('shop/index/' . $storeId);
        $ans['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount']);
        $this->_showView($ans, $storeId);
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
    /**
     * 本店搜索，需要用户输入关键字并且提供商店编号
     */
    public function search($storeId, $pageId = 1) {
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
        $key = $this->_filterKeywords($key);
        // 对关键字数组中的所有关键字进行搜索，搜索的范围是：指定商店编号，在商品的 title 和 category 中搜索
        $data = array();
        for ($i = 0, $len = (int)count($key); $i < $len; $i ++) {
            if ($key[$i] == '') {
                continue;
            }
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
        $commonUrl = site_url('shop/search/' . $storeId);
        $ans['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount'], $getString);
        // 调出相关页面进行显示
        $this->_showView($ans, $storeId);
    }

    /**
     * 本店筛选，筛选的是本店的分类，对应商品标签中的第四个标签
     * @param $storeId
     * @param int $pageId
     */
    public function select($storeId, $pageId = 1) {
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            show_404();
            return;
        }
        // 通过 GET 的方式获得关键字
        if (isset($_GET['name'])) {
            $key = trim($_GET['name']);
            //将返回的数组变成字符串，方便下次接着索引 by unasm 2014-02-16 01:49:05
            $categoryName = implode($this->_filterKeywords($key) , ',');
            $getString = '?name=' . $categoryName;
        } else {
            $categoryName = '';
            $getString = '?name=';
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
        $commonUrl = site_url('shop/select/' . $storeId);
        $ans['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount'], $getString);

        // 调出相关页面进行显示
        $this->_showView($ans, $storeId);
    }

    /**
     * 店铺列表页面
     * @author farmerjian<chengfeng1992@hotmail.com>
     * @since 2014-02-26 22:33:36
     */
    public function queue() {
        $data['pageNumFooter'] = ' ';
        $data['shopList'] = $this->store->getShopList();
        for ($i = 0, $len = (int)count($data['shopList']); $i < $len; $i ++) {
            $data['shopList'][$i]['sellNum'] = $this->morder->getSellNum($data['shopList'][$i]['id']);
        }
        $data['dir'] = $this->part;
        //$this->help->showArr($data);
        $this->load->view('shopList' , $data);
    }

    /**
     * 选择价格区间呈现商品，需要用户提供价格区间，价格区间存在 session 中，我认为页面显示的默认区间就应该从 session 中读取，用户输入的价格区间通过 GET 的方式获取，对应是 $low 和 $high，他们的大小关系可以随意，后台会进行相应的检验和修正
     * @param int $storeId 商店编号，可以通过 GET 的方式获取
     * @param int $pageId 当前页号
     * @author farmerjian<chengfeng1992@hotmail.com>
     */
    public function price($storeId = 0, $pageId = 1) {
        if (isset($_GET['low'])) {
            $low = (int)$_GET['low'];
            $this->session->set_userdata('low', $low);
        } else {
            $low = (int)$this->session->userdata('low');
        }
        if (isset($_GET['high'])) {
            $high = (int)$_GET['hith'];
            $this->session->set_userdata('high', $high);
        } else {
            $high = (int)$this->session->userdata('high');
        }
        if (isset($_GET['pageId'])) {
            $pageId = (int)$_GET['pageId'];
        } else {
            $pageId = (int)$pageId;
        }
        if ($low > $high) {
            $tmp = $high;
            $high = $low;
            $low = $tmp;
        }
        $storeId = (int)$storeId;
        if ($storeId == 0) {
            show_404();
            return;
        }
        $ans = $this->mitem->priceInterval($storeId, $low, $high);
        if ($ans === false) {
            $ans = array();
        }
        $temp = $this->pagesplit->split($ans, $pageId, $this->config->item('pageSize'));
        $ans = array();
        $ans['item'] = $temp['newData'];
        $ans['key'] = false;
        $commonUrl = site_url('shop/price/' . $storeId);
        $ans['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount']);
        $this->_showView($ans, $storeId);
    }
    /**
     * 添加商店评论
     * @param   string      context     评价的内容
     * @param   int         storeId     评价的店铺的id
     * @param   int         speed       送货速度
     * @param   int         score       服务态度
     * @param   int         time        时间戳，标记某个商品时候评论过
     *
     * @todo 完成对商店 送货速度 以及商店评分的处理
     */
    public function addComment() {
        $context = trim($this->input->post('context'));
        $storeId = (int)trim($this->input->post('storeId'));
        $speed = (int)trim($this->input->post('speed'));
        $score = (int)trim($this->input->post('score'));
        $time = (int)trim($this->input->post('time'));

        // 设置评论数组
        $temp[0] = $this->getUserId();
        if ($temp[0] == -1) {
            show_404();
            return;
        }
        $temp[1] = (int)$storeId;
        $temp[2] = date('Y-m-d H:i:s', $time);
        $temp[3] = $context;

        // 设置参数数组
        $data['storeId'] = $storeId;
        $data['userId'] = $temp[0];
        $data['context'] = $temp;
        $data['time'] = $time;
        $this->comStore->insert($data);
    }
}
?>

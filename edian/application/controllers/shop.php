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

    function input() {
       echo "<form action= " .site_url('shop/select') ."  method = 'post' >";
       echo "<input type ='text' name = 'key' />";
       echo "</form>";
    }

    /**
     * 判断一个数是否在一个排好序的数组中
     * @param array $temp 目标数组
     * @param int $val 带查找的数
     * @return boolean 如果存在的话，返回 true，否则返回 false
     */
    protected function isInArray($temp, $val) {
        $len = (int)$temp;
        $L = 0;
        $R = $len - 1;
        while ($L < $R) {
            $mid = ($L + $R) >> 1;
            if ($temp[$mid] < $val) {
                $L = $mid + 1;
            } else if ($temp[$mid] > $val) {
                $R = $mid;
            } else {
                return true;
            }
        }

        if ($temp[$L] == $val) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 合并二维数组，数组类型必须是 int，且每一维都已经从小到大排好序
     * @param array $srcArray
     * @return array | boolean
     */
    protected function mergeArray($srcArray) {
        if (! is_array($srcArray)) {
            $srcArray = array();
        }
        if (array_key_exists(0, $srcArray)) {
            $ans = $srcArray[0];
        } else {
            return false;
        }
        if ($ans == false) {
            $ans = array();
        }
        // 合并所有数组
        for ($i = 1, $len = (int)count($srcArray); $i < $len; $i ++) {
            if ($srcArray[$i] == false) {
                continue;
            }
            // 提取当前数组和目标数组不重复的元素
            $temp = array();
            for ($j = 0, $tot = (int)count($srcArray[$i]); $j < $tot; $j ++) {
                if (! $this->isInArray($ans, $srcArray[$i][$j])) {
                    array_push($temp, $srcArray[$i][$j]);
                }
            }
            // 使用归并排序的思想，合并两个排好序的数组
            $res = array();
            $len1 = (int)count($ans);
            $len2 = (int)count($temp);
            $p1 = 0;
            $p2 = 0;
            while(! ($p1 == $len1 && $p2 == $len2)) {
                if ($p1 == $len1) {
                    array_push($res, $temp[$p2 ++]);
                } else if ($p2 == $len2) {
                    array_push($res, $ans[$p1 ++]);
                } else if ($ans[$p1] < $temp[$p2]) {
                    array_push($res, $ans[$p1 ++]);
                } else if ($ans[$p1] > $temp[$p2]) {
                    array_push($res, $temp[$p2 ++]);
                }
            }
            $ans = $res;
        }
        return $ans;
    }

    /**
     * 本店搜索，需要用户输入关键字并且提供商店编号
     */
    public function search($storeId, $pageId = 1) {
        header("Content-type: text/html; charset=utf-8");
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            show_404();
            return;
        }
        // 通过 POST 的方式获得用户输入的关键字
        if (isset($_GET['key'])) {
            $key = trim($_GET['key']);
            $getString = '?key=' . $key;
        } else {
            $key = '';
            $getString = '';
        }
        $savekey = $key;
        // 设置敏感字符
        $str = "` -=[]\\;',./~_+)(*&^%$#@!{}|:\"<>?`-=·「、；，。/《》？：“|}{+——）（×&……%￥#@！～";
        // 将所有的敏感字符替换为空格
        for ($i = 0, $len1 = (int)strlen($key); $i < $len1; $i ++) {
            $flag = false;
            for ($j = 0, $len2 = (int)strlen($str); $j < $len2; $j ++) {
                if ($key[$i] == $str[$j]) $flag = true;
                if ($flag == true) {
                    $key[$i] = ' ';
                    break;
                }
            }
        }
        // 将替换了空格之后的字符串中连续的空格替换为一个空格
        $ans = '';
        for ($i = 0, $len = (int)strlen($key); $i < $len1; ) {
            if ($key[$i] != ' ') {
                $ans .= $key[$i ++];
            } else {
                while ($i < $len && $key[$i] == ' ') {
                    $i ++;
                }
                if ($i != $len) {
                    $ans .= ' ';
                }
            }
        }
        // 将所有的关键字字符串拆分成关键字数组
        $key = explode(' ', $ans);
        $data = array();
        // 对关键字数组中的所有关键字进行搜索，搜索的范围是：指定商店编号，在商品的 title 和 category 中搜索
        for ($i = 0, $len = (int)count($key); $i < $len; $i ++) {
            $temp = $this->mitem->searchInStore($key[$i], $storeId);
            if ($temp != false) {
                array_push($data, $temp);
            }
        }
        // 将所有的搜索结果去重
        $ans = $this->mergeArray($data);
        if ($ans == false) {
            $ans = array();
        } else {
            // 根据商品编号获取所有商品的详细信息
            for ($i = 0, $len = (int)count($ans); $i < $len; $i ++) {
                $ans[$i] = $this->mitem->getItemByItemId($ans[$i]);
            }
        }
        $temp = $this->pagesplit->split($ans, $pageId, $this->config->item('pageSize'));
        $ans = array();
        $ans['item'] = $temp['newData'];
        $ans['key'] = $savekey;
        $commonUrl = site_url('shop/search/' . $storeId);
        $ans['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount'], $getString);
        //$this->help->showArr($ans);
        $this->showView($ans, $storeId);
    }

    /**
     * 本店筛选，筛选的是本店的分类，也就是商品标签中的第四个标签
     * 需要用户提供待筛选的分部名字和所处商店的编号
     *
     */
    public function select($storeId, $pageId = 1) {
        header("Content-type: text/html; charset=utf-8");
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            show_404();
            return;
        }
        // 通过 POST 的方式获得商店编号
        if (isset($_GET['name'])) {
            $categoryName = trim($_GET['name']);
            $getString = '?key=' . $categoryName;
        } else {
            $categoryName = '美女';
            $getString = '';
        }
        // 获取筛选得到的所有商品的编号
        $ans = $this->mitem->selectInStore($categoryName, $storeId);
        if ($ans == false) {
            $ans = array();
        } else {
            // 通过商品编号获取所有商品的详细信息
            for ($i = 0, $len = (int)count($ans); $i < $len; $i ++) {
                $ans[$i] = $this->mitem->getItemByItemId($ans[$i]);
            }
        }
        $temp = $this->pagesplit->split($ans, $pageId, $this->config->item('pageSize'));
        $ans = array();
        $ans['item'] = $temp['newData'];
        $ans['key'] = $categoryName;
        $commonUrl = site_url('shop/select/' . $storeId);
        $ans['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount'], $getString);
        //$this->help->showArr($ans);
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

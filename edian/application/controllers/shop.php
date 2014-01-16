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
    public function index($store = -1, $pageId = 1) {
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
            //var_dump($data1['pageNumFooter']);
            //$this->help->showArr($data1['pageNumFooter']);
        }
        $data1['storeId'] = $store;
        //$this->help->showArr($data1);
        $this->load->view('store.php', $data1);
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
            //header("Content-type: text/html; charset=utf-8");
            //var_dump($res);
            //$this->help->showArr($res);
            $this->load->view('storeMap', $res);
        }
    }

    function input() {
       echo "<form action= " .site_url('shop/search') ."  method = 'post' >";
       echo "<input type ='text' name = 'key' />";
       echo "</form>";
    }

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

    public function search($storeId = -1) {
        // 通过 GET 的方式获得商店编号
        /*
        if (isset($_GET['storeId'])) {
            $storeId = (int)$_GET['storeId'];
        } else {
            $storeId = 1;
        }
         */
        // 通过 POST 的方式获得用户输入的关键字
        $key = trim($this->input->post('key'));
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
        $this->load->library('help');
        // 将所有的搜索结果去重
        $ans = $this->mergeArray($data);
        // 展示
        $this->help->showArr($ans);
    }
}
?>

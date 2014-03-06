<?php
require 'basesearch.php';

class Search extends BaseSearch {

    function __construct() {
        parent::__construct();
        $this->load->model('store');
        $this->load->model('comitem');
    }

    /**
     * 获取每个商品对应的商店的送货时间
     * @param array $data mysql 查询返回的数组
     * @return array
     */
    protected function _getDuration($data) {
        $ans = $this->_getSubArray($data, 'belongsTo');
        for ($i = 0, $len = (int)count($ans); $i < $len; $i ++) {
            $ans[$i] = $this->store->getDuration($ans[$i]);
        }
        return $ans;
    }

    public function testSearch() {
        $this->load->view('farmerjian');
    }

    /**
     * 店外搜索对应的后台处理函数，提供排序机制
    @param int $button 排序方式，默认 1
     * <pre>
     *      1  表示按照综合排名，对应 item 中的 rating
     *      2  表示按照价格排序，对应 item 中的 price
     *      3  表示按照销量排序，对应 item 中的 sellNum
     *      4  表示按照商品评分，需要选出 item 中的 satisfyScore
     *      5  表示按照距离排序，需要选出 item 中的 belongsTo 对应的商店的坐标计算出距离该用户现在坐标的距离
     *      6  表示按照送货速度排序，需要选出 item 中的 belongsTo 对应的商店的 duration
     * </pre>
     * @param int $order 升序或降序，默认 1
     * <pre>
     *      1  表示按照 降序 排序
     *      2  表示按照 升序 排序
     * </pre>
     * @param int $pageId 分页号
     * @todo 两点，一个是belongsTo ，不能只是一个编号，而且应该有名字, satisfyScore 应该是评论的，是总的除以评论的人
     * @todo 在ans数组中传入button和order
     */
    public function searchAction($button = 1, $order = 1, $pageId = 1) {
        if (isset($_GET['key'])) {
            $key = trim($_GET['key']);
            $getString = '?key=' . $key;
        } else {
            $key = '';
            $getString = '';
        }
        $keyBackUp = $key;
        $key = $this->_filterKeywords($key);
        // 对关键字数组中的所有关键字进行搜索，搜索的范围是：在商品的 title 和 category 中搜索
        $data = array();
        for ($i = 0, $len = (int)count($key); $i < $len; $i ++) {
            if ($key[$i] == '') {
                continue;
            }
            $temp = $this->mitem->searchOutStore($key[$i]);
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
                $itemId = $ans[$i];
                $ans[$i] = $this->mitem->getDetailInfo($itemId);
                $commenterAmount = $this->comitem->getCommenterAmount($itemId);
                $ans[$i]['storeName'] = $this->store->getStoreName($ans[$i]['belongsTo']);
                if ($commenterAmount != false && $commenterAmount != 0) {
                    $ans[$i]['satisfyScore'] = $ans[$i]['satisfyScore'] / $commenterAmount;
                }
            }
        }
        // 将所得结果按照指定顺序排序
        //$this->help->showArr($ans);
        $ans = $this->_sort($ans, $button, $order);
        // 将所得的结果进行分页
        $temp = $this->pagesplit->split($ans, $pageId, $this->config->item('pageSize'));
        $ans = array();
        $ans['item'] = $temp['newData'];
        $ans['key'] = $keyBackUp;
        $commonUrl = site_url('search/searchAction/' . $button . '/' . $order);
        $ans['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount'], $getString);
        //$this->help->showArr($ans);
        $ans['type'] = $button;
        $ans['desc'] = $order;
//        $this->load->view("search" , $ans);
    }
}
?>

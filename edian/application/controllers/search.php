<?php
class Search extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('mitem');
        $this->load->model('store');
        $this->load->config('edian');
        $this->load->library('pagesplit');
    }

    /**
     * 店外搜索，用户通过 GET 的方式传递搜索关键字进来，按扎特定的方式进行排序
     * @param int $button 排序方式，默认 1
     *      1  表示按照综合排名，对应 item 中的 rating
     *      2  表示按照价格排序，对应 item 中的 price
     *      3  表示按照销量排序，对应 item 中的 sellNum
     *      4  表示按照商品评分，需要选出 item 中的 satisfyScore
     *      5  表示按照距离排序，需要选出 item 中的 belongsTo 对应的商店的坐标计算出距离该用户现在坐标的距离
     *      6  表示按照送货速度排序，需要选出 item 中的 belongsTo 对应的商店的 duration
     * @param int $order 升序或降序，默认 1
     *      1  表示按照 降序 排序
     *      2  表示按照 升序 排序
     */
    public function index($button = 1, $order = 1) {
        if ($button < 1 || $button > 6 || $order < 1 || $order > 2) {
            show_404();
            return;
        }
        $key = $_GET
    }
}
?>
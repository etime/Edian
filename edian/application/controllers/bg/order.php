<?php
//require 'bg/home.php';
include 'home.php';
/**
 * 这里是处理关于订单的函数,这里的东西，只是后台哦
 * @name       ../controllers/order.php
 *  @Author     unasm<1264310280@qq.com>
 *  @since      2013-07-29 10:06:13
 *  @package    controller
 *  @sub_package bg
 */
class Order extends Home {
    // 存储商店编号
    var $storeId;
    var $pageSize;
    // 构造函数
    function __construct() {
        parent::__construct();
        $this->load->model('morder');
            $this->load->config('edian');
        $this->storeId = $this->session->userdata('storeId');
        $this->pageSize = $this->config->item('pageSize');
    }

    /**
     * 处理今日订单
     * @param int $pageId    当前的页号
     */
    public function today($pageId = 1) {
        // 处理用户未登录
        if ($this->userId == -1) {
            $this->nologin(site_url('bg/order/today'));
            return;
        }

        // 通过 get 的方式获取 pageId
        if (isset($_GET['pageId'])) {
            $pageId = $_GET['pageId'];
        }

        // 通过 storeId 获取今日订单
        $ans = $this->morder->getToday($this->storeId);

        // 对今日订单进行解码
        for ($i = 0, $len = count($ans); $i < $len; $i ++) {
            // 获取商品的标题
            $temp = $this->mitem->getTitle($ans[$i]['item_id']);
            // 商品不存在
            if ($temp === false) {
                $temp = '******';
            }
            // 设置商品的标题
            $ans[$i]['title'] = $temp;
            // 获取购买者的昵称
            $temp = $this->user->getNameById($ans[$i]['ordor']);
            // 购买者不存在
            if ($temp === false) {
                $temp = '******';
            }
            // 设置购买者的昵称
            $ans[$i]['user_name'] = $temp['user_name'];
        }
        $data['today'] = $ans;
        if ($data['today']) {
            $temp = $this->pagesplit->split($data['today'], $pageId, $pageSize);
            $data['today'] = $temp['newData'];
            $commonUrl = site_url() . '/order/Today';
            $data['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount']);
            echo $data['pageNumFooter'];
        }
        $this->load->view('ordtoday', $data);
    }

    // 今日订单的入口
    public function index() {
        echo "今日订单";
    }

    /**
     * 显示后台当前正要处理的订单信息
     * 为后台实时刷新的页面提供数据,显示正要处理的订单信息
     */
    public function ontime($pageId = 1)
    {
        $this->load->library('help');
        //搞毛呦，这个怎么解释
        if (isset($_GET['pageId'])) {
            $pageId = $_GET['pageId'];
        }
        $pageSize = $this->config->item('pageSize');
        //只是检验storeId,因为storeId才是决定一个商店最重要的角色
        if(!$this->userId){
            $this->nologin(site_url()."/order/ontime");
            return;
        }

        $data = Array();
        $type = $this->user->getCredit($this->userId);
        $this->load->config("edian");
        if($type == $this->config->item("adminCredit")){
            $data["order"] = $this->morder->getAllOntime();
        }else if($type == $this->config->item('bossCredit')){
            $storeId = $this->session->userdata("storeId");
            //之所以这么处理，是因为考虑bg/home/index函数负责了店铺的选择和控制
            if(!$storeId){
                exit("登录失效，请刷新页面");
            }else{
                $data["order"] = $this->morder->getOntime($storeId);
            }
        }
        //因为及时订单比较少，所以不想加分页，店家也不想，不是吗？
        /*
        if ($data['order']) {
            $temp = $this->pagesplit->split($data['order'], $pageId, $pageSize);
            $data['order'] = $temp['newData'];
            $data['pageNumFooter'] = $this->pagesplit->setPageUrl( site_url('order/ontime'), $pageId, $temp['pageAmount']);
        }
         */
        /*
        if($data["order"])
            $data["order"] = $this->formData($data["order"]);
        echo $data['pageNumFooter'] . '<br>';
         */
        var_dump($data['order'][0]);
        $this->load->view("onTimeOrder",$data);
    }
}
?>

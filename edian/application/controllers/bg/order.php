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
class Order extends Home
{
    var $storeId;
    /**
     *  继承来自bg/home,逻辑上更加清晰,涉及后台的函数集中在bg/home中
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('morder');
    }
    public function index()
    {
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
        $this->load->view("onTimeOrder",$data);
    }
}
?>

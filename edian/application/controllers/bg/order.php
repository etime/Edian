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
    /** 存储商店编号*/
    protected  $storeId;
    /** 是分页的大小，每页多少内容 */
    protected $pageSize;

    // 构造函数
    function __construct() {
        parent::__construct();
        $this->load->model('morder');
        $this->load->config('edian');
        $this->load->model('mitem');
        $this->load->library('help');
        $this->load->library('pagesplit');
        $this->storeId = $this->session->userdata('storeId');
        $this->pageSize = $this->config->item('pageSize');
    }

    /**
     * 显示后台当前正要处理的订单信息
     * 为后台实时刷新的页面提供数据,显示正要处理的订单信息
     */
    public function ontime() {
        // 检查权限
        if ($this->_checkAuthority(site_url('bg/order/ontime')) === false) {
            return;
        }
        // 接受商店编号
        if (isset($_POST['storeId'])) {
            $storeId = (int)trim($this->input->post('storeId'));
            if ($storeId == -1 && $this->isBoss) {
                show_404();
                return;
            }
            if ($storeId == false) {
                $storeId = $this->session->userdata('storeId');
            }
        } else {
            $storeId = $this->session->userdata('storeId');
        }

        // 如果没有设置 storeId
        if ($storeId == false) {
            $this->choseStore($this->getBossId());
            return;
        }

        $this->storeId = $storeId;

        $data = Array();
        if ($this->isAdmin && $this->storeId == -1) {
            $data['order'] = $this->morder->getAllOntime();
        } else if ($this->storeId != -1) {
            $data['order'] = $this->morder->getOntime($this->storeId, $this->config->item('infFailed'));
            $data['order'] = $this->orderForm($data['order']);
            $data['orderState'] = $this->config->item('orderState');
            $data['storeId'] = $this->storeId;
        }
        $this->help->showArr($data);
        $this->load->view("onTimeOrder", $data);
    }

    /**
     * 历史订单的显示
     * @param int $pageId 当前页号
     */
    public function history($pageId = -1) {
        // 检查权限
        if ($this->_checkAuthority(site_url('bg/order/history')) === false) {
            return;
        }
        // 接受当前页号
        if (isset($_GET['pageId'])) {
            $pageId = (int)$_GET['pageId'];
        } else {
            $pageId = (int)$pageId;
        }
        // 接受商店编号
        if (isset($_POST['storeId'])) {
            $storeId = (int)trim($this->input->post('storeId'));
            if ($storeId == -1 && $this->isBoss) {
                show_404();
                return;
            }
            if ($storeId == false) {
                $storeId = $this->session->userdata('storeId');
            }
        } else {
            $storeId = $this->session->userdata('storeId');
        }

        // 如果没有设置 storeId
        if ($storeId == false) {
            $this->choseStore($this->getBossId());
            return;
        }

        $this->storeId = $storeId;
        if ($this->storeId != -1) {
            $data['order'] = $this->morder->hist($this->storeId);
        } else if ($this->isAdmin && $this->storeId == -1) {
            $data['order'] = $this->morder->histAdmin();
        } else {
            $data['order'] = array();
        }
        if ($data['order']) {
            $data['order'] = $this->orderForm($data['order']);
        }
//        if ($data['order']) {
            $temp = $this->pagesplit->split($data['order'], $pageId, $this->pageSize);
            $data['order'] = $temp['newData'];
            $commonUrl = site_url('/bg/order/history');
            $data['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount']);
//        }
        $data['storeId'] =  $this->storeId;
        $this->load->view('histOrder2' , $data);
    }

    /**
     *  对订单信息进行修缮弥补
     *  很多购物车订单里面的信息只是保存了id，下标，现在开始修补完成，为呈现准备，目前是为历史订单准备
     *  采用判断的方式是为了方便兼容，不是所有的修缮都会有对应的键值
     *  目前针对的格式为
     *  <pre>
     *  0 => (
     *      id=> 150
     *      addr=> 0
    *       info => (
    *           orderNum=>
    *           more=>
    *           price=>
    *           info=>
    *       )
    *       item_id=> 55
    *       time=> 2013-12-29 23:17:37
    *       ordor=> 52
    *       state=> 2
    *  )
    *  </pre>
     *  @param  array   $data 包含了各种各样需要修缮的订单信息，
     *  @todo 需要检验各个同一时间的订单的state是否相同
     */
    protected function orderForm($data)
    {
        $cnt = 0;
        $res = Array();
        for($i = 0, $len = $data ? count($data) : 0; $i < $len ;){
            $buyer = $data[$i]['ordor'];
            $time = $data[$i]['time'];
            $order = Array();
            if(array_key_exists('addr' , $data[$i])){
                $user = $this->user->getAplById($data[$i]['ordor'], $data[$i]['addr']);
                $user['id'] = $data[$i]['ordor'];
                //$res[$cnt]['order'] = $temp;
            }
            $res[$cnt]['item'] = Array();
            $res[$cnt]['state'] = $data[$i]['state'];
            $res[$cnt]['time'] = $time;
            $total = 0;
            while($i < $len && ($data[$i]['ordor'] === $buyer ) && ($time === $data[$i]['time'])){
                $item = Array();
                if(array_key_exists('item_id' , $data[$i])){
                    $item['id'] = $data[$i]['item_id'];
                    $tmp = $this->mitem->getTitPrice($item['id']);
                    $item = array_merge($item , $tmp);
                }
                $item['info'] = $data[$i]['info'];
                $total += $data[$i]['info']['price'] ;
                $item['orderId'] = $data[$i]['id'];
                array_push( $res[$cnt]['item'] , $item);
                $i++;
            }
            $res[$cnt]['user'] = $user;
            $res[$cnt]['total'] = $total;
            $cnt++;
        }
        return $res;
    }

    /**
     * 修改订单的状态，这个是为了后台准备的
     * 因为在设计的时候的问题，同一次下单的东西之间联系并不大，所以时间就成联系的根本节点了
     * @param   int     $orderId    订单的编号 ,实际上，是storeId和时间的结合，要简言之这种格式
     * @param   int     $state      将要修改的状态
     * @param   string  $goto       完成之后要跳转去的地方 ,默认是今日订单
     * @param   post    $context    投诉或者是拒绝时候输入的内容
     */
    public function changeNote($orderId = -1 , $state , $goto = 'ontime')
    {
        if($this->_checkAuthority(site_url('bg/order/ontime')) === false){
            return;
        }
        $orderId = explode('_' , $orderId);
        if(count($orderId) === 2){
            //$storeId = $this->session->userdata('storeId');
            $stateArr = $this->config->item('orderState');
            if(array_key_exists($state , $stateArr)){
                //管理员并没有拒绝订单和举报恶意订单的功能
                if($this->isAdmin){
                    $this->morder->setState($orderId , $state);
                } else if($this->storeId){
                    $context = trim($this->input->post('context'));
                    $this->morder->setStateByStore($orderId[1] , $state , $storeId , $context);
                } else {
                    $this->load->model('mwrong');
                    $this->mwrong->insert("有人非法入侵bg/order/changeNote " . __LINE__);
                }
            } else {
                $this->mwrong->insert("storeId = $this->storeId 的用户输入了不存在的订单状态state = $state" );
            }
        }

        $data['uri'] = site_url('bg/order/' . $goto);
        $data['uriName'] = '订单列表';
        $data['atten'] = '已经完成';
        $this->load->view('jump2' , $data);
        //Header('Location: ' . site_url('bg/order/' . $goto));
    }
}
?>

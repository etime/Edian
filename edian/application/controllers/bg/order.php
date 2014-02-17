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
     * 处理今日订单
     * @param int $pageId    当前的页号
     */
    public function today($pageId = 1) {
        if ($this->_checkAuthority(site_url('bg/order/today')) === false) {
            return;
        }

        // 通过 get 的方式获取 pageId
        if (isset($_GET['pageId'])) {
            $pageId = $_GET['pageId'];
        }

        // 通过 storeId 获取今日订单
        $ans = $this->morder->getToday($this->storeId);
        if ($ans != false) {
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
                $ans[$i]['user_name'] = $temp;
            }
        }
        $data['today'] = $ans;
        if ($data['today']) {
            $temp = $this->pagesplit->split($data['today'], $pageId, $this->pageSize);
            $data['today'] = $temp['newData'];
            $commonUrl = site_url('bg/order/today');
            $data['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount']);
//            echo $data['pageNumFooter'];
        }
        $this->load->view('ordtoday', $data);
    }

    /**
     * 历史订单的显示
     *
     * 通过登录者的id进行在后台查找用户的历史订单信息
     */
    public function history($pageId = 1) {
        if ($this->_checkAuthority(site_url('bg/order/history')) === false) {
            return;
        }
        // 通过 get 的方式得到页号
        if (isset($_GET['pageId'])) {
            $pageId = $_GET['pageId'];
        }
        $this->storeId = 2;
        $data['order'] = $this->morder->hist($this->storeId);
        if ($data['order']) {
            $temp = $this->pagesplit->split($data['order'], $pageId, $this->pageSize);
            $data['order'] = $temp['newData'];
            $commonUrl = site_url() . '/bg/order/history';
            $data['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount']);
        }
        if ($data['order']) {
            $data['order'] = $this->orderForm($data['order']);
        }
        //$this->help->showArr($data['order']);
        $data['storeId'] =  $this->storeId;
        //$this->help->showArr($data);
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
        $this->help->showArr($data);
        echo "<br/>";
        echo "<br/>";
        echo "<br/>";
        for($i = 0, $len = count($data); $i < $len ;){
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
     * 显示后台当前正要处理的订单信息
     * 为后台实时刷新的页面提供数据,显示正要处理的订单信息
     */
    public function ontime() {
        if ($this->_checkAuthority(site_url('bg/order/ontime')) == false) {
            return;
        }
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
                $data["order"] = $this->morder->getOntime($storeId , $this->config->item('infFailed'));
                $data['order'] = $this->orderForm($data['order']);
            }
            $data['orderState'] = $this->config->item('orderState');
            $data['storeId'] = $storeId;
            $this->help->showArr($data['order']);
        }
        $this->load->view("onTimeOrder",$data);
    }

    /**
     * 修改订单的状态，这个是为了后台准备的
     * @param   int     $orderId    订单的编号
     * @param   int     $state      将要修改的状态
     * @param   string  $goto       完成之后要跳转去的地方
     * @param   post    $context    投诉或者是拒绝时候输入的内容
     */
    public function changeNote($orderId = -1 , $state , $goto)
    {
        if($this->_checkAuthority(site('bg/order/ontime')) === false){
            return;
        }

        $storeId = $this->session->userdata('storeId');
        $stateArr = $this->config->item('orderState');
        var_dump($stateArr);
        die;
        if(array_key_exists($state , $stateArr)){
            //管理员并没有拒绝订单和举报恶意订单的功能
            if($this->isAdmin){
                $this->morder->setState($orderId , $state);
            } else if($storeId){
                $context = trim($this->input->post('context'));
                $this->morder->setStateByStore($orderId , $state , $storeId , $context);
            } else {
                $this->load->model('mwrong');
                $this->mwrong->insert("有人非法入侵bg/order/changeNote");
            }
        } else {
            $this->mwrong->insert("storeId = $storeId 的用户输入了不存在的订单状态state = $state" );
        }
    }
}
?>

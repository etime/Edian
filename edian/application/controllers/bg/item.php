<?php
require 'home.php';
/*************************************************************************
    > File Name :     ../controllers/bg/item.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-08-17 00:16:20
 ************************************************************************/
/*
 * 关于后台的一些item的操作集合
 */
class item extends Home {
    var $storeId;
    var $bossId;
    var $pageSize;

    /**
     * 构造函数
     */
    function __construct() {
        parent::__construct();
        $this->load->model('mitem');
        $this->load->library('pagesplit');
        $this->load->config('edian');
        $this->load->library('help');
        $this->load->model('comitem');

        $this->userId = $this->getUserId();
        $this->storeId = $this->session->userdata('storeId');
        $this->bossId = $this->session->userdata('bossId');
        $this->pageSize = $this->config->item('pageSize');
    }

    /**
     * 商品管理页面的后台
     * @param int $pageId
     */
    public function mange($pageId = 1) {
        if ($this->userId == -1) {
            $this->noLogin(site_url('bg/item/mange'));
            return;
        }
        if (! ($this->storeId && $this->bossId)) {
            $this->choseStore($this->bossId);
            return;
        }
        if (isset($_GET['pageId'])) {
        	$pageId = $_GET['pageId'];
        }
        $data = array();
        $data['item'] = $this->mitem->getBgList($this->storeId);
        $data['stateMark'] = $this->config->item('state');
        if ($data['item']) {
            $temp = $this->pagesplit->split($data['item'], $pageId, $this->pageSize);
            $data['item'] = $temp['newData'];
            $commonUrl = site_url() . '/bg/item/mange';
            $data['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount']);
        }
        $this->load->view('bgItemMan', $data);
    }

    /**
     * @param int $pageId 分页号
     */
    public function itemCom($pageId = 1) {
        if ($this->_checkAuthority(site_url('bg/item/itemcom')) === false) {
            return;
        }
        if (isset($_GET['pageId'])) {
            $pageId = $_GET['pageId'];
        }

        // 设置查看时间段
        if ($this->isAdmin) {
            $day = 1;
        } else if ($this->isBoss) {
            $day = 3;
        } else {
            show_404();
            return;
        }

        $storeId = $this->session->userdata('storeId');
        $comment = $this->comitem->getRecentComment($storeId, $day);

        // 获取被评论商品的标题
        if ($comment != false) {
            for ($i = 0, $len = (int)count($comment); $i < $len; $i++) {
                $temp = $this->mitem->getTitle($comment[$i]['context'][0][1]);
                $comment[$i]['title'] = $temp;
            }
        }

        //分页
        if ($comment != false) {
            $pageSize = $this->config->item('pageSize');
            $temp = $this->pagesplit->split($comment, $pageId, $pageSize);
            $comment = $temp['newData'];
            $commonUrl = site_url('/bg/item/itemCom');
            $data['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount']);
        } else {
        }

        $data['com'] = $comment;
        $data['isAdmin'] = $this->isAdmin ? 1 : 0;
        $data['title'] = $storeId . '号店的最近' . $day . '内的所有评论';
        $this->help->showArr($data);
        $this->load->view('bgcom', $data);
    }
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
    public function set($state = -1,$itemId = -1)
    {
        //指定商品指定状态
        if($itemId == -1){
            echo "没有指明删除的物品";
            return;
        }
        if($state == -1){
            echo "没有标明状态";
            return;
        }
        //检查权限
        if($this->check($itemId))
            $this->mitem->setState($state,$itemId);
        redirect(site_url("bg/item/mange"));//修改之后，返回原来页面
    }
    private function check($itemId)
    {
        //检查权限,
        $master = $this->mitem->getMaster($itemId);
        //必须是管理员或者是item的作者才可以
        if(($this->type == $this->ADMIN) || ($this->user_id == $master["author_id"]))return true;
        return false;
    }

    public function checom($comId = -1,$idx = -1)
    {
        $ajax = 0;
        //之后进行ajax判断，对两种请求进行处理
        //修改item评论的地方，只允许作者和管理员修改
        if($comId == -1 || $idx == -1){
            echo "呵呵，联系管理员吧/=.= ,communicate with admin please";
            show_404();
            return;
        }
        $this->load->model("comitem");
        $context = $this->comitem->getContext($comId);
        $this->showArr($context);
        $userName = $this->user->getNameById($this->user_id);
        if(count($context) <= $idx){
            exit("wrong Idx".__LINE__);
        }
        if(($this->type == $this->ADMIN)|| ($userName["user_name"] == $context[$idx]["user_name"])){
            //管理员和回复的本人，才有权利修改
            $cont = trim($this->input->post("cont"));
            $context[$idx]["context"] = $cont;
            $this->comitem->update($context,$comId);
        }
        if($ajax){
            echo json_encode(0);
        }else{
            redirect(site_url("bg/item/itemCom"));
        }
    }
    /*
    private function showArr($array)
    {
        echo "<br/>";
        foreach($array as $index => $value){
            var_dump($index);
            echo "   =>   ";
            var_dump($value);
            echo "<br>";
        }
        echo "<br/>";
    }
     */
}
?>

<?php
/*************************************************************************
    > File Name :     ../controllers/bg/item.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-08-17 00:16:20
 ************************************************************************/
/*
 * 关于后台的一些item的操作集合
 */
class item extends MY_Controller
{
    var $user_id,$ADMIN;
    /**
     * 用户必须登录这个，才可以
     */
     function __construct()
    {
        parent::__construct();
        $this->load->model("mitem");
        $this->user_id = $this->user_id_get();
        $this->load->model("user");
        $this->ADMIN = 3;
        $this->type = $this->user->getType($this->user_id);
    }
    public function mange()
    {
        if(!$this->user_id){
            $this->noLogin(site_url("bg/item/mange"));
            return;
        }
        $data = Array();
        if($this->type == $this->ADMIN){
            $data["item"] = $this->mitem->getAllList();
        }else{
            $data["item"] = $this->mitem->getBgList($this->user_id);
        }
        //$this->showArr($data);
        $this->load->view("bgItemMan",$data);
    }
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
    public function itemCom()
    {
        //管理员看到一天内所有的评论，其他人看到3天内所有的评论
        if(!$this->user_id){
            $this->noLogin(site_url("bg/item/itemCom"));
            return;
        }
        $type = $this->user->getType($this->user_id);
        $this->load->model("comitem");
        $com = Array();
        if($type == $this->ADMIN){
            //为管理员的时候
            $com = $this->comitem->getSomeDate(100);
        }else{
            $com = $this->comitem->getUserDate($this->user_id,100);
        }
        if($com)$len = count($com);
        else $len = 0;
        for ($i = 0; $i < $len; $i++) {
            $temp  = $this->mitem->getTitle($com[$i]["item_id"]);
            $com[$i]["title"] = $temp["title"];
        }
        $data["com"] = $com;
        $data["type"] = $type;
        $data["ADMIN"] = $this->ADMIN;
        $this->load->view("bgcom",$data);
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
}
?>

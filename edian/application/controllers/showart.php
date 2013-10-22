<?php
/**
 * 这个是作为帖子的显示页面
 * 数据的得到是首先通过php获得具体的店主，商品信息，其他的信息通过ajax获得,和mail不同，我想是因为信息量不同导致的吧
 **/
class Showart extends MY_Controller
{
    var $user_id;
    function __construct()
    {
        parent::__construct();
        $this->user_id = $this->user_id_get();
        $this->load->model("art");
        $this->load->model("user");
    }
    public function index($art_id = -1)
    {
        if($art_id == -1)show_404();
        $data = $this->_getIndexData($art_id);
        $this->add($art_id);
        $data["artId"] = $art_id;
        if($this->user_id){
            $temp = $this->user->getUpdate($this->user_id);
            $temp["photo"] = $temp["user_photo"];
            /*
                $data["userPhoto"] = $temp["user_photo"];
             */
            $data["user"] = $temp;
            $data["user"]["user_id"] = $this->user_id;
        }
        $data["dir"] = $this->part;
        $this->load->view("showart",$data);
    }
    public function index2($art_id)
    {
        //通过传进来的art_id给出具体的数据``,浏览页面
        $data = $this->_getIndexData($art_id);
        $this->add($art_id);
        $data["artId"] = $art_id;
        if($this->user_id){
            $temp = $this->user->getNess($this->user_id);
            $data["userPhoto"] = $temp["user_photo"];
            $data["user"] = $temp;
        }
        $this->load->view("showart2",$data);
    }
    public function test()
    {
        $data["tit"] = "testting title";
        $data["cont"] = "testing content";
        $data["part"] = rand(0,10);
        $data["value"] = rand(100,10000);
        $data["price"] = rand(10,1000);
        $arr = array(
            '191367926062.jpg','191369575022.jpg','221368022161.jpg','221368018984.jpg'
        );
        $data["file_name"] = $arr[rand(0,3)];
        $res = $this->art->cinsertArt($data,"19");
        var_dump($res);
    }
    private function _getIndexData($art_id)
    {
        //将要获取的不止是art的内容，and userinfomation其实还有评价的内容，我想通过ajax得到。
        $ans = $this->art->getById($art_id);
        if($ans == false)show_404();
        if ($ans["author_id"] == $this->user_id) {//当用户浏览的是自己的帖子的时候，因为动态已经看到，所以没有必要再给出new，将new去除，commer不变
            $this->art->changeNew($art_id);//将最新的状态修改
        }
        $data2 = $this->user->getPubAdr($ans["author_id"]);//获取大量的信息哦
        $ans = array_merge($ans,$data2);
        return $ans;
    }
    public function add($art_id)
    {
        $this->art->addvisitor($art_id);
        //每当一个用户浏览的话，就增加一个浏览量加value
    }
    public function getCom($artId  = "-1")
    {
        $this->load->model("comment");
        if($artId  =="-1"){
            exit("code");
        }
        $ans = $this->comment->getCommentById($artId);
        for($i = 0; $i < count($ans);$i++){
            $data = $this->user->getNess($ans[$i]["user_id"]);
            if($data){
                $ans[$i]["photo"] = $data["user_photo"];
                $ans[$i]["name"] = $data["user_name"];
            }
        }
        echo json_encode($ans);
    }
    public function addCom($artId)
    {//根据artId向其中添加评论
        if($this->user_id == false){
            exit("0");
        }
        $com = trim($this->input->post("com"));
        if(strlen($com)==0){
            echo json_encode("请输入内容");
            return;
        }
        $this->load->model("comment");
        $state["comment_id"] = $this->comment->insertComment($artId,$this->user_id,$com);//评论没有必要带空格吧,我会保留原文的空格，但不是评论的空格
        if($state["comment_id"]!=0){                                                    //利用返回的id判断，
            $this->art->addComNum($artId,$this->user_id);                               //向art中添加本帖子的评论数目
            $temp = $this->user->getNess($this->user_id);
            $state["photo"] = $temp["user_photo"];
            echo json_encode($state);
            $temp = $this->art->getMaster($artId);//找到帖子的主人，告诉他，添加了一个评论
            $this->user->addComNum($temp["author_id"]);                             //向用户的账户中添加楼主评论的人数;
            return;
        }
        echo json_encode($state["comment_id"]);
    }
}
?>

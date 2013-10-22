<?php
/**
* 这个是用户空间的设计页面，因为对之前的userspace不满意，所以第二次开始设计
*我关注的商品，我关注的店铺，都需要添加，将来，
comNum,就是我发表的帖子的回复数目，在我进入列表页面的时候清空
 **/
class Space extends MY_Controller
{
    var $user_id,$user_name;//空间主人的一些信息，保存到这里，就是为了在以后直接调用比较方便。
    function __construct()
    {
        parent::__construct();
        $this->load->model("mitem");
        $this->load->model("user");
        $this->user_id = $this->user_id_get();
    }
    public function index($masterid  = -1)
    {
        if($masterid == -1) $masterid = $this->user_id;
        if((!$masterid)||(preg_match("/^\d+$/",$masterid) == 0))show_404();//不仅没有给出空间id，也没有自己登陆，表示404
        $data = $this->user->getItem($masterid);
        if($data == false)show_404();
        $extro = $this->user->getExtro($masterid);
        if($extro &&(array_key_exists("lestPrc",$extro))){
            //这段代码重复度比较高呢？需要最低价格的地方,需要下单的地方，就需要这个
            $data["lestPrc"] = $extro["lestPrc"];
        }else{
            $data["lestPrc"] = 0;
        }
        $data["masterId"] = $masterid;//masterId当前访问的空间主任的id，userId为登陆者的id
        $data["addr"] = $this->formAddr($data["addr"]);//拼接地址
        $data["userId"] = $this->user_id;
        //$this->showArr($data);
        /**********下面是对用户信息的一些初始化，**************/
        $data["cont"] = $this->mitem->getUserList($masterid);
        //搜集订单所有的商品信息，订单数字，评论数，
        $this->load->view("userSpace",$data);
        /*
        if($this->user_id == $masterid){
            $this->user->cleCom($masterid);//将所有的评论num清空,目前取消提示的功能，将来必然添加
        }
         */
    }
    private function showArr($arr)
    {
        var_dump($arr);
        foreach ($arr as $key => $val) {
            echo $key."  =>  ".($val);
            echo "<br/>";
        }
    }
    private function formAddr($addr)
    {
        $addr = explode("&",$addr);
        if(count($addr)>1)return $addr[0];
        return null;
    }
    public function index2()
    {//这个页面得分不高，所以暂时抛弃
        $this->load->view("userSpace2");
    }
    public function getJoin($userId = -1)
    {
        //为前台通过ajax获得数据的space.js/getJoin后台，获得用户所有的参与的帖子
        if($this->user_id == $userId){
            $this->load->model("comment");
            $ans = $this->comment->getByUserId($userId);
            $ans = ($this->fb_unique($ans));//刚开始得到的是二维数组，整理成为1维，然后去重
            $timer = 0;//计数器，从0开始计算
            foreach ($ans as $key) {
                $temp = $this->art->getSeaResById($key);
                if($temp){
                    $author = $this->user->getNameById($temp["author_id"]);
                    if($author){
                        $temp["name"] =  $author["user_name"];
                        $temp["art_id"] = $key;
                        /*
                        $temp["partName"] = $this->partMap[$temp["part_id"]];
                         */
                        $res[$timer++]  = $temp;
                    }
                }
            }
            echo json_encode($res);
        }else show_404();
    }
    /*
    public  function fb_unique($array2D)
    {//将二维的数组转变成为一维数组,方便unique
        foreach ($array2D as $key) {
            $key = join(",",$key);
            $reg[] = $key;
        }
        $reg = array_unique($reg);
        return $reg;
    }
     */
}
?>

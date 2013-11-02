<?php
/*************************************************************************
    > File Name :     item.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-07-23 14:07:41
 ************************************************************************/
/*
 * 这个作为前台item.php 的操作合集了
 */
class item extends MY_Controller
{
    var $user_id;
    /**
     * 开始声明user_id,因为用到的地方比较多，My_controller中集成了几个经常用到的操作
     */
     function __construct()
    {
        parent::__construct();
        $this->user_id = $this->user_id_get();
        $this->load->model("mitem");
    }
    public function index($itemId = -1)
    {
        if($itemId == -1){
            show_404();
            return;
        }
        $det = $this->mitem->getDetail($itemId);//属性的列表中不可以是数字，这个在将来修复
        if($det == false){
            show_404();
            return;
        }
        $det["img"] = explode("|",$det["img"]);//对img进行切割，处理出各个图片

        /****进行attr的数据解码***/
            $attr = explode("|",$det["attr"]);
            $attr[0] = explode(",",$attr[0]);
            $attr[0] = $this->formAttr($attr[0]);
            $det["attr"] = $attr;
        /****进行attr的数据解码***/

        $this->load->model("user");
        $author = $this->user->getItem($det["author_id"]);//关于店主的个人信息
        //开始准备写最后的计算
        $data = array_merge($det,$author);
        /*
         * lestPrc 信息保存在js中，php的将在原来购物车没有的情况下添加
         */
        $extro = $this->user->getExtro($det["author_id"]);
        //$this->showArray($extro);
        if($extro && array_key_exists("lestPrc",$extro))
            $data["lestPrc"] = $extro["lestPrc"];//将最低起送价加到data中，前台处理
        else $data["lestPrc"] = 0;//0代表没有起送价
        $data["itemId"] = $itemId;
        $this->load->model("comitem");
        //$data["comt"] = $this->comitem->selItem($itemId);
        $comt = $this->comitem->selItem($itemId);
        $data["comt"] = Array();
        $cnt = 0;
        //接下来的查询可以分为两种，有机会对比下性能之比,一种是sql不停的or还有下面for一下
        for ($i = count($comt)-1; $i >= 0; $i--) {
            $temp = $this->user->getPubById($comt[$i]["user_id"]);
            if($temp){
                $data["comt"][$cnt] = array_merge($temp,$comt[$i]);
                $data["comt"][$cnt]["context"] = explode("&",$comt[$i]["context"]);
                $cnt++;
            }
        }
        $this->load->view("item",$data);
        $this->mitem->addvisitor($itemId);
    }
    /**
     * 对Attr进行解码和重组，
     *
     * 通过传入的attr字符串，构成html字符串，然后在页面展示
     *
     * @param string $attr attr等信息构成的字符串，需要解析
     * @return string html标签构成的页面内容；
     */
    private function formAttr($attr)
    {
        $reg = "/^\d+$/";
        $len = count($attr);
        $ans = "";
        if(($len > 4)&&preg_match($reg,$attr[1])){
            //对是两个属性
            $ans = "<p class = 'attr'><span class = 'item'>".$attr[2].":</span><br/>";
            $leni = ($attr[0]+4);//从第五个开始是真正的属性值
            $ans.=$this->pinAttr(4,$attr[0],$attr);
            $ans.="</p><p class = 'attr'><span class = 'item'>".$attr[3].":</span><br/>";
            $ans.=$this->pinAttr(4+$attr[0],$attr[1],$attr);
            $ans.="</p>";
        }else if($len > 2){
            //只有一个属性
            $ans = "<p class = 'attr'><span class = 'item'>".$attr[1].":</span><br/>";
            $ans.=$this->pinAttr(2,$attr[0],$attr);
            $ans.="</p>";
        }
        return $ans;
    }
    private function pinAttr($st,$len,$attr)
    {
        //构成 Attr中的一部分,重复度很高，所以独立
        $re = "";
        $reg2 = "/^\d+\.jpg$/";
        $leni = ($len+$st);
        $baseUrl = base_url();
        //从第五个开始是真正的属性值
        for($i = $st;$i < $leni;$i++){
            $temp = explode(":",$attr[$i]);
            if((count($temp)>1)&&preg_match($reg2,$temp[1])){
                $re.="<span class = 'atr atmk'><span name = '".($i-$st)."' title = '".$attr[$i]."' class = 'atv'>".$temp[0]."</span><img src = '".$baseUrl."upload/".$temp[1]."' /></span>";
            }
            else{
                $re.="<span name = '".($i-$st)."' title = '".$attr[$i]."' class = 'atv atmk'>".$temp[0]."</span>";
            }
            //atv 是元素真正的值，atmk attr mark
            //是表示的地方，通常atmk和atv是同一个节点，或者atv是atmk的子元素
        }
        return $re;
    }
    public function newcom($itemId = -1){
        //以后要返回插入的com id,对具体的item的评论进行的操作
        $res["flag"] = -1;
        if(!$this->user_id){
            $res["atten"] = "没有登录";
        }
        $data["text"] = $this->input->post("context");
        $data["score"] = $this->input->post("score");
        $data["item_id"] = $itemId;
        $data["user_id"] = $this->user_id;
    //    $this->showArray($data);
        $this->load->model("comitem");
        $ans = $this->comitem->insert($data);
        if($ans){
            $res["flag"] = $ans;
        }
        echo json_encode($res);
    }
    public function appcom($comId)
    {
        $res["flag"] = -1;
        if(!$this->user_id){
            $res["atten"] = "没有登录";
        }
        $data["text"] = $this->input->post("context");
        $data["userName"] = $this->session->userdata("user_name");
        $this->load->model("comitem");
        $ans = $this->comitem->append($data,$comId);
        if($ans){
            $res["flag"] = 1;
        }else{
            $res["atten"] = "插入失败";
        }
        echo json_encode($res);
    }
    private function showArray($array)
    {
        foreach($array as $index => $value){
            var_dump($index);
            echo "   =>   ";
            var_dump($value);
            echo "<br>";
        }
    }
}
?>

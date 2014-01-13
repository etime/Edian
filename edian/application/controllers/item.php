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
class item extends MY_Controller {
    // 存储用户的 userId
    var $userId;

    /**
     * 开始声明userId,因为用到的地方比较多，My_controller中集成了几个经常用到的操作
     */
    function __construct() {
        parent::__construct();
        $this->userId = $this->getUserId();
        $this->load->model('mitem');
        $this->load->model('user');
        $this->load->model('store');
        $this->load->model('comitem');
        $this->load->model('morder');
        $this->load->library('help');
    }
    public function item2()
    {
        $this->load->view('item2');
    }
    /**
     * 对Attr进行解码和重组，
     *
     * 通过传入的attr字符串，构成html字符串，然后在页面展示
     *
     * @param string $attr attr等信息构成的字符串，需要解析
     * @return string html标签构成的页面内容；
     */
    private function _formAttr($attr) {
        $reg = "/^\d+$/";
        $len = count($attr);
        $ans = '';
        if (($len > 4) && preg_match($reg,$attr[1])) {
            //对是两个属性
            $ans = "<p class = 'attr'><span class = 'item'>".$attr[2].":</span><br/>";
            $leni = ($attr[0]+4);//从第五个开始是真正的属性值
            $ans.=$this->pinAttr(4,$attr[0],$attr);
            $ans.="</p><p class = 'attr'><span class = 'item'>".$attr[3].":</span><br/>";
            $ans.=$this->pinAttr(4+$attr[0],$attr[1],$attr);
            $ans.="</p>";
        } else if ($len > 2) {
            //只有一个属性
            $ans = "<p class = 'attr'><span class = 'item'>".$attr[1].":</span><br/>";
            $ans.=$this->pinAttr(2,$attr[0],$attr);
            $ans.="</p>";
        }
        return $ans;
    }

    public function test($data) {
        header("Content-type: text/html; charset=utf-8");
        foreach ($data as $key => $val) {
            if (is_array($val)) {
                echo '--------------<br>';
                echo 'there is an array: <br>';
                $this->test($val);
                echo '--------------<br>';
            } else {
                echo $key . '=>' . $val . '<br>';
            }
        }
    }
    /**
     * 显示商品的view函数
     * @param int   $itemId  商品对应的唯一标示id
     * @todo 显示评论的总数,这个数据没有
     */
    public function index($itemId = -1) {

        $itemInfo = $this->mitem->getItemInfo($itemId);
        // 商品不存在
        if ($itemInfo === false) {
            show_404();
            return;
        }
        $itemInfo['orderNum'] = $this->morder->getOrderNum($itemId);
        // 获取商品所属商店的信息
        $storeInfo = $this->store->getStoreInfo($itemInfo['belongsTo']);
        $storeInfo['storeId'] = $itemInfo['belongsTo'];
        //$data = array_merge($itemInfo, $storeInfo);
        $data['itemId'] = $itemId;
        // 获取商品评论
        $comt = $this->comitem->selItem($itemId);
        $data['comment'] = Array();
        $cnt = 0;
        //对评论的编码解码，应该也放model中
        for ($i = count($comt)-1; $i >= 0; $i --) {
            $temp = $this->user->getPubById($comt[$i]['user_id']);
            if($temp) {
                $data['comment'][$cnt] = array_merge($temp, $comt[$i]);
                $data['comment'][$cnt]['context'] = explode('&', $comt[$i]['context']);
                $cnt ++;
            }
        }
        $data['item'] = $itemInfo;
        $data['store'] = $storeInfo;
        //$this->help->showArr($data);
        $this->mitem->addvisitor($itemId);
        //$this->load->view('item', $data);
        $this->load->view('item2', $data);
    }

/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
    /**
     *  拼凑attr的显示内容
     *  构成 Attr中的一部分,重复度很高，所以独立
     *  @param  int     $st     起始的位置
     *  @param  int     $len    字符串的长度
     *  @param  string  $attr   对attr构成的属性字符串
     */
    private function pinAttr($st,$len,$attr)
    {
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
    /**
     * 新的评论内容页面
     * 接下来怕是要吧评论单独分出去了，成为独立的模块
     * @param int   $itemId     针对的评论商品id
     * @param post  context     post提交的内容
     * @param post  score       对商品的评分
     */
    public function newcom($itemId = -1){
        //以后要返回插入的com id,对具体的item的评论进行的操作
        $res["flag"] = -1;
        if(!$this->userId){
            $res["atten"] = "没有登录";
        }
        $data["text"] = $this->input->post("context");
        $data["score"] = $this->input->post("score");
        $data["item_id"] = $itemId;
        $data["user_id"] = $this->userId;
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
        if(!$this->userId){
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

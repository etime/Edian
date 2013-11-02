<?php
require 'dsprint.class.php';
//require 'dsconfig.class.php';//在pritn中已经调用了一次
//打印的类文件
/*************************************************************************
    > File Name :     ../controllers/order.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-07-29 10:06:13
 ************************************************************************/
/**
 * 关于下单，是这么处理的，因为打印机的滞后性和不确定性，现在决定在用户下单的同时，发起两个http请求
 * 一个是set
 *  负责向数据库添加数据，完成后修改为完成下单，
 *  另一个是setPrint
 *   @todo 完成打印/通知的功能，完成状态为订单打印完毕,发货中
 *  @function myorder 我的订单，前端将来放到用户中心里面
    @function sended  将订单标记成为已经发货的状态，为后台的更新状态，貌似还是需要处理一下权限的问题
    @function index 一方面提供数据(ajax请求),另一方面返回页面，就是下单页面的信息
    @function  getLsp 取得最低起送价的函数，
    @function delCart 将index中的cart信息处理
 */
class Order extends My_Controller{
    protected $user_id,$user_name;
    /*
    var $Ordered,$printed,$signed;
    var $ADMIN;
     */
    function __construct(){
        parent::__construct();
        $this->load->model("morder");
        $this->load->model("mitem");
        $this->load->model("user");
        $this->load->model("mwrong");//其实都是不太可能出现错误的地方
        $this->user_id = $this->user_id_get();
        /*
        $this->Ordered = 1;//下单完毕
        $this->printed = 2;//打印完毕
        $this->sended = 3;//已经发货了
        $this->smsed = 5;//已经发送了短信，
        $this->signed = 4;//已经签订了
        $this->afDel = 7;//下单后删除
        $this->ADMIN = 3;//管理员的权限是3
         */
        //最好放到配置文件里面,统一一点
    }
    /**
     * 为我的订单页面，提供数据
     *
     * 好像目前只是为页面提供数据
     *
     * @param int $ajax 为标志位，查看是为ajax提供数据还是页面提供数据
     */
    public function myorder($ajax = 0)
    {
        if(!$this->user_id){
            if($ajax){
                echo json_encode(0);
            }else{
                $this->nologin(site_url()."/order/myorder");
            }
            return;
        }
        $data["cart"] = $this->morder->allMyOrder($this->user_id);
        //$this->showArr($data["cart"]);
        if($data["cart"]){
            for ($i = 0,$len = count($data["cart"]); $i < $len; $i++) {
                /**************分解info，得到其中的各种信息****************/
                $cart = $data["cart"][$i];//保存起来，方便更快的查找
                $seller[$i] = $cart["seller"];//这个操作是为下面的排序进行准备
                $temp = $cart["info"];//对info的的风格
                //$data["cart"][$i]["info"] = $cart["info"];//感觉对此一句
                /************取得卖家的名字**************************/
                $data["cart"][$i]["selinf"] = $this->user->getPubById($cart["seller"]);
                /****搜索现在商品的价格 图片和库存,用于显示，而非之前保存的,一旦下单完成，这些信息就固定了**************/
                $data["cart"][$i]["item"] = $this->mitem->getOrder($cart["item_id"]);
                /******************/
            }
        }
        $this->config->load("edian");
        $data["signed"] = $this->config->item("signed");
        $data["printed"] = $this->config->item("printed");
        $data["Ordered"] = $this->config->item("Ordered");
        $data["sended"] = $this->config->item("sended");
        $this->load->view("myorder",$data);
    }
    /**
     * 将订单标记成为已经发货的状态
     *
     * 在后台使用的函数和功能，在商家发货之后，可以自行在后台进行标记
     */
    public function sended()
    {
        //这里是将订单标记成为已经发货的状态
        $str = trim($_GET["id"]);
        if($str){
            $str = explode("|",$str);
            $len = count($str)-1;//最后一个是空不用理会
            for($i = 0;$i< $len;$i++){//其实这里最好做一个检测，是不是都是数字
                $this->morder->setState($this->sended,$str[$i]);
            }
        }
        redirect(site_url("order/ontime"));
    }
   /**
    * 用户的下单页面，和购物车页面，提供数据使用
    *
    *  为0，代表为非ajax请求，为1代表ajax，为1以上的，代表这次只下这个单,不理会购物车的东西
        同时对应ajax请求和页面请求两种，由ajax控制
        这个，是浏览购物车的时候的列表页面，要和淘宝京东很像，但是不能点两次，一个页面，将价格，送货地址之类的全部搞定，不要设置推荐，
        这个时候，就让用户安静的，无打扰的，迅速的下单，我们方便收钱
        备注的信息，按照店家进行分组,每组一个
        * @param bool $ajax 决定是为ajax提供数据，还是为页面提供数据
    */
    public function index($ajax = 0)
    {
        if(!$this->user_id){
            if($ajax){
                echo json_encode(0);
            }else{
                $this->nologin(site_url()."/order/index");
            }
            return;
        }
        if($ajax > 1){
            //大于1的时候为具体的商品立即下单
            if($_POST["inst"]){
                $info["info"] = $this->input->post("info");
                $info["orderNum"]= $this->input->post("buyNum");
                $info["more"] = "";
                $info["price"] = $this->input->post("price");
                $id = $this->add($ajax,$info["info"],$info["orderNum"],$info["price"]);//ajax代表商品号码
                $info["info"] = $this->spInf($info["info"]);
                $data[0]["item_id"] = $ajax;
                $data[0]["info"] = $info;
                if($id){
                    $data[0]["id"] = $id;
                }else{
                    echo "添加失败，请联系管理员";
                    return;
                }
                $user = $this->mitem->getMaster($ajax);
                $data[0]["seller"] = $user["author_id"];
                $data["cart"] = $this->delCart($data);
                $data["lsp"] = $this->getLsp($data["cart"]);
            }
        }else{
            $cart = $this->delCart($this->morder->getCart($this->user_id));//取得cart的信息
            $data["lsp"] = $this->getLsp($cart);
            $data["cart"]  = $cart;//这里，其实已经按照卖家进行了分组
        }
        $data["buyer"] = $this->addrDecode($this->user->ordaddr($this->user_id));
        if($ajax == 1){//等于1的时候是ajax申请数据
            echo json_encode($data);
        }else{
            //0或者是大于1都应该输出data
            $this->load->view("order",$data);
        }
    }
    /**
     * 得到最低起送价，
     *
     * 提供一个数组,根据数组中的卖家信息，在数组中添加最低起送价的信息
     *
     * @param array $cart 数组，至少包含买家的id
     * @return array 在原来的基础上，添加最低起送价
     */
    protected function getLsp($cart)
    {
        //在这里得到index的lsp，返回数组
        $cal = 0;
        $lsp = Array();
        $len = $cart?count($cart):0;
        for($i = 0;$i < $len;){
            //逻辑出问题了，i的加应该在while中进行，不然会跳过一个i的
            $last = $cart[$i]["seller"];
            $slIdx = $i;
            while(($i < $len) && ($last == $cart[$i]["seller"])){
                $i++;
            }
            if($cart[$slIdx]["seller"]){
                $extro = $this->user->getExtro($cart[$slIdx]["seller"]);
                if($extro && array_key_exists("lestPrc",$extro)){
                    $lsp[$cal]["lestPrc"] = $extro["lestPrc"];
                }else{
                    $lsp[$cal]["lestPrc"] = 0;//lsp在没有的时候表示为0，表示不存在
                }
                $lsp[$cal]["user_name"] = $cart[$slIdx]["selinf"]["user_name"];
                $lsp[$cal]["user_id"]  = $last;
                $cal++;
            }else{
                //var_dump($cart[$slIdx]);//这里应该向数据库添加错误信息，向管理员报错
            }
            // short for lest price
        }
        return $lsp;
    }
    /**
     * 将index中的cart信息处理
     *
     * 根据传入的id数组，处理cart中的信息，丰富并返回购物车的信息
     * @param array $tcart 包含购物车id的数组
     * @return array 返回包含所有购物车信息的函数
     */
    private function delCart($tcart)
    {
        $seller = Array();
        if($tcart){
            for ($i = 0,$len = count($tcart); $i < $len; $i++) {
                /**************分解info，得到其中的各种信息****************/
                $cart = $tcart[$i];//保存起来，方便更快的查找
                $seller[$i] = $cart["seller"];//这个操作是为下面的排序进行准备
                $temp = $cart["info"];//对info的的风格
                //$data["cart"][$i]["info"] = $cart["info"];//感觉对此一句
                /************取得卖家的名字**************************/
                $tcart[$i]["selinf"] = $this->user->getPubById($cart["seller"]);
                /****搜索现在商品的价格 图片和库存,用于显示，而非之前保存的,一旦下单完成，这些信息就固定了**************/
                $tcart[$i]["item"] = $this->mitem->getOrder($cart["item_id"]);
                /******************/
            }
            array_multisort($seller,SORT_NUMERIC,$tcart);//对店家进行排序,方便分组
            //$len = count($data["cart"]);
        }
        return $tcart;
    }
    private function formCart($data)
    {
        //就算是为买家准备的，早晚也需要另一个页面,历史订单
    }
    /**
     * 将地址信息进行解码
     */
    private function addrDecode($buyer)
    {
        $res = Array();
        //对地址的解码，对之前定义的规则的反解释
        $tmp = explode("&",$buyer["addr"]);
        $cntAddr = 0;
        for($i = 0,$length = count($tmp);$i < $length; $i++){
    //这里的规则很重要，因为将来解地址的时候，也是必须遵守同样的规则
            if($tmp[$i] == "") continue;
            $now = explode("|",$tmp[$i]);
            $len = count($now);
            if(($i == 0) && ($len == 1)){
                $res["0"]["phone"] = $buyer["contract1"];
                $res[0]["addr"] = $now[0];
                $res[0]["name"] = $this->session->userdata("user_name");
                $cntAddr++;
            }else if($len == 3){
                $res[$cntAddr]["phone"] = $now[1];
                $res[$cntAddr]["addr"] = $now[2];
                $res[$cntAddr]["name"] = $now[0];
                $cntAddr++;
            }
        }
        return $res;
    }
    /**
     * 对没有登录的情况进行处理
     * @param string/url $url 传入的url，希望跳转到的页面
     */
    protected function nologin($url)
    {
        $data["url"] = $url;
        $this->load->view("login",$data);
    }
    /**
     * 向购物车里面添加商品
     *
         这里更多对应的应该是ajax请求，可以的话，设置成双重的,因为只有在具体页面或者是列表页才可以加入购物车，总之，不会在这个页面的index加入，不会通过具体页面加入
         其实后面的参数，更多的是无用的，price是通过数据库查找的，所有的参数中，只有有info,itemid,buynum是有效的
     * @param int       $itemId     商品的id
     * @param string    $info       备注信息，用户希望添加的备注
     * @param int       $buyNum     表示希望购买的商品数目
     * @param float     $price      价格信息
     */
    public function add($itemId = 0,$info = "",$buyNum = "",$price = ""){
        //加入购物车
        $res["flag"] = 0;
        if(!$this->user_id){
            $res["atten"] = "请首先登录，或手机验证后下单";
            echo json_encode($res);
            return;
        }
        $data = $this->mitem->getMaster($itemId);//查找当前的id信息,这个等这是下单的时候再说
        if(!$data){
            $res["atten"] = "没有找到该商品";
            echo json_encode($res);
            return;
        }
        //信息的两种来源，调用和提交
        if(!$buyNum){
            $data["info"] = $this->input->post("info");//这里的info是款式信息,这些和备注混合在一起,他们就是备注
            $data["price"] = $this->input->post("price");
            $data["orderNum"] = $this->input->post("buyNum");//数据信息涉及到对比和倍乘，比较重要
        }else{
            $data["price"] = $price;
            $data["info"] = $info;
            $data["orderNum"] = $buyNum;
        }
        //对比下订单的数目和库存的关系
        //算了，这点没有意义，因为如果加上信息的话，就会分得很细，只是比较总的库存没有太大意义，看店家处理吧
        $data["itemId"] = $itemId;
        $data["ordor"] = $this->user_id;
        $id = $this->morder->insert($data);
        if($id){
            if($buyNum)return $id;
            $res["flag"] = $id;
            echo json_encode($res);
        }else{
            if($buyNum)return false;
            $res["atten"] = "加入购物车失败";
            echo json_encode($res);
        }
    }
    public function del($orderId  = -1){
        if($orderId == -1){
            echo json_encode(0);
        }
        if(!$this->user_id){
            echo json_encode(0);
            //将来要不要报一个没有登录呢？不过，可以没有登录删除的，应该是黑客吧
        }
        $this->load->config("edian");
        $flag = $this->morder->setFive($orderId,$this->user_id,$this->config->item("afDel"));
        //并不真正删除，而是设置成5，表示假死吧，将来分析数据用
        if($flag) echo json_encode(1);
        else echo json_encode(0);
    }
    public function addr()
    {
        //处理上传的地址信息,通过ajax提交
        $res["flag"] = 0;
        if(!$this->user_id){
            //其实没有什么意义了，因为是ajax提交的
            $res["atten"] = "请首先登录";
            echo json_encode($res);
            return;
        }
        $phone = $this->input->post("phone");
        $addr = $this->input->post("addr");
        $geter = $this->input->post("geter");
        $ans = "&".$geter."|".$phone."|".$addr;
        if($this->user->appaddr($ans,$this->user_id)){
            $res["flag"] = 1;
            $res["atten"] = $ans;
        }
        echo json_encode($res);
    }
    private function showArr($array)
    {
        foreach($array as $index => $value){
            var_dump($index);
            echo "   =>   ";
            var_dump($value);
            echo "<br>";
            echo "<br>";
        }
    }
    /**
     * 这里应该是因为set/setprint的读取数据相同，所以都是从这个函数得到内容
     * @return array $res 从input读取的内容
     */
    private function getData()
    {
        //读取数据，返回信息
        $res["addr"] = trim($this->input->post("addr"));
        $res["orderId"] = trim($this->input->post("orderId"));
        $res["buyNum"] = trim($this->input->post("buyNums"));
        $res["more"] = trim($this->input->post("more"));
        $res["orderId"] = explode("&",$res["orderId"]);
        $res["buyNum"] = explode("&",$res["buyNum"]);
        $res["more"] = explode("&",$res["more"]);
        return $res;
    }
    /**
     * 对下单之后的数据处理
     *
         下单时候，并发处理，将修改状态,将数据库中的内容进行变更
     */
    public function set()
    {
        $data = $this->getData();//获取input的信息
        $res["flag"]  = 0;
        if(!$this->user_id){
            $res["atten"] = "没有登录";
            echo json_encode($res);
            return ;
        }
        $this->load->config("edian");
        $res = $this->setOrderState($data,$this->config->item("Ordered"));//下订单后状态变为2
        echo json_encode($res);//目前就只准备ajax的版本吧
    }
    /**
     * setOrderState 将商品对应的状态进行修改
     * @todo 数据的检验，安全的检验
     */
    protected function setOrderState($data,$value)
    {
        $failed = 1;
        $res  = Array();
        $morelen = count($data["more"]);
        for($i = 0,$len = count($data["orderId"]);$i < $len;$i++){
            $id = $data["orderId"][$i];
            if($data["more"] && $len == $morelen)
                $more = addslashes($data["more"][$i]);
            else $more = "";//有时候，因为more没有输入，所以会造成bug，避免这个问题
            $info = $this->morder->getChange($id);
            if($info){
                //一般情况下都是有
                $temp = explode("&",$info["info"]);
                $attrStr = $data["buyNum"][$i]."&".$temp[1]."&".$temp[2]."&".$more;
                $flag = $this->morder->setOrder($data["addr"],$id,$attrStr,$value);
                if(!$flag){
                    $failed = 0;
                    $res["atten"] = "有商品下单失败";
                    //这个情况必须进行了解,坚决报告管理员
                }else{
                    //修改对应库存
                    if(!$this->mitem->changeStore($temp[1],$data["buyNum"][$i],$info["item_id"]) ){
                        $temp["text"] = "在order/setOrderState的".__LINE__."行插入失败对应参数为temp[1] = ".$temp[1]."buynum是".$data["buyNum"][$i]."itemId = ".$info["item_id"];
                        $this->mwrong->insert($temp);
                        $failed = 0;
                    }
                }
            }else{
                $temp["text"] = "在order.php/setOrderState/".__LINE__."行见到有\$info没有值,\$id为 \$id = ".$id;
                $this->mwrong->insert($temp);
            }
        }
        $res["flag"] = $failed;//全部成功的话，就是全部1，有一个失败的话，就是0
        return $res;
    }
    /**
     *  通过ajax得到数据，进行打印，短信和报错处理
     *
     *  提交订单之后，修改状态和打印同步进行,（为了效率和不等待），一种一面是者set ，另一面是setPrint
     *  setPrint 首先进行打印，不行或者没有打印机的话，就短信，失败之后就宣布通知失败，
     */
    public function setPrint()
    {
        //这里必须通过ajax提交，
        $res["flag"]  = 0;
        //$choseState = $this->input->post("buyNum");
        if(!$this->user_id){
            $res["atten"] = "没有登录";
            echo json_encode($res);
            return false;
        }
        //header("Content-Type:text/html;charset=UTF-8");//这个貌似没有什么意义
        $failed = 0;
        $data = $this->getData();
        //下单的时候，格式控制，只发送一次就好，不然的会重复下单，也会多打印的
        $ordInfo = Array();//保存打印者,下单的人信息
        $seller = Array();//用来排序
        $cnt = 0;
        for($i = 0,$len = count($data["orderId"]);$i < $len;$i++){
            $id = $data["orderId"][$i];//将所有的进行打印
            $ordInfo[$cnt]= $this->morder->getChange($id);
            if($ordInfo[$cnt]){
                //一般情况下都是有
                $temp = explode("&",$ordInfo[$cnt]["info"]);
                $seller[$cnt] = $ordInfo[$cnt]["seller"];
                //这个顺序要进行测试
                $ordInfo[$cnt]["buyNum"] = $data["buyNum"][$i];
                $ordInfo[$cnt]["more"] = $data["more"][$i];
                $ordInfo[$cnt]["price"] = $temp[2];
                $ordInfo[$cnt]["info"] = $temp[1];
                $ordInfo[$cnt]["ordId"] = $id;
                $cnt++;
            }else{
                $temp["text"] = "在order.php/".__LINE__."行没有检测到需要修改订单状态的订单，请检查数据ordId = ".$id;
                //$this->load->model("mwrong");
                $this->mwrong->insert($temp);
                //向管理员报告，检查原因和结果,目前检测到重复下单,之前的订单已经下了一次，目前下第二次
            }
        }
        array_multisort($seller,SORT_NUMERIC,$ordInfo);//对卖家进行排序,目测检验正确
        //$this->showArr($ordInfo);
        $quoto = "e点工作室竭诚为您服务";//口号
        $tim = date("Y-m-d H:i:s");
        $user = $this->getUser($data["addr"]);//取得用户的信息，$user中有名字，地址和联系方式，
        $idlist = Array();//保存打印处理商品的菜单id
        for($i = 0;$i < $cnt;){
            $nowSeller = $ordInfo[$i]["seller"];
            $list = "";
            $cntAl = 0;//将要打印的总和
            $cntPnt = 0;//将要打印的item_id array长度，为了在打印成功之后，进行处理
            while(($i < $cnt) && ($ordInfo[$i]["seller"] == $nowSeller)){
                $idlist[$cntPnt++] = $i;
                $temp = $ordInfo[$i];
                $title = $this->mitem->getTitle($temp["item_id"]);
                if($title){
                    $inf = $this->spInf($temp["info"]);
                    $list .= $title["title"].$inf." ".$temp["buyNum"]." x ".$temp["price"]."\n";
                    $cntAl += $temp["buyNum"]*$temp["price"];
                    if($temp["more"]){
                        $list.="\t备注:".$temp["more"]."\n";
                    }
                }else{
                    //呵呵，告诉管理员,解析，告诉管理员,向他报错
                    $temp["text"] = "在order.php/".__LINE__."行没有检测有item_id 但是却没有查找到，请检查一下temp[item_id]".$temp["item_id"];
                    $this->mwrong->insert($temp);
                }
                $i++;
            }
            //获取店家的名字
            $sellerName = $this->user->getNameById($temp["seller"]);
            $text = "\n顾客: ".$user["name"]."\n";//需要打印的代码
            $text .= "手机号: ".$user["phone"]."\n";
            $text .= "地址: ".$user["addr"]."\n";
            $text .= "店家: ".$sellerName["user_name"]."\n";
            $text .= "清单:\n".$list;
            $text .= "合计: \t￥\x1B\x21\x08".$cntAl."\x1B\x21\x00(元)\n";
            $text .= "下单时间: ".$tim."\n";
            $text .= "\t".$quoto."\n\n\n\n";
            $flag = $this->printInform($text ,$temp["seller"]);//这里首先进行打印，之后尝试短信
            $this->load->config("edian");
            //根据对应状态修改对应的商品的状态
            if($flag == "sms"){
                //成功发送短信
                //传入对应的参数和变量，交给afpnt处理之后的状态
                $smsed = $this->config->item("smsed");
                for($k = 0;$k < $cntPnt ;$k ++){
                    $this->afPnt($ordInfo[$idlist[$k]] ,$data["addr"],$smsed);
                }
            }else if($flag == "pr"){
                //打印成功
                $printed = $this->config->item("printed");
                for($k = 0;$k < $cntPnt ;$k ++){
                    $this->afPnt($ordInfo[$idlist[$k]] ,$data["addr"],$printed);
                }
            }else{
                //其他的通知方式都失败
                $failed = $this->config->item("infoFaild");
                for($k = 0 ;$k < $cntPnt ;$k ++){
                    $this->afPnt($ordInfo[$idlist[$k]] ,$data["addr"],$failed);
                }
            }
        }
    }
    /**
     * printInform是通知系统，在用户下单之后进行的多种联络通知手段
     *
     * 通知系统，依次通过打印，短信，数据库后台等方式保证通知。
     * @$text string 需要打印和通知的短信内容
     * @$selId int 卖家的id，通过id通知用户
     * @$return bool 打印/传递成功或者没有
     */
    public function printInform($text,$selId)
    {
        //通知系统，通过打印，短信，和数据库进行多重保证通知
        $selInfo = $this->user->informInfo($selId);
        $this->showArr($selInfo);
        if($selInfo && array_key_exists("dtuName" ,$selInfo)){
            $client = new DsPrintSend('1e13cb1c5281c812' ,$selInfo["dtuId"]);//密码和编号,或许这些东西也需要保存到后台，在必要的时候调用
            $flag = $client->printtxt($selInfo["dtuNum"] ,$text ,120 ,"\x1B\x76");//dtu编号，内容，重新发送打印的时间间隔，和查询代码，检查是否有纸
            if($flag == "00"){
                return "pr";//返回pr代表打印成功
            }else{
                $temp["text"] = $text;
                $temp["userId"] = $this->user_id;
                $temp["pntState"] = $flag;//如果打印失败，pntstate 是判断错误类型为打印失败的重要依据
                //其他为失败,失败则不处理，将检测到的信息和错误码发给管理员？
                //将将ordInfo保存起来，省得再次读取，将它们写道到一个新的表中，交给管理员处理
                /*
                 * 感觉没有必要重新组织结构，可以直接将$text 保存起来，接着只是打印就好
                for ($j = 0; $j < $cntPnt; $j++) {
                    $tempInfo["info"][$j] = $ordInfo[$idlist[$j]];
                }
                $tempInfo["addr"] = $data["addr"];
                $tempInfo["userId"] = $this->user_id;//下单人的id
                $tempInfo["pntState"] = $flag;
                //2013-09-22 20:27:14  ,unasm
                 */
                $this->mwrong->insert($temp);//打印失败，要通知给管理员
                if($selInfo["smsOrd"]){
                    //订购了这个短信服务的人才可以接收短信，
                    //过一段时间，加上在线验证吧,就是当用户在线的时候，就不发送，用户不在线的时候，就发送短信，
                    //之后添加一个在线即时聊天的功能，或许也可以截流一部分短信
                    return $this->smsInform($text,$selInfo["contract1"]);
                }
                return false;
            }
        }else if($selInfo && $selInfo["smsOrd"]){
            //小心selinfo为0的情况
            return $this->smsInform($text,$selInfo["contract1"]);
            //来到这里，代表没有打印机,接着尝试短信
        }
    }
    /**
     * 打印失败之后，通过短信进行通知。
     *
     * 通过短信发送订单的信息，向卖家进行通知
     * @$text string 需要打印和通知的订单内容
     * @$selId int 卖家的id
     * @return true/false 有没有打印成功
     * @author:  unasm
     * @time:    2013-09-22 19:59:55
     */
    //public function smsInform($text,$selId)
    public function smsInform($text,$phone)
    {
        $this->load->library("sms");
        $flag = $this->sms->send("test",$phone);
        if($flag == -1){
            //想管理员报错,不是手机号码,手机既然不符合要求，就要求换一个
            $temp["text"] = "controller/order.php/".__LINE__."行发现错误，手机号码不符合要求";
            //$this->load->model("mwrong");
            $this->mwrong->insert($temp);
            return false;
        }elseif($flag == 1){
            //1,代表发送了合格
            return "sms";//返回sms代表发送短信成功
        }else{
            //其他的为奇葩的情况，向管理员报错,因为不重复发送，所以就算了
            $temp["text"] = "controller/order.php/".__LINE__."行发现错误，短信发送返回码为".$flag;
            //$this->load->model("mwrong");
            $this->mwrong->insert($temp);
        }
        //echo $this->sendSms($url);
    }
    /**
     * 打印成功之后，修改对应的状态
     * @param array $arr 包含了购买数，价格，等其他信息的函数
     * @param int $state 修改完成之后，对应的状态，
     * @param string $addr 对应的地址
     */
    private function afPnt($arr,$addr,$state)
    {
        //这里就不做反馈了，一来复杂，而来因为这个反馈不是给用户看的，一般不会出问题，
        //为什么不是直接修改一个状态就够了呢？,以为但是
        /*
            seller,item_id,ordId,info,price,more,buyNum;
         */
        $info = $arr["buyNum"]."&".$arr["info"]."&".$arr["price"]."&".$arr["more"];
        $this->morder->setOrder($addr,$arr["ordId"],$info,$state);
    }
    /**
     * 通过用户的id取得用户下单地址的函数
     */
    private function getUser($adIdx)
    {
        $user = $this->user->ordaddr($this->user_id);
        $user = $this->addrDecode($user);
        return $user[$adIdx];
        //获取用户的地址，名字和联系方式的函数
    }
    private function spInf($info)
    {
        //这个函数是将info的具体解析出来，然后供打印使用的，目前的格式为inf|inf 的格式
        $res = "";
        $info = explode("|",$info);
        for($i = 0,$len = count($info);$i < $len; $i++){
            $res.="(".$info[$i].")";
        }
        return $res;
    }
    /**
     * 显示当前正要处理的订单信息
     *
     * 为后台实时刷新的页面提供数据,显示正要处理的订单信息
     */
    public function ontime()
    {
        //为买家量身定做的
        if(!$this->user_id){
            $this->nologin(site_url()."/order/ontime");
            return;
        }
        $data = Array();
        $type = $this->user->getType($this->user_id);
        $this->load->config("edian");
        if($type == $this->config->item("ADMIN")){
            $data["order"] = $this->morder->getAllOntime();
        }else{
            $data["order"] = $this->morder->getOntime($this->user_id);
        }
        //$this->showArr($data["order"]);
        if($data["order"])
            $data["order"] = $this->formData($data["order"]);
        $this->load->view("onTimeOrder",$data);
    }
    /**
     * 历史订单的显示
     *
     * 通过登录者的id进行在后台查找用户的历史订单信息
     */
    public function hist()
    {
        if(!$this->user_id){
            $this->nologin(site_url()."/order/ontime");
            return;
        }
        $type = $this->user->getType($this->user_id);
        $data = Array();
        $this->load->config("edian");
        if($type == $this->config->item("ADMIN")){
            $data["order"] = $this->morder->histAll();
        }else{
            $data["order"] = $this->morder->hist($this->user_id);
        }
        if($data["order"])
            $data["order"] = $this->histForm($data["order"]);
        $this->load->view("histOrder",$data);
    }
    /**
     * 历史订单的内容构成
     * @param array $arr 对得到的id信息进行丰富，和添加
     * @return array $arr 历史订单的结果
     */
    private function histForm($arr)
    {
        //历史的操作和即时的操作不同，
        $ordor = Array();
        //将info 格式化，组成数组，返回，
        for($i = 0,$len = count($arr);$i < $len ;$i++){
            $temp = $arr[$i];
            $now = $this->mitem->getTitle($temp["item_id"]);
            if($now){
                $now["ordorInfo"] = $this->formOrdor($temp["addr"],$temp["ordor"]);//获得买家的信息
            }else{
                $now['title'] = "该商品已经下架";
                $arr[$i]["item_id"] = "-1";
            }
            $arr[$i] = array_merge($arr[$i],$now);
        }
        return $arr;
    }
    private function formData($arr)
    {
        $ordor = Array();
        //将info 格式化，组成数组，返回，
        for($i = 0,$len = count($arr);$i < $len ;$i++){
            $temp = $arr[$i];
            $now = $this->mitem->getTitle($temp["item_id"]);
            //$now["info"] = $this->formInfo($temp["info"]);//将info消息分解整理
            $now["ordorInfo"] = $this->formOrdor($temp["addr"],$temp["ordor"]);//获得买家的信息
            $arr[$i] = array_merge($arr[$i],$now);
            $ordor[$i] = $temp["ordor"];
        }
        array_multisort($ordor,SORT_NUMERIC,$arr);//对买家进行排序
        return $arr;
    }
    private function formOrdor($addrNum,$userId)
    {
        $res = Array();
        //查找下订单的人的信息，地址，电话
        $inf = $this->user->ordaddr($userId);
        $temp = $this->addrDecode($inf);//用户保存的地址id中记录的就是addrdecode 生成的地址列表中的下标号码
        return $temp[0];
    }
    function change(){
        require_once 'dsprint.class.php';
        require_once $_SERVER["DOCUMENT_ROOT"].'/dsconfig.class.php';
        $client = new DsPrintSend('1e13cb1c5281c812','2050');
        echo $client->changeurl();
    }
    /**
     * 后台处理今日订单的，不止是今日的，包括之前没有处理的，包括下单状态为2，1，下单后出错和下单后没有发货了
     * 24小时的如论什么状态都会在这里
     */
    public function today()
    {

        if(!$this->user_id){
            $this->nologin(site_url()."/order/today");
            return;
        }
        $type = $this->user->getType($this->user_id);
        $ans = Array();
        $this->load->config("edian");
        if($type == $this->config->item("edian")){
            $ans = $this->morder->getAllToday();
        }else{
            $ans = $this->morder->getToday($this->user_id);
        }
        for($i = 0,$len = count($ans);$i < $len ;$i++){
            $temp = $this->mitem->getTitle($ans[$i]["item_id"]);
            $ans[$i]["title"] = $temp["title"];
            $temp = $this->user->getNameById($ans[$i]["ordor"]);
            $ans[$i]["user_name"] = $temp["user_name"];
        }
        $data["today"] = $ans;
        $this->load->view("ordtoday",$data);
    }
}
?>

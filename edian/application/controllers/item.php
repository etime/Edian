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
    protected $userId;

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

    public function item2() {
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

    /**
     * 显示商品的view函数
     * @param int   $itemId  商品对应的唯一标示id
     * @todo 显示评论的总数,这个数据没有
     */
    public function index($itemId = -1) {
        $itemInfo = $this->mitem->getItemInfo($itemId);
        $this->help->showArr($itemInfo);
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
        $data['comment'] = $this->comitem->getItemComment($itemId);
        $data['item'] = $itemInfo;
        $data['store'] = $storeInfo;
        $this->mitem->addvisitor($itemId);
//        $this->help->showArr($data);
        $this->load->view('item2', $data);
    }

    /**
     * 添加一个商品评论
     * <pre>
     * 需要添加的内容有：
     *      context    评论的详细内容，通过 POST 的方式获取，POST 中的变量名为 context
     *      score      评论的分数，通过 POST 的方式获取，POST 中的变量为 score
     *      user_id    评论者编号，通过 session 获取
     *      item_id    被评论商品编号，通过 url 参数传递获取
     * </pre>
     * @param int $itemId 商品编号
     * @todo 吐槽一句，感觉实现好蛋疼，itemid,date,userid居然有三处重复，
     */
    public function addComment($itemId = -1) {
        $itemId = (int)$itemId;
        $this->userId = 52;
        if ($this->userId === -1) {
            echo 'false';
            return;
        }
        if ($itemId === -1) {
            show_404();
            return;
        }

        // 设置评论数组
        $temp[0] = $this->userId;
        $temp[1] = (int)$itemId;
        $temp[2] = date('Y-m-d H:i:s');
        $temp[3] = trim($this->input->post('context'));

        // 设置参数数组
        $data['score'] = (int)trim($this->input->post('score'));
        $data['item_id'] = (int)$itemId;
        $data['user_id'] = (int)$this->userId;
        $data['text'] = $temp;
        //$this->help->showArr($data);
        $ans = $this->comitem->insert($data);
        if ($ans) {
            echo '1';
        } else {
            echo '评论失败';
        }
    }

    /**
     * 添加一个追加评论：用户 A 向用户 B 评论
     * <pre>
     *      如果用户 A 未登陆， echo 'false'，不再执行该函数
     *      如果 url 中 itemId 为 -1，返回 404 页面，不再执行该函数
     *      如果用户评论内容为空，echo '评论内容不能为空'，不再执行该函数
     *      如果用户 B 没有出现过，向网站报错， echo '不能对该用户进行回复'，不再执行该函数
     * </pre>
     * 需要添加的内容有：
     *      $userId1    用户 1 的编号，通过 session 获取
     *      $userId2    用户 2 的编号，通过 POST 获取，POST 中的变量名为： userId
     *      $cmtId      被追加的评论编号，通过 POST 获取，POST 中的变量名为：cmtId
     *      $cmtContent 评论的具体内容，通过 POST 获取，POST 中的变量名位： cmtContent
     *      $cmtdate    评论时间，通过系统生成
     * </pre>
     * @param $itemId
     */
    public function tackComment() {
        if ($this->userId == -1) {
            echo 'false';
            return;
        }
        // 设置评论数组，需要送给 comItem 编码
        $temp[0] = (int)$this->userId;
        $temp[1] = (int)(trim($this->input->post('userId')));
        $temp[2] = date('Y-m-d H:i:s');
        $temp[3] = trim($this->input->post('cmtContent'));
        // 设置需要传递给 comItem 的参数
        $data['comment'] = $temp;
        $data['cmtId'] = $this->input->post('cmtId');

        // 获取所有参与了该评论的评论者编号
        $cmter = $this->comitem->getCmterId($data['cmtId']);
        // 如果评论者集合为空
        if ($cmter == false) {
            $str = $_SERVER['PHP_SELF'] . 'userId 为' . $this->userId . '的用户向一个没有任何评论用户的评论添加回复';
            $this->load->model('mwrong');
            $this->mwrong->insert($str);
            echo '不能对该用户进行回复';
            return;
        }
        // 检查被评论者是否在已评论者集合中
        $flag = false;
        for ($i = 0, $len = (int)count($cmter); $i < $len; $i ++) {
            if ($cmter[$i] == $data['comment'][1]) {
                $flag = true;
                break;
            }
        }
        // 如果被评论者不在已评论者集合中
        if ($flag == false) {
            $str = $_SERVER['PHP_SELF'] . 'userId 为' . $this->userId . '的用户不存在的用户发起回复请求';
            $this->load->model('mwrong');
            $this->mwrong->insert($str);
            echo '不能对该用户进行回复';
            return;
        }

        // 经历重重检验，终于可以提交评论了，这傻逼后台！
        $flag = $this->comitem->updateComment($data);
        if ($flag) {
            echo '1';
        } else {
            echo '评论失败';
        }
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
}
?>

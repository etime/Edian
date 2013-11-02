<?php
 /**
   * 这里的item对应了mysql的item表，集中了item的所有的操作

   * art_id : 表明这个行的唯一id <br><br>
   * title : 商品信息的标题，也是搜索的主要依据<br><br>
   * content : 主要介绍内容          <br><br>
   * time，最后的发表时间或者是修改时间<br><br>
   * author_id 发表的人的id<br><br>
   * value 通过赞助，评论，浏览添加起来的价值，也是热度的另一称呼<br><br>
   * visitor_num 访问者的数目，将来收钱的依据，会增加少量的values<br><br>
   * price，商品的价格<br><br>
   * img，商品的图片:每件商品或许不止一个图片，所以做成列表的形式，将来通过正则截取,多个图片，会默认首先显示第一个<br><br>
   * keyword 关键字，保存格式为苹果;清苹果;分号隔开，关键字为分区的字和用户自己输入的关键字,搜索的时候通过like对比关键字<br><br>
   * //promise 承诺，货到付款，七日退货，保证正品，急速发货，赠运费险,送货//目前还没有做，以后做吧<br><br>
   * storeNum 库存量，是attr中各个存货量的叠加,减去每个的库存实在是太纠结了，目前先不处理吧,只是减去总的库存<br><br>
   * judgescore float商品评分：没有必要每次都重新计算一遍吧,加起来，然后除以评论数据就是了<br><br>
   * state : 商品状态 0 销售中，1 下架 2 预备中，3,删除过一段时间开始销售<br><br>
   * attr 通过拼成的字符串,表示商品的属性，颜色，分类的,方便商家查找商品
   * attr的解析拼接地方在插入的地方setorderstate,解析在item的formAttr，那是为了显示attr信息，在model/mitem筹备一个model级别的解析，一个做成数组，另一个管理数组
   * <pre>
   *    attr的格式为
   *    2,2,风味,时间,红烧: ,喷香: ,一个月的烤肉: ,两个月的烤肉: |1000,23;1000,23;1000,23;1000,23
   *        //第一个属性，第二个属性，颜色的个数，重量的个数,方便数据处理
   *        [红烧,一个月]1000,23(库存和价格)
   *        [红烧,两个月]1000,23
   *        [喷香,一个月]1000,23
   *        [喷香,两个月]1000,23
   *  </pre>
   * @author:        unasm <1264310280@qq.com>
   * @since:         2013-07-23 07:34:43
   * @name:          ../models/item.php
   * @package        model
   */
class Mitem extends Ci_Model
{

    static  $pageNum;//每次前端申请的数据条数
     function __construct()
    {
        parent::__construct();
        $this->pageNum = 30;
        $this->load->config("edian");
        $this->pageNum = $this->config->item("pageNum");
    }
    public function insert($data)
    {
        $data["title"] = addslashes($data["title"]);
        $data["content"] = addslashes($data["content"]);
        $sql = "insert into item(title,content,time,author_id,value,store_num,price,img,keyword,attr,promise) values('$data[title]','$data[content]',now(),'$data[author_id]','$data[value]','$data[store_num]','$data[price]','$data[img]','$data[keys]','$data[attr]','$data[promise]')";
        $res = $this->db->query($sql);
        return $res;
    }
    private function dataFb($res)
    {//对body，title反转义
        for($i = 0; $i < count($res);$i++){
            $res[$i]["title"] = stripslashes($res[$i]["title"]);
            $res[$i]["content"] = stripslashes($res[$i]["content"]);
        }
        return $res;
    }
    private function titleFb($res){
        //对title进行反转义
        for($i = 0; $i < count($res);$i++){
            $res[$i]["title"] = stripslashes($res[$i]["title"]);
        }
        return $res;
    }
    /*
    public function getIdByKey($key)
    {
        //这个性能有待考证，不知道对title的查找性能如何,而且，需要explain
        //这个需要四个以上的字做关键词，当调节到2个的时候，可以使用，现在使用like
        $sql = "select id,value from item where MATCH(keyword,title) AGAINST('$key')";
        $res = $this->db->query($sql);
        return $res->result_array();
    }
     */
    /**
     * 为热区的搜索提供数据
     *
     * 提供一个开始的id，然后返回热区需要的数据
     *
     * @$startId 数据的下标
     * @return array
     */
    public function getHot($startId)
    {
        //或许需要缓存，或许需要一个临时的表，这些测试之后再说吧
        $startId = $startId*$this->pageNum;
        $sql = "select id,title,price,author_id,img,visitor_num,judgescore from item where state = 0 order by value desc limit $startId,$this->pageNum";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        $res = $this->titleFb($res);
        for($i = 0,$len = count($res);$i < $len;$i++){
            $temp = $res[$i];
            $temp["img"] = explode("|",$temp["img"]);
            if($temp["img"][0]){
                $res[$i]["img"] = $temp["img"][0];//之后或许可以随机一个出来呢,额，还是算了，这样的话，让别人知道哪个更重要
            }else{
                $res[$i]["img"] = "edianlogo.jpg";
            }
            $temp = $this->db->query("select count(*) from comItem where item_id = $temp[id]");
            $temp = $temp->result_array();
            $res[$i]["comment_num"] = $temp[0]["count(*)"];
        }
        return $res;
    }
    public function getMin($id)
    {
        //通过id获得少量的信息，方便列表页面,订单和评价数通过查询获得
        //对img 进行分割，处理，读取出一张图片
        $sql = "select title,price,author_id,img,visitor_num,judgescore from item where id = $id";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        if(!$res)return false;//如果长度为0，则返回，需要测试
        $res = $this->titleFb($res);
        $res = $res[0];
        $res["img"] = explode("|",$res["img"]);
        if($res["img"][0]){
            $res["img"] = $res["img"][0];
        }else{
            $res["img"] = "edianlogo.jpg";
        }
        $temp = $this->db->query("select count(*) from comItem where item_id = $id");
        $temp = $temp->result_array();
        $res["comment_num"] = $temp[0]["count(*)"];
        return $res;
    }
    public function getUserList($userId)
    {
        //为用户中心提供数据，显示订单数字，评论数,
        $sql = "select id,title,price,author_id,img,visitor_num,judgescore,keyword from item where author_id = $userId && state = 0";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        if(!$res)return false;//如果长度为0，则返回，需要测试
        $res = $this->titleFb($res);
        for($i = count($res)-1;$i >= 0;$i--){
            $temp = $res[$i]["img"];
            $temp = explode("|",$temp);
            if($temp[0]){
                $res[$i]["img"] = $temp[0];
            }else{
                $res[$i]["img"] = "edianlogo.jpg";
            }
            $temp = $this->db->query("select count(*) from comItem where item_id = ".$res[$i]['id']);
            $temp = $temp->result_array();
            $res[$i]["comment_num"] = $temp[0]["count(*)"];
            $temp = $this->db->query("select  count(*) from ord where item_id = ".$res[$i]['id']);
            $temp = $temp->result_array();
            $res[$i]["order_num"] = $temp[0]["count(*)"];
        }
        return $res;
    }
    public function getDetail($id)
    {
        //获得详细商品介绍页面的信息
        // 评价和订单数目通过查找获得，
        $sql = "select title,content,price,author_id,img,judgescore,promise,attr,visitor_num,store_num,time from item where id = $id";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        if(!$res)return false;//如果长度为0，则返回，需要测试
        $res = $this->dataFb($res);
        $res = $res[0];
        $temp = $this->db->query("select count(*) from ord where item_id = $id && state");
        if($temp){
            $temp = $temp->result_array();
            $res["order_num"] = $temp[0]["count(*)"];
            return $res;
        }
        return false;
    }
    public function addValue($artId)
    {//为art添加浏览者数目,因为和用户想要的没有太大关系，所以不需要什么返回值,增加value
        $this->db->query("update item set value = value + 10  where art_id = '$artId'");
    }
    public function addComNum($artId)
    {//添加评论者信息，需要给出art_id,评论者id,需要更新new,commer,comment_num,同时增加value
        $this->db->query("update item set value = value+600 where art_id  = '$artId'");
        //大概是增加20分钟的样子，
    }
    public function getOrder($itemId)
    {
        //为订单提供必要的信息
        $res = $this->db->query("select title,author_id,store_num,price,img from item where id = $itemId");
        //如果搜一个没有id的主键id，结果会是什么,$res还会是true吗？
        if($res){
            $res = $res->result_array();
            return $res[0];//id是主键，有的话，结果必然只有一个
        }
        return false;
    }
    public function  getMaster($itemId){
        //找到商品对应的主人
        $res = $this->db->query("select author_id from item where id = $itemId");
        //如果搜一个没有id的主键id，结果会是什么,$res还会是true吗？
        if($res){
            $res = $res->result_array();
            return $res[0];//id是主键，有的话，结果必然只有一个
        }
        return false;
    }
    public function getTitle($itemId)
    {
        $res = $this->db->query("select title from item where id = $itemId");
        //如果搜一个没有id的主键id，结果会是什么,$res还会是true吗？
        if($res){
            $res = $res->result_array();
            //返回false的话，应该是已经下架之类的
            if(count($res))
                return $res[0];//id是主键，有的话，结果必然只有一个
            return false;
        }
        return false;
    }
    public function getIdByKey($key)
    {
        //通过关键字检索查询信息
        $res = $this->db->query("select id,value from item where title like '%$key%' or keyword like '%;$key;%' && state = 0");//关键字的存储要；key；的形式，就是两边都是；，查找的时候，也要两边都是;，这样，匹配出来的，就是完整的关键字
        //只匹配在销售的商品
        return $res->result_array();
    }
    public function addvisitor($itemId)
    {
        //添加访问量
        $this->db->query("update item set visitor_num = visitor_num +1 where id = $itemId");
    }
    public function getBgList($userId)
    {
        $res = $this->db->query("select id,title,store_num,price,state from item where author_id = $userId");
        if($res){
            $res = $res->result_array();
            return $res;
        }
        return false;
    }
    public function getAllList()
    {
        //获得全部的列表，为为后台浏览,管理员 权限
    $res = $this->db->query("select id,title,store_num,price,state from item");
        if($res){
            $res = $res->result_array();
            return $res;
        }
        return false;
    }
    public function setState($state,$itemId)
    {
        $this->db->query("update item set state = $state where id = $itemId");
    }
    /**
     * 在下单之后，修改对应的库存
     *
     * 通过传入的info信息，分解字符串,查找对应的库存信息，然后减去,重新拼接字符串
     * 目前针对的情况为属性只有两个的情况,
     * @param string $info 或许包含|,需要分割的字符串，是物品的可选属性
     * @param int $buyNum 用户购买的数量
     * @param int $itemId  需要修改的商品的id
     */
    public function changeStore($info,$buyNum,$itemId)
    {
        $infoToSet = $this->db->query("select attr from item where id = $itemId");
        if($infoToSet->num_rows){
            $infoToSet = $infoToSet->result_array();
            $infoToSet = $infoToSet[0]["attr"];//attr为0的情况
            if($infoToSet){
                $attr = $this->decodeAttr($infoToSet,$itemId);
                $idxNum = $this->getIdx($attr["idx"],$info);
                $len = count($idxNum);
                if($len == 1){
                    $attr["storePrc"][$idxNum[0]]["store"] -= $buyNum;
                }else{
                    $attr["storePrc"][$idxNum[0]][$idxNum[1]] -= $buyNum;
                }
                $fAttr = $this->formAttr($attr);//最终形成的attr，貌似是正确的
                return $this->db->query("update item set store_num = store_num - ".$buyNum.",attr = '$fAttr' where id = ".$itemId);
            }else{
                return $this->db->query("update item set store_num = store_num - ".$buyNum." where id = $itemId");
                //有没有可能小于0 呢
            }
        }else{
            $this->load->model("mwrong");
            $temp["text"] = "mitem/changeStore/".__LINE__."行，在itemId = ".$itemId."的情况下没有搜索结果";
            $this->mwrong->insert($temp);
            return false;
        }
        //$this->db->query("update item set store_num where id = $itemId");
    }
    /**
     * 通过传入的idx，构成拼接的字符串
     * @param array $attr attr拆分之后的数组
     * @return string 重新构成的字符串
     *     * idx: array(2) {
     *      ["风味"]=> array(2) {
     *              [0]=> array(2) {
     *                  ["font"]=> string(6) "红烧" ["img"]=> string(1) " "
     *              }
     *              [1]=> array(2) {
     *                  ["font"]=> string(6) "喷香" ["img"]=> string(1) " "
     *              }
     *      }
     *      ["时间"]=> array(2) {
     *              [0]=> array(2) {
     *                  ["font"]=> string(18) "一个月的烤肉" ["img"]=> string(1) " "
     *              }
     *              [1]=> array(2) {
     *                  ["font"]=> string(18) "两个月的烤肉" ["img"]=> string(1) " "
     *              }
     *      }
     *  }
     */
    protected function formAttr($attr)
    {
        $idx = $this->formIdx($attr["idx"]);
        $store = $this->formStore($attr["storePrc"]);
        return $idx."|".$store;
    }
    /**
     * 构成attr 的前面的一部分 attr属性
     * @param array $idx item/attr字段的构成前面一部分
     * @example 2,2,风味,时间,红烧: ,喷香: ,一个月的烤肉: ,两个月的烤肉: |1000,23;1000,23;1000,23;1000,23
     */
    protected function formIdx($idx)
    {
        $re = "";//属性的内容
        $idxVal = "";//属性的名字
        $num = "";//这个是为了attr之前的数字
        $cnt = 0;
        foreach ($idx as $key => $val) {
            $len = count($val);
            $idxVal = ",".$key;
            if($cnt == 0){
                $num = $len;
                $cnt = 1;
            }else{
                $num .= ",".$len;
            }
            for ($i = 0; $i < $len; $i++) {
                $re .= ",".$val[$i]["font"].":".$val[$i]["img"];
            }
        }
        return $num.$idxVal.$re;
    }
    /**
     * 通过传入的idx数组，得到里面的下标
     *
     * @param array $idx 包含了各个属性的数组
     * @param string $attr 被选中的属性
     * @return array 下标，一个，或则是两个
     */
    protected function getIdx($idx,$attr)
    {
        $attr = explode("|",$attr);
        $len = count($attr);
        $cnt = 0;
        $res = array();
        foreach ($idx as $val) {
            if($cnt < $len){
                for ($i = 0,$len = count($val); $i < $len; $i++) {
                    if($attr[$cnt] == $val[$i]["font"]){
                        $res[$cnt] = $i;
                        break;
                    }
                }
            }else{
                $this->load->model("mwrong");
                $temp["text"] = "mitem/getIdx".__LINE__."行出现bug,cnt超过len,目前数据为idx = ".$idx." attr = ".$attr;
                $this->mwrong->insert($temp);
                return false;
            }
            $cnt++;
        }
        return $res;
    }
    /**
     * 对attr进行解析
     * 传入attr 字符串，传出数组，将attr中包含的内容全部解析出来，方便处理
     * @param string $attr 拼接成为的字符串
     * @param int $itemId 表示商品的主键id
     * @return array
     * 传入的字符串如下
     *
     * @example 2,2,风味,时间,红烧: ,喷香: ,一个月的烤肉: ,两个月的烤肉: |1000,23;1000,23;1000,23;1000,23
     * <pre>
     * storeprc: array(2) {
     *      [0]=> array(2) {
 *              [0]=> array(2) {
*                      ["store"]=> string(4) "1000"
*                      ["prc"]=> string(2) "23"
 *              }
 *              [1]=> array(2) {
*                      ["store"]=> string(4) "1000"
*                      ["prc"]=> string(2) "23"
 *               }
     *      }
     *      [1]=> array(2) {
     *          [0]=> array(2) {
     *              ["store"]=> string(4) "1000"
     *              ["prc"]=> string(2) "23"
     *          }
     *          [1]=> array(2) {
     *              ["store"]=> string(4) "1000"
     *              ["prc"]=> string(2) "23"
     *          }
     *      }
     *  }
     * idx: array(2) {
     *      ["风味"]=> array(2) {
     *              [0]=> array(2) {
     *                  ["font"]=> string(6) "红烧" ["img"]=> string(1) " "
     *              }
     *              [1]=> array(2) {
     *                  ["font"]=> string(6) "喷香" ["img"]=> string(1) " "
     *              }
     *      }
     *      ["时间"]=> array(2) {
     *              [0]=> array(2) {
     *                  ["font"]=> string(18) "一个月的烤肉" ["img"]=> string(1) " "
     *              }
     *              [1]=> array(2) {
     *                  ["font"]=> string(18) "两个月的烤肉" ["img"]=> string(1) " "
     *              }
     *      }
     *  }
     *  </pre>
     */
   public function decodeAttr($attr,$itemId)
   {
       if(!$attr)return false;
       $temp = explode("|",$attr);
       $attrIdx = explode(",",$temp[0]);//将索引关键值保存到attrIdx中
       $num = explode(";",$temp[1]);
       $flag1 = preg_match("/^\d+$/",$attrIdx[1]);
       $flag0 = preg_match("/^\d+$/",$attrIdx[0]);
       if($flag1 && $flag0){
           //返回false的情况为长度编码和标准预订的不同
            $res = $this->_twoAttr($attrIdx,$num);
            //对两个的情况进行处理
       }else if($flag0){
            $res = $this->_oneAttr($attrIdx,$num);
       }else{
            //报错，出现了问题
            $this->load->model("mwrong");
            $wrong["text"] = "在mitem.php/decodeAttr/".__LINE__."行两个flag都是0，这种情况不应个出现的，请检查一下,itemId = ".$itemId;
            $this->mwrong->insert($wrong);
            return false;
       }
       if(!$res){
            $this->load->model("mwrong");
            $wrong["text"] = "在mitem.php/decodeAttr/".__LINE__."出现编码不对的情况检查一下,attr : ".$attr."，商品的id为 itemId = ".$itemId;
            $this->mwrong->insert($wrong);
       }else{
           return $res;
       }
   }
    /**
     * 对一个attr属性的时候进行解码
     * <code>2,2,风味,时间,红烧: ,喷香: ,一个月的烤肉: ,两个月的烤肉: |1000,23;1000,23;1000,23;1000,23"</code>
     * <pre>
     * 样例
     *array(2) {
     *  ["storePrc"]=> array(2) {
     *      [0]=> array(1) {
     *          [0]=> array(2) { ["store"]=> string(2) "12" ["prc"]=> string(2) "10" }
     *      }
     *      [1]=> array(1) {
     *          [0]=> array(2) { ["store"]=> string(2) "12" ["prc"]=> string(2) "10" }
     *      }
     *  }
     *  ["idx"]=> array(1) {
     *      ["颜色"]=> array(2) {
     *           [0]=> array(2) { ["font"]=> string(6) "佰色" ["img"]=> string(0) "" }
     *           [1]=> array(2) { ["font"]=> string(6) "红色" ["img"]=> string(0) "" }
     *      }
     *  }
     *}
     *</pre>
     */
    private  function _oneAttr($attrIdx,$num)
    {
        $clen = count($attrIdx);
        if($clen == $attrIdx[0]+2){
            for ($i = 2,$len = $attrIdx[0] + 2; $i < $len; $i++) {
                $tmp = explode(":",$attrIdx[$i]);
                $tmpArr["font"] = $tmp[0];
                $tmpArr["img"] = count($tmp)>1 ? $tmp[1]:"";
                $idx[$attrIdx["1"]][] = $tmpArr;
            }
            for ($i = 0; $i < $attrIdx[0]; $i++) {
                $tmp = explode(",",$num[$i]);
                $tmpStore["store"] = $tmp[0];
                $tmpStore["prc"] = count($tmp) > 1 ? $tmp[1] : "";
                $storePrc[$i] = $tmpStore;
            }
            $res["storePrc"] = $storePrc;
            $res["idx"] = $idx;
            return $res;
        }
        return false;
    }
    /**
     * 对两个的attr进行解码
     */
    private function _twoAttr($attrIdx,$num)
    {
        $clen = count($attrIdx);
        if($clen == ($attrIdx["0"] + $attrIdx["1"]+4 )){
            //检查与规则是不是相符合；
            for ($i = 4,$len = $attrIdx[0] + 4; $i < $len; $i++) {
                $tmp = explode(":",$attrIdx[$i]);
                $tmpArr["font"] = $tmp[0];
                $tmpArr["img"] = count($tmp) > 1 ? $tmp[1] : "";
                $idx[$attrIdx["2"]][] = $tmpArr;
            }
            for ($i = 4+$attrIdx[0]; $i < $clen; $i++) {
                $tmp = explode(":",$attrIdx[$i]);
                $tmpArr["font"] = $tmp[0];
                $tmpArr["img"] = count($tmp) > 1 ? $tmp[1]: "";
                $idx[$attrIdx["3"]][] = $tmpArr;
            }
            $cnt = 0;
            for ($i = 0; $i < $attrIdx[0]; $i++) {
                for ($j = 0; $j < $attrIdx[1]; $j++) {
                    $tmp = explode(",",$num[$cnt]);
                    $storePrc[$i][$j]["store"] = $tmp[0];
                    $storePrc[$i][$j]["prc"] = count($tmp) > 1 ? $tmp[1] : "";
                }
            }
            $res["storePrc"] = $storePrc;
            $res["idx"] = $idx;
            return $res;
        }
        return false;
    }
    /**
     * 对storeprc的编码
     * <code>2,2,风味,时间,红烧: ,喷香: ,一个月的烤肉: ,两个月的烤肉: |1000,23;1000,23;1000,23;1000,23"</code>
     */
    protected function formStore($storePrc)
    {
        $re = "";
        for ($i = 0,$leni = count($storePrc); $i < $leni; $i++) {
            $istore = $storePrc[$i];
            if(array_key_exists("store",$istore)){
                if($i == 0){
                    $re .= $istore["store"].",".$istore["prc"];
                }else{
                    $re .= ";".$istore["store"].",".$istore["prc"];
                }
            }else{
                for ($j = 0,$lenj = count($istore); $j < $lenj; $j++) {
                    if($re){
                        $re  .= ";".$istore[$j]["store"].",".$istore[$j]["prc"];
                    }else{
                        $re  = $istore[$j]["store"].",".$istore[$j]["prc"];
                    }
                }
            }
        }
        return $re;
    }
}
?>


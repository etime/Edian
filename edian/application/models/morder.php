<?php
/**
 * 这里集中了所有的order/订单的操作，并且order这个表，只对应这个class,或者这个class的继承的操作
 * 始终无法打印图片，所以最好添加图片的同时添加文字备注,后台还需要优化
 * table name ord
 * 之所以取这个名字，是因为order没有办法使用，然后测试的时候，就用了这个名字，不小心成功了，就懒得换了
 * id 订单的号码
 * addr 送(收)货地址，优先选择用户的地址，但是可以修改,然后把新的地址，放到用户地址中合并，订单的单次地址就只保存id，地址的id
 * addr的下标为controllers/order/addrdecode函数生成数组的的下标
 * info    通过一定的格式保存起来的商品的价格，id，和百字以内的备注，由特殊的分割符号进行分割,属性的挑选,图片,价格,记录各种交易信息的，各种不重要（检索），但是有比较关心的
 * info 的格式为
 * <pre>
    @example final
        orderNum & info & price & more
        info 为选购的属性，more 是说明和备注
    @example
        1&喷香|一个月的烤肉&23&
    </pre>
 * 不对，保留价格毫无意义，因为要按照最新的价格进行购买，不过，也算作为一种对比了吧，提示,不做修改了吧
 * 各大选则之间用;内部则使用|划分,最后的info 是用户添加的备注
 * //seller 卖家的id，这个是为了方便检索,不然通过item_id,然后找到卖家的话，太慢
 * item_id 购买的商品货号
 * 关于退货中，几个商品中，接受几个商品的状态，退几个商品，之后在处理
 * time 下订单的时间
 * state 状态：0，尚在购物车中，下看后尚未处理
 *              1,下单完成
 *              2,打印完订单，开始准备发货
 *              3,已经发货
 *              4 已经签收
 *              5:下单前删除(暂时不真正删除，算是作为数据研究吧)
 *              6:退货
 *              7:下单后删除,要不要真正删除
 * 付款方式：(目前必然是货到付款，之后就再说吧,这个，目前没有为它设置字段，放到info中去吧
 * ordor 下订单的人
 * 所谓的购物车，就是order中state为0的东西
 *  @name       models/order.php
 *  @Author     unasm<1264310280@qq.com>
 *  @since      2013-07-17 12:47:45
 *  @package    model
 */
class Morder extends Ci_Model
{
    var $user_id,$user_name,$Ordered,$printed;
    /**
     * 涉及到订单的话，必须有个名字，必须登录，通过手机号码，短信验证码也可以，不过那个时候，手机号码就是名字
     */
    function __construct()
    {
        parent::__construct();
        $this->Ordered = 1;//下单完毕
        $this->printed = 2;//打印完毕
    }
    /**
     *  插入订单的信息
     * 插入的四个东西最为关键，明细orderinnfo，买家ordor，卖家seller，商品货号item_id
     * @param array $data 包含了itemId,ordor,seller,orerNum,info,price,more集中信息的数组，其中more应该是没有的
     */
    public function insert($data)
    {
        $orderInfo = $this->formInfo($data);
        $sql = "insert into ord(info,seller,item_id,ordor) values('$orderInfo','$data[belongsTo]','$data[itemId]','$data[ordor]')";
        $res = $this->db->query($sql);
        if($res){
            $res = $this->db->query("select last_insert_id()");
            $res = $res->result_array();
            return $res[0]["last_insert_id()"];
        }
        return false;
    }
    /**
     * 拼接info字段信息，插入数据库
     * more是后来单独处理的，真正下单的时候添加的内容
     * 必须保证所有的输入数据都没有&符号,目前针对insert的输入是检查过的
     * @param array $data 需要装入info的数组
     * @return 拼接成对应的格式，将明细插入数据库
     * <code>final     orderNum & info & price & more</code>
     */
    private function formInfo($data)
    {
        $res = $data['orderNum'];
        if(array_key_exists('orderNum' , $data) && array_key_exists('info' , $data) && array_key_exists('price' , $data)){
            $res = $data['orderNum'] . '&' . $data['info'] . '&' . $data['price'];
            if(array_key_exists('more' , $data)){
                return $res . '&' .$data['more'];
            }
            return $res;
        }
        return false;
    }
    /**
     * 取得所有的cart中的商品
     * state为0的商品为购物车的商品
     * @param int $userId 用户的id
     * @return array/flase 返回数组或者是false
     */
    public function getCart($userId){
        $userId = (int)$userId;
        if(!$userId)return false;
        $res = $this->db->query("select id,info,item_id,seller from ord where ordor = $userId && state = 0");
        if($res->num_rows){
            $res = $res->result_array();
            $len = count($res);
            if($len){
                for($i = 0;$i < $len; $i++){
                    $res[$i]["info"] = $this->decodeInfo($res[$i]["info"]);//对info进行解码
                }
                return $res;
            }
        }
        return false;
    }
    /*
     * 取得所有的cart中的商品
     * 没有被删除的,1-3之间的,这个和设定有上面order中状态的设定有关系
     * @param int $userId 登录者的id
     */
    public function allMyOrder($userId){
        $userId = (int)$userId;
        if(!$userId)return false;
        $res = $this->db->query("select id,info,state,item_id,seller,time from ord where ordor = $userId && state > 0 && state < 4");
        // 1-4对应不同的状态
        if($res->num_rows){
            $res = $res->result_array();
            $len = count($res);
            if($len){
                for($i = 0;$i < $len; $i++){
                    $res[$i]["info"] = $this->decodeInfo($res[$i]["info"]);
                }
                return $res;
            }
        }
        return false;
    }
    /*
     * 用户删除自己的订单
     * 删除只能由用户自己,管理员有管理员的方法
     * @param int $ordor 下单的人自己的id
     */
    public function delete($ordor)
    {
        $ordor = (int)$ordor;
        if(!$ordor)return false;
        return $this->db->query("delete from ord where order = $ordor");
    }
    /**
     * 为了更好的人性化一点，就设置成7吧,目前应该只是为order/del服务吧
     */
    public function setFive($id,$userId,$state)
    {
        $userId = (int)$userId;
        if(!$userId)return false;
        $id = (int)$id;
        if(!$id)return false;
        return $this->db->query("update ord set state = $state where id = $id && ordor = $userId");
    }
    /**
     *  decode info 对info进行解码,并且显示
     *  因为已经不需要进行重新保存了，所以没有必要再为编码考虑了
     *  @param string $str info在数据库保存时候的string
     *  @return array $res
     */
    private function decodeInfo($str)
    {
        $temp = explode("&",$str);
        $res["orderNum"] = $temp[0];
        $res['more'] = (count($temp) === 4) ? $temp[3] : ' ';
        $res["price"] = $temp[2];
        //对从数据库中取得到数据抱着相信的态度
        $res["info"] = "";
        if($temp[1]){
            $temp = explode("|",$temp[1]);
            for($i = 0,$len = count($temp);$i < $len ;$i++){
                $now = explode(":",$temp[$i]);
                if($now[0] != "false")
                    $res["info"] .= "(".$now[0].")";
            }
        }
        return $res;
    }
    /**
     * 修改订单的状态
     *  这里的info是之前就处理好的,而且，必须之前处理好
     *   之所以加入state，我想避免bug，购物的状态是不可以逆转的，
     *   @param int $addr 地址的下标
     *   @param int $id  ord 的主键
     *   @param string $info 将info拼接之后的产物
     *   @param int $state 将ord想要标记的状态
     *   <code>
        Error Number: 1064

        You have an error in your SQL syntax; check the manua = that corresponds to your MySQL server version for the right syntax to use near '' at line 1

        select info,seller,item_id from ord where id =

        Filename: /var/www/html/edian/edian/models/morder.php

       Line Number: 167
       </code>
     *
     */
    public function setOrder($addr,$id,$info,$state)
    {
        $id = (int)$id;
        if(!$id)return false;
        $sql = "update ord set  state = $state,info = '$info',addr = '$addr' where id = $id && state < ".$state;
        return $this->db->query($sql);
    }

    /**
     * 将指定的订单设置成为指定的状态
     * 发生的变化为不可逆变化,state只能增大不能减小
     * @param int $state 指定的状态
     * @param int $id 指定订单的id
     */
    public function setState($state,$id)
    {
        $id = (int)$id;
        if(!$id)return false;
        return $this->db->query("update ord set state = $state where id = $id && state < ".$state);
    }
    /**
     * 修改下单之前得到要修改的信息
     *   查找下单时候，要修改的内容,目前仅为order set 效力
     *  功能增加，添加卖家，商品id，
     *  并不是用来输出，所以不需要解码
     *  @param int $id 订单ord 的主键id
     *  @param array $res 因为主键代表唯一，返回包含info，seller,item_id信息的数组
     */
    public function getChange($id)
    {
        $idInt = (int)$id;
        if($idInt == 0)return false;
        $res = $this->db->query("select info,seller,item_id from ord where id = $idInt");
        if($res->num_rows){
            $res = $res->result_array();
            return $res[0];
        }
        return false;
    }
    /**
     * 需要即时处理的订单,状态为未打印和未发货
     * 搜索店家刚刚得到的下单
     * @param int $userId 商家的id，其实是店铺的id
     */
    public function getOntime($userId){
        $userId = (int)$userId;
        if(!$userId)return false;
        $res = $this->db->query("select id,addr,info,item_id,time,ordor,state from ord where ( state = 1 or state = 2 ) && seller = $userId");
        if($res->num_rows){
            $len = $res->num_rows;
            $res = $res->result_array();
            for($i = 0;$i < $len; $i++){
                $res[$i]["info"] = $this->decodeInfo($res[$i]["info"]);
            }
            return $res;
        }
        return false;
    }
    public function getAllOntime()
    {
        //管理员权限才可以浏览的文件，全部需要处理的订单
        $res = $this->db->query("select id,addr,info,item_id,time,ordor,state from ord where ( state = 1 or state = 2 )");
        if($res->num_rows){
            $len = $res->num_rows;
            $res = $res->result_array();
            for($i = 0;$i < $len; $i++){
                $res[$i]["info"] = $this->decodeInfo($res[$i]["info"]);
            }
            return $res;
        }
        return false;
    }
    public function hist($userId)
    {
        $userId = (int)$userId;
        if(!$userId)return false;
        //历史上所有的订单，暂时不分页
        $res = $this->db->query("select id,addr,info,item_id,time,ordor,state from ord where  seller = $userId && state > 0");
        if($res){
            $res = $res->result_array();
            $len = count($res);
            if($len){
                for($i = 0;$i < $len; $i++){
                    $res[$i]["info"] = $this->decodeInfo($res[$i]["info"]);
                }
                return $res;
            }
        }
        return false;
    }
    public function histAll()
    {
        $res = $this->db->query("select id,addr,info,item_id,time,ordor,state from ord where  state > 0");
        if($res){
            $res = $res->result_array();
            $len = count($res);
            if($len){
                for($i = 0;$i < $len; $i++){
                    $res[$i]["info"] = $this->decodeInfo($res[$i]["info"]);
                }
                return $res;
            }
        }
        return false;
    }
    public function getToday($userId)
    {
        $userId = (int)$userId;
        if(!$userId)return false;
        $res = $this->db->query("select time,item_id,state,ordor,info from ord where seller = $userId and  unix_timestamp(time) > unix_timestamp(now()) - 86400 or state = $this->printed or state = $this->Ordered");
        if($res){
            //return $res->result_array();
            return $this->today($res->result_array());
        }
        return false;
    }
    public function getAllToday()
    {
        //和上面的相同，都是为了order/today服务的，一个是为管理员，一个是为了商家
        $res = $this->db->query("select time,item_id,state,ordor,info from ord where (unix_timestamp(time) > unix_timestamp(now()) - 86400) or state = $this->printed or state = $this->Ordered");
        if($res){
            return $this->today($res->result_array());
        }
        return false;
    }
    private function today( $arr)
    {
        //这个函数是为上面两个today服务的
        if($arr)$len = count($arr);
        else $len = 0;
        for ($i = 0; $i < $len; $i++) {
            $arr[$i]["info"] = $this->decodeInfo($arr[$i]["info"]);
        }
        return $arr;
    }
    /**
     * 获取商品的下单购买数目的函数
     *
     * @return int
     * @author unasm
     */
    public function getOrderNum($itemId = false)
    {
        $sql = "SELECT count(*) FROM ord WHERE item_id = $itemId && state";
        $temp = $this->db->query($sql);
        //这里需要debug,总是觉得返回的值使用会是true
        if ($temp) {
            $temp = $temp->result_array();
            return $temp[0]['count(*)'];
        }
        return false;
    }
}
?>

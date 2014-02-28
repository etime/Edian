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
 * $config['orderState']  = array(
 *      1 => '下单完成' ,
 *      2 => '打印完毕' ,
 *      3 => '短信发送完毕' ,
 *      8 => '接单' , //定义为在通知失败之后,不再通过任何软件的方式追求打印，而只是手动记录进行接单的方式
 *      9 => '各种通知均告失败' ,
 *      11=> '拒绝订单' ,
//店家在网页端已经查看 ， 以后需要加的状态
);
 * 付款方式：(目前必然是货到付款，之后就再说吧,这个，目前没有为它设置字段，放到info中去吧
 * ordor 下订单的人
 * 所谓的购物车，就是order中state为0的东西
 * SELECT * FROM `content` WHERE id <= (SELECT id FROM `content` ORDER BY id desc LIMIT ".($page-1)*$pagesize.", 1) ORDER BY id desc LIMIT $pagesize>
 *  @name       models/order.php
 *  @Author     unasm<1264310280@qq.com>
 *  @since      2013-07-17 12:47:45
 *  @package    model
 */
class Morder extends Ci_Model {

    var $user_id;
    var $user_name;
    var $Ordered;
    var $printed;

    /**
     * 构造函数
     */
    function __construct() {
        parent::__construct();
        $this->Ordered = 1;//下单完毕
        $this->printed = 2;//打印完毕
    }

    /**
     * 解码今日订单的具体函数
     * @param string $str
     * @return array
     */
    private function _decodeInfo($info) {
        $temp = explode('&', $info);
        $res['orderNum'] = $temp[0];
        $res['more'] = (count($temp) === 4) ? $temp[3] : '';
        $res['price'] = $temp[2];
        $res['info'] = '';
        //对info 进行解码，准备显示用
        if ($temp[1]) {
            $temp = explode('|', $temp[1]);
            for ($i = 0, $len = count($temp); $i < $len; $i ++) {
                $now = explode(':', $temp[$i]);
                if ($now[0] != 'false') {
                    $res['info'] .= '('.$now[0].')';
                }
            }
        }
        return $res;
    }

    /**
     * 对今日订单进行编码
     * @param string $arr
     * @return array
     */
    private function _today($arr) {
        if ($arr) {
            $len = count($arr);
        } else {
            $len = 0;
        }
        for ($i = 0; $i < $len; $i ++) {
            $arr[$i]['info'] = $this->_decodeInfo($arr[$i]['info']);
        }
        return $arr;
    }

    /**
     * 获取今日的所有订单
     * @return boolean | array
     */
    public function getAllToday() {
        $sql = "SELECT time, item_id, state, ordor, info FROM ord WHERE (unix_timestamp(time) > unix_timestamp(now()) - 86400) OR state = $this->printed OR state = $this->Ordered";
        $res = $this->db->query($sql);
        if ($res) {
            return $this->_today($res->result_array());
        } else {
            return false;
        }
    }

    /**
     * 获取指定商店的所有今日订单
     * @param int $storeId 商店编号
     * @return boolean | array  商店的今日订单
     */
    public function getToday($storeId) {
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            return false;
        }
        $sql = "SELECT time, item_id, state, ordor, info FROM ord WHERE seller = $storeId AND unix_timestamp(time) > unix_timestamp(now()) - 86400 OR state = $this->printed OR state = $this->Ordered";
        $res = $this->db->query($sql);
        if ($res) {
            return $this->_today($res->result_array());
        } else {
            return false;
        }
    }

    /**
     * 获取指定用户在指定时间，指定时间的店铺的订单
     * addr id , info
     * @param int $storeId 商店编号
     * @return boolean | array  商店的今日订单
     */
    public function getAiiByTime($time , $storeId , $buyer) {
        $storeId = (int)$storeId;
        $buyer   = (int)$buyer;
        $time    = (int)$time;
        if ($storeId === 0) {
            return false;
        }
        $sql = "SELECT id , addr FROM ord WHERE seller = $storeId AND unix_timestamp(time) = $time  AND  ordor = $buyer";
        $res = $this->db->query($sql);
        if ($res) {
            return $res->result_array();
            //return $this->_today($res->result_array());
        } else {
            return false;
        }
    }
    /**
     * 获取所有的历史订单
     * @return boolean | array
     */
    public function histAll() {
        $sql = "SELECT id, addr, info, item_id, time, ordor, state FROM ord WHERE state > 0";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            for($i = 0;$i < $len; $i++){
                $res[$i]["info"] = $this->_decodeInfo($res[$i]["info"]);
            }
            return $res;
        }
    }

    /**
     * 获取制定商店的所有历史订单
     * @param int $storeId 商店的编号
     * @return boolean | array 商店的所有历史订单
     */
    public function hist($storeId) {
        $storeId = (int)$storeId;
        if ($storeId === 0) {
            return false;
        }
        $sql = "SELECT id, addr, info, item_id, time, ordor, state FROM ord WHERE seller = $storeId AND state ORDER BY time";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $len = $res->num_rows;
            $res = $res->result_array();
            for ($i = 0; $i < $len; $i ++) {
                $res[$i]['info'] = $this->_decodeInfo($res[$i]['info']);
            }
            return $res;
        }
    }

    /**
     * admin 获取所有的历史订单
     * @return boolean | array
     */
    public function histAmin() {
        $sql = "SELECT id, addr, info, item_id, time, ordor, state FROM ord WHERE state ORDER BY time";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $len = $res->num_rows;
            $res = $res->result_array();
            for ($i = 0; $i < $len; $i ++) {
                $res[$i]['info'] = $this->_decodeInfo($res[$i]['info']);
            }
            return $res;
        }
    }

    /**
     * 拼接info字段信息，插入数据库
     * more是后来单独处理的，真正下单的时候添加的内容
     * 必须保证所有的输入数据都没有&符号,目前针对insert的输入是检查过的
     * @param array $data 需要装入info的数组
     * @return 拼接成对应的格式，将明细插入数据库
     * <code>final     orderNum & info & price & more</code>
     */
    private function _formInfo($data) {
        $res = $data['orderNum'];
        if(array_key_exists('orderNum', $data) && array_key_exists('info', $data) && array_key_exists('price', $data)) {
            $res = $data['orderNum'] . '&' . $data['info'] . '&' . $data['price'];
            if(array_key_exists('more', $data)){
                return $res . '&' . $data['more'];
            }
            return $res;
        }
        return false;
    }

    /**
     * 添加订单
     * <pre>
     * data 中主要包含：
     *      itemId  商品的id
     *      ordor   下单的人
     *      seller  店铺的id
     *      orerNum  购买的数量
     *      info
     *      price
     *      more
     * </pre>
     * @param array $data
     * @return boolean | int 插入成功则返回最近插入的订单的编号
     */
    public function insert($data) {
        $orderInfo = $this->_formInfo($data);
        $sql = "INSERT INTO ord(info, seller, item_id, ordor) VALUES('$orderInfo', '$data[belongsTo]', '$data[itemId]', '$data[ordor]')";
        $res = $this->db->query($sql);
        if ($res) {
            $sql = 'SELECT last_insert_id()';
            $res = $this->db->query($sql);
            $res = $res->result_array();
            return $res[0]['last_insert_id()'];
        } else {
            return false;
        }
    }

    /**
     * 获取商品的下单购买数目的函数
     *
     * @return int
     * @author unasm
     */
    public function getOrderNum($itemId) {
        $itemId = (int)$itemId;
        if ($itemId === 0) {
            return false;
        }
        $sql = "SELECT count(*) FROM ord WHERE item_id = $itemId && state";
        $temp = $this->db->query($sql);
        //这里需要debug,总是觉得返回的值使用会是true
        if ($temp) {
            $temp = $temp->result_array();
            return $temp[0]['count(*)'];
        }
        return false;
    }

    /**
     * 根据用户的编号获取用户的购物车
     * @param int $userId  用户的编号
     * @return boolean | array  用户的购物车中的订单
     */
    public function getOrder($userId){
        $userId = (int)$userId;
        if ($userId === 0) return false;
        $sql = "SELECT id, info, item_id, seller FROM ord WHERE ordor = $userId && state = 0";
        $res = $this->db->query($sql);
        $len = $res->num_rows;
        if ($len === 0) {
            return false;
        } else {
            $res = $res->result_array();
            //对info进行解码
            for ($i = 0; $i < $len; $i ++) {
                $res[$i]['info'] = $this->_decodeInfo($res[$i]['info']);
            }
            return $res;
        }
    }

    /**
     * 获取指定编号用户的所有以确认订单
     * @param int $userId 用户编号
     * @return boolean | array
     */
    public function getMyOrder($userId) {
        $userId = (int)$userId;
        if ($userId == 0) {
            return false;
        }
        $sql = "SELECT id, info, seller, item_id, time, state FROM ord WHERE ordor = $userId && state <> 0";
        $res = $this->db->query($sql);
        if ($res->num_rows == 0) {
            return false;
        } else {
            $res = $res->result_array();
            for ($i = 0, $len = (int)count($res); $i < $len; $i ++) {
                $res[$i]['info'] = $this->_decodeInfo($res[$i]['info']);
            }
            return $res;
        }
    }

    /**
     * @return boolean | array
     */
    public function getAllOntime($failed) {
        $now = time();
        $now -= 86400;
        $sql = "select id,addr,info,item_id,time,ordor,state from ord where state &&  UNIX_TIMESTAMP(time) > " . $now . ' && state < ' . $failed . ' || state = ' . $failed . ' order by time';
        $res = $this->db->query($sql);
        if ($res->num_rows != false) {
            $len = $res->num_rows;
            $res = $res->result_array();
            for ($i = 0; $i < $len; $i ++) {
                $res[$i]["info"] = $this->_decodeInfo($res[$i]["info"]);
            }
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 需要即时处理的订单,状态为未打印,打印失败的和未发货
     * 搜索店家刚刚得到的下单
     * @param int $storeId      商家的id，其实是店铺的id
     * @param int $failed       错误状态的编号
     */
    public function getOntime($storeId , $failed){
        $storeId = (int)$storeId;
        if ($storeId == false) {
            return false;
        }
        $now = time();
        $now -= 86400;
        $sql = "select id,addr,info,item_id,time,ordor,state from ord where state &&  seller = $storeId &&  UNIX_TIMESTAMP(time) > " . $now . ' && state < ' . $failed . ' || state = ' . $failed . ' order by time';
        $res = $this->db->query($sql);
        if ($res->num_rows != false) {
            $len = $res->num_rows;
            $res = $res->result_array();
            for($i = 0;$i < $len; $i++){
                $res[$i]["info"] = $this->_decodeInfo($res[$i]["info"]);
            }
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 允许店铺老板修改自己店铺的商品订单状态;
     * @param   int     $id     订单的编号 ,实际上是时间戳
     * @param   int     $state  想要修改的状态
     * @param   int     $storeId 店铺的id
     * @todo 其实应该只是允许店铺老板修改几个特定的状态，现在赶时间，先不做
     */
    public function setStateByStore($id, $state, $storeId, $context) {
        $id     = (int)$id;
        $state  = (int)$state;
        $storeId= (int)$storeId ;
        $context = mysql_real_escape_string($context);
        return $this->db->query("update ord set state = $state , info = '" . $context . "' where UNIX_TIMESTAMP(time) = $id && seller = $storeId ");
    }

    /**
     * 获取指定编号商店的销量
     * @param int $storeId 商店编号
     * @return boolean | int 如果销量为 0 ，返回 false，否则返回具体的销量
     */
    public function getSellNum($storeId) {
        $this->load->config('edian');
        $reject = $this->config->item('rejectOrder');
        $isfFailed = $this->config->item('infFailed');
        $sql = "SELECT COUNT(*) FROM ord WHERE seller = $storeId && state <> 0 && state <> $reject && state <> $isfFailed";
        $ans = $this->db->query($sql);
        if ($ans->num_rows == 0) {
           return false;
        } else {
            $ans = $ans->result_array();
            return $ans[0]['COUNT(*)'];
        }
    }
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
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
                    $res[$i]["info"] = $this->_decodeInfo($res[$i]["info"]);
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
     * @todo 目前的修改只是针对controller/order/setPrint中进行修改，也就是说目前只能针对setPrint进行服务
     *
     */
    public function setOrder($addr,$id,$info,$state)
    {
        $id = (int)$id;
        if(!$id)return false;
        $info = $this->_formInfo( $info );
        if($info){
            $addr = (int)$addr;
            $sql = "update ord set  state = $state,info = '$info',addr = '$addr' where id = $id ";
            return $this->db->query($sql);
        }

    }

    /**
     * 将指定的订单设置成为指定的状态
     * 发生的变化为不可逆变化,state只能增大不能减小
     * @param int $state 指定的状态
     * @param int $id 指定订单的id
     */
    public function setState($id , $state)
    {
        $id     = (int)$id;
        $state  = (int)$state;
        if(!$id)return false;
        return $this->db->query("update ord set state = $state where id = $id && state < ". $state);
    }

    /**
     * 修改下单之前得到要修改的信息
     *   查找下单时候，要修改的内容,目前仅为order set 效力
     *  功能增加，添加卖家，商品id，
     *  并不是用来输出，所以不需要解码
     *  @param int $id 订单ord 的主键id
     *  @param array $res 因为主键代表唯一，返回包含info，seller,item_id信息的数组
     */
    public function getChange($id){
        $idInt = (int)$id;
        if($idInt == 0)return false;
        $res = $this->db->query("select info,seller,item_id from ord where id = $idInt");
        if($res->num_rows){
            $res = $res->result_array();
            $res = $res[0];
            $res['info'] = $this->_decodeInfo($res['info']);
            return $res;
        }
        return false;
    }

}
?>

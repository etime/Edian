<?php
/*************************************************************************
 * 这里记录的是订单的数目，保存了订单的信息
    > File Name :     models/order.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-07-17 12:47:45
 ************************************************************************/
/*
 * table name ord
 * //之所以取这个名字，是因为order没有办法使用，然后测试的时候，就用了这个名字，不小心成功了，就懒得换了
 * id 订单的号码
 * addr 送货地址，优先选择用户的地址，但是可以修改,然后把新的地址，放到用户地址中，订单的单次地址就不用了
 info    通过一定的格式保存起来的商品的价格，id，和百字以内的备注，由特殊的分割符号进行分割,属性的挑选 ,记录各种交易信息的，各种不重要（检索），但是有比较关心的
seller 卖家的id，这个是为了方便检索,不然通过item_id,然后找到卖家的话，太慢
 item_id 购买的商品货号
 关于退货中，几个商品中，接受几个商品的状态，退几个商品，之后在处理
 time 下订单的时间
 state 状态：0，尚在购物车中，下看后尚未处理1,要求发货,发货中2，已经收货3，退货4,
 付款方式：(目前必然是货到付款，之后就再说吧,这个，目前没有为它设置字段，放到info中去吧
 ordor 下订单的人
 所谓的购物车，就是order中state为0的东西
 */
/**
 * 这里集中了所有的order的操作，并且order这个表，只对应这个class的操作
 */
class Morder extends Ci_Model
{
    var $user_id,$user_name;
    /**
     * 涉及到订单的话，必须有个名字，必须登录，通过手机号码，短信验证码也可以，不过那个时候，手机号码就是名字
     */
    function __construct()
    {
        parent::__construct();
    }
    public function insert($data)
    {
        $sql = "insert into ord(addr,info,seller,item_id,order) values('$data[addr]','$data[info]','$data[seller]','$data[itemId]','$data[ordor]')";
        var_dump($sql);
        die;
        $res = $this->db->query($sql);
        if($res){
            $res = $this->db->query("select last_insert_id()");
            $res = $res->result_array();
            return $res[0]["last_insert_id()"];
        }
        return false;
    }
    public function getCart(){
        //取得所有的cart中的商品
        $res = $this->db->query("select info,item_id,seller from ord where ordor = $userId");
        return $res->result_array();
    }
    public function delete($ordor)
    {
        //删除只能由用户自己，管理员有管理员的方法
        return $this->db->query("delete from ord where order = $order");
    }
}
?>

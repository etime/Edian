<?php
/**asdfasdf
 * 表的解释
 * user_id 用户的id，也是主键
 * user_name 用户的名称,用户名，添加了unique索引
 * user_passwd 没有加密的用户密码
 * user_type 1 是卖家，2是买家，顾客
 * reg_time 用户注册时间
 * user_photo 用户的头像
 * block目前还没有使用，就是封杀用户，block 阻塞
 * last_login_time 最后一次登陆时间
 * email ，联系方式的一种，邮箱
 * addr，地址，因为是以地址为中心的嘛, addr&user_name|phoneNum|addr
 * 第一个是用户的个人地址，这个可能没有，有的话，也是只有地址，第二个由用户名，手机号码，地址构成，构成第二第三地址,在订单中保存的是这个的编号，0代表作者自己的，
 * intro，用户的自我简介
 * contract1，我想是电话，或手机号码
 * contract2 QQ号码
 * mailNum，这段期间祖受到的站内信数目;
 * comNum 这段时间的品论数目，但是想废弃掉了，因为通过select 查询得到的更加确切,用户 如果已经浏览过了，但是状态还是没有清空，就出现问题了,算了，还是启用吧，这么定义，comNum为0的时候，不显示，com为1的时候，给出select new的数目
 * lny 经度，总长10位，小数最长7位，再精确已经没有意义了，1秒大概是30米，首先定位本身的不确切，再说精确到0.1m，现实中已经够用了
 * lat 维度,设计同lny
   operTime:是营业时间，前者务必小于后者8:00-12；00的格式
 * operst 营业开始的时间，从小时精确到s，如果以后有时间的话，就修改成精确到分钟吧
 * opered 营业时间的结束
 * impress 印象，游客或者是别人对店家的评价，感觉
 * 这个文件是作为user这个表的操作类来使用的，所有关于user的函数，都在这里使用
 * 目前还是需要删除用户的选项，就到以后吧
 * 在获得更新数目的时候，调用了art中的数据;
 * author:          unasm
 * email:           douunasm@gmail.com
 * Last_modified:   2013-06-20 21:10:58
 **/
class User extends Ci_Model
{
//对于select结果只有单独一条的情况下，要不返回false，要不给出结果
    function __construct()
    {
        parent::__construct();
    }
    private function author_check($permit_level)
    {//用户级别查询吗？
        //check the author of the user
        $level=$_SESSION["user_level"];//这里需要将来修改
        if($level<$permit_level)
            return false;
        return true;
    }
    public function getInfoById($id)
    {
        //这个函数是通过用户的id得到用户的信息的函数
        $sql="select * from user where user_id = $id";
        $res=$this->db->query($sql);
        return $this->getArray($res->result_array());
    }
    private function getArray($array)
    {//因为mysql对于数据的处理是返回$array[0][content]的形式，但是对于很多单独数据的情况下不是这个样子的，只是有一条的情况，则处理为返回content
        //处理只有单独一条的情况
        if(count($array)==1){
            $array = $this->dataFb($array);
            return $array[0];
        }
        return false;
    }
    public function getPubById($user_id)
    {
        //输出的都是显示的内容，不涉及用户的隐私，不知道这样会不会加快速度
        $res = $this->db->query("select  user_name,reg_time,user_photo from user where user_id  = $user_id");
        $res = $this->dataFb($res->result_array());
        if(count($res))return $res[0];
        return  false;
    }
    public function getNess($user_id)
    {
        //getPubById 的升级版本
        //添加上邮箱吧，不要这么小家子气
        $res = $this->db->query("select  user_name,user_photo,contract1,addr,email,lng,lat from user where user_id  = $user_id");
        return $this->getArray($res->result_array());
    }
    public function getSeller($pos)
    {
        //获得这一定范围内所有的商店的信息
        $sql = "select user_id from user  where user_type = 1 && lng < '".$pos["st"]["lng"]."' && lat < '".$pos["st"]["lat"]."' && lng > '".$pos["en"]["lng"]."' && lat > '".$pos["en"]["lat"]."'";
        $res = $this->db->query($sql);
        return $res->result_array();
    }
    function checkname($name){//这样get user_name会增加io读写的，当初真实笨蛋呢
        $sql="select user_id,user_passwd from user where user_name = '$name'";
        $res=$this->db->query($sql);
        return $this->getArray($res->result_array());
    }
    public function getNameById($id)
    {
        $res = $this->db->query("select user_name from user where user_id = '$id'");
        return $this->getArray($res->result_array());
    }
    public function showUserAll()

    {
        //这个函数的作用是输出数据库中所有的用户列表的函数
        $sql="select * from user";
        $res=$this->db->query($sql);
        return $this->dataFb($res->result());
    }
    public function delUserById($id)
    {
        //这个函数是通过用户的id删除用户信息的
        $res=$this->db->query("delete from user where user_id = '$id'");
        return $res;
    }
    public function userBlockById($id)
    {
        //通过用户的id冻结用户帐号的函数
        return $this->db->query("update user set block = 1  where user_id = '$id'");
    }
    public function userEnbleById($id)
    {
        //通过用户的id解冻的函数
        return $this->db->query("update user set block = 0 where user_id = '$id'");
    }
    public function showBlockAll()
    {
        //输出所有的冻结了的用户
        $res=$this->db->query("select * from user where block = 1" );
        return $this->dataFb($res->result());
    }
    public function updateUser()
    {//这个函数的作用是更新用户的文章的函数，还没有通过验证
        /*
        $this->title = $_POST['title'];
        $this->content=$_POST['content'];
        $this->date=time();
        $this->db->update('user',array('id'=>$_POST['id']));
         */
        var_dump("抱歉，这个函数的位置不太对，请移动到art中");
        die;
    }
    public function getNew()
    {
        //选择刚刚注册的初始值为-1，通过验证才可以复制为0以上，标志这个是一个很鸡肋的选择，大概不需要吧，只要通过了验证，就可以了
        $res=$this->db->query("select * from user where user_level = -1");
        return $this->dataFb($res->result());
    }
    public function insertUser($data)
    {
        //插入用户的时候的函数
        //$data["passwd"] = md5($data["passwd"]);//还是不再加密吧，既然已经是服务端了
        $day = date('Y-m-j');
        $data["name"] = addslashes($data["name"]);//因为对特殊字符的担心，这里给它添加转义
        $data["passwd"] = addslashes($data["passwd"]);
        if($data["addr"] == "")$data["addr"] = null;
        if($data["intro"] == "")$data["intro"] =  null;
        if($data["contract2"] == "")$data["contract2"] = null;
        if($data["email"] == "")$data["email"] = null;
        if($data["photo"] == "" || ($data["photo"] == false)){
            $data["photo"] = "edianlogo.jpg";
        }
        //if(($data["photo"] != "")&&($data["photo"]!=false))
        $sql = "insert into user(user_name,user_passwd,reg_time,user_photo,email,addr,intro,contract1,contract2,user_type,lng,lat,operst,opered,work) VALUES('$data[name]','$data[passwd]','$day','$data[photo]','$data[email]','$data[addr]','$data[intro]','$data[contract1]','$data[contract2]','$data[type]','".$data["pos"][0]."','".$data["pos"][1]."','".$data["st"]."','".$data["ed"]."','".$data["work"]."')";
        $res=$this->db->query("insert into user(user_name,user_passwd,reg_time,user_photo,email,addr,intro,contract1,contract2,user_type,lng,lat,operst,opered,work) VALUES('$data[name]','$data[passwd]','$day','$data[photo]','$data[email]','$data[addr]','$data[intro]','$data[contract1]','$data[contract2]','$data[type]','".$data["pos"][0]."','".$data["pos"][1]."','".$data["st"]."','".$data["ed"]."','".$data["work"]."')");
        return $res;
    }
    public function getType($userId)
    {
        $res = $this->db->query("select user_type from user where user_id = '$userId'");
        $res = $res->result_array();
        if(count($res)== 1){
            return $res[0]["user_type"];
        }
        return false;
    }
    public function getPubToAll($userId)
    {//获取那些所有可以被普通的用户浏览的信息，
        $res = $this->db->query("select user_name,reg_time,user_photo,last_login_time,email,addr,intro,contract1,contract2,user_type,lng,lat from user where user_id = '$userId'");
        return $this->getArray($res->result_array());
    }
    public function getPubNoIntro($userId)
    {//获取那些所有可以被普通的用户浏览的信息，但是没有intro，担心太多，而且，没有必要到处显示
        $res = $this->db->query("select user_name,reg_time,user_photo,last_login_time,email,addr,contract1,contract2 from user where user_id = '$userId'");
        return $this->getArray($res->result_array());
    }
    public function changeInfo($data,$userId)
    {//it is work for info.php
        if($data["addr"] == "")$data["addr"] = null;
        if($data["intro"] == "")$data["intro"] = null;
        if($data["contract2"] == "")$data["contract2"] = null;
        if($data["email"] == "")$data["email"] = null;
        //$data["addr"] = addslashes($data["addr"]);
        $sql = "update user set user_name = '$data[name]',contract1 = '$data[contract1]',contract2 = '$data[contract2]',lng = '".$data["pos"][0]."',lat = '".$data["pos"][1]."',addr = '$data[addr]',user_passwd = '$data[passwd]',email = '$data[email]',intro = '$data[intro]',user_type = '$data[type]',user_photo = '$data[photo]' where user_id = '$userId'";
        //$res = $this->db->query("update user set user_name = '$data[name]',contract1 = '$data[contract1]',contract2 = '$data[contract2]',lng = '".$data["pos"][0]."',lat = '".$data["pos"][0]."',addr = '$data[addr]',user_passwd = '$data[passwd]',email = '$data[email]',intro = '$data[intro]',user_type = '$data[user_type]',user_photo = '$data[photo]' where user_id = '$userId'");
        $res = $this->db->query($sql);
        return $res;
    }
    public function changeLoginTime($userId)
    {//修改最后登陆时间
        $this->db->query("update user set last_login_time  = now() where user_id = '$userId'");
    }
    private function dataFb($array)
    {
        if(count($array)){
            if(array_key_exists('passwd',$array["0"])){
                for($i = 0; $i < count($array);$i++){
                    $array[$i]["passwd"] = stripslashes($array[$i]["passwd"]);
                }
            }
            if(array_key_exists('user_name',$array["0"])){
                for($i = 0; $i < count($array);$i++){
                    $array[$i]["user_name"] = stripslashes($array[$i]["user_name"]);
                }
            }
        }
        return $array;
    }
    public function cleCom($userId)
    {//每当用户的帖子（商品）增加评论的时候，用户进入列表页，清除评论数字
        $this->db->query("update user set comNum = 0 where user_id = '$userId'");
    }
    public function cleMail($userId)
    {//每当用户的邮件增加时候，增加mailNum，当用户进入列表页，清除评论数字
        $this->db->query("update user set mailNum = 0 where user_id = '$userId'");
    }
    public function addMailNum($userId)
    {
        $this->db->query("update user set mailNum = mailNum+1 where user_id = '$userId'");
    }
    public function addComNum($userId)
    {
        $this->db->query("update user set comNum = 1 where user_id = '$userId'");
    }
    public function getPassById($userId)
    {//通过id获得密码，对应reg/getPass
        $res = $this->db->query("select user_passwd from user where user_id = '$userId'");
        return $this->getArray($res->result_array());
    }
    public function getUpdate($userId)
    {//这里目前对应的是reg/dc,就是不仅仅提供判断，而且提供数据,用户不在期间的更新
        $res = $this->db->query("select user_name,user_passwd,user_photo,mailNum,comNum from user where user_id = '$userId'");
        $res = $res->result_array();
        if(count($res)==0)return false;//如果查找失败，则返回false
        $com = $res["0"]["comNum"];
        if($com == "0")return $this->getArray($res);//没有更新，则返回原来数值
        //如果更新了，则给出select数目
        //无法跨model调用函数，这里违反了规定
        $ans = $this->db->query("select count(*) from art where  author_id  = '$userId' &&  new = 1");
        $ans = $ans->result_array();
        $res["0"]["comNum"]= $ans["0"]["count(*)"];
        return $this->getArray($res);
    }
    public function getNum($userId)
    {
        $res = $this->db->query("select mailNum,comNum from user where user_id = '$userId'");
        return $this->getArray($res->result_array());
    }
    public function getItem($userId){
        //为item提供的数据，包含商家一些主要的信息,通过查找
        $res = $this->db->query("select user_type,work,operst,opered,contract1,contract2,email,intro,addr,lng,lat,user_name from user where user_id = $userId");
        if(!$res)return false;
            $res = $res->result_array();
        return $res[0];
    }
    public function appaddr($addr,$userId)
    {
        $sql = "update user set addr  = concat(addr,'".$addr."') where user_id = $userId";
        return $this->db->query($sql);
    }
    public function ordaddr($userId)
    {
        $res = $this->db->query("select contract1,addr from user where user_id = $userId");
        $res = $res->result_array();
        if(count($res))return $res[0];
    }
    public function allWaiMai()
    {
        //得到所有的外卖商店,评分就算了，查询太多，就添加营业时间吧
        $sql = "select user_id,user_name,user_photo,work,operst,opered from user where user_name like '%外卖%' || work like '%外卖%'";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        for($i = count($res)-1;$i>=0;$i--){
            $sql2 = "select id from ord where seller = '$res[$i][user_id]'";
            $res2 = $this->db->query($sql2);
            $res[$i]["order"] = count($res2->result_array());
        }
        return $res;
    }
    public function getsea($userId)
    {
        $res = $this->db->query("select addr,user_name from user where user_id = $userId");
        return $this->getArray($res->result_array());
    }
}
?>

<?php
/**
 * 用于处理所有和 user 这个表有关的数据信息
 * address 的编码:
 *      第一位是用户的地址，第二位是第二选择地址，由名字，手机号码，地址构成，解码之后第一位是名字，第二位是号码，第三位是地址，具体有getAddr做
 * @author  farmerjian <chengfeng1992@hotmail.com>
 * @since   2013-11-24 23:29:38
 * @todo    http://wudi.in/archives/127.html  看下这个。。
 *
 */
class User extends CI_Model {
    /**
     * 构造函数
     * @author farmerjian <chengfeng1992@hotmail.com>
     * 这个author貌似没有存在的必要
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * 将输入的字符串转义后返回
     * 这样做的好处：经过转义的字符串，在一定程度上能够防止 sql 注入，对网站安全性的提高会有一点作用
     * @param  string $val
     * @return string
     */
    private function _escape($val) {
        return mysql_real_escape_string($val);
    }

    /**
     * 通过用户的 loginName 判断一个用户是否存在
     * @param string $loginName 用户的登录名
     * @return boolean 如果用户存在，返回 true，否则返回 false
     */
    public function isUserExistByLoginName($loginName) {
        $loginName = $this->_escape($loginName);
    	$sql = "select count(*) from user where loginName = '$loginName'";
    	$res = $this->db->query($sql);
    	$res = $res->result_array();
    	return $res[0]['count(*)'] == 1 ? true : false;
    }

    /**
     * 通过用户的 phoneNum 判断一个用户是否存在
     * @param string $phoneNum 用户的登录名
     * @return boolean 如果用户存在，返回 true，否则返回 false
     */
    public function isUserExistByPhone($phoneNum) {
        $phoneNum = $this->_escape($phoneNum);
    	$sql = "select count(*) from user where phone = '$phoneNum'";
    	$res = $this->db->query($sql);
    	$res = $res->result_array();
    	return $res[0]['count(*)'] == 1 ? true : false;
    }

    /**
     * 用过用户的 userId 判断一个用户是否存在
     * @param int $userId 用户的 userId
     * @return boolean 如果用户存在，返回 true，否则返回 false
     */
    public function isUserExistByUserId($userId) {
        $userId = (int)$userId;
        $sql = "SELECT COUNT(*) FROM user WHERE id = $userId";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        return $res[0]['COUNT(*)'] == 1 ? true : false;
    }

    /**
     * 通过用户的登录名查询一个用户的 id 号
     * @param string $loginName 用户的登录名（已经确认了登录名字存在）
     * @return int
     */
    public function getUserIdByLoginName($loginName) {
        $loginName = $this->_escape($loginName);
        if (! $this->isUserExistByLoginName($loginName)) {
            return false;
        }
        $sql = "SELECT id FROM user WHERE loginName = '$loginName'";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        if (count($res) == 0) {
            return false;
        } else {
            return $res[0]['id'];
        }
    }

    /**
     * 通过用户的电话号码查询其 id
     * @param string $phoneNum 用户的手机号码
     * @return int 用户的 userId
     */
    public function getuserIdByPhone($phoneNum) {
        $phoneNum = $this->_escape($phoneNum);
        if (! $this->isUserExistByPhone($phoneNum)) {
            return false;
        }
    	$sql = "SELECT id FROM user WHERE phone = '$phoneNum'";
    	$res = $this->db->query($sql);
    	$res = $res->result_array();
        if (count($res) == 0) {
            return false;
        } else {
            return $res[0]['id'];
        }
    }

    /**
     * 通过用户的登录名查询该用户的 password
     * @param string $loginName 用户的登录名
     * @return string 用户登录名对应的密码
     */
	public function getUserPasswordByLoginName($loginName) {
        $loginName = $this->_escape($loginName);
        if (! $this->isUserExistByLoginName($loginName)) {
            return false;
        }
		$sql = "SELECT password FROM user WHERE loginName = '$loginName'";
		$res = $this->db->query($sql);
		$res = $res->result_array();
        if (count($res) == 0) {
            return false;
        } else {
            return $res[0]['password'];
        }
	}

	/**
	 * 通过用户的手机号码查询该用户的 password
	 * @param string $phoneNum  用户的手机号码
	 * @return string  用户手机号码对应的密码
	 */
	public function getUserPasswordByPhone($phoneNum) {
        $phoneNum = $this->_escape($phoneNum);
        if (! $this->isUserExistByPhone($phoneNum)) {
            return false;
        }
		$sql = "SELECT password FROM user WHERE phone = '$phoneNum'";
		$res = $this->db->query($sql);
		$res = $res->result_array();
        if (count($res) == 0) {
            return false;
        } else {
            return $res[0]['password'];
        }
	}

    /**
     * 向 user 表中新增加一个用户
     * <pre>
     * 需要添加的字段有：
     *     nickname      用户昵称
     *     loginName     用户登陆名
     *     password      用户密码
     *     credit        用户信用度
     *     registerTime  用户注册时间
     *     email         用户邮箱地址
     *     phone         用户手机号码
     * </pre>
     * @param array $data
     */
    public function addUser($data) {
        foreach ($data as $key => $val) {
            $data[$key] = $this->_escape($val);
        }
        $sql = "INSERT INTO user(nickname, loginName, password, credit, registerTime, email, phone) " .
            "VALUES('$data[nickname]', '$data[loginName]', '$data[password]', '$data[credit]', now()" .
            ", '$data[email]', '$data[phoneNum]')";
        $this->db->query($sql);
    }

    /**
     * 获取用户的信用度,同时也是身份验证判别的依据
     * 通过对用户的信用度的获取，可以判别用户的权限：普通、老板、网站管理员
     * @param int $userId 用户的 userId
     * @return boolean | int 如果用户存在，返回其信用度，否则返回 false
     */
    public function getCredit($userId) {
        $userId = (int)$userId;
        if (! $this->isUserExistByUserId($userId)) {
            return false;
        }
        $sql = "SELECT credit FROM user WHERE id = $userId";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        if (count($res) == 0) {
            return false;
        } else {
            return $res[0]['credit'];
        }
    }

    /**
     * 通过用户的 userId 提取他的 loginName
     * @param int $userId 用户的 userId
     * @return string | boolean 如果用户存在，返回其登录名，够则返回 false
     */
    public function getLoginNameByUserId($userId) {
        $userId = (int)$userId;
        if (! $this->isUserExistByUserId($userId)) {
            return false;
        }
        $sql = "SELECT loginName FROM user WHERE id = $userId";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        if (count($res) == 0) {
            return false;
        } else {
            return $res[0]['loginName'];
        }
    }

    /**
     * 获取 state credit ,id ,nickname ,loginname , registertime 字段的列表
     * 目前是这样，后来可以添加修改一些.
     * @param int   $pageId     为分页准备的接口
     */
    public function getCilnrsList($pageId )
    {
        $res = $this->db->query('select state , credit , id , nickname ,loginName , registerTime   from  user ');
        if($res->num_rows){
            return $res->result_array();
        }
        return false;
    }
    /**
     *  修改用户的状态
     * @param int   $userId     用户的id
     * @param int   $state      对应的状态
     */
    public function updateUserState($userId,$state)
    {
        $userId = (int)$userId;
        $state  = (int) $state;
        return $this->db->query('update user set state = ' . $state . ' where id = ' . $userId);
    }
    /**
     * 获取用户的 昵称，注册时间，头像
     * @param int $userId
     * @return boolean | array
     */
    public function getPubById($userId) {
        $userId = (int)$userId;
        if ($userId === 0) {
            return false;
        }
        $sql = "SELECT nickname, registerTime, photo FROM user WHERE id  = $userId";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            return $res[0];
        }
    }

    /**
     * 通过用户的 id 获取用户的所有信息
     * 不推荐使用
     * @param int $id
     * @return boolean | array
     */
    public function getInfoById($userId) {
        $userId = (int)$userId;
        if (! $this->isUserExistByUserId($userId)) {
            return false;
        }
        $sql="SELECT * FROM user WHERE id = $userId";
        $res=$this->db->query($sql);
        $res = $res->result_array();
        if (count($res) == 0) {
            return false;
        } else {
            return $res[0];
        }
    }

//    /**
//     * 分解extro，得到包含的数据
//     *
//     * 传入一个string，将string分解成数组返回，得到其中包含的数据
//     *@$str string 传入的信息
//     *
//     */
//    private function deExtro($extro) {
//        $res = Array();
//        if ($extro) {
//            $temp = explode(',', $extro);
//            for ($i = 0, $len = count($temp); $i <  $len; $i ++) {
//                $now = explode(':', $temp[$i]);
//                $res[$now[0]] = $now[1];
//            }
//        }
//        return $res;
//    }
//
//    public function getExtro($userId) {
//        $userId = (int)$userId;
//        if ($userId === 0) {
//            return false;
//        }
//        $sql = "SELECT extro FROM user WHERE id = $userId";
//        $res = $this->db->query($sql);
//        if ($res->num_rows === 0) {
//            return false;
//        } else {
//            $res = $res->result_array();
//            return $this->deExtro($res[0]['extro']);
//        }
//        return false;
//    }

    /**
     * 获取用户的 昵称，头像，手机号码，地址，邮箱，经纬度
     * @param int $userId
     * @return array
     */
    public function getNess($userId) {
        $userId = (int)$userId;
        if (! $this->isUserExistByUserId($userId)) return false;
        $sql = "SELECT  nickname, photo, phone, address, email, longitude, latitude FROM user WHERE id  = $userId";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        if (count($res) == 0) {
            return false;
        } else {
            return $res[0];
        }
    }

    /**
     * 通过地址的下表获取对应的地址
     * 传入单个的字符，和用户id，获取对方在下单的时候，选择的id
     *
     * @return array
     * @author unasm
     */
    public function getAddrSub($pos , $userId)
    {
        //$this->db->query("")
    }
    /**
     *  对地址进行解码
     *  @param  string  $addr   地址构成的字符串
     *  @param  int     $sub    下表，如果下表为-1，返回数组
     *  return array
     */
    protected function decodeAddr($addr)
    {
        $adArr = explode('&', $addr);
        $res = Array();
        foreach ($adArr as $value) {
            if($value){
                $temp = explode('|' , $value);
                if( (count($temp) === 3 ) || (count($temp) === 1) ){
                    array_push($res, $temp);
                } else{
                    $this->load->mode('mwrong');
                    $this->mwrong->insert(basename($_SERVER['PHP_SELF']) . __LINE__ . '行出现以外格式地址，请检查，地址字符串为' . $addr);
                }
            }
        }
        return $res;
    }
    /**
     * 根据用户编号获取用户昵称
     * @param int $userId         用户编号
     * @return boolean | string   用户昵称，或者返回用户不存在信息：false
     */
    public function getNameById($userId) {
        $userId = (int)$userId;
        if ($userId == 0) {
            return false;
        }
        $sql = "SELECT nickname FROM user WHERE id = '$userId'";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            return $res[0]['nickname'];
        }
    }
    /**
    *  获取手机号码和地址
    *  @todo 地址没有解码
     */
    public function ordaddr($userId) {
        $sql = 'SELECT phone, address FROM user WHERE id = ' . $userId;
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $res = $res->result_array();
            $res[0]['address'] = $this->decodeAddr($res[0]['address']);
            return $res[0];
        }
    }

    /**
     *  获取对应的下表和和用户手机，登录名,address , phone loginName，
     *  @param int  $userId     用户的id
     *  @param int  $addrSub    用户的地址下标，默认为-1 ，那个时候不在解码
     *  @return array
     *  @todo 这里应该增加一个报错呢
     */
    public function getAplById($userId , $addrSub = -1)
    {
        $res = $this->db->query('SELECT address, phone, loginName FROM user where id = ' . $userId);
        if($res->num_rows){
            $res = $res->result_array();
            $res = $res[0];
            $address = $this->decodeAddr($res['address']);
            if(count($address) && count($address[0]) === 1){
                $address[0][1] = $res['phone'];
                $address[0][2] = $address[0][0];
                $address[0][0] = $res['loginName'];
            }
            if($addrSub === -1){
                return $address;
            }else {
                return $address[$addrSub];
            }
        } else {
            return false;
        }
    }
    /**
     * 为用户新增一个地址
     * @param string $addr
     * @param int $userId
     * @return mixed
     * @todo,地址应该通过编码之后处理
     */
    public function appaddr($addr, $userId) {
        $userId = (int)$userId;
        if ($userId === 0) {
            return false;
        }
        $addr = mysql_real_escape_string($addr);
        $sql = "UPDATE user SET address = concat(address,'".$addr."') WHERE id = $userId";
        return $this->db->query($sql);
    }
//    public function getNum($userId) {
//        $userId = (int)$userId;
//        $sql = "SELECT mailNum, comNum FROM user WHERE id = '$userId'";
//        $res = $this->db->query($sql);
//        $res = $res->result_array();
//        return $res[0];
//    }
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/

    /**
     * 获得这一定范围内所有的商店的信息
     * 目前被废弃的节奏
     */
    public function getSeller($pos)
    {
        $sql = "select user_id from user  where user_type = 1 && lng < '".$pos["st"]["lng"]."' && lat < '".$pos["st"]["lat"]."' && lng > '".$pos["en"]["lng"]."' && lat > '".$pos["en"]["lat"]."'";
        $res = $this->db->query($sql);
        return $res->result_array();
    }
    //这些都是被废弃的，过些日子，如果发现没有用了，就删除
    /*
    function checkname($name){
        $sql="select user_id,user_passwd from user where user_name = '$name'";
        $res=$this->db->query($sql);
        return $this->getArray($res->result_array());
    }
    public function checkPhone($phone)
    {
        //用于通过手机号码登录的情形
        $sql="select user_id,user_passwd from user where contract1 = '$phone'";
        $res=$this->db->query($sql);
        return $this->getArray($res->result_array());
    }

    public function showUserAll()
    {
        //这个函数的作用是输出数据库中所有的用户列表的函数
        $sql="select * from user";
        $res=$this->db->query($sql);
        $res = $this->dataFb($res->result_array());
        if($res){
            $len= count($res);
            for($i = 0;$i< $len;$i++){
                $res[$i]["addr"] = $this->divAddr($res[$i]["addr"]);
            }
            return $res;
        }
        return false;
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
    public function getPubAdr($userId)
    {//获取那些所有可以被普通的用户浏览的信息，是getpubnointro的升级
        $res = $this->db->query("select user_name,reg_time,user_photo,last_login_time,email,addr,contract1,contract2 from user where user_id = '$userId'");
        $res = $this->getArray($res->result_array());
        if($res){
            $res["addr"] = $this->divAddr($res["addr"]);
            return $res;
        }
        return false;
    }
    private function divAddr($str)
    {
        //传入str，传出str,将地址进行修改,加工
        if($str){
            $str = explode("&",$str);
            if(count($str))return $str[0];
        }
        return false;
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



    public function allWaiMai()
    {
        //得到所有的外卖商店,评分就算了，查询太多，就添加营业时间吧
        $sql = "select user_id,user_name,user_photo,work,intro,operst,opered from user where user_name like '%送货%' || work like '%送货%'";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        for($i = count($res)-1;$i>=0;$i--){
            $sql2 = "select id from ord where seller = '$res[$i][user_id]'";
            $res2 = $this->db->query($sql2);
            $res[$i]["order"] = count($res2->result_array());
            preg_match("/^[\d]{1,2}\:[\d]{1,2}/",$res[$i]["operst"],$res[$i]["operst"]);
            $res[$i]["operst"] = $res[$i]["operst"][0];
            preg_match("/^[\d]{1,2}\:[\d]{1,2}/",$res[$i]["opered"],$res[$i]["opered"]);
            $res[$i]["opered"] = $res[$i]["opered"][0];
        }
        return $res;
    }
    public function getsea($userId)
    {
        $res = $this->db->query("select addr,user_name from user where user_id = $userId");
        return $this->getArray($res->result_array());
    }
    */
    public function insertExtro($data,$userId)
    {
        $str = $this->enExtro($data);
        $str = addslashes($str);
        //return $this->db->query("insert into user(extro) values('$str') where user_id = $userId");
        return $this->db->query("update user set extro = '$str' where user_id = $userId");
    }


    private function enExtro($arr)
    {
        //extro中保存了很多的数组，现在必须构成字符串，格式使用json，不过只有一维数组
        $res = "";
        $flag = 0;
        foreach ($arr as $idx => $val) {
            if($flag == 0){
                $res.=$idx.":".$val;
                $flag = 1;
            }else{
                $res.=",".$idx.":".$val;
            }
        }
        return $res;
    }
    public function getaddrCratById($userId)
    {
        //根据id取得联系方式和名字的函数
        $res = $this->db->query("select contract1,user_name from user where user_id = $userId");
        if($res){
            $res = $res->result_array();
            return $res[0];
        }
        return false;
    }
    public function setBlock($block,$userId)
    {
        //将指定的用户的状态修改成指定的状态
        //或许可以在这里添加一个监视呢
        $this->db->query("update user set block = $block where user_id = $userId");
    }
    /**
     *  通知的时候进行的查找，查找用户的extro和用户的手机号码,目前在order中调用，为通知系统提供后台支持
     *
     *  @$userId int 用户的id，通常是买家的
     */
    public function informInfo($userId)
    {
        $res = $this->db->query("select contract1,extro from user where user_id = $userId");
        if($res){
            $res = $res->result_array();
            if(count($res)){
                $res = $res[0];
                $res["extro"] = $this->deExtro($res["extro"]);
                return $res;
            }
        }
        return false;
    }
}
?>

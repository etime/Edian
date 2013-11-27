<?php
/**
 * 用于处理所有和 user 这个表有关的数据信息
 * @author farmerjian <chengfeng1992@hotmail.com>
 * @since 2013-11-24 23:29:38
 *
 */
class User extends CI_Model {
	/**
	 * 构造函数
	 * @author farmerjian <chengfeng1992@hotmail.com>
	 */
	function __construct() {
		parent::__construct();
	}
	
	private function dataFb($array) {
		if (count($array)) {
			if (array_key_exists('passwd', $array["0"])) {
				for ($i = 0, $len = count($array); $i < $len; $i ++) {
    				$array[$i]["passwd"] = stripslashes($array[$i]["passwd"]);
    			}
    		}
    		if(array_key_exists('user_name', $array["0"])) {
    			for ($i = 0, $len = count($array); $i < $len; $i ++) {
    				$array[$i]["user_name"] = stripslashes($array[$i]["user_name"]);
    			}
    		}
    	}
    	return $array;
    }
    
    /**
     * 处理 mysql 查询的返回结果只有单独一条的情况
     * 
     * 因为mysql对于数据的处理是返回$array[0][content]的形式，但是对于很多单独数据的情况下不是这个样子的，只是有一条的情况，则处理为返回content
     * 
     * @param array $array
     * @return array|boolean
     */
    private function getArray($array) {
	    if(count($array) == 1) {
	    	$array = $this->dataFb($array);
	    	return $array[0];
	    }
	    return false;
    }
    
    /**
     * 通过电话号码查询一个用户是否存在，如果存在，返回这个用户的所有信息，如果不在，返回 false
     * 
     * @param string $phone 待查询的电话号码
     * @return array | boolean
     */
    public function getUserByPhone($phone) {
    	$sql = "select * from user where phone = '$phone'";
    	$res = $this->db->query($sql);
    	return $this->getArray($res->result_array());
    }
    
    /**
     * 通过用户的登录名查询一个用户是否存在，如果存在，返回这个用户的所有信息，如果不在，返回 false
     * @param string $loginName
     * @return array | boolean
     */
    public function getUserByLoginName($loginName) {
    	$sql = "select * from user where loginName = '$loginName'";
    	$res = $this->db->query($sql);
    	return $this->getArray($res->result_array());
    }
    
    /**
     * 通过用户的邮箱查询一个用户是否存在，如果存在，返回这个用户的所有信息，如果不在，返回 false
     * @param string $email
     * @return array | boolean;
     */
    public function getUserByEmail($email) {
    	$sql = "select * from user where email = '$email'";
    	$res = $this->db->query($sql);
    	return $this->getArray($res->result_array());
    }
    
    /**
     * 向 user 表中新增加一个用户
     * @param array $data
     */
    public function addUser($data) {
    	$sql = "INSERT INTO user(nickname, loginName, password, credit, registerTime, email, phone) VALUES('$data[nickname]', '$data[loginName]', '$data[password]', '$data[credit]', now(), '$data[email]', '$data[phoneNum]')";
    	$this->db->query($sql);
    }
    
    private function author_check($permit_level)
    {//用户级别查询吗？
        //check the author of the user
        $level=$_SESSION["user_level"];//这里需要将来修改
        if($level<$permit_level)
            return false;
        return true;
    }
    
    /**
     * 通过用户的 id 获取用户的相关信息
     * 
     * @param int $id
     * @return Ambigous <boolean, array>
     */
    public function getInfoById($id) {
        $sql="select * from user where id = $id";
        $res=$this->db->query($sql);
        return $this->getArray($res->result_array());
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
    public function checkPhone($phone)
    {
        //用于通过手机号码登录的情形
        $sql="select user_id,user_passwd from user where contract1 = '$phone'";
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
    
    /**
     * 获取用户的权限
     * 
     * 通过查询用户的 credit 的值来获取用户的权限，其中，credit 在[0, 100]为普通用户，为 255 的为老板，为 250 的为超级管理员
     * 
     * @author farmerjian <chengfeng1992@hotmail.com>
     * @param int $userId
     * @return boolean | int
     */
	public function getType($userId) {
		$res = $this->db->query("select credit from user where id = '$userId'");
		$res = $res->result_array();
		if (count($res) == 0) return false;
		echo $res[0]["credit"] . '<br>';
        
		if ($res[0]["credit"] == 250) return 3;
		if ($res[0]["credit"] == 255) return 2;
		return 1;
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
    public function getNum($userId)
    {
        $res = $this->db->query("select mailNum,comNum from user where user_id = '$userId'");
        return $this->getArray($res->result_array());
    }
    public function getItem($userId){
        //为item提供的数据，包含商家一些主要的信息,通过查找
        $res = $this->db->query("select user_type,work,operst,opered,contract1,contract2,email,intro,addr,lng,lat,user_name,impress,user_photo from user where user_id = $userId");
        if(!$res)return false;
            $res = $res->result_array();
        $res = $res[0];
        /**************对时间的处理************************/
        preg_match("/^[\d]{1,2}\:[\d]{1,2}/",$res["operst"],$res["operst"]);
        $res["operst"] = $res["operst"][0];
        preg_match("/^[\d]{1,2}\:[\d]{1,2}/",$res["opered"],$res["opered"]);
        $res["opered"] = $res["opered"][0];
        /*******************************/
        $res["addr"] = $this->divAddr($res["addr"]);
        return $res;
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
        $sql = "select user_id,user_name,user_photo,work,intro,operst,opered from user where user_name like '%送货%' || work like '%送货%'";
        $res = $this->db->query($sql);
        $res = $res->result_array();
        for($i = count($res)-1;$i>=0;$i--){
            $sql2 = "select id from ord where seller = '$res[$i][user_id]'";
            $res2 = $this->db->query($sql2);
            $res[$i]["order"] = count($res2->result_array());
            /*********去掉秒，这个毫无意义*********/
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
    public function insertExtro($data,$userId)
    {
        $str = $this->enExtro($data);
        $str = addslashes($str);
        //return $this->db->query("insert into user(extro) values('$str') where user_id = $userId");
        return $this->db->query("update user set extro = '$str' where user_id = $userId");
    }
    public function getExtro($userId)
    {
        $res = $this->db->query("select extro from user where user_id = $userId ");
        if($res){
            $res = $res->result_array();
            if(count($res)){
                return $this->deExtro($res[0]["extro"]);
            }
        }
        return false;
    }
    /**
     * 分解extro，得到包含的数据
     *
     * 传入一个string，将string分解成数组返回，得到其中包含的数据
     *@$str string 传入的信息
     *
     */
    private function deExtro($str)
    {
        $str = stripslashes($str);
        //传入string，制作成为数组返回
        $res = Array();
        if($str){
            $temp = explode(",",$str);
            for($i = 0,$len = count($temp);$i <  $len; $i++){
                $now = explode(":",$temp[$i]);
                $res[$now[0]] = $now[1];
            }
        }
        return $res;
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

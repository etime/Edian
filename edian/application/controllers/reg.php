<?php
/**
 *      本文件包含了注册和登录的内容
 *
 *      该文件的作用是处理登录和注册的，包含了所有的关于用户注册登陆的操作
 * 其实手机号码也是不允许重复的，这里就不再检查计较了
 *
 * @author   unasm <1264310280@qq.com>
 * @since    2013-06-20 21:05:39
 * @name     reg.php
 * @package  controller
 */
class Reg extends MY_Controller{
    var $max_img_height,$max_img_width,$img_save_path;
    function __construct(){
        parent::__construct();
        $this->load->model("user");
        $this->max_img_width = 200;
        $this->max_img_height = 200;
        $this->img_save_path = "./upload/";
        $this->load->helper(array('form'));
    }
    /**
     * 用户修改注册信息的时候，调用的函数
     *
     *  对用户名的重复检验,重新插入数据库
     */
    public function change()
    {
        $userId = $this->user_id_get();
        if(!$userId){
            $atten["atten"] = "请登录后修改";
            $atten["uri"] = site_url("reg/login");
            $atten["uriName"] = "信息修改页";
            $atten["title"] = "出错了";
            $atten["time"] = 5;
            $this->load->view("jump",$atten);
            return;
        }
        /***调转初始化**********************/
        $re = false;
        $user = $this->user->getPubById($userId);//get user_name reg_time,user_photo
        $data["photo"]= $this->ans_upload();//如果返回的是数组，就是失败了
        if(@array_key_exists("failed",$data["photo"])){
            if($data["photo"]["failed"]!=3){//使用原来的图片
                $re.= $data["photo"]["atten"];
            }
            $data["photo"] = $user["user_photo"];
        }
        $temp = $this->regInfoCheck();//除了图片,用户名，手机号码，等不允许重复的之外，所有的都在这里取得和检查
        if(array_key_exists("failed",$temp)){
            if($temp["errorType"]!=5){
                //5是用户名重复，在修改的时候，可以不考虑
                $atten["atten"] = "失败了，原因:".$temp["atten"];
                $atten["uri"] = site_url("info");
                $atten["uriName"] = "用户信息页";
                $atten["title"] = "出错了";
                $atten["time"] = 5;
                $this->load->view("jump",$atten);
                return;
            }
        }
        $data = array_merge($temp,$data);
        if(($user["user_name"]!=$data["name"])&&($this->user->checkname($data["name"]))){
            $atten["atten"] = "失败了，原因:用户名重复";
            $atten["uri"] = site_url("info");
            $atten["uriName"] = "信息修改页";
            $atten["title"] = "出错了";
            $atten["time"] = 5;
            $this->load->view("jump",$atten);
            return;
        }
        $res = $this->user->changeInfo($data,$userId);
        if($res){
            if($re){
                $atten["atten"] = "图片上传失败,原因:".$re;
                $atten["uri"] = site_url("info");
                $atten["uriName"] = "信息页";
                $atten["title"] = "图片上传失败";
                $atten["time"] = 5;
                $this->load->view("jump",$atten);
            }else redirect(site_url("info"));
        }
    }
    /**
     * reg 信息检验
     *
     * 是change和regSub数据检查的函数,通常在函数之前执行,除了用户名，联系方式，图片之外都在这里检查
     * 因为只是作为被调用的函数，调转就免了把
     * 返回错误的编号和原因，编号从上向下;
     */
    private function regInfoCheck()
    {
        if($_POST['sub']){
            $data["name"] =trim($this->input->post("userName"));
            $atten["failed"] = false;
            $ans = preg_match("/[\[\];\"\/?:@=#&<>%{}\\\|~`^]/",$data["name"]);
            if($ans){
                $atten["atten"] = "用户名出现不允许出现符号";
                $atten["errorType"] = 0;
                return $atten;
            }
            if($data["name"] == ""){
                $atten["atten"] = "忘记输入用户名，请点击后退重新输入";
                $atten["errorType"] = 1;
                return $atten;
            }
            else {
                $data["contract1"] = trim($this->input->post("contra"));
                $data["contract2"] = trim($this->input->post("contra2"));
                $pos = trim($this->input->post("pos"));
                if(preg_match("/\d+\.\d+;\d+\.\d+/",$pos)){
                    $data["pos"] = preg_split("/;/",$pos);//前面的是lng，后面的是lat
                } else  {
                    $data["pos"][0] = 0;
                    $data["pos"][1] = 0;
                }
                if($data["contract1"]  == ""){
                    $atten["atten"] = "请输入联系方式";
                    $atten["errorType"] = 2;
                    return $atten;
                }
            }
            $data["addr"] = $this->input->post("add");
            $data["passwd"] = $this->input->post("passwd");
            $repass = $this->input->post("repasswd");
            if($data["passwd"] != $repass){
                $atten["atten"] = "两次输入密码不同";
                $atten["errorType"] = 3;
                return $atten;
            }
            if($repass == ""){
                $atten["atten"] = "忘记输入密码,点击后退，可以避免重新输入数据";
                $atten["errorType"] = 4;
                return $atten;
            }
            $data["email"] = trim($this->input->post("email"));
            $data["intro"] = trim($this->input->post("intro"));
            /************对时间的整理*********/
            $sth = trim($this->input->post("opersth"));
            $stm = trim($this->input->post("operstm"));
            $edh = trim($this->input->post("operedh"));
            $edm = trim($this->input->post("operedm"));
            $data["st"] = $sth.":".$stm;
            $data["ed"] = $edh.":".$edm;
            /***********时间*****************/
            $work = trim($this->input->post("work"));
            $work = preg_split("/[^\x{4e00}-\x{9fa5}0-9a-zA-Z]+/u",$work);//以非汉字，数字，字母为分界点开始分割;
            $data["work"] = "";
            for($i  = count($work)-1;$i >=0;$i--){
                $data["work"].=";".$work[$i];
            }
            $data["work"].=";";
            /******************************/
            $data["type"] = trim($this->input->post("type"));
            return $data;
        }
    }
    /**
     * register submit 处理注册内容的函数,是处理注册的入口函数
     */
    public function regSub()    {
        $re = false;//作用是为添加失败添加原因,在报错中使用
        $atten["uri"] = site_url("reg/index");
        $atten["uriName"] = "注册";
        $temp = $this->ans_upload();
        $data = $this->regInfoCheck();//失败的时候返回包含failed的数组
        $sms = trim($this->input->post("smschk"));
        /*
            //短信验证还没有正式通过
        if($sms != $this->session->userdata("smscode")){
            //对短信验证码的检验
            $atten["atten"] = "短信验证码错误,请仔细核对，输入正确的验证码";
            $atten["title"] = "短信验证码出错";
            $this->load->view("jump",$atten);
            return;
        }
        */
        if(array_key_exists("failed",$data)){
            //出错了，就将错误报出来，然后返回
            $atten["atten"] = $data["atten"];
            $atten["title"] = "出错了";
            $this->load->view("jump",$atten);
            return;
        }
        if($this->user->checkname($data["name"])){
            //和修改的时候不同，这里不允许重复
            $atten["atten"] = "用户名重复，请后退后更换";
            $atten["title"] = "用户名重复";
            $this->load->view("jump",$atten);
            return;
        }
        if(is_array($temp)){//判断是否成功，是则赋值，否，则看是否上传，否，则直接false，是，则提示
            if($temp["failed"]!=3){
                $re = "图片未上传成功，请在之后用户空间中修改";
            }
            $data["photo"] = false;
        }else {
            $data["photo"] = $temp;
        }
        $ans = $this->user->insertUser($data);
        if($ans){
            $this->session->set_userdata("user_name",$data["name"]);
        //  $this->session->set_userdata("passwd",$data["passwd"]);
            $userId =  $this->user->checkname($data["name"]);
            $this->session->set_userdata("user_id",$userId["user_id"]);
            $this->user->changeLoginTime($userId["user_id"]);//修改登陆时间，还未检查
            $atten["title"] = "恭喜您，注册成功";
            $atten["atten"] = "恭喜，欢迎来到Edian<br/>".$re;
            $atten["uri"] = site_url("home/index");
            $atten["uriName"] = "主页";
            $this->load->view("jump2",$atten);
            return;
        }
        else{
            $atten["title"] = $ans;
            $atten["atten"] = $ans;
            $this->load->view("jump",$atten);
        }
    }
    /**
     * 显示html代码的入口函数
     */
    public function index()
    {
        //$data["dir"] = $this->partMap;
        $this->load->view("reg/userReg.php");
    }
    /*
    private  function _lSet($userId,$name)
    {//登陆后的信息初始化,不再想保存用户的密码了，
        $this->session->set_userdata("user_id",$userId);
        $this->session->set_userdata("user_name",$name);
    }
     */
    /**
     * denglu check,对登录信息的检验，更多对应ajax请求
     * @param bool $ajax 判断是否是ajax请求的标志位
     */
    public function dc($ajax = 0){
        //所有的登录的操作都集中在这里了吧
        //这个函数其实是对denglu_check的补充，这个是不需要form表单，通过ajax get的方式发送到这里进行判断，和session的操作，一切都是为了不再刷新
        $ans["flag"] = 1;
        $userId = trim($this->input->post("userId"));
        $passwd = trim(@$this->input->post("passwd"));
        if(!preg_match("/^\d+$/",$userId)){//检查id是不是数字
            $atten["flag"] = 0;
            $atten["atten"] = "id错误";
        }
        if(strlen($userId) == 0 ){//有待判断
            //来到这里，代表没有通过ajax的手段
            $userName = trim($this->input->post("userName"));
            if(strlen($userName)){//多一次查询，将用户名找到，其实只是为了扩展方便，不然已经可以确定了
                $res  = "";
                if(preg_match("/^1[\d]{10}$/",$userName)) {
                    $res = $this->user->checkPhone($userName);
                }else{
                    $res = $this->user->checkname($userName);
                }
                $userId = $res["user_id"];
            }else{
                $atten["flag"] = 0;
                $ans["atten"] = "没有输入信息";
            }
        }
        if($ans["flag"]){//其实进入这个，就代表是通过ajax的方式登录的
            $res = $this->user->getUpdate($userId);
            if($res && ($res["user_passwd"] == $passwd)){//一次取出所有的想要的，节省消耗
                $this->_lSet($userId,$res);
                $ans["photo"] = $res["user_photo"];
                $ans["mailNum"] = $res["mailNum"];//这里更多是兼容之前的代码，好傻，当初
                $ans["comNum"] = $res["comNum"];//新增加的评论的数目
                $ans["flag"] = 1;
                $ans["user_id"] = $userId;
            }
            else{
                $ans["flag"] = 0;
                $ans["atten"] = "用户名或密码错误";
            }
        }
        if($ajax){
            echo json_encode($ans);
        }
        else{
            $target = trim($this->input->post("target"));
            if(strlen($target) == 0){
                $target = site_url("mainpage");
            }
            if($ans["flag"]){
                    redirect($target);
            }else{
                $data["uri"]= $target;
                $data["uriName"]="主页";
                $data["time"]=5;
                $data["title"]="失败";
                $data["atten"] = $ans["atten"];
                $this->load->view("jump",$data);

            }
        }
    }
    /**
     * 显示login函数
     */
    public function login()
    {
        $this->load->view("login");
    }
    /**
     * 确认用户登录之后的信息初始化
     * @param int $userId 用户的id
     * @param array $res 包含其他的需要初始化的变量
     * @todo $res 的初始化中函数对session的初始化，其实可以通过foreach进行的
     */
    protected  function _lSet($userId,$res)
    {
        $this->session->set_userdata("user_id",$userId);
        $this->session->set_userdata("user_name",$res["user_name"]);
        //$this->session->set_userdata("passwd",$res["user_passwd"]);//需要把passwd给保存起来吗？暂时禁止
        $this->user->changeLoginTime($userId);
    }
    /**
     * 已经遭到废弃的函数
     */
    public function denglu()
    {
        if($_POST['enter']){
            $name = $this->input->post("userId");
            $pass = $this->input->post("passwd");
            $res = $this->user->checkname($name);
            if($res == false){
                exit("没有该用户，请退回重新输入");
            }
            else {
                if($pass == $res["user_passwd"]){
                    $this->session->set_userdata("user_id",$res["user_id"]);
                    $this->session->set_userdata("user_name",$res["user_name"]);
                    $this->session->set_userdata("passwd",$res["user_passwd"]);
                    $this->user->changeLoginTime($res["user_id"]);
                    $data["uri"]=site_url("mainpage?".$res["user_id"]);
                    $data["uriName"]="主页";
                    $data["time"]=3;
                    $data["title"]="登陆成功";
                    $data["atten"] = "恭喜您，登陆成功";
                    $this->load->view("jump",$data);
                }
                else {
                    exit("用户名不正确");
                }
            }
        }
    }
        /**
         * 这里对应的是前台的showart和art.js中的ajax申请
         * 感觉这里需要进行判断呢，一旦用户name中有很奇葩的名字，会出问题的
         * 应该已经废弃了
         */
    public function artD($name,$passwd)
    {

        $name = urldecode($name);
        $passwd = urldecode($passwd);
        $res = $this->user->checkname($name);
        if($res){
            if($passwd == $res["user_passwd"]){
                $re["user_id"] = $res["user_id"];
                $this->_lSet($res["user_id"],$name);
            }
            else $re["user_id"] = 0;
        }else {
            $re["user_id"] = -1;
        }//0 代表密码错误，-1，代表没有该用户，其他代表用户id
        echo json_encode($re);
    }
    /**
     * 登录的后台，获取用户名验证
     * 几乎被废弃
     */
    public function get_user_name(){
        //该函数是为前段的js服务的//其实也可以为reg服务不是吗
        header("Content-Type: text/xml; charset=utf-8");
        /*
         * 预设中 checkname就是根据$name再数据库中比对，然后返回密码的。如果没有返回密码，则返回false；
         */
        $name = $this->input->post("userName");
        //$name = urldecode($name);//目前tianyi ，老大测试还是可以的，将来还需要验证
        $ans = preg_match("/[\[\];\"\/?:@=#&<>%{}\\\|~`^]/",$name);
        if($ans){
            echo "<root><id>0</id></root>";
            return;
        }
        $res =  "";
        if(preg_match("/^1[\d]{10}$/",$name)) {
            $res = $this->user->checkPhone($name);
        }else{
            $res = $this->user->checkname($name);
        }
        $ans="<root>";
        if($res)
        {
            $ans.="<id>".$res["user_id"]."</id>";
            /*传递出去passwd是危险的行为
                $ans.="<passwd>".$res[0]["user_passwd"]."</passwd>";
             */
        }
        else {
            $ans.="<id>0</id>";
        }
        $ans.="</root>";
        echo $ans;
    }
    /**
     * 遭到废弃
     * 之前的函数的作用是通过js判断用户的信息对否正确，这里为了安全，通过js判断另一次
     * 在函数中进行userid和name的对比，保存cookie和session；
     */
    function denglu_check(){
        if($_POST['sub']){
            $res=$this->user->checkname($this->input->post("user_name"));//这里只是提取出了name,passwd,id,个人觉得，应该有很多东西值得做的事情，而不止是对比一下而已
            if($res["user_passwd"]==$this->input->post("passwd")){
                $this->session->set_userdata("user_id",$res["user_id"]);
                $this->session->set_userdata("user_name",$res["user_name"]);
                $this->session->set_userdata("passwd",$res["user_passwd"]);
                //因为无法读取session的缘故，取消这种方式，将来添加cookie
                //$this->id->alert("恭喜您登陆了");
                $data["uri"]=site_url("mainpage?".$res["user_id"]);
                $this->user->changeLoginTime($res["user_id"]);
                $data["uriName"]="主页";
                $data["time"]=5;
                $data["title"]="登陆成功";
                $data["atten"] = "恭喜您，登陆成功";
                $this->load->view("jump",$data);
            }
            else {
                //echo "<script type='text/javascript'>history.back()</script>";
            }
        }
    }
    /**
     * 进行密码验证
     * @param int $userId 进行验证的用户的id
     * @param string $passwd 密码
     */
    public function getPass($userId,$passwd)
    {//这里2013/05/04 10:07:49 AM做了修改，未知是否有问题
        $flag = 0;
        $res = $this->user->getPassById($userId);
        if($res == false){
            echo json_encode($flag);
            return;
        }
        $passwd = urldecode($passwd);
        if($res["user_passwd"] == $passwd){
            $flag = 1;
        }
        echo json_decode($flag);
    }
    /**
     * 上传头像的函数,显示对应的页面
     */
    public function upload()
    {//这里是上传函数，对应相册中的上传
        $userId = $this->user_id_get();
        if(!$userId){
            exit("<a href = '".site_url('mainpage')."'>E点</a>请首先登陆");
        }
        $temp = $this->user->getNess($userId);
        if(count($temp)==1){
            $temp = $temp[0];
        }else exit("没有该用户");
        $data["title"] = $temp["user_name"]."的空间";
        $data["masterId"] = $userId;
        $data["photo"] = $temp["user_photo"];
        $this->load->view("upload",$data);
    }
    /**
     * 对上传进行处理的类
     */
    public function ans_upload(){
        $config['max_size']='5000000';
        $config['max_width']='4500';
        $config['max_height']='4000';//here need to be changed someday
        $config['allowed_types']='gif|jpg|png|jpeg';//即使在添加PNG JEEG之类的也是没有意义的，这个应该是通过php判断的，而不是后缀名
        $config['max_filename'] = 100;
        $upload_name=time().".jpg";        // 当图片名称超过100的长度的时候，就会出现问题，为了系统的安全，所以需要在客户端进行判断
        $config['upload_path']= $this->img_save_path;
        $config['file_name']=$upload_name;
        $temp=$_FILES['userfile']['name'];        // 当图片名称超过100的长度的时候，就会出现问题，为了系统的安全，所以需要在客户端进行判断
            if(strlen(trim($temp)) == 0){
                $data["failed"] = 3;
                $data["atten"] = "没有上传图片";
                return $data;
            }
        $this->load->library('upload',$config);
        //$this->load->model("img");//因为不再插入数据，所以也用不到它了吧
        if(!$this->upload->do_upload()){
            $error = $this->upload->display_errors();
            $data["atten"] = $error;
            $data["failed"] = false;
            return $data;
        }
        else {
            $temp=$this->upload->data();
            if(($temp['image_width']> $this->max_img_width )||($temp['image_height']> $this->max_img_height))
                $this->thumb_add($temp['full_path'],$temp['file_name']);
            //因为担心用户的图片的名称会造成路径不支持的问题，所以决定增加同一名称，并且，保存原来的名称
            return $upload_name;
        }
    }
    /**
     * 生成缩略图
     */
    protected  function thumb_add($path,$name){//为什么这里不可以是private 呢，这里重写了MY_Controller/thumb_add
        //生成缩小图的函数
        $this->load->library("upload");
        $config['image_library']='gd2';
        $config['source_image']=$path;
        $config['new_image'] = $this->img_save_path;//和原来的图片是同一个路径,在construct中指定；
        $config['create_thumb']=true;
        $config['maintain_ratio']=true;//保持原来的比例
        $config['width']=$this->max_img_width;
        $config['height']=$this->max_img_height;//我希望得到的效果是一个宽度最大为600，但是如果宽度超过一个屏幕也是不可以的，也是不必要的，一旦超过一个屏幕的时候，即使宽度已经小于600也要缩小
        $config['thumb_marker']="";//禁止自动添加后缀名
        //$config['master_dim']="auto";//自动设置定轴,目前觉得好无用处
        $this->load->library('image_lib',$config);
        if(!$this->image_lib->resize()){
            var_dump($this->image_lib->display_errors());
            var_dump("请联系管理员".$this->adminMail);
        }
    }
}
?>

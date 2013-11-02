<?php
/**
 * 这个是为了管理扩展方便，目前，其实还是没有太多的作用，类似于id，但是alert还是放到了library中
 * author:          unasm
 * email:           douunasm@gmail.com
 * Last_modified:   2013-06-11 10:39:28
 **/
class MY_Controller extends  CI_Controller
{
    public $part;//表示首页的菜单目录的关系
    public $adminMail;
    protected $priAdd;//当运费不足的情况下,添加的运费
    function __construct()
    {
        parent::__construct();
        session_start();
        date_default_timezone_set("Asia/Chongqing");
        $this->load->library("session");
        $this->adminMail = "1264310280@qq.com";
        //将来这里的先后顺序，就根据商品的多少和点击的多少来决定吧,目前暂定顺序如下,而且，觉得有必要给出二级连接呢,只是商品比较少的时候，就算了吧
        //$this->partMap = array(
            //"0" => "热门",
            //"1" => "服装",
            //"2" => "鞋帽配饰",
            //"3" => "数码",
            //"4" => "美食特产",
            //"5" => "日用百货",
            //"6" => "文化玩乐",
            //"7" => "美容护发",
            //"8" => "本地生活",
            //"9" => "书籍",
            //"10" => "家具建材",
            //"11" => "二手交易",
            //"12" => "其他"
        //);
        $this->part = array(
            "零食饮料" => array(
                "素材" => array("肉质品","鲜鱼","素材","干菜"),
                "饮料" => array("果汁","橙汁","酒","奶茶"),
                "水果" => array("鲜果","干果"),
                "包装食品" => array("火腿","泡面")
           ),
            "餐饮" => array(
                "外卖" => array("盒饭","蛋炒饭"),
                "饭店" => array("烧烤","火锅","炒菜","凉菜","特色","小吃")
            ),
            "服务" => array(
                "兼职招聘" => array("发传单","礼仪","促销","家教"),
                "美容" => array("美甲","彩妆","眼线","美发"),
                "生活" => array("理发","泡澡","桑拿","打印","租房"),
                "维修" => array("自行车","家电","数码"),
                "娱乐" => array("KTV","网吧"),
            ),
            /*
            "二手交易" => array(
                "图书" => array("课本","习题"),
                "日用百货" => array("自行车","日用品")
            ),
             */
            //"衣服" => array(
                //"男装" => array("T恤","卫衣","休闲裤","牛仔裤","运动裤","裤子","毛衣","内衣","西服","夹克","外套"),
                //"女装" => array("裙装","T恤","衬衫","牛仔裤","休闲裤","毛衣","内衣","卫衣","蕾丝衫","外套","短外套")
            //),
            //"鞋包配饰" => array(
                //"女鞋" => array("运动鞋","凉鞋","拖鞋","单鞋","帆布鞋","靴子","高跟鞋","大码鞋","小码鞋"),
                //"男鞋" => array("篮球鞋","运动鞋","休闲鞋","豆豆写","帆布鞋","板鞋","高帮鞋","凉鞋","靴子"),
                //"配饰" => array("腰带","帽子","丝巾","手套","披肩","领带","围巾","手表","眼睛"),
                //"女包" => array("大牌","真皮","钱包","樱桃包","斜挎包","手提包","真皮","单肩包","双肩包"),
                //"男包" => array("单肩包","手提包","双肩包","钱包","休闲包","真皮","电脑包","商务包"),
                //"旅行包" => array("登山包","旅行箱","登机箱")
            //),
            //"数码" => array(
                //"外设" => array("显示器","cpu","硬盘","键盘","机箱","散热器","电源"),
                //"数码" => array("相机","笔记本","平板","手机","路由","电脑主机"),
                //"配件" => array("贴膜","保护膜","蓝牙","移动电源")
            //),
            "日用百货" => array(
                "清洁用品" => array("拖把","晾衣架","洗衣粉","扫帚"),
                "床品" => array("被子","枕头","抱枕","床单"),
                "季节用皮" => array("扇子","风扇","花露水","驱蚊","蚊帐"),
                "厨房用品" => array("盘子","杯子","碗","酒具","烹饪餐具")
            )
            //"书籍" => array(
                //"童书" => array("画册","漫画","拼音"),
                //"外文" => array("小说","技术","美文"),
                //"教材" => array("课本","辅导资料","习题","考卷")
            //),

        );
        $this->max_img_width = 800;
        $this->max_img_height = 505;
        $this->img_thumb_width = 200;
        $this->img_thumb_height = 125;
        $this->img_save_path = "./upload/";
        $this->imgPath = base_url("upload");//这两个，其实是同一的
        $this->thumb_path = "./thumb/";
    }
    public function checkAuth()
    {
        //检查用户是否登陆，没有登陆返回0，登陆了返回1,暂时不完成，以后完成
    }
    public function user_id_get()
    {
        //或许可以选择保存在数据库，但是总要有一个唯一的标示，我想或许是session_id吧
        $user_id = false;
        if($this->session->userdata("user_id")!=""){
            $user_id = $this->session->userdata("user_id");
            $intUser = intval($user_id);
            if(is_numeric($user_id)&&($intUser == $user_id)){
                return $user_id;
            }
        }
        return $user_id;
    }
    public  function fb_unique($array2D)
    {//将二维的数组转变成为一维数组,方便unique
        if(count($array2D) == 0)return $array2D;
        foreach ($array2D as $key) {
            $key = join(",",$key);
            $reg[] = $key;
        }
        $reg = array_unique($reg);
        return $reg;
    }
    /**
     * 排序函数，为有id 和value两种属性
     *
     * 整理的原则非常简单，首先是排序，对value进行，其次，通过计算重复度，重复度高的在前面，低的在后面，要稳定的算法，所以也按照了价格的从前向后
     * 这个至少是nlogn级别的运算，希望可以缓存保存3分钟，或者是其他的方式保存,不用再次运算
     *
     *
     * 实例测试，并不理想，第二个数组好像没有作用
     *
     * @$array2D 一个包含value和id两个值的数组
     * @return $array 包含只有一个id的数组，value经过排序，已经没有用处了
     */
    protected function uniqueSort($array2D)
    {
        $len = count($array2D);
        //其实len长度应该限制，因为太长的话，一般用户浏览不到
        if($len == 0)return;
        $id = array();
        for($i = 0; $i < $len;$i++){
            $id[$i] = (int)$array2D[$i]["id"];//id 用来判断重复度，value用来排序时作为第二参数
            $value[$i] = (int)$array2D[$i]["value"];
        }
        $repeat = array_count_values($id);//计算各个id重复次数的函数
        for($i = 0; $i < $len;$i++){
            $re[$i] = $repeat[$array2D[$i]["id"]];//作为排序时候的第一参数，re，重复度，
        }
        array_multisort($re,SORT_DESC,SORT_NUMERIC,$value,SORT_DESC,SORT_NUMERIC,$array2D);//用法真蛋疼,多重排序
        $last = -1;
        $cont = 0;
        for($i = 0; $i < $len;$i++){
            if($array2D[$i]["id"] != $last){
                $last = $array2D[$i]["id"];
                $res[$cont++] = $last;
            }
        }
        return $res;
    }
    function ans_upload($height = -1,$width = -1){
        //对上传进行处理的函数，去掉了jump的部分，使它更富有扩展性
        //返回数据格式为数组，flag,0,标示没有错误,1,没有登陆，2，图片重复,3,没有上传，4，其他原因
        $re["flag"] = 1;
        $user_id=$this->user_id_get();
        if($user_id==false){
            $re["atten"] = "请首先登陆";
            return $re;
        }
        $config['max_size']='5000000';
        $config['max_width']='4500';
        $config['max_height']='4000';//here need to be changed someday
        $config['allowed_types']='gif|jpg|png|jpeg';//即使在添加PNG JEEG之类的也是没有意义的，这个应该是通过php判断的，而不是后缀名
        $config['max_filename'] = 100;
        $config['upload_path']= $this->img_save_path;
        $config['file_name']=$user_id.time().".jpg"; //这里将来修改成前面是用户的id，这样，就永远都不会重复了
        $this->load->library('upload',$config);
        $this->load->model("img");//图片验重复使用
        if($this->input->post("sub")){
            $upload_name=$_FILES['userfile']['name'];        // 当图片名称超过100的长度的时候，就会出现问题，为了系统的安全，所以需要在客户端进行判断
            if(strlen(trim($upload_name)) == 0){
                $re["flag"] = 3;
                $re["atten"] = "没有上传图片";
                return $re;
            }
            if($this->img->judgesame($upload_name)){
                $re["atten"] = "图片重复，您已经提交过同名图片";
                return $re;
            }
            else {
                if(!$this->upload->do_upload()){
                    $error = $this->upload->display_errors();//这里的英文将来要汉化
                    $re["atten"] = $error;
                    return $re;
                }
                else {
                    $temp=$this->upload->data();
                    $this->load->library("image_lib");
                    if($width == -1){//如果没有给出指定宽度，就按照默认的，否则按照指定的
                        if(($temp['image_width']> $this->max_img_width )||($temp['image_height']> $this->max_img_height)){
                            $this->thumb_add($temp['full_path'],$temp['file_name'],$this->img_save_path,$this->max_img_width,$this->max_img_height);
                        }
                    }else {
                        if(($temp['image_width']> $width )||($temp['image_height']> $height)){
                            $this->thumb_add($temp['full_path'],$temp['file_name'],$this->img_save_path,$width,$height);
                        }
                    }
                    $this->thumb_add($temp['full_path'],$temp['file_name'],$this->thumb_path,$this->img_thumb_width,$this->img_thumb_height);//生成缩略图
                    $intro = $this->input->post("intro");//上传就是上传，数据的处理就交给其他的吧
                    $re["flag"] = 0;
                    $re["file_name"] = $temp['file_name'] ;
                    $re["upload_name"] = $upload_name;
                    return $re;
                }
            }
        }
        $re["atten"] = "没有submit";
        return $re;
    }
    protected function thumb_add($path,$name,$newPath,$width,$height){
        //生成缩小图的函数,函数的属性不可以随便修改呢，下层必须和上层相同才可以
        $this->load->library("upload");
        $config['image_library']='gd2';
        $config['source_image']=$path;
        $config['new_image'] = $newPath;//和原来的图片是同一个路径,在construct中指定；
        $config['create_thumb']=true;
        $config['maintain_ratio']=true;//保持原来的比例
        $config['width']= $width;
        $config['height']= $height;//我希望得到的效果是一个宽度最大为600，但是如果宽度超过一个屏幕也是不可以的，也是不必要的，一旦超过一个屏幕的时候，即使宽度已经小于600也要缩小
        $config['thumb_marker']="";//禁止自动添加后缀名
        //$config['master_dim']="auto";//自动设置定轴,目前觉得好无用处
        $this->image_lib->initialize($config);
        if(!$this->image_lib->resize()){
            var_dump($this->image_lib->display_errors());
            var_dump("请联系管理员:".$this->adminMail);
        }
    }
    protected  function noLogin($url)
    {
        //没有登录时候的操作
        $data["url"] = $url;
        $this->load->view("login",$data);
    }
    /*
    public function userInfoGet()
    {
        //获得用户的信息，根据就是sessionId,返回用户名，id，密码
        $this->load->model("monline_user");
        $res = $this->monline_user->checkOnline($_SESSION['id']);
        var_dump($res);
        echo "<br/>";
        var_dump("检查下这个错误的时候返回的是不是false，正确的时候返回的是数组MY_Controller/userInfoGeg");
        if($res){
            return $res["user_id"];
        }
        return false;
    }
    public function userInfoSet($userid,$userName,$passwd)
    {
        //代替原来的sessiondataset，向数据库保存用户信息,使用之前确保用户不在线
        $this->load->model("monline_user");
        $data["user_id"] = $userid;
        $data["user_name"] = $userName;
        $data["passwd"] = $passwd;
        $data["time"] = now();
        var_dump($data["time"]);
        echo "<br/>";
        var_dump("检查下这个时间是不是时间戳的格式，不是就错了，MY_Controller/userInfoSet");
        die;
        $this->monline_user->denglul($data);
    }
    public function userInfoDel()
    {
        //删除用户信息，
        $this->monline_user->delete($_SESSION['id']);
    }
*/
}
?>

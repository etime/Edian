<?php
/**
 *这个文件是用来发表文章的，之前的测试版本已经在test有过了，现在需要添加js和css，大概不需要太多的css吧js也不需要太多吧
 author:            unasm
 email:         douunasm@gmail.com
 last_modefied: 2013/03/28 12:31:53 AM
 **/
class Write extends MY_Controller
{
    var $userId,$defaultImg;//defaultImg 是在用户没有提交图片的情况下的默认图片
    function __construct()
    {
        parent::__construct();
        define('imgDir',"upload/");
        define('THUMB',"upload/");
        $this->defaultImg = "real.png";
        $this->userId = $this->user_id_get();
        $this->load->model("art");
    }
    public function index2()
    {//目前暂时废弃，write和对应的js，view和后台都不改变，将来需要可以随时添加，只是对应的表已经变了
        $data["title"] = "发表新帖";
        if(!$this->userId){
            $atten["uri"] = site_url("mainpage/index");
            $atten["uriName"] = "登陆页面";//如果将来有时间，专门做一个登陆的页面把
            $atten["time"] = 5;
            $atten["title"] = "请首先登陆";
            $atten["atten"] = "请登陆后发表新帖";
            $this->load->view("jump",$atten);
            return;
        }
        $this->load->view("write",$data);
    }
    public function index()
    {//view 中cwrite c代表商业，就是商家的添加，也是默认的添加，有分区，价格的东西，对应的是目前的表
        $data["title"] = "新品上架";
        if($this->noLogin())return;
        $data["dir"] = $this->part;
        $this->load->model("user");
        $data["userType"] = $this->user->getType($this->userId);
        $this->load->view("Cwrite",$data);
    }
    public function change($artId)
    {//对帖子进行修改重新编辑的函数，除了id，value之外，什么都修改吧
        if($this->noLogin())return;
        $data = $this->art->getUserInsert($artId);
        $data["keyword"] = preg_split("/;/",$data["keyword"]);
        $temp = "";
        for($i = 0,$len = count($data["keyword"]); $i < $len;$i++){
            $temp.=$data["keyword"][$i]." ";
        }
        $data["keyword"] = trim($temp);
        $this->load->model("user");
        $data["userType"] = $this->user->getType($this->userId);
        if($data["author_id"]!=$this->userId){
            echo "抱歉，您无权修改该商品信息";
            return ;
        }
        $data["dir"] = $this->part;
        $data["artId"] = $artId;
        //var_dump($data);
        $this->load->view("wChange",$data);
    }
    public function reAdd($artId)
    {//修改帖子的时候
        if($this->noLogin())return;
        $info = $this->art->getImgId($artId);//取得author_id 和img 的信息,
        if($info == false)show_404();
        if($info["author_id"] != $this->userId){
            echo "抱歉，您无权修改该商品信息,只有发布者本人才可以";
            return ;
        }
        //var_dump($this->input->post("userfile"));
        $data = $this->ans_upload(300,150);//成功的时候返回两个名字，一个是本来上传的时候的名字，一个是数字组成的名字，采用数字的名字，保持兼容性
        if($data["flag"]||($data == NULL)){//上传图片，且成功时，采用上传图片，否则采用原来图片，上传成功时原来图片删除
            $insert["img"] = 0;//没有图片就什么都不做，在model做判断，是否需要插入图片;
        }else{
            $insert["img"] = $data["file_name"];
            unlink(imgDir.$info["img"]);//这里即使没有删除成功也没有办法，继续是必然的
            unlink(THUMB.$info["img"]);//这里即使没有删除成功也没有办法，继续是必然的
        }
        $temp = $this->insertJudge();
        if($temp === false)return;
        $insert = array_merge($temp,$insert);
        $flag = $this->art->reAdd($insert,$artId);
        if($flag){//成功之后则返回showart，否则回到jump之后再回
            redirect(site_url("showart/index/".$artId));
        }else{
            $atten["uri"] = site_url("showart/index/".$artId);
            $atten["uriName"] = "商品介绍页";
            $atten["title"] = "修改失败了";
            $atten["atten"] = "修改失败，请联系管理员解决".$this->adminMail;
            $this->load->view("jump",$atten);
        }
    }
    protected function noLogin()
    {//所有的view的登陆判断页面
        if(!$this->userId){
            $atten["uri"] = site_url("mainpage/index");
            $atten["uriName"] = "登陆";//如果将来有时间，专门做一个登陆的页面把
            $atten["title"] = "请首先登陆";
            $atten["atten"] = "请登陆后继续";
            $this->load->view("jump",$atten);
            return true;
        }
        return false;
    }
    private function addError($error)
    {//为下面的cadd提供抱错的函数
        $atten["uri"] = site_url("write/index");
        $atten["uriName"] = "新品发表页";//如果将来有时间，专门做一个登陆的页面把
        $atten["title"] = "图片出错了";
        $atten["atten"] = $error;
        $atten["time"] = 5;
        $this->load->view("jump",$atten);
    }
    private function bgError($error)
    {//为下面的cadd提供抱错的函数
        $atten["uri"] = site_url("bg/home/itemadd");
        $atten["uriName"] = "新品发布";//如果将来有时间，专门做一个登陆的页面把
        $atten["title"] = "出错了";
        $atten["atten"] = $error;
        $atten["time"] = 50;
        $this->load->view("jump",$atten);
    }
    private function insert()
    {
        //对后台上传数据时候的数据检查
        $data["title"] = trim($this->input->post("title"));
        if(strlen($data["title"])==0){
            $this->bgError("没有添加标题");
            return false;
        }
        $data["content"] = $this->input->post("cont");
        if(strlen(trim($data["content"]))==0){
            $this->bgError("忘记添加内容");
            return false;
        }
        //$data["part"] = trim($this->input->post("part"));
        $data["price"] = trim($this->input->post("price"));
        $data["img"] = trim($this->input->post("Img"));
        $data["promise"] = trim($this->input->post("promise"));
        if(strlen($data["img"]) == 0){
            $this->bgError("忘记添加图片");
        }
        $data["attr"] = trim($this->input->post("attr"));
        $data["store_num"] = trim($this->input->post("storeNum"));
        if(!preg_match("/^\d+.?\d*$/",$data["price"])){
            //其实这样还是有bug的，比如12.的情况，只是mysql好像可以自己转化这类型的为数字，比如这种情况就自动转化为12了
            $this->bgError("请输入标准数字");
            return false;
        }
        //这里需要添加监视，就是用户到底输入的符合不符合规范
        $keys = trim($this->input->post("key"));
        $keys = preg_split("/[^\x{4e00}-\x{9fa5}0-9a-zA-Z]+/u",$keys);//以非汉字，数字，字母为分界点开始分割;
        $key = trim($this->input->post("part"));
        $keys = $this->getrepeat($keys,$key);
        $key = trim($this->input->post("keyj"));
        $keys = $this->getrepeat($keys,$key);
        $key = trim($this->input->post("keyk"));
        $keys = $this->getrepeat($keys,$key);
        $data["keys"] = $this->formate($keys);
        //以上是对关键字的处理
        return $data;
    }
    private function insertJudge()
    {//返回标题，价格，内容，分区
        //对输入信息判断的函数，因此两次添加修改的判断一样，合并
        $data["tit"] = trim($this->input->post("title"));
        if(strlen($data["tit"])==0){
            $this->addError("没有添加标题");
            return false;
        }
        $data["cont"] = $this->input->post("cont");
        if(strlen(trim($data["cont"]))==0){
            $this->addError("忘记添加内容");
            return false;
        }
        $data["part"] = trim($this->input->post("part"));
        $data["price"] = trim($this->input->post("price"));
        if(!preg_match("/^\d+.?\d*$/",$data["price"])){
            //其实这样还是有bug的，比如12.的情况，只是mysql好像可以自己转化这类型的为数字，比如这种情况就自动转化为12了
            $this->addError("请输入标准数字");
            return false;
        }
        //这里需要添加监视，就是用户到底输入的符合不符合规范
        $keys = trim($this->input->post("key"));
        $keys = preg_split("/[^\x{4e00}-\x{9fa5}0-9a-zA-Z]+/u",$keys);//以非汉字，数字，字母为分界点开始分割;
        $key = trim($this->input->post("keyj"));
        $keys = $this->getrepeat($keys,$key);
        $key = trim($this->input->post("keyk"));
        $keys = $this->getrepeat($keys,$key);
        $data["keys"] = $this->formate($keys);
        return $data;
    }
    private  function formate($arr)
    {
        //整理数组，将数组变成A;B;的形似存储
        $temp = ";";
        for($i = 0,$len = count($arr); $i < $len;$i++){
            if($arr[$i]!="")
            $temp.=$arr[$i].";";
        }
        return $temp;
    }
    private function getrepeat($arr,$value)
    {//检查数组中有木有重复的，有就不添加，没有，就直接添加了。
        if(strlen($value)== 0)return $arr;
        $len = count($arr);
        for($i = 0; $i < $len;$i++){
            if($arr[$i] == $value)return $arr;
        }
        $arr[$len] = $value;
        return $arr;
    }
    public function cadd()
    {
        if(!$this->userId){
            exit("请登陆后继续");//这里修改成主页调转
        }
        if($_POST["sub"]){
            $re = null;
            $data = $this->ans_upload(300,150);//成功的时候返回两个名字，一个是本来上传的时候的名字，一个是数字组成的名字，采用数字的名字，保持兼容性
            if($data["flag"]){
                if($data["flag"] == 3){//这个是没有上传图片的情况
                    $data["file_name"] = $this->defaultImg;
                }else {
                    $atten["uri"] = site_url("write/index");
                    $atten["uriName"] = "新品发表页";//如果将来有时间，专门做一个登陆的页面把
                    $atten["time"] = 5;//现在好像可以去掉这个了
                    $atten["title"] = "图片出错了";
                    $atten["atten"] = $data["atten"];
                    $this->load->view("jump",$atten);
                    return;
                }
            }else if($data == NULL){//没有上传图片的情况下
                $data["file_name"] = $this->defaultImg;
            }
            $data["value"] = time();//value ，标示一个帖子含金量的函数,初始的值为当时的事件辍
            $temp = $this->insertJudge();
            if($temp === false)return;//返回false，代表出错，而且，已经进入了调转
            $data = array_merge($temp,$data);
            $re = $this->art->cinsertArt($data,$this->userId);
            if($re){
                $data["time"] = 3;
                $data["title"] = "恭喜你，成功了";
                $data["uri"] = site_url("showart/index/".$re);
                $data["uriName"] = "新品";
                $data["atten"] = "成功,可喜可贺";
                $this->load->view("jump2",$data);
            }else {
                $this->load->view("write",$data);
            }
        }
    }
    public function bgAdd()
    {
        if(!$this->userId){
            exit("请登陆后继续");//这里修改成主页调转
        }
        if($_POST["sub"]){
            $re = null;
            //$data = $this->ans_upload(300,150);//成功的时候返回两个名字，一个是本来上传的时候的名字，一个是数字组成的名字，采用数字的名字，保持兼容性
            $data = $this->insert();
            $data["value"] = time();//value ，标示一个帖子含金量的函数,初始的值为当时的事件辍
            $data["author_id"] = $this->userId;
            if($data === false)return;//返回false，代表出错，而且，已经进入了调转
            $this->load->model("mitem");//调出model
            $re = $this->mitem->insert($data);
            if($re){
                $data["time"] = 3;
                $data["title"] = "恭喜你，成功了";
                //$data["uri"] = site_url("showart/index/".$re);
                $data["uri"] = site_url("bg/home/itemadd");
                $data["uriName"] = "新品";
                $data["atten"] = "成功,可喜可贺";
                $this->load->view("jump2",$data);
            }else {
                $data["time"] = 5;
                $data["title"] = "出错了，请联系客服";
                $data["uri"] = site_url("bg/home/itemadd");
                $data["uriName"] = "新品上架";
                $data["atten"] = "出错了，请联系客服帮助解决";
                $this->load->view("jump",$data);
            }
        }
    }
    public function imgAns()
    {//目前对应的是xhe函数，编辑器上传图片的后台处理部分，将来需要将大图片压缩成为小图片,目前集中精力处理重要部分吧
        header('Content-Type: text/html; charset=UTF-8');
        $inputName='filedata';//表单文件域name,form的name
        //$attachDir='upload';//上传文件保存路径，结尾不要带/
        $attachDir="upload";//上传文件保存路径，结尾不要带/
        $dirType=2;//1:按天存入目录 2:按月存入目录 3:按扩展名存目录  建议使用按天存
        $maxAttachSize=2097152;//最大上传大小，默认是2M
        $upExt='txt,rar,zip,jpg,jpeg,gif,png';//上传扩展名
        $msgType=2;//返回上传参数的格式：1，url，2，返回参数数组
        $immediate=isset($_GET['immediate'])?$_GET['immediate']:0;//立即上传模式，仅为演示用
        ini_set('date.timezone','Asia/Shanghai');//时区

        $err = "";
        $msg = "''";
        $tempPath=$attachDir.'/'.date("YmdHis").mt_rand(10000,99999).'.tmp';
        $localName='';

        if(isset($_SERVER['HTTP_CONTENT_DISPOSITION'])&&preg_match('/attachment;\s+name="(.+?)";\s+filename="(.+?)"/i',$_SERVER['HTTP_CONTENT_DISPOSITION'],$info)){//HTML5上传
            file_put_contents($tempPath,file_get_contents("php://input"));
            $localName=urldecode($info[2]);
        }
        else{//标准表单式上传
            $upfile=@$_FILES[$inputName];
            if(!isset($upfile))$err='文件域的name错误';
            elseif(!empty($upfile['error'])){
                switch($upfile['error'])
                {
                case '1':
                    $err = '文件大小超过了php.ini定义的upload_max_filesize值';
                    break;
                case '2':
                    $err = '文件大小超过了HTML定义的MAX_FILE_SIZE值';
                    break;
                case '3':
                    $err = '文件上传不完全';
                    break;
                case '4':
                    $err = '无文件上传';
                    break;
                case '6':
                    $err = '缺少临时文件夹';
                    break;
                case '7':
                    $err = '写文件失败';
                    break;
                case '8':
                    $err = '上传被其它扩展中断';
                    break;
                case '999':
                default:
                    $err = '无有效错误代码';
                }
            }
            elseif(
                empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none')$err = '无文件上传';
            else{
                move_uploaded_file($upfile['tmp_name'],$tempPath);
                $localName=$upfile['name'];
            }
        }
        if($err==''){
            $fileInfo=pathinfo($localName);
            $extension=$fileInfo['extension'];
            if(preg_match('/^('.str_replace(',','|',$upExt).')$/i',$extension))
            {
                $bytes=filesize($tempPath);
                if($bytes > $maxAttachSize)$err='请不要上传大小超过'.$this->formatBytes($maxAttachSize).'的文件';
                else
                {
                    $attachSubDir = 'month_'.date('ym');
                    /*
                    switch($dirType)
                    {
                    case 1: $attachSubDir = 'day_'.date('ymd'); break;
                    case 2: $attachSubDir = 'month_'.date('ym'); break;
                    case 3: $attachSubDir = 'ext_'.$extension; break;
                    }
                     */
                    $attachDir = $attachDir.'/'.$attachSubDir;
                    if(!is_dir($attachDir))
                    {
                        @mkdir($attachDir, 0777);
                        @fclose(fopen($attachDir.'/index.htm', 'w'));
                    }
                    PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
                    $newFilename=date("YmdHis").mt_rand(1000,9999).'.'.$extension;
                    $targetPath = $attachDir.'/'.$newFilename;
                    rename($tempPath,$targetPath);
                    @chmod($targetPath,0755);
                    $targetPath=base_url("").$this->jsonString($targetPath);
                    if($immediate=='1')$targetPath='!'.$targetPath;
                    if($msgType==1)$msg="'$targetPath'";
                    else {
                        //$msg="{'url':'".$targetPath."','localname':'".json_encode($localName)."','id':'1'}";//id参数固定不变，仅供演示，实际项目中可以是数据库ID;
                        $msg="{'url':'".$targetPath."','localname':'".$this->jsonString($localName)."','id':'1'}";//id参数固定不变，仅供演示，实际项目中可以是数据库ID;
                    }
                }
            }
            else $err='上传文件扩展名必需为：'.$upExt;

            @unlink($tempPath);
        }
        echo "{'err':'".$this->jsonString($err)."','msg':".$msg."}";
    }
    function jsonString($str)
    {
        return preg_replace("/([\\\\\/'])/",'\\\$1',$str);
    }
    function formatBytes($bytes) {
        if($bytes >= 1073741824) {
            $bytes = round($bytes / 1073741824 * 100) / 100 . 'GB';
        } elseif($bytes >= 1048576) {
            $bytes = round($bytes / 1048576 * 100) / 100 . 'MB';
        } elseif($bytes >= 1024) {
            $bytes = round($bytes / 1024 * 100) / 100 . 'KB';
        } else {
            $bytes = $bytes . 'Bytes';
        }
        return $bytes;
    }

}
?>

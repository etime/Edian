<?php
/**
 *      这个文件是用来发表文章的，
 *  处理各种文章信息，作为发布文章和数据，上传到网站后台，包括二手和商城
 * 需要检验后台上传数据的时候，强制前端所有信息重新检验,数据必须合格
 *
 * @author      unasm<1264310280@qq.com>
 * @since       2013/03/28 12:31:53 AM
 * @package     controller
 */
class Write extends MY_Controller
{

    /**
     * 用户的id，登录者的id
     * 每个controller都有会，记录登录者的id，方便处理,提供数据
     * @var int
     */
    var $userId;
    var $isBoss;
    var $isAdmin;

    /**
     * 默认的头像图片
     * 当初没有想到，其实$defaultImg 使用常量就最好了,或者是没有，在浏览查找的时候，修改成为默认图片，方便管理
     * @var string $defaultImg 是在用户没有提交图片的情况下的默认图片
     * @todo 废弃掉这个
     */
    var $defaultImg;

    function __construct() {
        parent::__construct();
        define('imgDir',"upload/");
        define('THUMB',"upload/");
        $this->defaultImg = "real.png";
        $this->userId = $this->getUserId();
        $this->load->model("art");
        $this->load->model("mwrong");
        $this->load->model("mitem");
        $this->load->model('store');

        $this->isAdmin = false;
        $this->isBoss = false;
    }

    /**
     * 判断用户是否登录，如果没有登录，跳转到登录页面并返回 true，否则返回 false
     * @return boolean
     */
    protected function isNoLogin() {
        if ($this->userId == -1) {
            $atten['uri'] = site_url('mainpage/index');
            $atten['uriName'] = '登陆';
            $atten['title'] = '请首先登陆';
            $atten['atten'] = '请登陆后继续';
            $this->load->view('jump', $atten);
            return true;
        }
        return false;
    }

    /**
     * 检查用户是否登陆以及权限是否为管理员或者老板
     * 如果用户未登录，跳转到登陆页面，如果权限不够，跳转到 404 页面
     * @param string $url 如果用户未登录，登陆之后需要跳转的页面
     * @return boolean 如果用户登陆了并且权限足够，返回 1,boss;2,admin，否则返回 false
     * @author farmerjian<chengfeng1992@hotmail.com>
     */
    protected function _checkAuthority($url = false) {
        if ($url === false) {
            $url = site_url();
        }
        $this->isBoss = false;
        $this->isAdmin = false;
        // 用户未登录
        if ($this->userId === -1) {
            $this->noLogin($url);
            $this->isAdmin = false;
            $this->isBoss = false;
            return false;
        }
        $credit = $this->user->getCredit($this->userId);
        // 不是管理员或者老板权限
        $flag = false;
        if ($credit == $this->config->item('bossCredit')) {
            $flag = 1;
            $this->isBoss = true;
            $this->isAdmin = false;
        }
        if ($credit == $this->config->item('adminCredit')) {
            $flag = 2;
            $this->isBoss = false;
            $this->isAdmin = true;
        }
        if ($flag === false) {
            show_404();
            return false;
        }
        return $flag;
    }

//    /**
//     * 目前暂时废弃，write和对应的js，view和后台都不改变，将来需要可以随时添加，只是对应的表已经变了
//     */
//    public function index2()
//    {
//        $data["title"] = "发表新帖";
//        if($this->userId == -1){
//            $atten["uri"] = site_url("mainpage/index");
//            $atten["uriName"] = "登陆页面";//如果将来有时间，专门做一个登陆的页面把
//            $atten["time"] = 5;
//            $atten["title"] = "请首先登陆";
//            $atten["atten"] = "请登陆后发表新帖";
//            $this->load->view("jump",$atten);
//            return;
//        }
//        $this->load->view("write", $data);
//    }

    /**
     * 重新编辑修改的页面
     * 对帖子进行修改重新编辑的函数，除了id，value之外，什么都修改吧
     * 这里是显示view
     * @param int $artId 目标文档的id
     */
    public function change($artId) {
        if ($this->isNoLogin()) {
            return;
        }
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
    /**
     * 修改帖子的时候
     * 应该是和上面的change差不多，都是修改商品的，这里是提交之后，后台逻辑处理
     */
    public function reAdd($artId)
    {
        if($this->isNoLogin())return;
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

    /**
     * 为下面的cadd提供抱错的函数
     * @param string $error 错误的原因
     */
    private function addError($error)
    {
        $atten["uri"] = site_url("write/index");
        $atten["uriName"] = "新品发表页";//如果将来有时间，专门做一个登陆的页面把
        $atten["title"] = "图片出错了";
        $atten["atten"] = $error;
        $atten["time"] = 5;
        $this->load->view("jump",$atten);
    }

    /**
     * 为下面的cadd提供抱错的函数
     *
     *  向用户显示错误信息，同时想wrong检测报错
     * @param string $error 错误的原因
     */
    private function bgError($error)
    {
        $atten["uri"] = site_url("bg/home/itemadd");
        $atten["uriName"] = "新品发布";//如果将来有时间，专门做一个登陆的页面把
        $atten["title"] = "出错了";
        $atten["atten"] = $error;
        $atten["time"] = 50;
        $this->load->view("jump",$atten);
        $temp["text"] = $error.";目前所在的代码在".__LINE__."行，对应的用户为userId = ".$this->userId;
        $this->mwrong->insert($temp);
    }

    /**
     * 对后台上传数据时候的数据检查
     * 对本函数内的上传数据检验
     * @param array 包含了各种post输入信息的array；
     * @todo 库存应该分为1:一定量库存，2：无限库存，3：一定时间内最大量库存,目前实现前两种，第三种以后说
     */
    private function insert()
    {
        $data["title"] = trim($this->input->post("title"));
        if(strlen($data["title"]) == 0){
            $this->bgError("没有添加标题");
            return false;
        }
        $data["content"] = $this->input->post("cont");
        //只能是整数或者是两位小数,12或则是12.12,最大交易额不应该超过10万
        $data["price"] = trim($this->input->post("price"));
        if(!preg_match("/^\d+(.\d)?\d$/",$data["price"])){
            $this->bgError("请输入标准数字");
            return false;
        }
        // 必须是"12_1212.PNG|123_123.gif"的格式，userId_uploadTime.(gif|png|jpg)
        // 第二个preg_match是为了兼容之前的格式，正式上线的时候去掉
        $data["img"] = trim($this->input->post("Img"));
        if( ! (preg_match("/^\d+_\d+[\d_|.pngjif]*\.(png|jpg|gif)$/i",$data["img"]) || preg_match("/^\d+[\d|.jpg]*\.jpg$/",$data["img"]) ) ) {
            $this->bgError("忘记添加图片");
            return false;
        }
        $data["attr"] = trim($this->input->post("attr"));
        //如果包含下面的字符的话，则视为注入,这样的话，应该能防住很多的攻击了吧
        if(preg_match("/[\[\]\\\"\/?@=#&<>%$\{\}\\\~`^*]/",$data["attr"])){
            $this->bgError("请不要在商品属性中添加中英文之外的字符");
            return false;
        }
        // 在存储之前解码，判断格式的正确,如果可以正确的解码，表示没有问题，
        // 如果返回的是false，表示不可以，不符合规则
        if($data["attr"] && ( !$this->mitem->decodeAttr($data["attr"],0))){
            $this->bgError("请完整输入库存和对应的价格");
            return false;
        }
        //库存目前分为两种，一个是无限的，一个是定量的,无限的量为65535
        $data["store_num"] = trim($this->input->post("storeNum"));
        //1到5位数字，没有什么库存可以超过6万个，除非本来就是无限的，
        //不检验超过65535，可以在后台管理员定期检查这个,不涉及安全
        //其实可以通过int强制转码实现的，但是那样没有办法发现恶意提交，也没有办法对应用书的无意错误输入
        if(!preg_match("/^\d{1,5}$/" ,$data["store_num"])){
            $this->bgError("请在库存中输入数字");
            return false;
        }
        $data["promise"]   = trim($this->input->post("promise"));
        //只能包含中文英文数字|，不能包含空格，特殊字符
        if(preg_match("/[^\x{4e00}-\x{9fa5}a-z\d|]+/iu" ,$data["promise"])){
            $this->bgError("承诺中有不允许的特殊符号");
            return false;
        }
        $keys = trim($this->input->post("key"));
        $keys = preg_split("/[^\x{4e00}-\x{9fa5}0-9a-zA-Z]+/u",$keys);//以非汉字，数字，字母为分界点开始分割;
        $key  = trim($this->input->post("part"));
        $keys = $this->getrepeat($keys,$key);
        $key  = trim($this->input->post("keyj"));
        $keys = $this->getrepeat($keys,$key);
        $key  = trim($this->input->post("keyk"));//这些不进行检验是不安全的
        $keys = $this->getrepeat($keys,$key);
        $data["keys"] = $this->formate($keys);//以上是对关键字的处理
        return $data;
    }

    /**
     * 返回标题，价格，内容，分区
     * 在这里读取数据，检验数据，对输入信息判断的函数，因此两次添加修改的判断一样，合并
     */
    private function insertJudge()
    {

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

    /**
     * 整理数组，将数组变成A;B;的形似存储
     * @param array 想要转化成为字符串的数组
     * @return string
     */
    private  function formate($arr)
    {
        $temp = ";";
        for($i = 0,$len = count($arr); $i < $len;$i++){
            if($arr[$i]!="")
            $temp.=$arr[$i].";";
        }
        return $temp;
    }

    /**
     * 检查数组中有木有重复的，有就不添加，没有，就直接添加了。
     * @param array $arr 想要检验的数组
     * @param string $value 查找的值
     */
    private function getrepeat($arr,$value)
    {
        if(strlen($value)== 0)return $arr;
        $len = count($arr);
        for($i = 0; $i < $len;$i++){
            if($arr[$i] == $value)return $arr;
        }
        $arr[$len] = $value;
        return $arr;
    }

    /**
     * 商家添加数据使用那个，
     * 应该已经被废弃了
     */
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

    /**
     * 当商家填写的信息出错时，自动跳转，跳转前，返回给 view 出错的信息
     *
     * @param string $content  出错时，返回给 view 的信息
     * @param string $url      出错时，跳转到的页面的 url
     * @param string $urlName  出错时，跳转到的页面的 title
     */
    private function _errorJump($content, $url, $urlName) {
        $data['atten'] = $content;
        $data['uri'] = $url;
        $data['uriName'] = $urlName;
        $this->load->view("jump", $data);
    }

    /**
     * 用于判断用户提交的表单的内容是否为空，如果为空，跳转到相应的页面
     *
     * @param string $val      需要判断的变量
     * @param string $content  出错时，返回给 view 的信息
     * @param string $url      出错时，跳转到的页面的 url
     * @param string $urlName  出错时，跳转到的页面的 title
     * @return boolean         变量不为空，返回 false，否则返回 true
     */
    private function _isInputNull($val, $content, $url, $urlName) {
        if ($val != '') return false;
        $this->_errorJump($content, $url, $urlName);
        return true;
    }

    /**
     * 判断一个名字为 $fileName 的文件是否在 $dir 这个文件夹中
     *
     * @param $dir        需要存储的文件夹
     * @param $fileName   需要判断的文件名字
     * @return boolean    如果文件夹存在且文件在文件夹中存在，返回 true，否则返回 false
     */
    private function _isFileExit($dir, $fileName) {
        $handle = opendir($dir);
        if (! $handle) {
            return false;
        }
        while (($file = readdir($handle)) !== false) {
            if ($file == $fileName) {
                return true;
            }
        }
        return false;
    }

    private function _isIllegalString($val) {
        return preg_match("/[;|]+/", $val);
    }

    /**
     * 后台添加数据后的处理函数
     * 由 view 提供的数据应该包括：
     *     keyi           :     string      商品第一级关键字
     *     keyj           :     string      商品第二级关键字
     *     keyk           :     string      商品第三级关键字
     *     category       :     string      商品在本店中的分类
     *     price          :     float       商品单价
     *     mainThumbnail  :     string      商品主图，一个，保存在 image/"userId"/main
     *     attr           :     string      属性，用特殊的格式编码
     *     storeNum       :     int         库存
     *     thumbnail      :     string      商品图片，多个，用 '|' 分开，保存在 image/"userId"/thumb/big(在 small 中还有一份镜像)
     *     title          :     string      商品名字，一个
     *     detail         :     string      商品详细信息
     *
     * 由后台自己得到的数据应该包括：
     *     belongsTo      :     int         所属商店的 id 号码
     *
     * 说明：老板上传成功商品之后，跳转到该商品的商品详情页面
     * @todo 判断商品属性是否合法
     */
    public function bgAdd() {
        // 检查用户是否登陆以及权限是否足够
        if (! $this->_checkAuthority()) {
            return;
        }

        // 从 view 回收所有数据
        $data['keyi']          = trim($this->input->post('keyi'));
        $data['keyj']          = trim($this->input->post('keyj'));
        $data['keyk']          = trim($this->input->post('keyk'));
        $data['category']      = trim($this->input->post('category'));
        $data['price']         = trim($this->input->post('price'));
        $data['mainThumbnail'] = trim($this->input->post('mainThumbnail'));
        $data['attr']          = trim($this->input->post('attr'));
        $data['storeNum']      = trim($this->input->post('storeNum'));
        $data['thumbnail']     = trim($this->input->post('thumbnail'));
        $data['title']         = trim($this->input->post('title'));
        $data['detail']        = trim($this->input->post('detail'));

        // 由后台自己判断得到的数据
        $data['belongsTo']     = $this->session->userdata('storeId');

        // 设置用户填写商品信息出错时跳转的 url，和跳转页面的 title
        $url = site_url('bg/home/item');
        $urlName = '添加商品';

        // 判断返回的必须值是否为空
        if ($this->_isInputNull($data['keyi'], '第一级关键字不能为空', $url, $urlName)) return;
        if ($this->_isInputNull($data['keyj'], '第二级关键字不能为空', $url, $urlName)) return;
        if ($this->_isInputNull($data['keyk'], '第三级关键字不能为空', $url, $urlName)) return;
        if ($this->_isInputNull($data['category'], '商品在您商店中的关键字不能为空', $url, $urlName)) return;
        if ($this->_isInputNull($data['price'], '商品价格不能为空', $url, $urlName)) return;
        if ($this->_isInputNull($data['mainThumbnail'], '商品主图不能为空', $url, $urlName)) return;
        if ($this->_isInputNull($data['storeNum'], '商品库存不能为空', $url, $urlName)) return;
        if ($this->_isInputNull($data['thumbnail'], '商品图片不能为空', $url, $urlName)) return;
        if ($this->_isInputNull($data['title'], '商品名字不能为空', $url, $urlName)) return;
        if ($this->_isInputNull($data['detail'], '商品详细信息不能为空', $url, $urlName)) return;

        // 获取全局分类数组
        $categoryArray = $this->part;

        // 判断第一级关键字是否合法
        $flag = false;
        foreach ($categoryArray as $keyi => $vali) {
            if ($data['keyi'] == $keyi) $flag = true;
            if ($flag) break;
        }
        $flag = $flag && (! $this->_isIllegalString($data['keyi']));
        if (! $flag) {
            $this->_errorJump('第一级关键字不合法', $url, $urlName);
            return;
        }

        // 判断第二级关键字是否合法
        $flag = false;
        foreach ($categoryArray as $keyi => $vali) {
            if ($flag) break;
            foreach ($vali as $keyj => $valj) {
                if ($keyj == $data['keyj']) $flag = true;
                if ($flag) break;
            }
        }
        $flag = $flag && (! $this->_isIllegalString($data['keyj']));
        if (! $flag) {
            $this->_errorJump('第二级关键字不合法', $url, $urlName);
            return;
        }

        // 判断第三级关键字是否合法
        $flag = false;
        foreach ($categoryArray as $keyi => $vali) {
            if ($flag) break;
            foreach ($vali as $keyj => $valj) {
                if ($flag) break;
                foreach ($valj as $keyk => $valk) {
                    if ($valk == $data['keyk']) $flag = true;
                    if ($flag) break;
                }
            }
        }
        $flag = $flag && (! $this->_isIllegalString($data['keyk']));
        if (! $flag) {
            $this->_errorJump('第三级关键字不合法', $url, $urlName);
            return;
        }

        // 判断本店分类是否合法
        $stroeCategory = $this->store->getCategoryByStoreId($data['belongsTo']);
        $flag = false;
        foreach ($stroeCategory as $key => $val) {
            if ($val == $data['category']) $flag = true;
            if ($flag) break;
        }
        $flag = $flag && (! $this->_isIllegalString($data['category']));
        if (! $flag) {
            $this->_errorJump('本店分类不合法', $url, $urlName);
            return;
        }

        // 判断商品价格是否合法
        if (! preg_match("/\d[.\d]?\d/", $data['price'])) {
            $this->_errorJump('商品价格设置不合法', $url, $urlName);
            return;
        }

        // 判断商品主图片是否合法
        $dir = './image/' . $this->session->userdata('userId') . '/main';
        $flag = $this->_isFileExit($dir, $data['mainThumbnail']);
        if (! $flag) {
            $this->_errorJump('选择的商品主图片不合法', $url, $urlName);
            return;
        }

        // 判断商品属性是否合法，目前暂时不做

        // 判断商品库存是否合法
        if (! preg_match("/\d/", $data['storeNum'])) {
            $this->_errorJump('商品库存设置不合法', $url, $urlName);
            return;
        }

        // 判断商品图片是否合法，这个需要和前端商量接口和编码的问题
        $tmp = explode('|', $data['thumbnail']);
        $dir = './image/' . $this->session->userdata('userId') . '/thumb/big';
        foreach ($tmp as $key => $val) {
            $flag = $this->_isFileExit($dir, $val);
            if (! $flag) {
                $this->_errorJump('商品图片格式非法', $url, $urlName);
                return;
            }
        }

        // 判断商品标题是否合法，暂时不做

        // 判断商品详细信息是否合法，暂时不做

        // 经过重重难关，终于能够上传了！
        $itemId = $this->mitem->addItem($data);

        // 跳转到该商品的详情页面
        $url = site_url('item/index/' . $itemId);
        $urlName = '商品详情';
        $this->_errorJump('上传成功！', $url, $urlName);
    }

    /**
     * 编辑器自动上传图片的后台处理函数
     * 目前对应的是xhe函数，编辑器上传图片的后台处理部分，将来需要将大图片压缩成为小图片,目前集中精力处理重要部分吧
     * 应该是借鉴的别人的代码
     */
    public function imgAns()
    {
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
    /**
     * 计算文件大小的函数
     * @param int  $bytes 文件的大小比特
     */
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

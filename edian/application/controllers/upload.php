<?php
/**
 * upload controller 处理上传图片
 * ans_upload    继承自MY_Controller,处理一些配置
 * upload_insert 将上传的图片插入数据库,定义于model: img
 *
 * @author zmdyiwei<zmdyiwei@gmail.com>
 * @since  2013-11-20 18:23
 * @todo 对logo的处理，有待商榷，现在这个黑色的，好难看
 */
class Upload extends MY_Controller {

    // isBoss 用于判断是否具有老板权限，isAdmin 用于判断是否具有管理员权限
    protected $isBoss, $isAdmin, $userId;

    function __construct() {
        parent::__construct();
        $this->load->model('img');
        $this->load->config('edian');
        $this->load->model('user');
        $this->isAdmin = false;
        $this->isBoss = false;
        $this->userId = $this->getUserId();
    }

    /**
     * 检查用户是否具有老板或者管理员权限
     * @param string $url 如果没有登陆需要跳转的 url
     * @return boolean 如果有老板或者管理员权限，返回 true，否则返回 false
     * @author farmerjian<chengfeng1992@hotmail.com>
     * @since 2014-02-27 12:56:46
     */
    protected function _checkAuthority($url = false) {
        if ($url === false) {
            $url = site_url();
        }
        $this->isBoss = false;
        $this->isAdmin = false;
        // 用户未登录
        if ($this->userId === -1) {
            $this->isAdmin = false;
            $this->isBoss = false;
            $this->noLogin($url);
            return false;
        }
        $credit = $this->user->getCredit($this->userId);
        // 不是管理员或者老板权限
        if ($credit == $this->config->item('bossCredit')) {
            $this->isBoss = true;
            $this->isAdmin = false;
            return true;
        } else if ($credit == $this->config->item('adminCredit')) {
            $this->isBoss = false;
            $this->isAdmin = true;
            return true;
        } else {
            $this->isAdmin = false;
            $this->isBoss = false;
            return false;
        }
    }

    /**
     * 根据 path 创建文件夹，以 index.php 为参考点，例如：$path = 'image/56'
     * @param string $path
     * @author farmerjian<chengfeng1992@hotmail.com>
     */
    protected function _makeFolder($path = '') {
        $path = explode('/', $path);
        for ($i = 0, $len = (int)count($path), $cur = '.'; $i < $len; $i ++) {
            if (! is_dir($cur . '/' . $path[$i])) {
                mkdir($cur . '/' . $path[$i]);
            }
            $cur .= '/' . $path[$i];
        }
    }

    /**
     * 通过对文件类型的检查，判断上传的文件是否是图片
     * @param string $type 上传文件的类型，通过 $_FILES 获取
     * @return bool 如果是图片，返回 true，否则返回 false
     */
    protected function _isImg($type) {
        if ($type == 'image/gif') return true;
        if ($type == 'image/jpeg') return true;
        if ($type == 'image/pjpeg') return true;
        if ($type == 'image/png') return true;
        return false;
    }

    /**
     * 将给定的图片缩小成 w*h 的新图片并保存在相应文件夹中
     * @param int      $oldW        原始的图片的宽度
     * @param int      $oldH        原始的图片的高度
     * @param int      $newW        缩小后图片的宽度
     * @param int      $newH        缩小后图片的高度
     * @param string   $oldParh     原始的图片的存放地址
     * @param string   $newPath     缩小后图片的存放地址
     * @param string   $name        图片的名字
     * @param int      $flag        用于判断图片的格式：1 代表 jpg；2 代表 png；3 代表 gif
     */
    protected function _shrinkImage($oldW, $oldH, $newW, $newH, $oldPath, $newPath, $name, $flag) {
        // 确定原始图片和剪切后图片的路径
        $oldImage = $oldPath . '/' . $name;
        $newImage = $newPath . '/' . $name;

        // 得到原始图片的资源类型对象
        if ($flag == 1) {
            $srcImage = ImageCreateFromJpeg($oldImage);
        } else if ($flag == 2) {
            $srcImage = ImageCreateFromPng($oldImage);
        } else if ($flag == 3) {
            $srcImage = ImageCreateFromGif($oldImage);
        } else {
            return;
        }

        // 新建一个资源类型的剪切后图像对象，设置为真彩色
        $dstImage = ImageCreateTrueColor($newW, $newH);

        // 复制原始图像制定范围内的像素到新建图像中
        ImageCopyResized($dstImage, $srcImage, 0, 0, 0, 0, $newW, $newH, $oldW, $oldH);

        // 把新的到的图像保存
        if ($flag == 1) {
            ImageJpeg($dstImage, $newImage);
        } else if ($flag == 2) {
            ImagePng($dstImage, $newImage);
        } else if ($flag == 3) {
            ImageGif($dstImage, $newImage);
        }
    }

    /**
     * 自动跳转，跳转前，返回给 view 出错的信息
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
     * 显示上传商品图片的具体页面，传递给 view 处理上传的图片的处理函数
     * @param int $flag
     *              $flag 为 1 表示上传的是 1:1 的 mainThumbnail
     *              $falg 为 2 表示上传到mis文件夹中的图片，目前针对的是logo
     *              $flag 为 0 的情况是商品的缩略图的文件
     */
    public function index($flag = 0) {
        // 用户没有登录
        $userId = $this->getUserId();
        if ($userId == -1) {
            $this->load->view('login');
            return;
        }

        // 不同情况下选择不同的后台处理函数
        if($flag == 1) {
            $data["url"] = site_url("upload/imgMain");
        } else if ($flag == 0) {
            $data["url"] = site_url("upload/thumb");
        } else if ($flag == 2) {
            $data['url'] = site_url('upload/uploadStoreLogo');
        }
        $this->load->view('uploadImg', $data);
    }

    /**
     * 删除图片
     * @param string $imageName 图片的名字
     * @todo imageName false的时候应该返回，而不是应该什么都不管，这样为false还有什么意义码？
     * @todo unlink 具体看下面的错误
     */
    public function imgDelete($imageName = false) {
        // 用户没有登录
        if ($this->getUserId() == -1) {
            $this->load->view('login');
            return;
        }

        // 如果是 ajax 调用，设置 imageName
        if ($imageName == false) {
            $imageName = './image/' . trim($this->input->post('imageName'));
        }

        // 删除图片
        if (file_exists($imageName)) {
            unlink($imageName);
        }
    }

    /**
     * 对 mainThumbnail 上传，通过 post 方式提交回来的变量名为 userfile
     * 对 mainThumbnail 的要求：
     *     长宽比为 1:1
     *     最少为 400*400 像素
     *     文件不得大于 5Mb
     */
    public function imgMain() {
        // 用户没有登录
        $userId = $this->getUserId();
        if ($userId == -1) {
            $this->load->view('login');
            return;
        }

        // 用户的权限不够
        if ($this->_checkAuthority() == false) {
            show_404();
            return;
        }

        // 跳转的 url 和 urlName
        $url = site_url('upload/index/1');
        $urlName = '上传图片';

        // 获取文件的类型和大小
        $type = $_FILES['userfile']['type'];
        $size = $_FILES['userfile']['size'];

        // 上传的文件格式非法
        if (! $this->_isImg($type)) {
            $info = "文件格式非法";
            $this->_errorJump($info, $url, $urlName);
            return;
        }

        // 上传的文件太大
        if ($size > $this->config->item('imageSize')) {
            $info = "图片太大";
            $this->_errorJump($info, $url, $urlName);
            return;
        }

        // 对上传的文件进行重命名
        $fileName = $userId . '_' . date('Y-m-d_H-i-s');
        if ($type == 'image/gif') {
            $fileName .= '.gif';
        } else if ($type == 'image/png') {
            $fileName .= '.png';
        } else {
            $fileName .= '.jpg';
        }
//
//        // 创建 image/"userId"
//        if (! is_dir('./image/' . $userId)) {
//            mkdir('./image/' . $userId);
//        }
//
//        // 创建 image/"userId"/main 文件夹
//        if (! is_dir('./image/' . $userId . '/main')) {
//            mkdir('./image/' . $userId . '/main');
//        }

        $path = 'image/' . $userId . '/main';
        $this->_makeFolder($path);

        // 定义用户上传的图片的存储地址和名字
        $path = './' . $path . '/' . $fileName;

        // 上传图片
        move_uploaded_file($_FILES['userfile']['tmp_name'], $path);

        // 获得图片的 size
        $imageSize = getimagesize($path);

        // 上传的主图片必须满足长宽比为 1:1，且 长度不得小于 300 像素
        if ($imageSize[0] != $imageSize[1]) {
            $this->imgDelete($path);
            $info = "图片长宽比必须为 1:1";
            $this->_errorJump($info, $url, $urlName);
            return;
        }
        if ($imageSize[0] < $this->config->item('mainLength')) {
            $this->imgDelete($path);
            $info = "图片宽度不能小于 300px";
            $this->_errorJump($info, $url, $urlName);
            return;
        }
        $url = base_url('image/' . $userId . '/main/' . $fileName);
        $info = "<input type = 'hidden' name = 'value' id = 'value' value = ".$url." />";
        echo($info);
        $this->index(1);
    }

    /**
     * 对 thumbnail 上传，通过 post 方式提交回来的变量名为 userfile
     * 对 thumbnail 的要求：
     *     文件不得大于 300kb
     *     短边长度不得小于 700，长边:短边 <= 2，缩小成两份图片，一份的短边为 700 存在 big 里面，一份的短边为 400 存在 small 里面
     */
    public function thumb() {
        // 用户没有登录
        $userId = $this->getUserId();
        if ($userId == -1) {
            $this->load->view('login');
            return;
        }

        // 用户权限不够
        if ($this->_checkAuthority() == false) {
            show_404();
            return;
        }

        // 获取文件的类型和大小
        $type = $_FILES['userfile']['type'];
        $size = $_FILES['userfile']['size'];

        // 跳转页面的 url 和 urlName
        $url = site_url('upload/index/0');
        $urlName = '上传图片';

        // 上传的文件格式非法
        if (! $this->_isImg($type)) {
            $info = "文件格式非法";
            $this->_errorJump($info, $url, $urlName);
            return;
        }

        // 上传的文件太大
        if ($size > $this->config->item('imageSize')) {
            $info = "图片太大";
            $this->_errorJump($info, $url, $urlName);
            return;
        }

        // 对上传的文件进行重命名
        $fileName = $userId . '_' . date('Y-m-d_H-i-s');
        if ($type == 'image/gif') {
            $fileName .= '.gif';
            $flag = 3;
        } else if ($type == 'image/png') {
            $fileName .= '.png';
            $flag = 2;
        } else {
            $fileName .= '.jpg';
            $flag = 1;
        }

//        // 创建 image/"userId" 文件夹
//        if (! is_dir('./image/' . $userId)) {
//            mkdir('./image/' . $userId);
//        }
//        // 创建 image/"userId"/thumb 文件夹
//        if (! is_dir('./image/' . $userId . '/thumb')) {
//            mkdir('./image/' . $userId . '/thumb');
//        }
//        // 创建 image/"userId"/thumb/big 文件夹
//        if (! is_dir('./image/' . $userId . '/thumb/big')) {
//            mkdir('./image/' . $userId . '/thumb/big');
//        }
//        // 创建 image/"userId"/thumb/small 文件夹
//        if (! is_dir('./image/' . $userId . '/thumb/small')) {
//            mkdir('./image/' . $userId . '/thumb/small');
//        }

        $path = 'image/' . $userId . '/thumb/big';
        $this->_makeFolder($path);
        $path = 'image/' . $userId . '/thumb/small';
        $this->_makeFolder($path);

        // 定义用户上传的图片的存储地址和名字
        $path = './image/' . $userId . '/' . $fileName;

        // 上传图片
        move_uploaded_file($_FILES['userfile']['tmp_name'], $path);

        // 获得图片的 size
        $imageSize = getimagesize($path);
        $oldW = $imageSize[0];
        $oldH = $imageSize[1];

        // 上传的图片的短边必须大于 700，且长边:短边 <=2
        if (min($oldW, $oldH) < $this->config->item('bigLength')) {
            $this->imgDelete($path);
            $info = "图片的最小宽度不能小于 700px";
            $this->_errorJump($info, $url, $urlName);
            return;
        } else if (max($oldW, $oldH) / min($oldW, $oldH) > 2) {
            $this->imgDelete($path);
            $info = "图片的 长:宽 不能大于 2";
            $this->_errorJump($info, $url, $urlName);
            return;
        }

        // 确定原始图片的存放地址
        $oldPath = './image/' . $userId;

        // 确定存到 big 文件夹中的图片的 w 和 h
        if ($oldW > $oldH) {
            $newW = $this->config->item('bigLength');
            $newH = $oldH / $oldW * $newW;
        } else {
            $newH = $this->config->item('bigLength');
            $newW = $oldH / $oldW * $newH;
        }

        // 对原始图片进行缩小，并存放进 image/"userId"/thumb/big 文件夹中
        $newPath = './image/' . $userId . '/thumb/big';
        $this->_shrinkImage($oldW, $oldH, $newW, $newH, $oldPath, $newPath, $fileName, $flag);

        // 确定存到 small 文件夹中的图片的 w 和 h
        if ($oldW > $oldH) {
            $newW = $this->config->item('smallLength');
            $newH = $oldH / $oldW * $newW;
        } else {
            $newH = $this->config->item('smallLength');
            $newW = $oldH / $oldW * $newH;
        }

        // 对原始图片进行缩小，并存放进 image/"userId"/thumb/small 文件夹中
        $newPath = './image/' . $userId . '/thumb/small';
        $this->_shrinkImage($oldW, $oldH, $newW, $newH, $oldPath, $newPath, $fileName, $flag);

        // 删除原始图片
        $this->imgDelete($path);

        $url = base_url('image/' . $userId . '/thumb/small/' . $fileName);
        $info = "<input type = 'hidden' name = 'value' id = 'value' value = ".$url." />";
        echo($info);
        $this->index(0);
    }

    public function uploadStoreLogo() {
        // 用户没有登录
        $userId = $this->getUserId();
        if ($userId == -1) {
            $this->load->view('login');
            return;
        }

//        // 用户权限不够
//        if ($this->_checkAuthority() == false) {
//            show_404();
//            return;
//        }

        // 跳转页面的 url 和 urlName
        $url = site_url('upload/index/2');
        $urlName = '上传图片';

        // 获取文件的类型和大小
        $type = $_FILES['userfile']['type'];
        $size = $_FILES['userfile']['size'];

        // 上传的文件格式非法
        if (! $this->_isImg($type)) {
            $info = "文件格式非法";
            $this->_errorJump($info, $url, $urlName);
            return;
        }

        // 对上传的文件进行重命名
        $fileName = $userId . '_' . date('Y-m-d_H-i-s');
        if ($type == 'image/gif') {
            $fileName .= '.gif';
            $flag = 3;
        } else if ($type == 'image/png') {
            $fileName .= '.png';
            $flag = 2;
        } else {
            $fileName .= '.jpg';
            $flag = 1;
        }

//        // 创建 image/"userId" 文件夹
//        if (! is_dir('./image/' . $userId)) {
//            mkdir('./image/' . $userId);
//        }
//        // 创建 image/"userId"/mix 文件夹
//        if (! is_dir('./image/' . $userId . '/mix')) {
//            mkdir('./image/' . $userId . '/mix');
//        }

        $path = 'image/' . $userId . '/mix';
        $this->_makeFolder($path);

        // 定义用户上传的图片的存储地址和名字
        $path = './image/' . $userId . '/' . $fileName;

        // 上传图片
        move_uploaded_file($_FILES['userfile']['tmp_name'], $path);

        // 获得图片的 size
        $imageSize = getimagesize($path);
        $oldW = $imageSize[0];
        $oldH = $imageSize[1];

        // 确定原始图片的存放地址
        $oldPath = './image/' . $userId;

        // 确定存到 mix 文件夹中的图片的 w 和 h
        $newW = $this->config->item('storeLogoW');
        $newH = $this->config->item('storeLogoH');

        // 对原始图片进行缩小，并存放进 image/"userId"/mix 文件夹中
        $newPath = './image/' . $userId . '/mix';
        $this->_shrinkImage($oldW, $oldH, $newW, $newH, $oldPath, $newPath, $fileName, $flag);

        // 删除原始图片
        $this->imgDelete($path);

        $url = base_url('image/' . $userId . '/mix/' . $fileName);
        $info = "<input type = 'hidden' name = 'value' id = 'value' value = ".$url." />";
        echo($info);
    }

    /**
     * 这里是zmdyiwei 为上传写的函数，
     * @param  int $height 上传图片的高度
     * @param  int $width 上传图片的宽度
     */
    function upload_config($height = -1,$width = -1){
        //对上传进行处理的函数，去掉了jump的部分，使它更富有扩展性
        //返回数据格式为数组，flag,0,标示没有错误,1,没有登陆，2，图片重复,3,没有上传，4，其他原因
        $re["flag"] = 1;
        $user_id=$this->getUserId();
        if($user_id == false){
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

    /**
    * 这里上传的是之前的有关键字和索引的图片
    */
    function upload_picture() {
        $user_id = $this->getUserId();
        $re = $this->upload_config();
        $re['category'] = $this->input->post('category');
        $re['key_word'] = $this->input->post('key_word');
        $data["uri"] = site_url("upload/index");
        $data["uriName"] = "上传图片";//不管胜利或者失败，家总是要回去的
        if($re["flag"]){
            $data["atten"] = $re["atten"];
            $data["title"] = "上传失败";
            $data["time"] = 5;
            $this->load->view("jump",$data);
        } else{
            $res=$this->img->upload_insert($re['file_name'], $re["upload_name"], $re['category'], $re['key_word'], $user_id);
            $data["atten"]= "上传成功";
            $data["title"] = "上传成功";
            $data["time"] = 3;
            $data["value"] = $this->imgPath."/".$re["file_name"];
            $this->load->view("jump2",$data);
        }
    }
}
?>

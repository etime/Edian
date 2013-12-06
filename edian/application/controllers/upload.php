<?php
/**
 * upload controller 处理上传图片
 * ans_upload    继承自MY_Controller,处理一些配置
 * upload_insert 将上传的图片插入数据库,定义于model: img
 *
 * @author zmdyiwei<zmdyiwei@gmail.com>
 * @since  2013-11-20 18:23
 */
class Upload extends MY_Controller {

    /**
     * imgMain /thumb 功能如此接近的上传函数，居然没有复用
     * @author      unasm
     */
    function __construct() {
        parent::__construct();
        $this->load->model('img');
    }

    /**
     * 通过对文件类型的检查，判断上传的文件是否是图片
     * @param string $type 上传文件的类型，通过 $_FILES 获取
     * @return bool 如果是图片，返回 true，否则返回 false
     */
    private function _isImg($type) {
        if ($type == 'image/gif') return true;
        if ($type == 'image/jpeg') return true;
        if ($type == 'image/pjpeg') return true;
        if ($type == 'image/png') return true;
        return false;
    }

    /**
     * 显示上传商品图片的具体页面，传递给 view 处理上传的图片的处理函数
     * @param int $flag $flag 为 1 表示上传的是 1:1 的 mainThumbnail，否则为其他情况
     */
    public function index($flag = 0) {
        // 用户没有登录
        $userId = $this->getUserId();
        if ($userId == -1) {
            $this->load->view('login');
            return;
        }

        // 不同情况下选择不同的后台处理函数
        if($flag) {
            $data["url"] = site_url("upload/imgMain");
        } else {
            $data["url"] = site_url("upload/thumb");
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
            ;
        }

        // 删除图片
        /*
         * 我只是给了你名字而已，还有路径呢,这个要根据我们制订的保存规则删除
         */
        if (file_exists($imageName)) {
            unlink($imageName);
        }
    }

    /**
     * 对 mainThumbnail 上传，通过 post 方式提交回来的变量名为 userfile
     * 对 mainThumbnail 的要求：
     *     长宽比为 1:1
     *     最少为 300*300 像素
     *     文件不得大于 300kb
     */
    public function imgMain() {
        // 用户没有登录
        $userId = $this->getUserId();
        if ($userId == -1) {
            $this->load->view('login');
            return;
        }

        // 获取文件的类型和大小
        $type = $_FILES['userfile']['type'];
        $size = $_FILES['userfile']['size'];

        // 上传的文件格式非法
        if (! $this->_isImg($type)) {
            $this->index(1);
            return;
        }

        // 上传的文件太大
        if ($size > 300 * 1024) {
            $this->index(1);
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
        // 创建用户文件夹
        if (! is_dir('./image/' . $userId)) {
            mkdir('./image/' . $userId);
        }

        // 定义用户上传的图片的存储地址和名字
        $path = './image/' . $userId . '/' . $fileName;

        // 上传图片
        move_uploaded_file($_FILES['userfile']['tmp_name'], $path);

        // 获得图片的 size
        $imageSize = getimagesize($path);

        // 上传的主图片必须满足长宽比为 1:1，且 长度不得小于 300 像素
        if ($imageSize[0] != $imageSize[1] || $imageSize[0] < 300) {
            $this->imgDelete($path);

            $this->index(1);
            return;
        }

        echo('your uploaded file has stroed !<br>');
    }

    /**
     * 对 thumbnail 上传，通过 post 方式提交回来的变量名为 userfile
     * 对 thumbnail 的要求：
     *     文件不得大于 300kb
     */
    public function thumb() {
        // 用户没有登录
        $userId = $this->getUserId();
        if ($userId == -1) {
            $this->load->view('login');
            return;
        }

        // 获取文件的类型和大小
        $type = $_FILES['userfile']['type'];
        $size = $_FILES['userfile']['size'];

        // 上传的文件格式非法
        if (! $this->_isImg($type)) {
            $this->index(0);
            return;
        }

        // 上传的文件太大
        if ($size > 300 * 1024) {
            $this->index(0);
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

        // 创建用户文件夹
        if (! is_dir('./image/' . $userId)) {
            mkdir('./image/' . $userId);
        }

        // 定义用户上传的图片的存储地址和名字
        $path = './image/' . $userId . '/' . $fileName;

        // 上传图片
        move_uploaded_file($_FILES['userfile']['tmp_name'], $path);

        echo('your uploaded file has stroed !<br>');
    }

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
    function upload_picture()
    {
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

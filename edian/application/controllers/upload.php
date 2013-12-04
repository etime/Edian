<?php
/**
 * upload controller 处理上传图片
 * ans_upload    继承自MY_Controller,处理一些配置
 * upload_insert 将上传的图片插入数据库,定义于model: img
 * @author zmdyiwei<zmdyiwei@gmail.com>
 * @since  2013-11-20 18:23
 */

class Upload extends MY_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('img');
    }
    /**
     * 显示具体的页面，view
     * @param int $flag 当flag为1的时候，页面对应的action为上传1：1主图，其他的情况，上传不比例
     */
    function index($flag = 0)
    {
        if($flag){
            $data["url"] = site_url("upload/imgMain");
        }else $data["url"] = site_url("imgpicture");//不同情况下对应的后台处理url
        $this->load->view('uploadImg',$data);
    }
    /**
     *  对mainThumbnail上传，1:1的图片
     */
    public function imgMain()
    {
    }
    /**
     *  对不分比例的图片进行上传
     */
    public function imgpicture()
    {
    }
    /**
     * 通过传入一个图片的的名字，删除这个图片
     * 检查是否登录，删除使用unlink
     */
    public function imgDelete($imgName  = false)
    {
    }
    function upload_config($height = -1,$width = -1){
        //对上传进行处理的函数，去掉了jump的部分，使它更富有扩展性
        //返回数据格式为数组，flag,0,标示没有错误,1,没有登陆，2，图片重复,3,没有上传，4，其他原因
        $re["flag"] = 1;
        $user_id=$this->user_id_get();
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
        $user_id = $this->user_id_get();
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

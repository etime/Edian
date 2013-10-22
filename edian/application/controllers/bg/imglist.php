<?php
//class Imglist extends Chome{
class Imglist extends MY_Controller{
    var $imgUrl = "/var/www/html/edian/edian/upload/";
    var $thumbImg = "/var/www/html/edian/edian/thumb/";
    var $user_id,$ADMIN;
    function __construct()              {
        parent::__construct();
        $this->user_id = $this->user_id_get();
        $this->load->model("img");
        $this->ADMIN = 3;
        $this->load->model("user");
        $this->type = $this->user->getType($this->user_id);
        /*
                $this->load->library('image_lib');
         */
    }
    function  index(){
        //显示一个用户所有的图片
        if(!$this->user_id){
            echo "请登录";
            return;
        }
        //要不要添加浏览全部图片的设定呢？
        $data['imgall']=$this->img->userImgAll($this->user_id);
        /*
         * 这里暂时设定显示所有的图片，将来如果用户增多的话，就设置成为根据用户id显示图片
         */
        $this->load->view("m-bg-imglist",$data);
    }
    function oneimg($imgname){
        $data['imgname']=$imgname;
        $this->load->view("m-bg-showimg",$data);
    }
    function imgdel($imgId  = "",$img_name = ""){
        /*
         *这里/var/www/ci/upload真是太原始,将来要通过全局变量的形式,改成例如baseurl的形式
         */
        if($imgId && $img_name && ( $this->type == $this->ADMIN)){
            if($this->img->imgdel($imgId)){
                //      $res=unlink(base_url("upload")."/".$img_name);
                unlink($this->imgUrl.$img_name);
                unlink($this->thumbImg.$img_name);
            }
        }else{
            echo __LINE__."行有问题出现,请联系开发者";
            return;
        }
    }
    function test($time,$url,$content){
        $data['time']=$time;
        $data['url']=$url;
        $data['content']=$content;
        $this->load->view("m-selfjump",$data);
    }
    function user_photo(){
        /*
         * 目前作为一个模块，将来嵌套进入网站的模块
         */
        if($this->input->post("sub")){
            $config['max_size']='2000000';
            $config['max_width']='1024';
            $config['max_height']='800';
            $config['allowed_types']='gif|jpg|png|jpeg';//即使在添加PNG JEEG之类的也是没有意义的，这个应该是通过php判断的，而不是后缀名
            $config['upload_path']='./upload/';
            $this->load->model("mhome");
            $upload_name=$_FILES['userfile']['name'];
            /*
             * 当图片名称超过100的长度的时候，就会出现问题，为了系统的安全，所以需要在客户端进行判断
             */
            if($this->mhome->judgesame($upload_name)){
                $data['attention']="您已经提交过同名图片了";
            }
            else {
                $this->load->library("upload",$config);
                if(!$this->upload->do_upload()){
                    $data['attention'] = $this->upload->display_errors()."请选择图片文件，保持宽度在1024高度在800之间，大小请不要超过2M";
                }
                else {
                    $temp=$this->upload->data();
                    $res=$this->mhome->mupload($temp['file_name'],2);
                    /*
                     * 这里的2将来要修改成为用户的id
                     */
                    $data['attention']= "上传成功";
                }
            }
        }
        $this->load->view("vupload.php",$data);
    }
    public function thumb_add($path){
        //生成缩小图的函数
        $config['image_library']='gd2';
        $config['source_image']=$path;
        $config['create_thumb']=true;
        $config['maintain_ratio']=true;
        $config['width']=100;
        $config['height']=150;
        $this->load->library('image_lib',$config);
        $this->image_lib->resize();
    }
}
?>

<?php
/**
 *  这里对应后台的入口函数
 *  这里是后台管理显示的入口，很多具体class的入口都在这里
 * @author          unasm<1264310280@qq.com>
 * @since           2013-06-11 10:39:28
 * @name            sea.php
 * @package         bg_controller
 */
class Imglist extends MY_Controller{
    /** img大图片的保存路径 */
    var $imgUrl = "/var/www/html/edian/edian/upload/";
    /** 缩略图的保存路径 */
    var $thumbImg = "/var/www/html/edian/edian/thumb/";
    var $user_id,$ADMIN;
    function __construct()              {
        parent::__construct();
        $this->user_id = $this->user_id_get();
        $this->load->model("img");
        $this->load->model("user");
        $this->type = $this->user->getType($this->user_id);
    }
    /**
     * 当初设计的时候，是为了浏览大图片而准备的
     * @param string $imgname  硬盘上面的图片名字
     */
    function oneimg($imgname){
        $data['imgname']=$imgname;
        $this->load->view("m-bg-showimg",$data);
    }
    /**
     *  删除具体的图片,抹除它的存在
     *  @param int      $imgId img      保存时候的id,为了从数据库删除
     *  @param string   $img_name img   保存得硬盘上面的名字,为了从硬盘上删除
     *  @todo 这里/var/www/ci/upload真是太原始,将来要通过全局变量的形式,比如通过DOCUMENT__ROOT的形式
     */
    public function imgdel($imgId  = "",$img_name = ""){

        $this->load->config("edian");
        if($imgId && $img_name && ( $this->type == $this->config->item("ADMIN"))){
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

		/*
		 * search函数完成图片搜索功能，返回图片数据信息到view
		 */
		function search()
		{
			  $this->load->model("img");

        $data['imgall']= $this->img->get_search();
        $this->load->view("m-bg-imglist",$data);
		}
    /*
     *  应该已经被废弃了
     *  上传图片的检测函数
     */
    private function user_photo(){

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
    /**
     * 生成缩小图的函数
     * 应该已经被废弃了
     */
    public function thumb_add($path){
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

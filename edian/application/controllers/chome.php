<?php
/*
 * 在下面的thumb函数中有一处使用了绝对路径的地方，将来更改的时候要注意，如果学会了如何读取config的话，可以替换掉。
 * 下面包括的函数包括上传处理，编辑器使用以及插入文章，分页，和缩小图片的生成
 * 上传的内容要从这里拆分出去，独立成一个class
 * 有点好奇，这个class还有保存的价值嘛？,吐槽一下，貌似只有关于上传的有用了
 * */
class Chome extends MY_Controller{
    var $max_img_height,$max_img_width,$img_save_path;
    function __construct(){
        parent::__construct();

        $this->load->helper(array('form'));
        $this->load->model('mhome');
        $this->load->model("img");
    }

    function index(){
        $data['title'] = $this->mhome->home_title();
        $this->load->view('home',$data);
    }

   function bubble(){
        $this->load->view("bubble")             ;
    }

    function editor(){
        //这个函数是和edian数据库项符合的
        $this->load->library("ckeditor");
        $this->ckeditor->basePath=base_url().'ckeditor/';
        $this->ckeditor->Width="100";
        $this->ckeditor->Height="100";
        //$this->load->view("veditor");
        $cont="hello,here is ckeditor /chome/eidtor/";
        $data["cke"]=$this->ckeditor;
        $this->load->view("veditor",$data);
        //  $this->ckeditor->editor('content',$cont);
    }
    function reditor(){
        //这个函数是和edian数据库项符合的
        $title=$this->input->post("title");
        $cont=$this->input->post("content");
        $part_id=$this->input->post("part_id");
        $user_id=$this->input->post("user_id");//user_id不能这麽取得
        $time=$this->input->post("time");
        $this->load->model("art");
        $value=time();
        for($i = 0; $i < $time ;$i++){
            $re=$this->art->insert_art($title,$cont,$part_id,$user_id,$value);
            if($re)echo "<br/>insert into success;<br/>";
            else echo "<br/>发表失败``<br/>";
        }
    }
    function listart(){
        /*
         * 这个应该是分页函数
         */
        $this->load->library("pagination");
        $config['base_url']='http://localhost/index.php/chome/config/';
        $config['per_page']=2;
        $config['first_link']="首页";
        $config['prev_link']="上一页";
        $config['next_link']="下一页";
        $config['last_link']="尾页";
        $config['num_links']=3;
        $id=$this->uri->segment(3);
        if(!$id){
            $id=1;
        }
        $id--;
        $this->load->model("mar_list");
        $cont_page=$this->mar_list->list_perpage(2,$id,2);
        foreach($cont_page as $temp){
            echo $temp->title."  --------------".$temp->time."<br/>";
        }
        $ans=$this->mar_list->listall(2);
        $config['total_rows']=count($ans);
        //$config['total_rows']=20;
        //$config['use_page_numbers']=true;
        $this->pagination->initialize($config);
        echo $this->pagination->create_links();
        $this->load->view("artlist");
    }

    //下面该函数的作用是显示图片在m-showimg上面
    function showimg($id){
        //  $this->load->model("mhome") ;
        $data['name']=$this->mhome->getImgName($id);
        $data['id']=$id;
        $this->load->view('m-showimg',$data);
    }
    /*
    function test(){
        $this->load->view("common_head");
        $this->showimg(8);
        $this->load->view("common_foot");
    }
     */
}
?>

<?php
class Home extends MY_Controller{
    var $ADMIN,$SELLER;
    function __construct()              {
        parent::__construct()               ;
        $this->load->model("bghome");
        $this->load->model("user");
        $this->user_id = $this->user_id_get();
        $this->ADMIN = 3;
        $this->SELLER = 1;
    }
    function  index(){
        //echo "hello ,here is the bg/home.php ";
        //这里显示的应该是第三版本的后台的页面,通过div布局和iframe的页面
        if(!$this->user_id){
            $this->noLogin();
            return;
        }
        $data["type"] = $this->user->getType($this->user_id);
        $data["ADMIN"] = $this->ADMIN;
        $data["SELLER"] = $this->SELLER;
        $this->load->view("bghome",$data);
    }
    public function index2()
    {
        $this->load->view("bghome2");
    }
    function index_test(){
        //这里显示的是第二版本的页面，使用framset实现的大致还让人满意的布局
        $this->load->view("bghome_test");
    }
    function head(){
        $this->load->view("m-bghead");
        //echo "<h1>这里是管理员后台,正在建设中,请加油!!</h1>";
    }
    function leftdiruser(){
        $this->load->view("m-bg-home-leftdir-user");
    }
    function leftdirimg(){
        $this->load->view("m-bg-home-leftdir-img");
    }
    function leftdirart(){
        $this->load->view("m-bg-home-leftdir-art");
    }
    function content(){
        $this->load->view("m-bg-home-content");
    }
    function artlist(){
        $data['title']="文章列表";
        $data['allart']=$this->bghome->artlist_all();
        $this->load->view("m-bg-artlist2",$data);
        //$this->load->view("m-bg-home-artlist3",$data);
    }
    function  artdelete($id){
        $this->bghome->artdel($id);
        return $this->db->affected_rows();
        /*
         * 依照我本意,期望能够能够有一个返回值 ,不过后期可以通过使用affect_num决定给前端一个提醒
         */
    }
    function artchange($id){
        $this->load->library("ckeditor")    ;
        $this->ckeditor->basePath=base_url().'ckeditor/';
        $this->ckeditor->Width="100";
        $this->ckeditor->Height="400";
        $data['cont']=$this->bghome->getArtById($id);
        $data['cke']=$this->ckeditor;
        $this->load->view("bgeditor",$data);
    }
    function  reditor($id){
        $this->load->model("meditor");
        $this->meditor->artchange($id);
        redirect(site_url('bg/home/artlist'));
    }
    function artshow($id){
        $data['art']=$this->bghome->getArtById($id);
        //  var_dump($data);
        $this->load->view("m-bg-artshow",$data);
    }
    function itemadd(){
        if(!$this->user_id){
            $this->noLogin();
            return;
        }
        $data['title']="添加文章";
        $data["dir"] = $this->part;
        $data["userType"] = $this->user->getType($this->user_id);
        $this->load->model("img");
        $data["img"] = $this->img->getImgName($this->user_id);
        $this->load->view("mBgItemAdd",$data);
    }
    public function noLogin()
    {
        $data["url"] = site_url("bg/home");
        //redirect(site_url("reg/login/"));
        $this->load->view("login",$data);
    }
    function comment(){
        $data['title']="评论模块";
        $this->load->view("m-comment",$data)                ;
    }
    function set()
    {
        //这里是添加商城设置的地方，就是需要，但是又不必在注册时候的信息,
        //营业时间，dtu，起送价，店家公告等
        if(!$this->user_id){
            $this->noLogin();
            return ;
        }
        $data = $this->user->getExtro($this->user_id);//获取之前的类型
        $data["type"] = $this->user->getType($this->user_id);//获取用户的类型，方便差异化处理
        $this->load->view("bgHomeSet",$data);
    }
    public function setAct(){
        if($_POST["sub"]){
            $data = $this->user->getExtro($this->user_id);//获取之前的类型
            $data["dtuName"] = trim($this->input->post("dtuName"));
            $data["intro"] = trim($this->input->post("intro"));
            $data["lestPrc"] = trim($this->input->post("lestPrc"));
            $sms = trim($this->input->post("smsOrd"));
            if($sms){
                $data["smsOrd"] = 1;
            }else $data["smsOrd"] = 0;
            $dtuNum = trim($this->input->post("dtuNum"));
            $userId = trim($this->input->post("user_id"));
            $dtuId = trim($this->input->post("dtuId"));
            //dtuNUm,userId,dtuId要单独处理，不是权限有问题
            if($dtuId)
            {
                //如果可以修改id，则证明为管理员，可以修改NUm，不然没有这个权限，只可以浏览
                $data["dtuId"] = $dtuId;
                if($dtuNum) $data["dtuNum"] = $dtuNum;
            }
            if($userId){
                $flag = $this->user->insertExtro($data,$userId);
                if($flag)redirect(site_url("bg/home/set"));
                else echo "插入失败";
            }
            else{
                $flag = $this->user->insertExtro($data,$this->user_id);
                if($flag)redirect(site_url("bg/home/set"));
                else echo "插入失败";
            }
        }
    }
}
?>

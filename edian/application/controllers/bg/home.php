<?php
/**
 *  这里对应后台的入口函数
 *  这里是后台管理显示的入口，很多具体class的入口都在这里
 * @author          unasm<1264310280@qq.com>
 * @since           2013-06-11 10:39:28
 * @name            sea.php
 * @package         bg_controller
 */
class Home extends MY_Controller{
    var $user_id;
    function __construct(){
        parent::__construct();
        $this->load->model("bghome");
        $this->load->model("user");
        $this->user_id = $this->user_id_get();
    }
    //这里显示的应该是第三版本的后台的页面,通过div布局和iframe的页面
    function  index(){
        if(!$this->user_id){
            $this->noLogin();
            return;
        }
        $data["type"] = $this->user->getType($this->user_id);
        $this->load->config("edian");//读取admin和seller对应的配置
        $data["ADMIN"] = $this->config->item("ADMIN");
        $data["SELLER"] = $this->config->item("SELLER");
        $this->load->view("bghome",$data);
    }
    /**
     * 处理没有登录的情况
     */
    public function noLogin()
    {
        $data["url"] = site_url("bg/home");
        //redirect(site_url("reg/login/"));
        $this->load->view("login",$data);
    }
    /**
     * 商城设置的入口函数
     * 这里是添加商城设置的地方，就是需要，但是又不必在注册时候的信息,
     * 营业时间，dtu，起送价，店家公告等
     * 具体的操作处理在set 这个php里面
     */
    public function set()
    {
        if(!$this->user_id){
            $this->noLogin();
            return ;
        }
        $data = $this->user->getExtro($this->user_id);//获取之前的类型
        $data["type"] = $this->user->getType($this->user_id);//获取用户的类型，方便差异化处理
        $this->load->view("bgHomeSet",$data);
    }
    /**
     * 添加商品的入口函数
     * 显示view,添加商品的view函数，对应的后台处理在item这个class里面，这里只是入口
     */
    public function item(){
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
}
?>

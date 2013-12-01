<?php
/**
 *  这里对应后台的入口函数
 *  这里是后台管理显示的入口，很多具体class的入口都在这里
 *  其他入口不再这里的有
 *  <pre>
 *      order/ontime  待处理订单
 *      order/Today   今日订单
 *      order/hist    历史订单
 *      item/mange    商品的管理
 *      item/itemCom  item_Comment 商品评论的显示
 *      chome/upload 上传图片的函数，其他的目前渐渐被遗弃了
 *  </pre>
 *  对于管理员登录来说，显示的东西稍微有些不同，添加了四项
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
//         $this->user_id = $this->user_id_get();
    }
    /**
     * 后台的入口view函数
     */
    function index(){
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
    public function set() {
			if(!$this->user_id){
					$this->noLogin();
					return ;
			}
			$data = $this->user->getExtro($this->user_id);//获取之前的类型
			$data["type"] = $this->user->getType($this->user_id);//获取用户的类型，方便差异化处理
			$this->load->model("img");
			$data["show_picture"] = $this->img->select_show_picture($this->user_id);
			$this->load->view("bgHomeSet",$data);
    }
    /**
     * 传递给 view 的数据包括：
     *     全局分类列表:dir
     *     本店的分类列表:category
     *     本店上传过的用于描述商品详细信息的图片:img
     *
     * 由 view 传递回来的信息:
     *     商品名字：title
     *     商品主缩略图：mainThumbnail
     *     商品的附图片：thumbnail
     *     库存：storeNum
     *     属性：attr
     *     价格：price
     *     索引分类：gKey1,gKey2,gKey3,category
     *     详情编辑：detail
     *     上架时间：putawayTime
     *     简要描述：briefInfo
     */
    public function item() {
//         if(!$this->user_id) {
//             $this->noLogin();
//             return;
//         }
        $data['title']="添加商品";
        $data["dir"] = $this->part;
        $data["userType"] = $this->user->getType($this->user_id);
        $this->load->model("img");
        $data["img"] = $this->img->getImgName($this->user_id);
        $this->load->view("mBgItemAdd",$data);
    }
    /**
     * 显示一个商家所有的图片
     * @todo 添加分类和搜索
     */
    public function  imglist(){
        if(!$this->user_id){
            echo "请登录";
            return;
        }
        $this->load->model("img");
        //要不要添加浏览全部图片的设定呢？
        $data['imgall']=$this->img->userImgAll($this->user_id);
        $this->load->view("m-bg-imglist",$data);
    }
}
?>

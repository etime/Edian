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
class Home extends MY_Controller {
    var $userId;

    /**
     * 构造函数，需要使用的 model 文件有：bghome, user
     */
    function __construct() {
        parent::__construct();
        $this->load->model("bghome");
        $this->load->model("user");
        $this->load->model('boss');
        $this->userId = $this->getUserId();
    }

    /**
     * 如果没有登录，调出登录窗口
     */
    public function noLogin()
    {
        $data["url"] = site_url("bg/home");
        $this->load->view("login", $data);
    }

    /**
     * 获取老板的 bossId，并将其保存在 session 中
     */
    private function _setBossId() {
        $loginName = $this->session->userdata('loginName');
        $bossId = $this->boss->getBossIdByLoginName($loginName);
        $this->session->set_userdata('bossId', $bossId);
        return $bossId;
    }

    /**
     * 后台的入口view函数
     */
    function index() {
        // 如果用户未登录
        if ($this->userId == -1) {
            $this->noLogin();
            return;
        }
        //每一个用户，进入的时候都意味着设置bossId和storeId,为了避免刷新的时候重复设置.进行判断
        if(!$this->session->userdata("storeId")) {
            $bossId = $this->_setBossId();
            $this->choseStore($bossId);
        }else{
            $data["type"] = $this->user->getCredit($this->userId);
            //读取admin和seller对应的配置
            $this->load->config("edian");
            $data["ADMIN"] = $this->config->item("ADMIN");
            $data["SELLER"] = $this->config->item("SELLER");
            $this->load->view("bghome",$data);
        }
    }

    /**
     * 商城设置的入口函数
     * 这里是添加商城设置的地方，就是需要，但是又不必在注册时候的信息,
     * 营业时间，dtu，起送价，店家公告等
     * 具体的操作处理在set 这个php里面
     * 1,需要传入的数据,全部
     * 2,当前登录者的权限,如果是管理员的话，还需要提供商店列表
     * @todo 关于设置显示的问题，讨论
     * @deprecated 因为没有办法处理 管理员选择店家的操作，因此废弃
     */
    public function set(){
        if($this->userId == -1) {
            $this->noLogin();
            return;
        }
        //$data = $this->user->getExtro($this->userId);//获取之前的类型
        $data["type"] = $this->user->getType($this->userId);//获取用户的类型，方便差异化处理
        $data["type"] = 0;//普通用户
        //选择当前登录者的权限，根据不同的权限，决定不同的事情
        $data["type"] = 2;
        if($data["type"] == 2){
            $data["store"] = array(
                array('id' =>1,"storeName" =>"壮士店" ),
                array('id' =>1,"storeName" =>"壮士店" ),
                array('id' =>1,"storeName" =>"壮士店" )
            );
        }
        $this->load->model("img");
        //$data["show_picture"] = $this->img->select_show_picture($this->userId);
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
     *  @todo 对图片的使用，需要再次商量
     *  @todo 对管理员和店家进行两种不同的操作
     *  @todo 需要将店家之前的信息显示提供出来，为管理员提供接口，可以选择店家的信息，然后设置
     */
    public function item() {
        if ($this->userId == -1) {
             $this->noLogin();
             return;
        }
        $data['title']="添加商品";
        $data["dir"] = $this->part;
        $data["credit"] = $this->user->getCredit($this->userId);

        $this->load->model("img");
        //得到属于该用户的图片，方便二次添加,另议
        $data["img"] = $this->img->getImgName($this->userId);
        $this->load->view("mBgItemAdd",$data);
    }
    /**
     * 显示一个商家所有的图片
     * @todo 添加分类和搜索
     */
    public function  imglist(){
        if(!$this->userId){
            echo "请登录";
            return;
        }
        $this->load->model("img");
        //要不要添加浏览全部图片的设定呢？
        $data['imgall']=$this->img->userImgAll($this->userId);
        $this->load->view("m-bg-imglist",$data);
    }

    /**
     *  选择店铺，
     * 通过session获取老板的所有商店的 id 和 name
     * @param int $ownerId  店铺的拥有者的id
     */
    public function choseStore($ownerId  = -1 ) {
        //$ownerId = $this->session->userdata('bossId');
        $this->load->model("store");
        $data["store"] = $this->store->getIdNameByOwnerId($ownerId);
        $data["len"] = count($data["store"]);
        //在没有设置店铺的情况下，进入店铺设置，
        //如果有一个，就直接跳转到店铺，
        //如果有多个，就给出选择页面
        if($data['len'] == 0){
            $storeId = $this->store->insertStore($ownerId);
            $this->receiveStoreId($storeId);
        }else if($data['len'] == 1){
            $this->receiveStoreId($data["store"][0]["id"]);
        }else{
            $this->load->view("choseStore" , $data);
        }
    }

    /**
     * 初始化storeId,表示店家在选择了店铺的操作
     * 对应了直接页面提交和其他函数提交的两种情况
     *
     * @param int $storeId  表示选择的storId
     */
    public function receiveStoreId($storeId = -1 ) {
        $storeId = (int)$storeId;
        echo $storeId . '<br>';
        $bossId = $this->session->userdata("bossId");
        // 判断该老板是否拥有该商店
        if (! $this->store->isMatch($storeId, $bossId)) {
            echo "请选择您名下的商店";
            $this->mwrong->insert('controller/bg/home/receiveStoreId/'. __LINE__ .'bossId为'. $bossId . '的用户选择索引了一个不属于自己的名下的storeid'. $storeId);
            return false;
        }
        // 将 storeId 存入 session 中
        $this->session->set_userdata('storeId', $storeId);
        //对storeId初始化之后，开始选择进入后台，进行操作
        $this->index();
    }
}
?>

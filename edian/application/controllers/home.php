<?php
/**
 * @author          unasm<douunasm@gmail.com>
 * @since           2013-06-11 10:39:28
 * @name            sea.php
 * @package         controller
 * @deprecated
 * 这里对应的是home.php，操作包括为前段的js提供数据，对应的xml,逻辑上的各种操作，目前还不准备继承上层的类 ，对于登陆的功能，独立到reg文件中去了
 **/
class Home extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('art');
        $this->load->model('user');
        $this->load->library('session');
    }

    private function _delPartInfo($part_id, $id) {
        $data["part_id"]=$part_id;
        $data["id"]=$id;
        //处理其他版块的信息提供,part，表示版块号码，id表示页数
        return $this->art->getTop($data);
    }

    protected function _delHotInfo($id) {
        //$id,表示页数,
        $data["id"]=$id;
        return $this->art->getHot($data);
    }

    private function _xmlData($ans) {
        //补充一些$ans数据，将原来粗糙的数据进一步加工完善，返回调用函数
        for($i = 0; $i < count($ans);$i++){
            $author=$this->user->getNess($ans[$i]["author_id"]);
            if($author){
                $ans[$i]["user"] = $author;
                $temp  = preg_split("/\s/",$ans[$i]["time"]);
                $ans[$i]["time"] = $temp[0];
                //$ans[$i]["photo"] = $author[0]["user_photo"];
                //$ans[$i]["userName"] = $author[0]["user_name"];
            }
            else {//被删除的用户的信息还需要显示吗？
                //这里将来修改成报错，因为出现僵尸用户
                //var_dump("不存在用户".$key['author_id']);//这里其实应该给管理员一个报错，因为出现了僵尸用户
            }
        }
        return $ans;
    }

    /**
     * 首页的入口函数
     * @author FarmerJian <chengfeng1992@hotmail.com>
     * @deprecated    新的设计出来了，旧版本就放弃了
     */
    public function home2() {
        $userId = $this->getUserId();
        $data = array();
        if ($userId != -1) {
            $data = $this->user->getNess($userId);
            $temp = array();
            //$temp = $this->user->getNum($userId);
            if($data != false) {
                $data = array_merge($data, $temp);
            } else {
                $data = array();
            }
        }
        $data['dir'] = $this->part;
        $this->load->view('home', $data);
    }

    public function index() {
        $this->load->view("home2");
    }

    //只是为添加新的特性而测试的函数
    public function test($id = 0) {
        $userId = $this->getUserId();
        $this->load->model("user");
        $data = null;
        if($userId){
            $data = $this->user->getNess($userId);
            $temp = $this->user->getNum($userId);
            if($data){
                $data = array_merge($data,$temp);
            }else $data = null;
        }
        //这里准备只是画面框架的内容，没有具体的信息，其他的，由js申请
        $data["dir"] = $this->partMap;
        $data["cont"] = $this->infoDel($id);//0 获取热区的内容
        $this->load->view("test",$data);
    }

    public function mainCon($id = 0) {
        $data["cont"] = $this->infoDel($id);
        $this->load->view("manCon",$data);
    }

    //处理显示消息的函数，为js服务,$part表示热区，其他的1,2,3表示分版块,0为热门板块，具体看MY_Controller->partMap
    public function infoDel($part = -1,$id = 1,$ajax = 0) {
        //不设置页数，就默认是1了
        if($part== -1){
            exit("part不正确，请根据链接浏览");
        }
        if($part=="0")
            $re=$this->_delHotInfo($id);
        else {
            $re=$this->_delPartInfo($part,$id);
        }
        $re=$this->_xmlData($re);//补充数据，完善数据
        //echo "testing";
        //var_dump($re);
        //sleep(6);//但是测试还是没有结束
        //存在HTTP_X_REQUESTED_WITH 的情况下为ajax请求，不对具体数值进行判断了;
        /*
        if(array_key_exists("HTTP_X_REQUESTED_WITH",$_SERVER))
            echo json_encode($re);
        else return $re;
         */
        if($ajax){
            echo json_encode($re);
        }else{
            return $re;
        }
        //显示热门消息的函数，$id的作用是提供显示的页数,貌似除了热门消息之外，其他的都是可以同一个函数和model处理的
    }

    //根据part_id得到所有的本part_id的总数
    public function getTotal($part_id ) {
        if($part_id==0){
            $num=$this->art->allTotal();
        }
        else {
            $num=$this->art->getTotal($part_id);
        }
        echo json_encode(intval($num[0]["count(*)"]));
    }
}
?>

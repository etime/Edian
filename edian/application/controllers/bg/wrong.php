<?php
/**
 * 这里是处理错误情况的，将来这里会不断的丰富的，目前只是处理打印失败的，
 *  @name :         ../controllers/bg/wrong.php
 *  @Author :       unasm <1264310280@qq.com>
 *  @since :        2013-08-18 10:02:56
 */
class Wrong extends MY_Controller
{
    var $type,$user_id;
    /**
     * type是用户类型，也是权限的象征，type 3为管理员，1，2为用户和商家，但是都不允许进来
     */
    public function __construct()
    {
        parent::__construct();
        $this->user_id = $this->user_id_get();
        $this->load->model("mwrong");//对wrong表操作集中的函数
    }
    /**
     * 错误处理的入口函数，其他的操作的中心
     */
    public function index()
    {
        if(!$this->user_id){
            //检查是否登录
            $this->noLogin(site_url("bg/wrong/index"));
            return;
        }
        $type = $this->getTp($this->user_id);
        if((!$type) || ($type < 3)){
            echo "抱歉，您没有权限浏览";
            return;
        }
        $wrong = $this->mwrong->getAll();
        $data = Array();
        $this->load->model("user");
        if($wrong && $wrong[0]["content"] &&array_key_exists("pntState",$wrong[0]["content"])){
            //打印出错，是第一个错误,处理wrong不存在和content = null和pntstate不存在的情况
                $len = count($wrong);
                $data["flag"] = 1;
                for($i = 0;$i < $len;$i++){
                    $temp = $wrong[$i]["content"];
                    $info = $temp["info"];
                    $wrong[$i]["content"]["buyer"] = $this->user->getaddrCratById($temp["userId"]);
                    $wrong[$i]["content"]["seller"] = $this->user->getaddrCratById($info[0]["seller"]);
                }
        }else $data["flag"] = 0;
        $data["wrong"] = $wrong;
        $this->load->view("bgWrong",$data);
    }
    private function showArr($arr)
    {
        echo "<br/>";
        foreach($arr as $idx => $val){
            echo $idx."=>";
            var_dump($val);
            echo "<br/>";
        }
        echo "<br/>";
    }
    /**
     * gettype的简称，得到用户的类型
     *
     * @param int $userId 用户的id
     * @return int 用户的类别
     */
    protected function getTp($userId)
    {
        $this->load->model("user");
        return $this->user->getType($userId);
    }
    /**
     * 删除错误的报告，之后跳转到index
     * @param int $wrongId 错误的id
     */
    public function delete($wrongId)
    {
        $type = $this->getTp($this->user_id);
        $this->load->config("edian");
        if($type == $this->config->item("ADMIN")){
            //验证权限
            if($this->mwrong->del($wrongId) == true){
                redirect(site_url("bg/wrong/index"));
            }
        }
        echo $admin."<br/>";
        echo $type."<br/>";
    }
}
?>

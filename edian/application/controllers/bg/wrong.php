<?php
/**
 * 这里是处理错误情况的，将来这里会不断的丰富的，目前只是处理打印失败的，
 *  @name       ../controllers/bg/wrong.php
 *  @author     unasm <1264310280@qq.com>
 *  @since      2013-08-18 10:02:56
 *  @package    controllers
 *  @subpackage bg
 */
class Wrong extends MY_Controller {
    // 用户类型，和权限相关
    var $type;
    // 用户编号
    var $user_id;

    public function __construct() {
        parent::__construct();
        $this->user_id = $this->getUserId();
        $this->load->model("mwrong");
        $this->load->library('pagesplit');
        $this->load->config('edian');
    }

    /**
     * 错误处理的入口函数，其他的操作的中心
     */
    public function index($pageId = 1) {
        // 检查是否登陆
        if ($this->user_id == -1) {
            $this->noLogin(site_url("bg/wrong/index"));
            return;
        }
        $type = $this->getTp($this->user_id);
        if ( (! $type) || ($type < 3)) {
            echo "抱歉，您没有权限浏览";
            return;
        }
        $wrong = $this->mwrong->getAll();
        $data = Array();
        $data["flag"] = 0;
        $data["wrong"] = $wrong;

        if (isset($_GET['pageId'])) {
            $pageId = (int)$_GET['pageId'];
        } else {
            $pageId = (int)$pageId;
        }

        // 将所得的结果进行分页
        if ($data['wrong'] != false) {
            $temp = $this->pagesplit->split($data['wrong'], $pageId, $this->config->item('pageSize'));
            $data['wrong'] = array();
            $data['wrong'] = $temp['newData'];
            $commonUrl = site_url('bg/wrong/index');
            $data['pageNumFooter'] = $this->pagesplit->setPageUrl($commonUrl, $pageId, $temp['pageAmount']);
        }
        $this->showArr($data);
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
        return $this->user->getCredit($userId);
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

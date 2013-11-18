<?php
/**
 * 设置一些商店特殊信息的地方,个性化信息，标志信息，等等
 * @name      ./set.php
 * @author    unasm < 1264310280@qq.com >
 * @since     2013-11-19 06:28:10
 */
class set extends MY_Controller
{
    /** 来到这里的人必须有权限检查 */
    var $user_id;
    /**
     * 进入后台的人必须有id，对应的model应该有model
     */
     function __construct()
    {
        parent::__construct();
        $this->user_id = $this->user_id_get();
    }
    /**
     * setact setAction set函数对应的后台操作函数
     */
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

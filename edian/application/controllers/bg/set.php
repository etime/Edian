<?php
/**
 * 设置一些商店特殊信息的地方,个性化信息，标志信息，等等
 * @name        ./set.php
 * @author      unasm < 1264310280@qq.com >
 * @since       2013-11-19 06:28:10
 * @package     controller
 * @sub_package bg
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
        $this->user_id = $this->getUserId();
    }

    /**
     * 这里是添加商品类别列表的函数
     * 通过发送的POST提交中的字符串，添加到对应商户列表中
     * @param   string  $_POST["listName"]
     * @return  1/string 添加成功返回1，否则返回返回错误原因
     */
    public function listAdd()
    {
        echo "1";
    }

    /**
     * 通过post提交，将用户的列表中某一项删除
     * 目前对应的是ajax请求
     *
     * @param   string  $_POST["listName"]
     * @return bool/int  删除成功返回1，否则返回错误的原因
     */
    public function listDelete()
    {
        echo "1";
    }
    /**
     * setact setAction set函数对应的后台操作函数
     * 共有14项需要设置
     *<pre>
     * 商店名字 ：storeName
     * 营业时间 ：businessTime  拼接成的字符串,对应了两种情况，一个时间段，两个时间段
     *                          格式为9:0-19:0&21:0-23:0 和 9:0-19:0两种
     * 客服qq   ：serviceQQ      纯数字
     * 客服电话 ：servicePhone   11位或者座机，这里应该允许座机的出现了吧
     * 商店logo ：logo          这个的限制再说吧
     * 商店列表 ：list          在禁用的字符中选一个作为拼接符号，传入的字符串
     * dtu名字  ：dtuName
     * dtu密码  ：dtuPassword   用户权限决定是否修改,只有管理员才可以修改
     * dtuId    ：dtuId         每个dtu的物理编号
     * 简介图片 ：再议，规格再说
     * 经度     ：latitude
     * 纬度     ：longtitude
     * 文字位置 ：字符串的形式
     * 送货范围 ：在地图上标记出来,如果记录送货的左上和右下角的位置,是不是更好
     * </pre>
     */
    public function setAct(){
        $this->load->library("help");
        $this->help->showArr($_POST);
        return ;
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

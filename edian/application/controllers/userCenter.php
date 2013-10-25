<?php
/*******************************************************************
    > @name:      userCenter.php
    > @author:      unasm < 1264310280@qq.com >
    //上面按照这种格式修改成为你的名字吧
    > @since:     2013-10-24 19:05:16
 ************************************************************************/
/**
 * @package     controller
 * @deprecated
 *      这里是用户中心的操作函数
 *  现在这里是unasm书写的，只是为了可以显示代码而已
 *  入口函数userCenter在views下面，而剩下的其他的文档，则在views/center下面
 */
class UserCenter extends MY_Controller
{
    static $user_id;
    /**
     * 进入这个空间的人，必然是有一个用户的id的，为了隐私，我想这些信息应该不对外公布，除非是店家的
     */
     function __construct()
    {
        parent::__construct();
        $this->user_id = $this->user_id_get();//获取用户的id
    }
    public function index()
    {
        if(!$this->user_id){
            $this->_noLogin();
        }
        $this->load->view("userCenter");
    }
    /**
     * 处理用户没有登录的情况
     */
    private function _noLogin()
    {
    }
    /**
     * 我的关注，
     * 显示用户关注的商店的信息，最新动态还有
     */
    public function atten()
    {
        $this->load->view("center/atten");
    }
}
?>

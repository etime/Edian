<?php
require "home.php";
/**
 * 这里是对商店和用户,boss管理的类
 *
 * @package controller
 * @subpackage bg
 * @author unasm | farmerjian
 */
class Userlist extends Home{
    function __construct(){
        parent::__construct();
        $this->user_id = $this->getUserId();
        $this->load->library('help');
    }
    /**
     * 商店管理的函数，
     */
    function index(){
        $this->_checkAuthority(site_url('bg/userlist/index'));
        if($this->isAdmin){
            $this->load->model("store");
            $data['storeAll'] = $this->store->getStateList();
            $data['state'] = $this->config->item("storeState");
            $this->load->view("bgStoreList" , $data);
        }else {
            echo '权限不足';
            return false;
        }
    }
    public function mange($storeId = -1,$state = -1)
    {
        //将用户block的状态修改成指定的状态
        if(($state != -1 ) && ($state != -1)){
            $this->_checkAuthority(site_url('bg/userlist/index'));
            if($this->isAdmin){
                $this->load->model('store');
                if($this->store->updateStoreState($storeId , $state)){
                    $this->index();
                } else {
                    $this->load->model('mwrong');
                    $this->mwrong->insert('bg/userlist/mange/' . __LINE__ .' 行修改店铺的信息失败');
                    exit("修改失败");
                }
            }else{
                $this->load->model('mwrong');
                $this->mwrong->insert('bg/userlist/mange/' . __LINE__ .' 行出现非admin访问用户信息修改的情况');
                exit('权限不足');
            }
        }else{
            echo "程序错误，去踹开发的那个人吧";
        }
    }
    /**
    *  管理boss和user表的内容
    *  感觉没有必要再对这两个表的东西修改了，一切的差异化，都在后台实现吧
     */
    public function user($pageId  = 0)
    {
        $this->_checkAuthority(site_url('bg/userlist/user'));
        if($this->isAdmin){
            $this->load->model('user');
            $data['userList'] = $this->user->getCilnrsList($pageId);
            $data['state'] = $this->config->item('userState');
            //$this->help->showArr($data['userList']);
            $this->load->view('bgUserList' , $data);
        } else {
            exit('权限不足');
            echo "no";
        }
    }
    /**
     * 修改用户的state状态
     * @param int   $userId     用户的id
     * @param int   $state      对应的状态
     */
    public function userUpdate($userId = -1 , $state = -1)
    {
        if( ($userId !== -1) && ($state !== -1)){
            $this->_checkAuthority(site_url('bg/userlist/userUpdate/' . $userId . '/' . $state));
            if($this->isAdmin){
                $this->load->model('user');
                if($this->user->updateUserState($userId, $state)){
                    $this->user();
                }else{
                    $this->load->model('mwrong');
                    $this->mwrong->insert("bg/userlist/userUpdate出现update失败的情景");
                    echo "修改状态失败";
                    return false;
                }

            }
        }
    }
    function userDel($user_id){
            //通过用户名删除用户,并且重定向到bg/userlist/那个u页面
            $this->mbguserlist->user_del($user_id);
            redirect(site_url("bg/userlist"));
    }
    function  userBlock($user_id){
            $res=$this->mbguserlist->user_block($user_id);
            redirect(site_url("bg/userlist"));
    }
}
?>

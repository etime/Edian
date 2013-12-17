<?php
/**
 * 设置一些商店特殊信息的地方,个性化信息，标志信息，等等
 * @name        ./set.php
 * @author      unasm < 1264310280@qq.com >
 * @since       2013-11-19 06:28:10
 * @package     controller
 * @sub_package bg
 */

define("TEST","1");
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
        $this->load->model("user");
        $this->load->model("store");
        //$this->load->model("mwrong");
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
        $name = $this->input->post("listName");
        if( preg_match("/[~!@#$%^&*_+`\\=\\|\\{\\}:\\\">\\?<\\[\\];',\/\\.\\\\]/", $data['name']) ) {
            echo '包涵非法字符';
        }else{
            $this->store->categoryAdd($name);//插入category
        }
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
     * 将setact的数据输入检验的函数
     * 当一个数值不符合规定的时候，就赋值位false，表示表示不再修改,和change的特殊用法有关系
     * @todo logo 还没有做，复用fj代码
     */
    protected function setGet()
    {
        $data["name"]         = trim( $this->input->post("storeName"));
        $data["deliveryTime"] = trim( $this->input->post("businessTime") );
        $data["deliveryArea"] = trim( $this->input->post("distance"));
        $data["servicePhone"] = trim( $this->input->post("servicePhone"));
        $data["serviceQQ"]    = trim( $this->input->post("serviceQQ"));
        $data['longitude']    = trim( $this->input->post('longitude'));
        $data['latitude']     = trim( $this->input->post('latitude'));
        $data['address']      = trim( $this->input->post('address'));
        $data['sendPrice']      = trim( $this->input->post('lestPrc'));
        //不能存在除-()之外一切特殊字符
        if( preg_match("/[~!@#$%^&*_+`\\=\\|\\{\\}:\\\">\\?<\\[\\];',\/\\.\\\\]/", $data['name']) ) {
            $data['name'] = false;
        }
        /*
            //测试代码
            $data['deliveryTime'] = "23sdfa";
            $data['deliveryTime'] = '-sd@#@#323';
            $data['deliveryTime'] = '&sd23';
         */
        if(preg_match('/[^\d\\:\\-&]+/' , $data['deliveryTime'])){
            echo "含有deliveryTime之外的字符";
            $data['deliveryTime'] = false;
        }
        if(!preg_match('/^\d+$/', $data['deliveryArea'])){
            $data['deliveryArea'] = false;
        }
        if(!preg_match('/^\d{11}$/' , $data['servicePhone'])){
            $data['servicePhone'] = false;
        }
        if(!preg_match('/^\d+$/' , $data['serviceQQ'])){
            $data['serviceQQ'] = false;
        }
        if(!preg_match('/^\d+[.\d]?\d*$/' , $data['longitude'])){
            $data['longtitude'] = false;
        }
        if(!preg_match('/^\d+[.\d]?\d*$/' , $data['latitude'])){
            $data['latitude'] = false;
        }
        /*
            $data["address"] = "sdf斯蒂芬";
            $data["address"] = "sdf斯蒂芬)";
            $data["address"] = "sdf斯蒂芬)-";
            $data["address"] = "sdf斯蒂芬)-d@#";
            echo $data["address"];
        */
        if( preg_match("/[~!@#$%^&*_+`\\=\\|\\{\\}:\\\">\\?<\\[\\];',\/\\.\\\\]/", $data['address']) ) {
            $data['address'] = false;
        }
        //标准的来说，应该是只有一个小数的
        if(!preg_match('/^\d+[.\d]?\d*$/' , $data['sendPrice'])){
            $data['sendPrice'] = false;
        }
        return $data;
    }
    /**
     * setact setAction set函数对应的后台操作函数和view显示函数
     * 共有14项需要设置
     *<pre>
     *      商店名字 ：name
     *      营业时间 ：deliverytime  拼接成的字符串,对应了两种情况，一个时间段，两个时间段
     *                          格式为9:0-19:0&21:0-23:0 和 9:0-19:0两种
     *      客服qq   ：serviceQQ      纯数字
     *      客服电话 ：servicePhone   11位或者座机，这里应该允许座机的出现了吧
     *      商店logo ：logo          这个的限制再说吧
     *      商店列表 ：list          在禁用的字符中选一个作为拼接符号，传入的字符串
     *      dtu名字  ：dtuName
     *      dtu密码  ：dtuPassword   用户权限决定是否修改,只有管理员才可以修改
     *      dtuId    ：dtuId         每个dtu的物理编号
     *      简介图片 ：再议，规格再说
     *      经度     ：latitude
     *      纬度     ：longtitude
     *      文字位置 ：字符串的形式
     *      送货范围 ：在地图上标记出来,如果记录送货的左上和右下角的位置,是不是更好
     * </pre>
     * @todo 被遗忘的最低起送价格，没有添加
     */
    public function setAct(){
        $this->load->library("help");

        //对用户权限进行检验
        if($this->user_id == -1){
            $this->noLogin( site_url("bg/set/setAct") );
            return;
        }
        $data['credit'] = $this->user->getCredit($this->user_id);//获取用户的类型，方便差异化处理
        $this->load->config('edian');
        if($data['credit'] == $this->config->item("adminCredit")){
            $data["type"] = 2;
        }else if($data['credit'] == $this->config->item("bossCredit")){
            $data["type"] = 1;
        }else exit("您没有权限进入本页面");
        if(TEST)
            $data["type"] = 2;


        //在没有不同的store之前，先代替
        if($data["type"] == 2){
            if(TEST){
                $data["store"] = array(
                    array('id' =>1,"name" =>"壮士店1" ),
                    array('id' =>2,"name" =>"壮士店2" ),
                    array('id' =>3,"name" =>"壮士店3" )
                );
            }else{
                $data["store"] = $this->store->getStoreList();
            }
            //优先选择店，在没有的情况下选择一个默认的店 ,1号
            $data["storeId"] = $this->input->post("storeId");
            if(!$data["storeId"]) $data["storeId"] = 1;
        }else{
            //强制转换，如果发现为0，报错
            $data["storeId"] = (int)$this->session->userdata("storeId");
        }
        //对提交的判断，数据的获取
        if($this->input->post("sub") === '提交'){
            $inputData = $this->setGet();
            $more['dtuName'] = $this->input->post('dtuName');
            if($data["type"] == 2){
                $more['dtuPassword'] = trim( $this->input->post("dtuPassword") );
                $more['dtuId']       = trim($this->input->post('dtuId'));
            }
            $flag = $this->store->update($inputData, $more ,$data["storeId"]);
            //$data = array_merge($data,$inputData);
            if(!$flag){
                exit("插入失败");
            }
        }else{
            //在不是提交的情况下，重新读取
            //本店的列表的编码和解码和get,
        }
        $data = array_merge($data , $this->store->getSetInfo($data['storeId'] ));
        $this->load->view("bgHomeSet",$data);
    }
    /**
     * 对用户没有登录的情况进行处理
     */
    protected function noLogin( $url )
    {
        $data["url"]  = $url;
        $this->load->view("login", $data);
    }

}
?>

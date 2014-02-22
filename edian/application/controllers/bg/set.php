<?php
/**
 * 设置一些商店特殊信息的地方,个性化信息，标志信息，等等
 * @name        ./set.php
 * @author      unasm < 1264310280@qq.com >
 * @since       2013-11-19 06:28:10
 * @package     controller
 * @sub_package bg
 */

define("TEST",0);
class set extends MY_Controller
{
    /** 来到这里的人必须有权限检查 */
    var $user_id;
    /**
     * 进入后台的人必须有id，对应的model应该有model
     */
    function __construct() {
        parent::__construct();
        $this->load->model('user');
        $this->load->model('store');
        $this->load->model('boss');
        $this->load->model('mitem');
        $this->load->model("mwrong");
        $this->user_id = $this->getUserId();
    }


    /**
     * 这里是添加商品类别列表的函数
     b* 通过发送的POST提交中的字符串，添加到对应商户列表中
     * @param   string  $_POST["listName"]
     * @return  1/string 添加成功返回1，否则返回返回错误原因
     */
    public function listAdd($name)
    {
        $name = trim( $this->input->post("listName") );
        if( preg_match("/[~!@#$%^&*_+`\\=\\|\\{\\}:\\\">\\?<\\[\\];',\/\\.\\\\]/", $name) ) {
            echo '包涵非法字符';
        }else{
            if(TEST)$storeId = 1;
            else $storeId = $this->session->userdata("storeId");
            $flag = $this->store->changeCategory($name,$storeId);//插入category
            if($flag)echo 1;
            else echo "添加失败";
        }
    }
    /**
     * 这个是用来测试下面的listDelete的函数
     *
     * @return void
     * @author unasm
     */
    public function testListDelete()
    {
        $this->load->library("help");
        $val = array("adb",'saf','sdba','sdfa');
        foreach ($val as $key) {
            $data["listName"] = $key;
            $this->help->curl($data , site_url('bg/set/listDelete'));
        }
    }
    /**
     * 通过post提交，将用户的列表中某一项删除
     * 目前对应的是ajax请求
     *
     * @param   string  $_POST["listName"]
     * @return bool/int  删除成功返回1，否则返回错误的原因
     */
    public function listDelete() {
        // 接收数据
        $listName = trim($this->input->post('listName'));
        // 从 session 中获取当前商店的 storeId
        $storeId = trim($this->session->userdata('storeId'));
        $storeId = (int)$storeId;
        if(!$storeId){
            echo "请首先登录";
            $storeId = 2;//这里是为了测试
        }
        if( preg_match("/[~!@#$%^&*_+`\\=\\|\\{\\}:\\\">\\?<\\[\\];',\/\\.\\\\]/", $listName) ) {
            $this->mwrong->insert('controller/bg/set/listDelete' . __LINE__  .'中有非法字符,此时输入的字符为listName = ' .$listName .'，storeId为' . $storeId);
            sleep(1000);//延迟和误导
            echo "请正确输入";
            return false;
        }
        // 获取当前商店的所有分类列表
        $list = $this->store->getCategoryByStoreId($storeId);
        // 判断要删除的分类是否在分类列表中
        $flag = false;
        foreach ($list as $key => $val) {
            if ($val == $listName) {
                $flag = true;
                break;
            }
        }
        if (! $flag) {
            echo '该分类不存在';
            return;
        }
        // 判断是否有商品属于要删除的分类
        $flag = $this->mitem->isCategoryUsed($listName, $storeId);
        if ($flag) {
            echo '该分类正被使用中，不能删除';
            return;
        }

        // 将删除后的分类进行编码
        $newCategory = '';
        foreach ($list  as $key => $val) {
            if ($val == $listName) {
                continue;
            }
            if ($newCategory == '') {
                $newCategory .= $val;
            } else {
                $newCategory .= '|' . $val;
            }
        }
        $flag = $this->store->updateCategoryByStoreId($newCategory, $storeId);
        if(!$flag){
            $this->mwrong->insert(__LINE__."行set/listDelete/update失败了");
        }
        echo "1";
    }
    /**
     * 将setact的数据输入检验的函数
     * 当一个数值不符合规定的时候，就赋值位false，表示表示不再修改,和change的特殊用法有关系
     * @todo logo 还没有做，复用fj代码
     */
    public function setGet()
    {
        $data["name"]         = trim( $this->input->post("storeName"));
        $data["deliveryTime"] = trim( $this->input->post("businessTime") );
        $data["deliveryArea"] = trim( $this->input->post("distance"));
        $data["servicePhone"] = trim( $this->input->post("servicePhone"));
        $data["serviceQQ"]    = trim( $this->input->post("serviceQQ"));
        $data['longitude']    = trim( $this->input->post('longitude'));
        $data['latitude']     = trim( $this->input->post('latitude'));
        $data['address']      = trim( $this->input->post('address'));
        $data['sendPrice']    = trim( $this->input->post('lestPrc'));
        $data['logo']         = trim( $this->input->post("logo"));
        $data['briefInfo']    = trim( $this->input->post('briefInfo'));
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
        if( preg_match("/[~!@#$%^&*_+`\\=\\|\\{\\}:\\\">\\?<\\[\\];',\/\\.\\\\]/", $data['address']) ) {
            $data['address'] = false;
        }
        //标准的来说，应该是只有一个小数的
        if(!preg_match('/^\d+[.\d]?\d*$/' , $data['sendPrice'])){
            $data['sendPrice'] = false;
        }
        if(!preg_match('/^[\d-_]+\.(jpg|png|gif)$/' , $data['logo'])){
            $data['logo'] = false;
        }
        if( preg_match("/[~!@#$%^&*_+`\\=\\|\\{\\}:\\\">\\?<\\[\\];',\/\\.\\\\]/", $data['briefInfo']) ) {
            $data['briefInfo'] = false;
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
     * @param int   $storeId    选择的商店的id,添加这个接口，是为了方便其他的链接查看,目前在bg/userlist/index 使用
     */
    public function setAct($storeId = -1) {
        //对用户权限进行检验
        if ($this->user_id == -1) {
            $this->noLogin(site_url("bg/set/setAct"));
            return;
        }
        //获取用户的类型，方便差异化处理
        $data['credit'] = $this->user->getCredit($this->user_id);
        $this->load->config('edian');
        if ($data['credit'] == $this->config->item("adminCredit")) {
            $data["type"] = 2;
        } else if($data['credit'] == $this->config->item("bossCredit")) {
            $data["type"] = 1;
        } else {
            exit("您没有权限进入本页面");
        }
        if (TEST) {
            $data["type"] = 2;
        }
        //如果有管理员权限
        if ($data["type"] == 2) {
            if (TEST) {
                $data["store"] = array(
                    array('id' =>1,"name" =>"壮士店1" ),
                    array('id' =>2,"name" =>"壮士店2" ),
                    array('id' =>3,"name" =>"壮士店3" )
                );
            } else {
                $data["store"] = $this->store->getStoreList();
            }
            //优先选择店，在没有的情况下选择一个默认的店 ,1号
            if ($storeId === -1) {
                $data["storeId"] = (int)trim($this->input->post("storeId"));
            } else {
                $data['storeId'] = (int)$storeId;
            }
            if (! $data["storeId"]) {
                $data["storeId"] = 1;
            }
        } else {
            //强制转换，如果发现为0，报错
            $data["storeId"] = (int)$this->session->userdata("storeId");
        }
        //对提交的判断，数据的获取
        if ($this->input->post("sub") === '提交') {
            $inputData = $this->setGet();
            $more['dtuName'] = $this->input->post('dtuName');
            if ($data["type"] == 2) {
                $more['dtuPassword'] = trim($this->input->post("dtuPassword"));
                $more['dtuId'] = trim($this->input->post('dtuId'));
            }
            $flag = $this->store->update($inputData, $more, $data["storeId"]);
            if (! $flag) {
                exit("插入失败");
            }
        }
        $temp = $this->store->getSetInfo($data['storeId']);
        if ($temp == false) {
            $temp = array();
        } else {
            for ($i = 0, $len = (int)count($temp['category']); $i < $len; $i ++) {
                $name = $temp['category'][$i];
                $temp['category'][$i] = array();
                $temp['category'][$i]['name'] = $name;
                $count = $this->mitem->getCountByStoreTag($data['storeId'], $name);
                if ($count == false) {
                    $count = 0;
                }
                $temp['category'][$i]['count'] = $count;
            }
        }
        $data = array_merge($data, $temp);
        //之前为了和扩展，只在数据库中保存了名字，现在补全对应的路径,logo存放在mix文件架下面
        if ($data['logo']) {
            $data['logo']  = base_url('image/' . $this->user_id . '/mix/' . $data['logo']);
        }
        $this->help->showArr($data);
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

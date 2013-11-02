<?php
/**
 *    这里面继承了搜索的一切操作，因为没有对应的表，
 *    所以没有对应的model文件，将来在数据库中添加关键词会添加相应的model，ast的代码比较挫，要不要拷贝一些呢。看看吧
 * 目前的搜索方法是这样的，首先是通过查看关键字，是不是属于第一级菜单，如果是的话，就查询第二级菜单，然后在首页分列显示,
 * 如果是第二级菜单，就从查询第三级菜单，然后分列显示，其他的则正常显示
 * 如果不是第一级菜单，就正常显示，和搜索和其他没有任何区别，
 * 但是这么处理，显然增大的工作量，几倍增大了搜索量，
 *
 * <code> <?php echo "hello,world!!" ?></code>
 * @author          unasm<1264310280@qq.com>
 * @since           2013-06-11 10:39:28
 * @name            sea.php
 * @package         controller

 **/
class Sea extends MY_Controller
{
    var $pageNum;
    function __construct()
    {
        parent::__construct();
        $this->load->model("mitem");
        $this->load->model("user");
        $this->load->model("mwrong");//为了避免多次载入，在开头直接载入
        $this->load->config("edian");//配置文件
        $this->pageNum = 4;
    }
    protected function res()
    {//增加搜索页面，显示搜索结果
        $keyword = trim($_GET["sea"]);
        $ans = $this->index(0,$keyword,1);
    }
    /**
     * 这里是处理首页数据申请的地方
     *
     * 这里通过url传入的参数，决定查找的方向，可以查找热区和二手，其他目前则为关键字超找。
     *
     * <var>$currentPage</var> int 当前正在搜索的页面<br/>
     * <var>$keyword</var>     string 关键词，需要查找的关键字
     *
     */
    public function index()
    {//通过减少查询工作量，增加查询次数，减少io读写，我想是一个优化，具体，其实还是需要检验
    //那么，这个函数将成为我最重要的函数吗？
        /**
         * @access private
         * @internal int
         */
        $currentPage = trim(@$_GET["pg"]);
        $currentPage = $currentPage?$currentPage:0;
        if($currentPage<0){
            show_404();
            return;
        }
        $keyword = trim(urldecode(@$_GET["key"]));
        $flag = 0;
        $ans = "";
        if($keyword == "0"){
            //0 是热区
            $ans = $this->hotDel($currentPage);
            //这里的得到数据的方式，需要优化
        }else if($keyword == "1"){
            // 1 是二手专卖，要单独处理
            // 对热区和二手的处理暂时不变
            $this->load->model("art");
            $ans = $this->art->getSecTop($currentPage);
        }else{
            $app = trim(@$_GET['app']);
            $this->load->library("cache");//搜索的时候引入缓存
            /*
             * app append的简写，就是添加，之前已经索引过了，现在就是单纯的添加，可以通过缓存，过期的话，就重新检索,
             * 只对关键字进行检索,而且，关键字必然是只有一个，如果发现长度很长，超过一个关键字，报告管理员,将关键字和用户的id
             */
            if($app){
                $key = preg_split("/[^\x{4e00}-\x{9fa5}0-9a-zA-Z]+/u",$keyword);
                //临时替换成key，keyword要保留
                if(count($key)>1){
                    $temp["text"] = "sea.php/index/".__LINE__."出现问题，用户输入关键字长度超过1,有可能是黑客,关键词为:";
                    $this->mwrong->insert($temp);
                }
                //以非汉字，数字，字母为分界点开始分割;
                $key = $this->getAppend($key[0]);//返回id数组
                $ans = $this->sea($key,$currentPage);
            }else{
                $key = $this->keyPreDel($keyword);
                //对关键字进行处理，得到id数组和value之后的排序，然后
                if(count($key) > 1){
                    $flag = 1;
                    foreach ($key as $idx => $val) {
                        //虽说为2维数组，但是第二纬只有一个数字，所以合并成为一维数组，然后unique
                        $tmp = $this->sea($val,$currentPage);//这里的$val必然是数组，id的数组
                        if($tmp){
                            $ans[$idx] = $tmp;
                        }
                    }
                }else{
                    foreach ($key as $idx => $val) {
                        $ans = $this->sea($val,$currentPage);//这里的key长度为1，所以$ans长度必然只能为1
                    }
                }
            }
            //$ans = $this->getAnsBykey($key,$currentPage);
            //在不是app的情况下，没有必要添加flag了,flag只是区别分区和动态添加的标志位
            if($flag)$ans["flag"] = $flag;
        }

        echo json_encode($ans);
    }
    /**
     * 通过key数组得到数据
     *
     * @param int $page  页码
     * @param array $key  关键字数组和对应的id数组
     * @return array 返回数据数组
     */
    protected function getAnsBykey($key,$page)
    {
        /*
         * 关键字大于1个，就证明不是很多个条目，需要分类
         * foreach 的idx为搜索的关键字，$val为id的数组，
         * unasm 2013-09-27 16:49:44
         */
        $ans = Array();
        foreach ($key as $idx => $val) {
            //虽说为2维数组，但是第二纬只有一个数字，所以合并成为一维数组，然后unique
            $tmp = $this->sea($val,$page);//这里的$val必然是数组，id的数组
            if($tmp){
                $ans[$idx] = $tmp;
            }
        }
        return $ans;
    }
    /*
     * 这里是在第二次添加的时候，希望可以从缓存中读取数据进行的操作,如果不可以，从数据库读取信息
     *
     * @$idx  str 索引，根据这个得到字符串，
       @return array 数组，需要的答案
     */
    protected function getAppend($idx)
    {
        $cache = $this->cache->get($idx);
        if($cache){
            return $cache;
            //直接从缓存中得到id。
            $res[$idx] = $cache;//为了格式上的要求
        }else{
            //通过getIdArr 得到id，
            //$res[$idx] = $this->getIdArr($idx);
            return $this->getIdArr($idx);
        }
        return $res;
    }
    private function showArr($array)
    {
        foreach($array as $index => $value){
            var_dump($index);
            echo "   =>   ";
            var_dump($value);
            echo "<br>";
            echo "<br>";
        }
    }
    private function hotDel($stp){
        $res = $this->mitem->getHot($stp);
        for($i = 0,$len = count($res);$i < $len ;$i++){
            $userInfo = $this->user->getsea($res[$i]["author_id"]);
            if($userInfo){//因为之前的局限，现在必须按照这种方法
                //$temp = array_merge($temp,$userInfo[0]);
                $now = explode("&",$userInfo["addr"]);//将地址拆分
                $userInfo["addr"] = $now[0];
                $res[$i]["user"] = $userInfo;
                $res[$i]["art_id"] = $res[$i]["id"];//因为在读取的数字中，没有art_id,这里添加上,保留和之前一样的格式
            }
        }
        return $res;
    }
    /**
     *  $key 对关键词的预处理，或者构成数组，或者是单独处理
     *
     *  @$key string 要传入的关键字
     */
    protected function keyPreDel($key)
    {
        $key = preg_split("/[^\x{4e00}-\x{9fa5}0-9a-zA-Z]+/u",$key);//以非汉字，数字，字母为分界点开始分割;
        if(count($key) == 0)return;
        $keyArrLen = count($key);
        $res = Array();
        if($keyArrLen == 1){
            $key = $this->getSubItem($key[0]);
            if(is_array($key)){
                //如果传入一个string，返回一个数组，代表找到了子目录
                foreach ($key as $val) {
                    $res[$val] = $this->getIdArr($val);//这里要处理的肯定都是单个的词
                }
            }else{
                //这里要处理的肯定都是单个的词,而这种处理的结果和下面的是一样的，应该都是搜索，或者是最下既级菜单的结果。
                $res[$key] = $this->getIdArr($key);
            }
        }else{
            /*
             * 这种情况发生是因为用户搜索，而不是点击浏览，所以不需要
             */
            $res[$key[0]] = $this->getIdArr($key);
        }
        return $res;
    }
    /**
     * 获取一级菜单的子菜单，在part数组中进行查找，找不到关键字则直接返回原来的字符串
     * @$key 一个单独的string，代表关键字
     */
    protected function getSubItem($key)
    {
        foreach ($this->part as $idx => $arr) {
            if(is_array($arr)){//这个目前不必要哦
                if($idx == $key){
                    $res = Array();
                    foreach ($arr as $tmpIdx => $secArr) {
                        array_push($res,$tmpIdx);
                    }
                    return $res;
                    //return $arr;
                }
            }
        }
        return $key;
    }
    /**
     * 通过传入的key组成id，然后通过id获得应该有的字符串
     *
     * 目前就通过搜索的方法得到,然后保存到缓存里面
     *
     * @$key array 有可能是字符串，也许是数组，但是所有搜到的应该都成为一个idArray
     */
    protected function getIdArr($key)
    {
        $id = Array();
        if(is_array($key)){
            //如果传入的关键字数组
            $keyArrLen = count($key);
            for($i = 0; $i < $keyArrLen;$i++){
                if(mb_strlen($key[$i],"UTF8")<2)continue;                   //小于1个的字是没有任何搜索价值的，必须是词语才可以
                $temp = $this->mitem->getIdByKey($key[$i]);
                $id = array_merge($temp,$id);                               //输入的数组中有相同的字符串键名，则该键名后面的值将覆盖前一个值。
                //if(count($id)>$this->pageNum*($currentPage+1))break;
            }
            //return $id;
        }else{
            //如果传入的，只是关键字
            $id = $this->mitem->getIdByKey($key);
        }
        //将id进行排序，然后保存到缓存里面
        $id = $this->uniqueSort($id);
        $this->cache->store($key,$id);
        return $id;
    }
    /**
     * 对$id，currentPage进行处理 得到具体的数据，返回的数据数组
     * @$id array 保存了item 主键id的数组，
     * @return 根据id得到的数据返回
     */
    protected function sea($id,$currentPage)
    {
        /**********************/
        //将这个id保存到缓存中，将来
        $res = array();
        $timer = 0;
        for($i = $currentPage*$this->pageNum,$idLen = min(count($id),$this->pageNum*($currentPage+1)); $i < $idLen;$i++){
            $temp = $this->mitem->getMin($id[$i]);//通过id获得内容
            if($temp){
                $userInfo = $this->user->getsea($temp["author_id"]);
                if($userInfo){//因为之前的局限，现在必须按照这种方法
                    //$temp = array_merge($temp,$userInfo[0]);
                    $now = explode("&",$userInfo["addr"]);//将地址拆分
                    $userInfo["addr"] = $now[0];
                    $temp["user"] = $userInfo;
                    $temp["art_id"] = $id[$i];//因为在读取的数字中，没有art_id,这里添加上
                    $res[$timer++] = $temp;
                }else{
                    $temp["text"] = "sea.php/sea/".__LINE__."出现问题，输入了用户的id却没有结果，请检查，temp[author_id] = ".$temp["author_id"];
                    $this->mwrong->insert($temp);
                    //为0，是不是代表用户的被删除呢,向管理员报告呢
                }
            }else{
                $temp["text"] = "sea/sea/".__LINE__."行出现问题，在按照读取的id进行查找的时候，发现没有，检验一下,id为：".$id[$i]."返回值temp为".$temp;
                $this->mwrong->insert($temp);
                //这里为0会是什么情况呢，我通过like匹配出结果，然后根据id具体去查找，发现居然没有，要检查
            }
        }
        if($timer)
            return $res;
            //echo json_encode($res);
        return 0;
    }
}
?>

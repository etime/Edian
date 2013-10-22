<?php
/**
 * 对应的数据库为art这个表，目前还是在使用中,处理的就是帖子，文章的第一层楼,他们都差不多，不是吗？
 *art_id表明这个行的唯一id
 title，商品信息的标题，也是搜索的主要依据
 content，主要介绍内容
// part_id,表明这个商品的分区，没有添加索引，因为数据差别不大""这项在最新的设计中，被去掉了
 time，最后的发表时间或者是修改时间
 author_id 发表的人的id
value 通过赞助，评论，浏览添加起来的价值，也是热度的另一称呼
visitor_num 访问者的数目，将来收钱的依据，会增加少量的values
// comment_num 很大程度上增加价值，评论者的数目，
 //new，是不是有新的人评论了，回复了
 //commer 最近的评论者
price，商品的价格

img，商品的图片:每件商品或许不止一个图片，所以做成列表的形式，将来通过正则截取,多个图片，会默认首先显示第一个
keyword 关键字，保存格式为苹果;清苹果;分号隔开，关键字为分区的字和用户自己输入的关键字,搜索的时候通过like对比关键字
attr 通过拼成的字符串,格式采用json的格式，表示上平的属性，颜色，分类的,商品编号也在这中间,方便商家查找商品;之所以是这样，是因为这些都是一些无关紧要的因素，不会有人关注这个，不会有人在这里搜索
storeNum 库存量，是attr中各个存货量的叠加
judgescore float商品评分：没有必要每次都重新计算一遍吧,加起来，然后除以评论数据就是了
attr的格式为color
                2,2,"颜色","重量",红色,绿色,1kg,3kg|//第一个属性，第二个属性，颜色的个数，重量的个数,方便数据处理
                    [红色,1kg]12,11;
                    [红色,3kg]12,11;
                    [绿色,1kg]12,11
                    [绿色,3kg]12,11
    绿色对应颜色的具体表示，1kg是重量的具体表示，12是存货量,11表示价格
         author:        unasm
         email:         douunasm@gmail.com
         Last_modified: 2013-06-28 09:23:15

 **/
class Art extends Ci_Model
{
    var $pageNum;
    //pageNum 每页，如热区的数据量
    function __construct()
    {
        //$this->pageNum=24;
        $this->load->config("edian");//读取配置文件中的每页数据量
        $this->pageNum = $this->config->item("pageNum");
        parent::__construct();
    }
    public function insert_art($art_title,$art_text,$part_id,$user_id,$value)
    {//插入文章的的函数 ，未经过测试
        $art_title = addslashes($art_title);
        $art_text = addslashes($art_text);
        $sql="insert into art(title,content,part_id,time,author_id,value) values('$art_title','$art_text','$part_id',now(),'$user_id','$value')";
        return $this->db->query($sql);
    }
    public function cinsertArt($data,$userId)
    {//目前只是为cadd 服务,返回插入成功时候的id
        $data["tit"] = addslashes($data["tit"]);
        $data["cont"] = addslashes($data["cont"]);
        $data["keys"] = addslashes($data["keys"]);
        $flag = $this->db->query("insert into art(title,content,part_id,time,author_id,value,price,img,keyword) values('$data[tit]','$data[cont]','$data[part]',now(),'$userId','$data[value]','$data[price]','$data[file_name]','$data[keys]')");
        if($flag){
            $flag = $this->db->query("select last_insert_id()");
            $flag = $flag->result_array();
            return $flag["0"]["last_insert_id()"];
        }
        return false;
    }
    private function dataFb($res)
    {//对body，title反转义
        for($i = 0; $i < count($res);$i++){
            $res[$i]["title"] = stripslashes($res[$i]["title"]);
            $res[$i]["content"] = stripslashes($res[$i]["content"]);
        }
        return $res;
    }
    private function titleFb($res)
    {//对body，title反转义
        for($i = 0; $i < count($res);$i++){
            $res[$i]["title"] = stripslashes($res[$i]["title"]);
        }
        return $res;
    }
    public function getTop($data)
    {
        //根据最新的设计，已经废除了
        //根据id和part_id获得信息的函数，将从上到下，根据value获得信息
        //没有，或者是小于1的情况，为0
        if(!array_key_exists("id",$data)||($data["id"] < 1))$data["id"] = 1;
        $data["id"]=($data["id"]-1)*$this->pageNum;//$this->num中保存的是每页显示的条数，$id,表示的是当前的页数，默认从1开始，所以需要减去1
        $sql="select art_id,title,author_id,time,comment_num,visitor_num,price,img from art where part_id = $data[part_id] order by value  desc limit $data[id],$this->pageNum";
        $res=$this->db->query($sql);
        return $this->titleFb($res->result_array());
    }
    public function getSecTop($page)
    {//根据id和part_id获得信息的函数，将从上到下，根据value获得信息
        //没有，或者是小于1的情况，为0
        $page =$page*$this->pageNum;//$this->num中保存的是每页显示的条数，$id,表示的是当前的页数，默认从1开始，所以需要减去1
        $sql="select art_id,title,author_id,time,comment_num,visitor_num,price,img from art order by value  desc limit $page,$this->pageNum";
        $res=$this->db->query($sql);
        if($res){
            $res = $this->titleFb($res->result_array());
            $len = count($res);
            $this->load->model("user");
            for ($i = 0; $i < $len; $i++) {
                $temp = $this->user->getNameById($res[$i]["author_id"]);
                $res[$i]["user"] = $temp;
            }
            return $res;
        }
        return false;
    }
    public function getHot($data)
    {
        $data["id"]=($data["id"]-1)*$this->pageNum;//$this->num中保存的是每页显示的条数，$id,表示的是当前的页数，默认从1开始，所以需要减去1
        $sql="select art_id,title,author_id,time,comment_num,visitor_num,price,img from art  order by value  desc limit $data[id],$this->pageNum";
        $res=$this->db->query($sql);
        return $this->titleFb($res->result_array());
    }
    public function getHotRecet()
    {
        //取得全部的hot内容
        $sql="select art_id,title,price,author_id,time,comment_num,visitor_num,price,img from art where unix_timestamp(time) >(unix_timestamp(now()) - 259200)";//查看三天以内的
        //$res = $this->db->query("select time,item_id,state,ordor,info from ord where seller = $userId and  unix_timestamp(time) > unix_timestamp(now()) - 86400 or state = $this->printed or state = $this->Ordered");
        $res=$this->db->query($sql);
        if($res){
            return $this->titleFb($res->result_array());
        }
    }
    public function delById($id)
    {
        //根据art_id删除id,删除id的同时，评论也应该相应删除，应该成为硬性准则
        return $this->db->query("delete * from art where art_id = $id");
    }
    public function getTotal($part_id)
    {//根据part_id 计算总数的函数
        $res=$this->db->query("select count(*) from art where part_id = $part_id");
        return $res->result_array();
    }
    public function allTotal()
    {//这个是获得art中所有的条数的函数
        $res=$this->db->query("select count(*) from art ");
        return $res->result_array();
    }
    public function getById($artId)
    {
        //通过artId将所有的信息输出，大概很简单吧
        $sql = "select title,content,time,price,img,author_id,visitor_num,comment_num,part_id from art where art_id  = $artId";
        $res = $this->db->query($sql);
        return $this->getArray($this->dataFb($res->result_array()));
    }
    public function getUserart($userId)
    {//获得某一个用户所有的art，只是包含紧要的,对应space index
        $res = $this->db->query("select new,art_id,title,time,commer,visitor_num,comment_num,price,img from art where author_id = '$userId' order by value desc");
        return $this->titleFb($res->result_array());
    }
    public function addvisitor($artId)
    {//为art添加浏览者数目,因为和用户想要的没有太大关系，所以不需要什么返回值,增加value
        $this->db->query("update art set visitor_num = visitor_num +1,value = value + 10  where art_id = '$artId'");
    }
    public function addComNum($artId,$comerId)
    {//添加评论者信息，需要给出art_id,评论者id,需要更新new,commer,comment_num,同时增加value
        $this->db->query("update art set comment_num  = comment_num+1,new  = 1,commer = '$comerId',value = value+600 where art_id  = '$artId'");
        //大概是增加20分钟的样子，
    }
    public function changeNew($artId)
    {//当用户自己浏览过之后，就将其中的new设置成为0，只是commer不变，目前再_getIndexData中有调用
        $this->db->query("update art set new = 0 where art_id  = '$artId'");
    }
    public function getIdByKey($key,$partId = -1)
    {
        //通过%like%匹配检测有没有相似的,这次只是获取id而已
        //记忆中，貌似可以通过其他的方式进行这种匹配查询,应该添加限制，比如时间不能超过1年，或者是三个月等等
        if($partId == -1)
            $res = $this->db->query("select art_id,value from art where title like '%$key%' or keyword like '%;$key;%'");//关键字的存储要；key；的形式，就是两边都是；，查找的时候，也要两边都是;，这样，匹配出来的，就是完整的关键字
        else
            $res = $this->db->query("select art_id,value from art where title like '%$key%' or keyword like '%;$key;%' AND part_id = '$partId'");
        return $res->result_array();
    }
    public function getIdMap($key,$sql)
    {
        $sql = "select art_id,value from art where ( title like '%$key%' or keyword like '%;$key;%' ) AND ( ".$sql." )";
        $res = $this->db->query($sql);
        return $res->result_array();
        //对应map中的搜索，地图内所有商店的关键字，一一查找
    }
    public function getSeaResById($id)
    {
        //get search result by id,根据id获得具体搜索内容的函数
        $res = $this->db->query("select price,img,title,part_id,time,author_id,visitor_num,comment_num from art where art_id = '$id'");
        return $this->getArray($this->titleFb($res->result_array()));
    }
    public function getMaster($artId)
    {
        $res = $this->db->query("select author_id from art where art_id = '$artId'");
        return $this->getArray($res->result_array());
    }
    public function getUserInsert($artId)
    {//根据id取得用户自己当初插入的那些，然后，修改
        $res = $this->db->query("select title,part_id,author_id,content,price,keyword from art where art_id = '$artId'")    ;
        return $this->getArray($this->dataFb($res->result_array()));
    }
    public function reAdd($data,$artId)
    {
        $data["tit"] = addslashes($data["tit"]);
        $data["cont"] = addslashes($data["cont"]);
        if($data["img"]==0){
            return $this->db->query("update art set title = '$data[tit]',content = '$data[cont]',part_id = '$data[part]',price = '$data[price]',keyword = '$data[keys]',time = now() where art_id = '$artId'");
        }else{
            return $this->db->query("update art set title = '$data[tit]',content = '$data[cont]',part_id = '$data[part]',price = '$data[price]',keyword = '$data[keys]',img = '$data[img]',time = now() where art_id = '$artId'");
        }
        //对应write/reAdd中的函数调用
    }
    public function getImgId($artId)
    {
        //获得art中img和author_id,为/write/reAdd效力
        $res = $this->db->query("select img,author_id from art where art_id = '$artId'");
        return $this->getArray($res->result_array());
    }
    private function getArray($arr)
    {
        if(count($arr)==1)return $arr[0];
        return false;
    }


}
?>

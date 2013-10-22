<?php
/**
 * 这个文件存贮了所有关于img的操作,所有的图片上传之后都会存储在这里，不过，更多的是为其他的地方上传需要图片提供支持，直接调用这里的图片就是了
 * img_id  img的唯一独立id，它的标识
 * user_id 上传人的id
 * img_name，图片的系统命名，算是为了担心重复而采取的措施吧，由时间戳和用户的Id共同决定的;
 * upload_name 上传时候的名字
 * upload_time 上传时间
 * intro 关于图片的一些介绍，随便说说
 **/
class Img extends Ci_Model
{

    function __construct()
    {
        parent::__construct();
    }
    public function dataFb($array)
    {
        if(count($array)){
            $len = count($array);
            if(array_key_exists("upload_name",$array[0])){
                for($i = 0; $i < $len;$i++){
                    $array[$i]["upload_name"] = stripslashes($array[$i]["upload_name"]);
                }
            }
            if(array_key_exists("intro",$array[0])){
                for($i = 0; $i < $len;$i++){
                    $array[$i]["intro"] = stripslashes($array[$i]["intro"]);
                }
            }
        }
        return $array;
    }
    function mupload($name,$upload_name,$id){
        //向数据库中添加上传的图片的信息
        $upload_name = addslashes($upload_name);
        $res = $this->db->query("insert into img(user_id,img_name,upload_name,upload_time) values('$id','$name','$upload_name',now())");
        return $res;
        //return $res->result();
        //如果使用$res->result的话,会报错,说没办法转为string,而直接return $res答案是正确的
    }
    function getImgName($user_id){
        //获得该用户所有上传的图片的服务器名称
        $res = $this->db->query("select img_name from img where user_id  = $user_id");
        return $res->result_array();
    }

    function user_photo($name,$user_id){
        //这个是为用户上传头像的函数
        $sql="update user set user_photo = '$name' where user_id = '$user_id'";
        return $this->db->query($sql);
    }
    function judgesame($name){
        //检查是否有相同的图片名字,存在的函数
        $sql="select img_id from img where upload_name = '$name'";
        $res=$this->db->query($sql);
        return $res->num_rows;
    }
    function showimg_all(){
        /*$sql="select * from img where user_id = $user_id"             ;
         *将来根据需要，使用上面的功能,其实下面的很不科学，应该加上一个from
         */
        $sql="select * from img";
        $res=$this->db->query($sql);
        return $res->result_array();
    }
    public function userImgAll($userId){
        //从mbgimglist 中转移过来的,查找用户所有的图片
        $sql="select img_id,upload_name,upload_time,img_name from img where user_id = $userId";
        $res=$this->db->query($sql);
        return $res->result();
    }
    function imgdel($name){
        $sql="delete  from img where img_name  = '$name'"               ;
        $res=$this->db->query($sql);
        return $res;
    }
    function getimg_id($user_id){
        /*
         * 通过用户的id，得到该用户所有的图片的id的函数
         *
         */
        $sql="select img_id from img where user_id = '$user_id'";
        $res=$this->db->query($sql);
        return $res->result();
    }
    public function getDetail($imgId)
    {
        //通过id获得图片本来名称，时间，介绍的函数
        $ans = $this->db->query("select upload_time,upload_name,intro from img where img_id = '$imgId'");
        return $this->getArray($ans->result_array());
    }
    function img_name($img_id){
        /*
         * 通过img——id得到图片名称的函数,返回的不再是函数，而是名字，因为每个id对应的只是一个名字
         */
        $sql="select img_name from img where img_id = '$img_id'";
        $res=$this->db->query($sql);
        $res = $res->result_array();
        if(count($res))return $res[0]["img_name"];
        return false;
    }
    private function getArray($arr)
    {
        if(count($arr)){
            $arr = $this->dataFb($arr);
            return $arr[0];
        }
        return false;
    }
    function img_info(){
        /****************************
         * 通过img_id得到图片信息的函数
         */
        $sql="select * from img where img_id = '$img_id'";
        $res=$this->db->query($sql);
        return $this->getArray($res->result_array());
    }
    public function getUserImg($userId)
    {
        //得到img_name,就可以申请缩略图和大图了,img_id用户获得他其他的信息
        $res = $this->db->query("select img_id,img_name from img where user_id = '$userId'");
        return  $res->result_array();
    }
}
?>

<?php
/*************************************************************************
    > File Name :     wrong.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-08-14 20:36:25
 ************************************************************************/
/*
 * 这个函数处理的是出现意外的订单打印，和各种意外情况需要，需要紧急处理，或者是向管理员报错吧，格式为json格式，
 * content 具体内容，不缺定格式，管理员自己查看
 * 如果是意外情况的报告，一般是需要当时触发的环境，用户的id和一些关键字
 */
class Mwrong extends Ci_Model
{
     function __construct()
    {
        parent::__construct();
    }
     public function insert($text)
     {
        $text = json_encode($text);
        $text = addslashes($text);
        $this->db->query("insert into wrong(content) values('$text')");
     }
     public function getAll(){
         //对之前的进行反解码，
         $res = $this->db->query("select id,content from wrong");
         $res = $res->result_array();
         if($res){
             $len = count($res);
             for($i = 0;$i < $len;$i++){
                //$res[$i]["content"] = stripslashes($res[$i]["content"]);
                $res[$i]["content"] = json_decode($res[$i]["content"]);
             }
             return $res;
         }
         return false;
     }
}
?>

<?php
/**
 *  对意外情况处理的函数
 *
 * 这个函数处理的是出现意外的订单打印，和各种意外情况需要，需要紧急处理，或者是向管理员报错吧，格式为json格式，
 * content 具体内容，不缺定格式，管理员自己查看
 * 如果是意外情况的报告，一般是需要当时触发的环境，用户的id和一些关键字
 *  @name :     wrong.php
 *  @author :   unasm < 1264310280@qq.com >
 *  @since :    2013-08-14 20:36:25
 *  @package    model
 */
class Mwrong extends Ci_Model
{
     function __construct()
    {
        parent::__construct();
    }
     public function insert($text)
     {
        $text["text"] .= ", 现在时间是".date("m-d h:i:s");//添加上时间，更好辨别,分析
        $text["text"] = addslashes($text["text"]);
        $wrong  = "";
        //对数组进行编码
        foreach($text as $key => $value){
            $wrong .= $key."&[".$value."&]";//通过转义的分号，应该是没有重复的可能性吧
        }
        $this->db->query("insert into wrong(content) values('$wrong')");
     }
     /**
      * 对wrong进行解码
      * @param string $text 编码之后的字符串
      * @return array 解码之后的数组
      */
     protected function deWrong($text)
     {
         static $res ;
         $tmp = explode("&]",$text);
         //之所以 -1 是因为在
         for ($i = 0,$len = count($tmp) - 1; $i < $len; $i++) {
            $keyVal = explode("&[",$tmp[$i]);
            $res[$keyVal[0]] = $keyVal[1];
            //$tmpArr[$keyVal[0]] = $keyVal[1];
            //array_push($res,$tmpArr);
         }
         return $res;
     }
     public function getAll(){
         //对之前的进，
         $res = $this->db->query("select id,content from wrong where id > 52");
         if($res->num_rows){
             $len = $res->num_rows;
             $res = $res->result_array();
             for($i = 0 ; $i < $len;$i++){
                $res[$i]["content"] = $this->deWrong($res[$i]["content"]);
             }
             return $res;
         }
         return false;
     }
     /**
      * 错误日志的id，处理看完之后，删除
      * @param int $wrongId 错误情况处理的id
      * @return bool
      */
     public function del($wrongId)
     {
         return $this->db->query("delete from wrong where id = $wrongId");
     }
}
?>

<?php
/**
 *  对意外情况处理的函数,就像一个检测机器
 *
 * 这个函数处理的是出现意外的订单打印，和各种意外情况需要，需要紧急处理，或者是向管理员报错吧，格式为json格式，
 * content 具体内容，不缺定格式，管理员自己查看
 * 如果是意外情况的报告，一般是需要当时触发的环境，用户的id和一些关键字
 *  @name :     wrong.php
 *  @author :   unasm < 1264310280@qq.com >
 *  @since :    2013-08-14 20:36:25
 *  @package    model
 */
class Mwrong extends Ci_Model {
    /**
     * 构造函数
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * 向数据库报错，检查各种意外情况，监控系统运行
     * @param string $text 想要插入的内容，最初设计为数组，现在慢慢想变成插入string,其他的内容，如id,时间，都是自动
     */
    public function insert($text) {
        if(is_array($text)){
            $text = $text['text'];
        }
        $wrong = mysql_real_escape_string($text);
        $sql = "INSERT INTO wrong(content) VALUES('$wrong')";
        $this->db->query($sql);
    }

    /**
    * 对wrong进行解码
    * 已经被废弃。。。没有编码解码的必要
    * @param string $text 编码之后的字符串
    * @return array 解码之后的数组
    */
    protected function decodeContent($text) {
        static $res ;
        $tmp = explode('&]', $text);
        for ($i = 0, $len = count($tmp) - 1; $i < $len; $i ++) {
            $keyVal = explode('&[', $tmp[$i]);
            $res[$keyVal[0]] = $keyVal[1];
        }
        return $res;
    }

    /**
     * 获取所有错误日志
     * @return boolean | array
     */
    public function getAll() {
        $sql = "SELECT id, content, time FROM wrong";
        $res = $this->db->query($sql);
        if ($res->num_rows != 0) {
            $res = $res->result_array();
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 根据日志的编号删除错误日志
     * @param int $logId
     * @return boolean
     */
    public function deleteLog($logId) {
        $logId = (int)$logId;
        if ($logId === 0) {
            return false;
        }
        $sql = "DELETE FROM wrong WHERE id = $logId";
        return $this->db->query($sql);
    }
}
?>

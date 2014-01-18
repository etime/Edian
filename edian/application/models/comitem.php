<?php
/*************************************************************************
    > File Name :     ../application/models/comItem.php
    > Author :        unasm
    > Mail :          douunasm@gmail.com
    > Last_Modified : 2013-07-27 22:55:13
 ************************************************************************/
/*id 主键 作为索引的存在
//score 用户的评分，0-10，不过貌似没有比tinyint更小的int了
//context 用户的评价信息，之前一致在想楼钟楼的情况，决定将其他的评价也放到context中，如果有的话，
    //就是其他人对评论的回复，于这个合并，节省空间，加快速度，然后利用js分解
//格式如下context&context|time|user&context|....
//time 时间，精确到日期，更加精确就没有必要了
    user_id 评论者的id，方便添加其他的信息
    item_id 回复的那个商品的id,大概这个才是最关键的吧
 */
class ComItem extends CI_Model {

    // 一天的秒数
    var $lenDay;

    function __construct() {
        parent::__construct();
        $this->lenDay = 60 * 60 * 24;
    }

    /**
     * 对评论进行编码
     * <pre>
     * context 数组的格式定义：
     *      第一维数组：
     *          context[0]   用户对商品的评论
     *          context[1~n] 用户 A 对用户 B 的评论
     *      第二维数组：
     *          context[i][0]  用户 A 的用户编号
     *          context[i][1]  用户 B 的用户编号，如果 i = 0，context[i][1] 是商品编号
     *          context[i][2]  用户 A 评论的时间
     *          context[i][3]  用户 A 对用户 B 评论内容
     *      编码方法：
     *          1. context[i][0~3] 之间用 '`' 分开拼接成字符串
     *          2. context[0~n] 之间用 '~' 分开拼接成字符串
     * </pre>
     * @param array $context 待编码评论数组
     * @return string 编码之后的字符串
     */
    protected function _encodeContext($context) {
        for ($i = 0, $len = (int)count($context); $i < $len; $i ++) {
            $context[$i] = implode('`', $context[$i]);
        }
        $context = implode('~', $context);
        return $context;
    }

    /**
     * 对评论进行解码，解码方法与编码方法相反，详细请看 $this->_encodeContext 的注释
     * @param string $context 待解码字符串
     * @return array 解码之后的数组
     */
    protected function _decodeContext($context) {
        $context = explode('~', $context);
        for ($i = 0, $len = (int)count($context); $i < $len; $i ++) {
            $context[$i] = explode('`', $context[$i]);
        }
        return $context;
    }

    /**
     * 获取指定编号的商品的评论信息
     * @param int $itemId 商品编号
     * @return boolean | array
     */
    public function getItemComment($itemId) {
        $itemId = (int)$itemId;
        if ($itemId === 0) {
            return false;
        }
        $sql = "SELECT id, score, context, time, user_id FROM comItem WHERE item_id = $itemId";
        $res = $this->db->query($sql);
        if ($res->num_rows == 0) {
            return false;
        } else {
            $res = $res->result_array();
            for ($i = 0, $len = (int)count($res); $i < $len; $i ++) {
                $res[$i]['context'] = $this->_decodeContext($res[$i]['context']);
            }
            return $res;
        }
    }

    /**
     * 获取指定商店编号的最近用户评论
     * @param int $storeId 商店编号
     * @param int $day 指定的天数
     * @return boolean | array
     */
    public function getRecentComment($storeId, $day) {
        $day = (int)$day;
        $storeId = (int)$storeId;
        if ($storeId == 0) {
            return false;
        }
        $second = $this->lenDay * $day;
        $sql = "SELECT id, score, context FROM comItem WHERE unix_timestamp(time) > (unix_timestamp(now()) - $second) AND seller = $storeId";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            return false;
        } else {
            $len = $res->num_rows;
            $res = $res->result_array();
            for ($i = 0; $i < $len; $i ++) {
                $res[$i]['context'] = $this->_decodeContext($res[$i]['context']);
            }
            return $res;
        }
    }

    /**
     * 添加一个商品评价，并更新商品的 rating
     * <pre>
     * 需要添加的东西有
     *      score      对商品满意度评分，由 $data 数组提供
     *      context    对商品详细评论内容，由 $data 数组提供
     *      time       评论时间，系统自动添加
     *      user_id    评论者编号，由 $data 数组提供
     *      item_id    被评论商品编号，由 $data 数组提供
     *      seller     被评论商品所属商店编号，由 $item_id 从 item 数据表中获取
     * </pre>
     * @param array $data
     * @return boolean | int 如果成功添加，返回最后一次添加评论编号，否则返回 false
     */
    public function insert($data) {
        $this->load->model('mitem');
        $seller = $this->mitem->getMaster($data['item_id']);
        if ($seller === false) {
            return false;
        } else {
            $seller = (int)$seller;
        }
        // 对评论内容进行编码
        $temp[0] = $data['text'];
        $data['text'] = $this->_encodeContext($temp);
        $data['text'] = mysql_real_escape_string($data['text']);

        $sql = "INSERT INTO comItem(score, context, time, user_id, item_id, seller) VALUES('$data[score]', '$data[text]', date_format(now(),'%Y-%m-%d'), '$data[user_id]', '$data[item_id]', $seller)";
        $res = $this->db->query($sql);
        if ($res) {
            $res = $this->db->query("select last_insert_id()");
            $res = $res->result_array();
            $sql = "UPDATE item SET satisfyScore = satisfyScore + $data[score] where id = $data[item_id]";
            $this->db->query($sql);

            // 更新 rating 信息
            $addon = $this->config->item('satisfyScoreAffect') * ($data['score'] - 5);
            $itemId = $data['item_id'];
            $sql = "UPDATE item SET rating = rating + $addon WHERE id = $itemId";
            $this->db->query($sql);

            return $res["0"]["last_insert_id()"];
        } else {
            return false;
        }
    }

    /**
     * 获取指定评论编号的详细评论内容
     * @param int $cmtId 评论编号
     * @return array | boolean
     */
    public function getComment($cmtId) {
        $cmtId = (int)$cmtId;
        if ($cmtId == 0) {
            return false;
        }
        $sql = "SELECT context FROM comItem WHERE id = $cmtId";
        $cmt = $this->db->query($sql);
        if ($cmt->num_rows == 0) {
            return false;
        } else {
            $cmt = $cmt->result_array();
            $cmt = $cmt[0]['context'];
            $cmt = $this->_decodeContext($cmt);
            return $cmt;
        }
    }

    /**
     * 获取指定评论编号的所有评论者的编号
     * @param int $cmtId 评论编号
     * @return array | boolean
     */
    public function getCmterId($cmtId) {
        $cmt = $this->getComment($cmtId);
        if ($cmt == false) {
            return false;
        } else {
            for ($i = 0, $len = (int)count($cmt); $i < $len; $i ++) {
                $cmt[$i] = $cmt[$i][0];
            }
            return $cmt;
        }
    }

    /**
     * 给指定评论编号的评论追加一个评论
     * @param $data 参数数组，$data['cmtId'] 存放评论编号，$data['comment'] 存放评论数组
     * @return boolean 更新成功返回 true，否则返回 false
     */
    public function updateComment($data) {
        $cmtId = $data['cmtId'];
        $oldComment = $this->getComment($cmtId);
        $len = (int)count($oldComment);
        $oldComment[$len] = $data['comment'];
        $newComment = $this->_encodeContext($oldComment);
        $sql = "UPDATE comItem SET context = '$newComment' WHERE id = $cmtId";
        return $this->db->query($sql);
    }
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
    public function append($data,$comId)
    {
        //添加回复
        $data["text"] = addslashes($data["text"]);
        $sql = "update comItem set context = concat( context,".'\'&'.$data['text'].'|\''.",date_format(now(),'%Y-%m-%d'),'".'|'.$data["userName"]."') where id = $comId";
        return $this->db->query($sql);
    }
    public function update($arr,$comId)
    {
        $cont = $this->formStr($arr);//整理格式，将传入的数组变成字符串
        $sql = "update comItem set context = '".$cont."' where id = $comId";
        return $this->db->query($sql);
    }

    public function getUser($id)
    {
        //取得user——id
        $res = $this->db->query("select user_id from comItem where id = $id");
        if($res){
            $res = $res->result_array();
            return $res[0]["user_id"];
        }
        return false;
    }
    public function getContext($Id)
    {
        //获得评论的内容
        //$res = $this->db->query("select context from comItem where id = $id");
        $res = $this->db->query("select user_id,context,time from comItem where id = $Id");
        if($res){
            $res = $this->conForm($res->result_array());
            return $res[0]["context"];
        }
        return false;
    }
}
?>

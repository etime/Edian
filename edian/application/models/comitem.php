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
class ComItem extends Ci_Model{
    var $lenDay;

    /**
     * 构造函数
     */
    function __construct() {
        parent::__construct();
        $this->lenDay = 86400;
    }

    public function selItem($itemId) {
        $itemId = (int)$itemId;
        if ($itemId === 0) {
            return false;
        }
        $sql = "SELECT id, score, context, time, user_id FROM comItem WHERE item_id = '$itemId'";
        $res = $this->db->query($sql);
        return $res->result_array();
    }

    //对arr中的context格式整理，整理成数组
    protected function conForm($arr) {
        if ($arr == false) {
            return false;
        }
        $this->load->model('user');
        for ($i = 0, $len = count($arr); $i < $len; $i ++) {
            $temp = explode('&', $arr[$i]['context']);
            $arr[$i]['context'] = Array();
            $userName = $this->user->getNameById($arr[$i]['user_id']);
            $arr[$i]['context'][0]['user_name'] = $userName;
            $arr[$i]['context'][0]['time'] = $arr[$i]['time'];
            $arr[$i]['context'][0]['context'] = $temp[0];
            for ($j = 1, $lenj = count($temp); $j < $lenj; $j ++) {
                $tempj = explode('|', $temp[$j]);
                $now = Array();
                $now['user_name'] = $tempj[2];
                $now['time'] = $tempj[1];
                $now['context'] = $tempj[0];
                $arr[$i]['context'][$j]= $now;
            }
        }
        return $arr;
    }

    /**
     * 管理员权限获取用户评论
     * @param int $date
     * @return boolean | array
     */
    public function getSomeDate($date) {
        $date = (int)$date;
        $date = $this->lenDay * $date;
        $sql = "SELECT user_id, id, score, context, time, item_id FROM comItem WHERE unix_timestamp(time) > (unix_timestamp(now()) - $date)";
        $res = $this->db->query($sql);
        if ($res->num_rows === 0) {
            $res = $res->result_array();
            $res = $this->conForm($res);
            return $res;
        } else {
            return false;
        }
    }

    /**
     * 老板权限获取用户评论
     * @param int $userId
     * @param int $date
     * @return boolean | array
     */
    public function getUserDate($userId, $date) {
        $userId = (int)$userId;
        if ($userId == 0) {
            return false;
        }
        $date = (int)$date;
        $date = $this->lenDay * $date;
        $sql = "SELECT user_id, id, score, context, time, item_id FROM comItem WHERE seller = $userId && unix_timestamp(time) > (unix_timestamp(now()) - $date)";
        $res = $this->db->query($sql);
        if ($res) {
            $res = $res->result_array();
            $res = $this->conForm($res);
            return $res;
        } else {
            return false;
        }
    }
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/**********************************************************************************************************************/

    public function insert($data)
    {
        $data["text"] = addslashes($data["text"]);
        $this->load->model("mitem");
        $seller = $this->mitem->getMaster($data["item_id"]);//将商品主人的id查找出来，以便将来方便搜索
        $sql = "insert into comItem(score,context,time,user_id,item_id,seller) values('$data[score]','$data[text]',date_format(now(),'%Y-%m-%d'),'$data[user_id]','$data[item_id]','$seller[author_id]')";
        $res = $this->db->query($sql);
        if($res){
            $res = $this->db->query("select last_insert_id()");
            $res = $res->result_array();
            $this->db->query("update item set judgescore = judgescore + $data[score] where id = $data[item_id]");
            return $res["0"]["last_insert_id()"];
        }
        return false;
    }
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
    private function formStr($arr)
    {
        $len = count($arr);
        if($arr && $len){
            $res = $arr[0]["context"];
            for($i = 1;$i < $len;$i++){
                $res.="&".$arr[$i]["context"]."|".$arr[$i]["time"]."|".$arr[$i]["user_name"];
            }
            return $res;
        }
        return false;
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

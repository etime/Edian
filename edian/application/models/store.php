<?php
/**
 *
 * @since 2013-11-24 09:52:12
 * @author farmerjian <chengfeng1992@hotmail.com>
 * @todo 完成所有对 store 表中数据的相关操作
 * @todo store表的credit is wrong ,the biggest num is 0.99,it can't be done
 *
 */
class Store extends CI_Model {
    /**
     * 构造函数
     *
     * @author farmerjian <chengfeng1992@hotmail.com>
     * @since 2013-11-24 09:55:40
     */
    public function __construct() {
        parent::__construct();
        $this->load->model("mwrong");
    }
    /**
     * 构成more中的数组，
     *
     * 注意，为了实现反转码，必须不能存在|=两种字符串
     * @param array $arr 想转化为字符串的一维数组
     */
    protected function encodeMore($arr)
    {
        $str = "";
        foreach ($arr as $key => $val) {
            if($str)
                $str .= '|' . $key . '=' .$val;
            else
                $str = $key . '=' .$val;
        }
        echo $str;
        return $str;
    }
    /**
     * 将more从一个字符串的状态变幻成为数组
     * @param string $str more在数据库中的存储数组
     * @return array
     */
    protected function decodeMore($str)
    {
        $arr = Array();
        $tmpArr = explode("|" , $str);
        for($i = 0,$len = count($tmpArr) ; $i < $len; $i++){
            $keyval = explode('=' , $tmpArr);
            if(count($keyval) === 2){
                array_push($arr, Array($keyval[0] => $keyval[1]) );
            }else{
                $this->mwong->insert("model/store/". __LINE__ . "行count的结果大于2，不应该出现,此时对应的参数str = " . $str);
            }
        }
        return $arr;
    }
    /**
     * 根据传入的more在对应的数据库中进行查找更改，修改数据库的more内容
     * 并不在这里插入,之所以这样，首先是想减少一次sql修改，第二，更加灵活吧，交给调用的地方进行处理
     * @param array $more   想要修改的内容
     * @param int   storeId 修改more内容的商店id
     * @return 返回需要插入的字符串
     */
    protected function formMore($more , $storeId)
    {
        $res = $this->db->query("select more from store where id = ". $storeId);
        $res = $res->result_array();
        $orginMore = $this->decodeMore($res[0]["more"]);
        foreach ($more as $key => $val) {
            if(!$val) continue;//如果没有对应的值更新，不更改，也不添加
            if(array_key_exists($key,$more)){
                $orginMore[$key] = $val;
            }else{
                array_push($orginMore,Array($key => $val));
            }
        }
        return $this->encodeMore($orginMore);
    }
    /**
     * 修改store信息的时候使用的函数
     *
     * @param   array   $arr     array中的规则是这样的，没一个key对应的都是数据库中的字段名，后面是想更改成的数值
     * @return  boolen          修改成功，或者失败
     * @author  unasm
     * @since   2013-12-13 20:38:16
     */
    public function update($arr , $more ,$storeId)
    {
        $sql = 'update store set ';
        $cnt = false;
        foreach ($arr as $key => $val) {
            if($val){
                $val = mysql_real_escape_string($val);
                //做所以会出现val为false的情况，我想是因为val不合法，被更改成为false了
                if($cnt){
                    $cnt .= ', ' .$key . '=' . $val;
                }else{
                    $cnt = $key . '=' . $val;
                }
            }
        }
        $sql .= $cnt . 'where id = ' .$storeId;
        return $this->db->query($sql);
    }
    /**
     * 利用提供的 storeId 和 ownerId，判断一个 owner 是否拥有这个 store
     *
     * @param int $storeId 商店 id
     * @param int $ownerId 老板 id
     * @return bool 如果匹配，返回 true，否则返回 false
     */
    public function isMatch($storeId, $ownerId) {
        // 对要匹配的字符进行转义
        $storeId = mysql_real_escape_string($storeId);
        $ownerId = mysql_real_escape_string($ownerId);

        $sql = "SELECT count(*) FROM store WHERE id = $storeId && ownerId = $ownerId";
        $res = $this->db->query($sql)->result_array();
        return $res[0]['count(*)'] == 1 ? true : false;
    }

    /**
     * 在判断出 storeId 存在的情况下，提取它的分类列表
     *
     * @param int $storeId
     * @return string
     */
    public function getCategoryByStoreId($storeId) {
        // 对要匹配的字符串进行转义
        $storeId = mysql_real_escape_string($storeId);

        $sql = "SELECT category FROM store WHERE id = $storeId";
        $res = $this->db->query($sql)->result_array();
        return $res[0];
    }
}
?>

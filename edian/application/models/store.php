<?php
/**
 * 
 * @since 2013-11-24 09:52:12
 * @author farmerjian <chengfeng1992@hotmail.com>
 * @todo 完成所有对 store 表中数据的相关操作
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
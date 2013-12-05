<?php
/**
 * 处理所有和商品有关的信息处理
 * 
 * @author farmerjian <chengfeng1992@hotmail.com>
 * @since 2013-11-24 12:37:49
 * @todo 所有和商品有关的数据信息处理
 *
 */
class Item extends CI_Model {
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct();
	}

    /**
     * 将输入的字符串转义后返回
     * 这样做的好处：经过转义的字符串，在一定程度上能够防止 sql 注入，对网站安全性的提高会有一点作用
     *
     * @param  string $val
     * @return string
     */
    private function _escape($val) {
        return mysql_real_escape_string($val);
    }

	/**
	 * 用于添加一个具体的商品
	 * $data 应该包含这些内容：
	 *     title         :  string          商品名字
	 *     storeNum      :  int             商品存货
	 *     price         :  float           商品价格
	 *     attr          :  string          商品属性
	 *     detail        :  string          商品详细描述
	 *     mainThumbnail :  string          商品主缩略图
	 *     thumbnail     :  string          商品缩略图
	 *     category      :  string          商品所属分类
	 *     deliveryTime  :  string          商品的送货时间
	 *     putawaryTime  :  string          商品的上架时间
	 *     briefInfo     :  string          商品简要描述
	 *     belongsTo     :  int             商品所属 boss 的 id
	 * 
	 * @param array $data
	 */
	public function addItem($data) {
        // 先对所有需要加入数据库中的内容转义
        for ($data as $key => $val) {
            $data[$key] = $this->_escape($val);
        }

		$sql = "INSERT INTO item(title, attr, detail, mainThumbnail, thumbnail, category, deliveryTime," .
            " putawaryTime, briefInfo, ) VALUES ('$data[title]', '$data[attr]')";
        $this->db->query($sql);
	}
}
?>
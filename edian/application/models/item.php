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
	 * 
	 * @author farmerjian <chengfeng1992@hotmail.com>* 
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * 用于添加一个具体的商品
	 * $data 应该包含这些内容：
	 *     title ： string
	 *     storeNum  : int
	 *     price  : float
	 *     attr  : string
	 *     detail  ： string
	 *     mainThumbnail  : string
	 *     thumbnail  ： string
	 *     category  : string
	 *     deliveryTime  : string
	 *     putawaryTime  : string
	 *     briefInfo  : string
	 *     belonsTo  : int
	 * 
	 * @param array $data
	 */
	public function addItem($data) {
		$data['title'] = addslashes($data['title']);
		$data['attr'] = addslashes($data['attr']);
		$data['detail'] = addslashes($data['detail']);
		$data['mainThumbnail'] = addslashes($data['mainThumbnail']);
		$data['thumbnail'] = addslashes($data['thumbnail']);
		$data['category'] = addslashes($data['category']);
		$data['deliveryTime'] = addslashes($data['deliveryTime']);
		$data['putawaryTime'] = addslashes($data['putawaryTime']);
		$data['briefInfo'] = addslashes($data['briefInfo']);
		
		$sql = "INSERT INTO item "
	}
}
?>
<?php
/**
 * 用于分页，对提供进来的数据进行划分
 *
 * @author farmerjian
 * @since 2013-11-19 15:43:51
 * @todo 新建一个函数，用于花粉数据
 *
 */
class PageSplit {
	/**
	 * 按页面显示数据条目的数据分割将要显示的数据
	 *
	 * @author farmerjian
	 * @param array $data
	 * @param int $pageSize  每页显示的条目
	 * @param int $pageId   当前的页号
	 * @return array  输出信息：对输入的数据分割后得到的条目数组($newData)以及总的页号($pageAmount)
	 */
	public function split($data, $pageId, $pageSize) {
		$itemAmount = count($data);
		$pageAmount = (int)($itemAmount / $pageSize);
		if ($itemAmount % $pageSize != 0) $pageAmount ++;
		if ($pageId < 1) $pageId = 1;
		if ($pageId > $pageAmount) $pageId = $pageAmount;
		$newData = array();
		for ($i = ($pageId - 1) * $pageSize; $i < min($pageId * $pageSize, $itemAmount); $i ++) {
			array_push($newData, $data[$i]);
		}
		$ans = array();
		$ans['newData'] = $newData;
		$ans['pageAmount'] = $pageAmount;
		return $ans;
	}
}
?>

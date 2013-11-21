<?php
/**
 * 用于分页，对提供进来的数据进行划分
 *
 * @author 	farmerjian
 * @package library
 * @since 	2013-11-19 15:43:51
 * @todo 新建一个函数，用于划分数据
 *
 */
class PageSplit {
	/**
	 * 按页面显示数据条目的数据分割将要显示的数据
	 *
	 * 输出信息：对输入的数据分割后得到的条目数组($newData)以及总的页号($pageAmount)
	 *
	 * @author farmerjian
	 * @param array $data    条目数组
	 * @param int $pageSize  每页条目的数量
	 * @param int $pageId    当前的页号
	 * @return array
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
    /**
     * <code>
     * <ul class = "pagesplit">
     *  <li><a href = "">1</a></li>
     *  <li><a href = "">2</a></li>
     *  <form action="" method="get" accept-charset="utf-8">
     *  <input type="text" name="pageId" id="pageId"  />
     *   </form>
     * </ul>
     * </code>
     * @todo 按照这个规则，返回一个字符串
     */
	public function setPageUrl($commonUrl, $pageId, $pageAmount) {
		if ($pageId > $pageAmount) $pageId = $pageAmount;
		if ($pageId < 1) $pageId = 1;
		$ans = "<ul class=\"pagesplit\" id=\"pagesplit\">";
		for ($i = max(1, $pageId - 2); $i < $pageId; $i ++) {
			$curPageUrl = $commonUrl . '/' . $i;
			$ans .= "<li><a href=\"" . $curPageUrl . "\">" . $i . '</a></li>';
		}
		$ans .= '<li>' . $pageId . '</li>';
		for ($i = $pageId + 1; $i <= min($pageAmount, $pageId + 2); $i ++) {
			$curPageUrl = $commonUrl . '/' . $i;
			$ans .= "<li><a href=\"" . $curPageUrl . "\">" . $i . '</a></li>';
		}
		$ans .= '</ul>';
		return $ans;
	}
}
?>

<?php
/**
 * 用于处理分页相关的操作，包括：对提供进来的数据进行划分，提供页号的 html 代码
 *
 * @author  farmerjian
 * @package library
 * @since   2013-11-19 15:43:51
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
    public function html()
    {
        $this->load->view("test");
    }
    /**
     * 显示页面按钮，包括跳转页面功能的实现，其主要 html 代码如下：
     *
     * <code>
     * <ul class = "pagesplit" id = pagesplit>
     *     <li><a href = "">1</a></li>
     *     <li><a href = "">2</a></li>
     *     <span class="toalPage">共有 x 页</span>
     *     <form action="" method="get" accept-charset="utf-8">
     *         跳到<input type="text" name="pageId" id="pageId"/>页
     *         <input type="submit" value="确定"/>
     *     </form>
     * </ul>
     *<form action="" method="get" accept-charset="utf-8">
     *       <span>当前1/3</span>
     *       <a href = "">第一页</a>
     *       <a href = "">上一页</a>
     *       <a href = "">下一页</a>
     *       <span>
     *           <input type="text" name="pageId"   />
     *       </span>
     *       <a href = "">尾页</a>
     *   </form>
     *   href后面的是接收这个响应的url，action后面的也是接收对应的url
     * </code>
     *
     * @author farmerjian
     * @param string $commonUrl  所有调用 controller 的公共接口
     * @param int $pageId  当前的页号
     * @param int $pageAmount  总共的页数
     * @return string
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
        $ans .= "<span class=\"toalPage\">共有 $pageAmount 页</span>";
        $ans .= "<form action=\"$commonUrl\" method=\"get\" accept-charset=\"utf-8\">";
        $ans .= "跳到<input type=\"text\" name=\"pageId\" id=\"pageId\"/>页";
        $ans .= "<input type=\"submit\" value=\"确定\"/>";
        $ans .= '</form></ul>';
        return $ans;
    }
}
?>

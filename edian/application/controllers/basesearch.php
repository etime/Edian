<?php
class BaseSearch extends MY_Controller {

    // 非法字符集和
    protected $IllegalString;

    function __construct() {
        parent::__construct();
        $this->load->model('store');
        $this->load->model('mitem');
        $this->load->config('edian');
        $this->load->library('pagesplit');

//         设置非法字符集
        $this->IllegalString = "` -=[]\\;',./~_+)(*&^%$#@!{}|:\"<>?`-=·「、；，。/《》？：“|}{+——）（×&……%￥#@！～";
    }

    /**
     * 判断一个数是否在一个按升序排列的数组中，使用二分查找
     * @param array $temp 目标数组
     * @param int $val 待查找的数
     * @return boolean 如果存在的话，返回 true，否则返回 false
     */
    protected function _isInArray($temp, $val) {
        $len = (int)$temp;
        $L = 0;
        $R = $len - 1;
        while ($L < $R) {
            $mid = ($L + $R) >> 1;
            if ($temp[$mid] < $val) {
                $L = $mid + 1;
            } else if ($temp[$mid] > $val) {
                $R = $mid;
            } else {
                return true;
            }
        }
        if ($temp[$L] == $val) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 提取数组 array2 中没有在数组 array1 中出现过的元素
     * @param array $array1 数组 array1
     * @param array $array2 数组 array2
     * @return array 提取结果组成的数组
     */
    protected function _getUniqueValue($array1, $array2) {
        $ans = array();
        for ($i = 0, $len = (int)count($array2); $i < $len; $i ++) {
            if (! $this->_isInArray($array1, $array2[$i])) {
                array_push($temp, $array2[$i]);
            }
        }
        return $ans;
    }

    /**
     * 合并两个按照升序排序的数组，要求两数组中的元素的交集为空，合并之后仍然升序排序
     * @param array $array1 待合并的数组 1
     * @param array $array2 待合并的数组 2
     * @return array 合并之后的数组，仍然是升序排列
     */
    protected  function _mergeArrayAscending($array1, $array2) {
        $ans = array();
        $len1 = (int)count($array1);
        $len2 = (int)count($array2);
        for($p1 = 0, $p2 = 0; ! ($p1 == $len1 && $p2 == $len2); ) {
            if ($p1 == $len1) {
                array_push($ans, $array2[$p2 ++]);
            } else if ($p2 == $len2) {
                array_push($ans, $array1[$p1 ++]);
            } else if ($array1[$p1] < $array2[$p2]) {
                array_push($ans, $array1[$p1 ++]);
            } else if ($array1[$p1] > $array2[$p2]) {
                array_push($ans, $array2[$p2 ++]);
            }
        }
        return $ans;
    }

    /**
     * 把一个二维数组合并成一维数组，二维数组的每一维都按升序排序
     * @param array $srcArray 待合并的二维数组
     * @return array | boolean  合并之后的数组，如果为空返回 false
     */
    protected function _mergeDimensionalArray($srcArray) {
        if (! is_array($srcArray)) {
            $srcArray = array();
        }
        if (array_key_exists(0, $srcArray)) {
            $ans = $srcArray[0];
        } else {
            return false;
        }
        if ($ans == false) {
            $ans = array();
        }
        for ($i = 1, $len = (int)count($srcArray); $i < $len; $i ++) {
            if ($srcArray[$i] == false) {
                continue;
            }
            $temp = $this->_getUniqueValue($ans, $srcArray[$i]);
            $ans = $this->_mergeArrayAscending($temp, $ans);
        }
        return $ans;
    }

    protected function _safeFilter($string) {
//        $string = str_replace('%20', ' ', $string);
//        $string = str_replace('%27', ' ', $string);
//        $string = str_replace('%2527', ' ', $string);
        $string = str_replace('`', ' ', $string);
        $string = str_replace('~', ' ', $string);
        $string = str_replace("!", ' ', $string);
        $string = str_replace('@', ' ', $string);
        $string = str_replace('#', ' ', $string);
        $string = str_replace('$', ' ', $string);
        $string = str_replace('%', ' ', $string);
        $string = str_replace("^", ' ', $string);
        $string = str_replace('&', ' ', $string);
        $string = str_replace('*', ' ', $string);
        $string = str_replace('(', ' ', $string);
        $string = str_replace(')', ' ', $string);
        $string = str_replace('_', ' ', $string);
        $string = str_replace('+', ' ', $string);
        $string = str_replace('-', ' ', $string);
        $string = str_replace('=', ' ', $string);
        $string = str_replace('[', ' ', $string);
        $string = str_replace(']', ' ', $string);
        $string = str_replace('\\', ' ', $string);
        $string = str_replace(';', ' ', $string);
        $string = str_replace('\'', ' ', $string);
        $string = str_replace(',', ' ', $string);
        $string = str_replace('.', ' ', $string);
        $string = str_replace('/', ' ', $string);
        $string = str_replace('{', ' ', $string);
        $string = str_replace('}', ' ', $string);
        $string = str_replace('|', ' ', $string);
        $string = str_replace(':', ' ', $string);
        $string = str_replace('"', ' ', $string);
        $string = str_replace('<', ' ', $string);
        $string = str_replace('>', ' ', $string);
        $string = str_replace('?', ' ', $string);
        return $string;
    }

    /**
     * 过滤敏感字符，将所有敏感字符替换为空格，并将所有连续的空格替换为一个空格，然后拆分成数组返回
     * @param string $key 待过滤字符串
     * @return array 过滤之后的字符串数组
     */
    protected function _filterKeywords($key) {
        echo('原始字符串是 : ' . $key . '<br>');
        $key = $this->_safeFilter($key);
        echo($key);
        $ans = '';
        for ($i = 0, $len = (int)strlen($key); $i < $len; ) {
            if ($key[$i] != ' ') {
                $ans .= $key[$i ++];
            } else {
                while ($i < $len && $key[$i] == ' ') {
                    $i ++;
                }
                if ($i != $len) {
                    $ans .= ' ';
                }
            }
        }
        return explode(' ', $ans);
    }
}
?>
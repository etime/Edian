<?php

/**
 * Class ComStore
 * 包含对 comStore 表的各种操作
 * <pre>
 *  这里简单介绍一下 comStore 表中的字段
 *      id       评论的编号，设置为自增
 *      context  具体的评论，这个涉及到编解码
 *      storeId  被评论的商店的编号
 *      userId   评论者编号
 *      time     评论的具体时间
 * </pre>
 * @author farmerjian<chengfeng1992@hotmail.com>
 * @since 2014-02-28 10:26:32
 */
class ComStore extends CI_Model {
    function __construct() {
       parent::__construct();
       $this->load->config('edian');
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
     * 为某个商店添加一个评论
     * @param array $data 包含各种字段的值
     * @return boolean 如果添加成功，返回 true，否则返回 false
     */
    public function insert($data) {
        $data['context'] = $this->_encodeContext($data['context']);
        $data['context'] = mysql_real_escape_string($data['context']);
        $data['time'] = mysql_real_escape_string($data['time']);
        $data['userId'] = (int)$data['userId'];
        $data['storeId'] = (int)$data['storeId'];
        $sql = "INSERT INTO comStore(context, storeId, userId, time) VALUES('$data[context]', $data['storeId'], $data['userId'], '$data[time]')";
        $ans = $this->db->query($sql);
        return $ans;
    }
}
?>
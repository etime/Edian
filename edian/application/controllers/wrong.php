<?php
/**
 * 向后台插入错误的情况
 * 一般情况下可以直接调用model的wrong插入错误情况，这里是方便前端js向服务器报错
 * @name      ../application/controllers/wrong.php
 * @author    unasm < 1264310280@qq.com >
 * @since     2013-12-02 22:00:45
 * @package   controllers
 */
class Wrong extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("mwrong");
    }
    /*
     * 对应的，一定是ajax请求
     * 只能包含中文，不能出现任何的空格和特殊符号,不然一定不能插入
     */
    public function index()
    {
        $temp["text"] = $this->input->post("text");
        if ( ! preg_match("/[ ~!@#$%^&*()_+`\\=\\|\\{\\}:\\\">\\?<\\[\\];',\/\\.\\-\\\\]/", $temp["text"])) {
            $this->mwrong->insert($temp);
        }
    }
}
?>

<?php
class Boss extends CI_Model {
	function  __construct() {
		parent::__construct();
	}
	
	/**
     * 向 boss 表中新增加一个用户
     * @param array $data
     */
    public function addBoss($data) {
    	$sql = "INSERT INTO boss(nickname, loginName, password, registerTime, email, phone) VALUES('$data[nickname]', '$data[loginName]', '$data[password]', now(), '$data[email]', '$data[phoneNum]')";
    	$this->db->query($sql);
    }
}
?>
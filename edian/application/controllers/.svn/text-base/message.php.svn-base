<?php
不像我写的文件
class Message CI_controller(){
	function __construct (){
		parent::__construct();
		header("Content-Type: text/html;charset=utf-8");
		$this->load->help(array('form','url'));
		$this->load->model('Message_model');
		$this->load->database();
		$this->load->library('table');
	}				
	function index(){
		$this->load->view('message_view');				
	}
	function post(){
		$data=array(
			'id'='',
			'name'=>$this->input->post('name'),
			'url'=> $this->input->post('url'),
			'title'=>$this->input->post('title'),
			'content'=>$this->input->post('content'),
			'data'=>date('Y-m-d')
		);
		$this->Message_model->insert('message',$data)	;
		redirect(site_url());

	}
}
?>	

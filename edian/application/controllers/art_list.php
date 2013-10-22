<?php
/*
 * 这个是分页类,分页类，不过哦，觉得作为一个类
 */
class Art_list extends Controller{
	function __construct()				{
		parent::Controller();
	}
	function listnum(){
		$this->load->library("pagination");
		$this->load->model("mar_list");
		$num=$this->mar_list->listall(2);
		var_dump($num);
		$config['total_rows']=$this->mar_list->listall(2);
		$config['per_page']=2;
		$config['base_url']="index.php/art_list/listnum/";
		$config['use_page_numbers']=true;
		$this->pagination->initialize($config);
		echo $this->pagination->create_links();
	}
}
?>	

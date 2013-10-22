<?php
		class Showart extends Controller{
				function __construct(){
				parent::Controller();
				$this->load->helper('url');
		}
				function index(){
						$this->load->model('mshowart');
						$data['uri'] = $this->uri;
						$data['cont'] = $this->mshowart->showart_content($this->uri->segment(3));
						$data['seg']=$this->uri->segment(3);
						$this->load->view('common_head');
						$this->load->view('art',$data);
						$this->load->view('common_foot');
		}
}
?>	

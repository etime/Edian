<?php
		class showart extends Controller{
				function __construct()				{
						parent::Controller();
				}
				function index(){
						$this->load->model('Mshowart');
						$id = $this->uri->segment(3);
						if(($id>"9")||($id<"0"))$id=1;
						//**上面这一句话还是有问题,留到以后检查吧
						$data['cont']=$this->Mshowart->showart_content($id);
						$data['seg']=$this->uri->segment(3);
						$this->load->view('art',$data);
				}
		}
?>

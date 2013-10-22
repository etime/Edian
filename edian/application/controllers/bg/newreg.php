<?php
class Newreg extends Ci_Controller{
		function __construct()				{
				parent::__construct()				;
				$this->load->model("mbgnewreg");
		}
		function index(){
			//	$data['newall']='$this->mbgnewreg->newreg()';
				$data['newall']=$this->mbgnewreg->newget();
			//	echo "这里是 iｎｄｅｘ of newreg.php controller/bg, when you see these you program is right";
				$this->load->view("m-bg-newreg",$data);
		}
}
?>	

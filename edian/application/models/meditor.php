<?php
class Meditor extends Ci_Model{
		function __construct(){
				parent::__construct();
		}
		function insert_art($id){
				$title=$this->input->post("title");
				$content=$this->input->post("content");
				$sql="insert art values ('$id','','$title','$content',now())";
			//	$sql="update art set title = '$title' ,content  = '$content' , time = 'now()' where art_id = $id";
				//echo $sql;
				if($this->db->query($sql)){
						return 1;				
				}
				return 0;
		}
		function  artchange($id){
				$title = $this->input->post("title");
				$cont=$this->input->post("content");
				$sql="update art set title =  '$title' ,content = '$cont' ,time = 'now()' where art_id = '$id'";
				if($this->db->query($sql)){
						return 1;				
				}
				return 0;
		}
}
?>	

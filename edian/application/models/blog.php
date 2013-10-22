<?php
		class Blog_model extendss CI_Model{
				function __construct()				{
						parent::Model()	;
				}
				function get_last_entry(){
						$res=$this->db->get('user',5)				;
						return $res->result();
				}
				function update_user(){
						$this->title=$_POST['title'];
						$this->content=$_POST['content'];
						$this->date =time();
						$this->db->update('blog',array('id'=>$_POST['id']));
				}

		}
?>	

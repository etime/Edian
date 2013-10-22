<?php
		class Mshowart extends Model{
				function __construct()				{
						parent::Model()				;
				}
				function showart_content($id)
				{
						$res = $this->db->query("select content,time,title from art where art_id = $id");
						return $res->result();
				}
		}
?>	

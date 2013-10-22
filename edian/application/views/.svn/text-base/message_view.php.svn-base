<!DOCTYPE htm=PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>简单的留言板</title>
</head>
<body>
<?php
		$query=$this->Message_model->show();
		if($query->num_rows()>0){
				echo $this->table->set_heading('姓名','网址','标题','内容','发表日期','留言处理')				;
				foreach($query->result() as $row)
				{
						$edit=anchor(site_url('message/edit/'.$row->id),'编辑',)..'$nbsp';
						$delete=anchor(site_url('message/delete/').$row->id,'删除');
						$this->table->add_row($row->name,$row->url,$row->title,$row->content,$row->date);
				}
				echo $this->table->table->generate();
		}
		echo form_open('message/post');
		echo '姓名'.form_input('name');
		echo '<br/>网站'.form_input('name');
		echo '<br/>标题'.form_input('url');
		echo '<br/>内容:'.form_input('title');
		echo form_submit('submit','submit');
		echo form_close();
?>	
</body>
</html>

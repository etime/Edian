<!doctype html>	
<html>
	<head>
		<meta charset="utf-8">
		<title></title>

		<link rel="stylesheet" type="text/css" href="<?=base_url("common_content.css")?>">
		<style type="text/css">
		table{
				table-layout: fixed;
			white-space: nowrap;
			width: 100%;
			border-top: 1px solid #ccc;
				text-align:center;
			font-size: 16px;
		}
		.mail-box th{
			font-size: 20px;
			color: #4bbdfd;
			border-bottom: 1px solid #ccc;
		}
		a{
		text-decoration:none;
		}
		.mail-box td{
			border-bottom: 1px solid #ccc;
		}
		.mail-box .user{
			width: 100px;
				overflow:hidden;
		}
		.mail-box .date{
				width: 170px;
		}
		.mail-box .tm{
			overflow: hidden;
				text-overflow:ellipsis;
		}
		.mail-box .action{
				width:80px;		
		}
			</style>
		
	</head>
		<!--  S - body -->
	<body>
			
				<table cellspacing="0" class="mail-box">
						<tr>
							<th class="user">user</th>
							<th class="tm">content</th>
							<th class="date">date</th>
							<th class="action">操作</th>
						</tr>
					<?php foreach($allart as $temp):?>
						<tr>
								<td class="user"><?php echo $temp->author_id?></td>
								<td class="tm"><a href="<?=site_url("bg/home/artshow/$temp->art_id")?>"><?php echo $temp->title?></a></td>
							  <td class="date"><?php echo $temp->time ?></td>
								<td class="action"><a href="<?=site_url("bg/home/artdelete/$temp->art_id")?>">删除</a><a href="<?=site_url("bg/home/artchange/$temp->art_id")?>">|修改</a></td>
					</tr>
				<?php endforeach?>
				</table>
	</body>                
		<!--  E - body -->
</html>

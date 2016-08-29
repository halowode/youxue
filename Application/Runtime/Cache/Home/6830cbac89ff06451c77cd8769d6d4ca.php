<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户管理</title>
<link rel="stylesheet" type="text/css" href="/Public/css/Iframe.css" />
<link rel="stylesheet" href="/Public/utilLib/bootstrap.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/js/main.js"></script>
</head>

<body style="height:100%;overflow-y:auto;">
<div class="add_cp "><a class="btn btn-primary"  href="<?php echo U('add_user');?>">+添加用户</a></div>
<span class="cp_title">用户管理</span>
<div class="table_con">
    <form method="get" name="userf" action="<?php echo U('index');?>">
		<table cellpadding="0" cellspacing="1">
	    	<tr>
	        	<td width="10%" align="center" class="tb_title">ID</td>
	            <td width="15%" align="center" class="tb_title">登录名</td>
	            <td width="15%" align="center" class="tb_title">用户名</td>
                <td width="15%" align="center" class="tb_title">部门</td>
	            <td width="20%" align="center" class="tb_title">操作</td>
	        </tr>
	        <?php if(!empty($data['list'])): if(is_array($data['list'])): foreach($data['list'] as $key=>$vo): ?><tr>
				     	 <td width="10%" align="center"><?php echo ($vo["id"]); ?></td>
				         <td width="15%" align="center"><?php echo ($vo["logname"]); ?></td>
				         <td width="15%" align="center"><?php echo ($vo["username"]); ?></td>
                         <td width="15%" align="center"><?php echo ($vo["depname"]); ?></td>
				         <td width="20%" align="center">
				              <a href="<?php echo U("edit_user?id=$vo[id]");?>">编辑</a>
				               | 
				              <?php if(($vo[id]) == "1"): ?>删除<?php else: ?><a href="<?php echo U("del?id=$vo[id]");?>" onclick="return cfirmdel('M');">删除</a><?php endif; ?>
				         </td>
				     </tr><?php endforeach; endif; ?>
		    <?php else: ?>
		        <tr><td colspan="6">暂无信息</td></tr><?php endif; ?>
            <?php if(($data['list'] != null)): ?><tr>
                    <td colspan="6">
                        <?php echo ($data["show"]); ?>
                    </td>
                </tr><?php endif; ?>
	    </table>
    </form>
</div>
</body>
</html>
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户编辑</title>
<link rel="stylesheet" type="text/css" href="/Public/css/index.css" />
<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/js/user.js"></script>
</head>

<body style="background:#fff;height:100%;overflow-y:auto;">
<div class="nav_top1">
	<div class="nav_tcon1" style="width:98%;">
        <div class="logotitle1">
        	<span>用户编辑</span>
        </div>
    </div>
</div>
<form name="user_form" id="user_form1" action="<?php echo U('edit');?>" method="post">
	<div class="logo_content1">
		<div class="logo_ccon1">
	        <div class="logo_enter1" style="border:none;float:left;">
	            <div class="login_box1">
		            <span class="login_title1" >登&nbsp;录&nbsp;名：</span>
		            <input class="use_name" name="logname" id="username" type="text" placeholder="登录名" readonly="true" value="<?php echo ($rs_user["logname"]); ?>" />
	            </div>
		        <div class="login_box1">
		            <span class="login_title1">用户名：</span>
		            <input class="use_name" name="username" id="uname" type="text" placeholder="填写真实姓名" value="<?php echo ($rs_user["username"]); ?>" />
	            </div>
                <div class="login_box1">
                    <span class="login_title1" >所属部门：</span>
                    <select name="did" id="did"  style="width:200px">
                        <?php if(is_array($dep)): foreach($dep as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo['id'] == $rs_user['did']) echo 'selected="selected"'; ?>> <?php echo ($vo["depname"]); ?></option><?php endforeach; endif; ?>
                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
	            <input type="hidden" name="id" value="<?php echo ($rs_user["id"]); ?>" />
	            <input type="submit" name="submit" class="login_submit" value="保存" />
	        </div>
	    </div>
	</div>
</form>
</body>
</html>
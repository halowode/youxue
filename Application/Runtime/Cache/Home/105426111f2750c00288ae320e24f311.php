<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户添加</title>
<link rel="stylesheet" type="text/css" href="/Public/css/index.css" />
    <link rel="stylesheet" href="/Public/utilLib/bootstrap.min.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/js/user.js"></script>
</head>

<body style="background:#fff;height:100%;overflow-y:auto;">
<div class="nav_top1">
	<div class="nav_tcon1" style="width:98%;">
        <div class="logotitle1">
        	<span>用户添加</span>
        </div>
    </div>
</div>
<form name="user_form" id="user_form" action="<?php echo U('add');?>" method="post">
	<div class="logo_content1">
		<div class="logo_ccon1">
	        <div class="logo_enter1" style="border:none;float:left;">
	            <div class="login_box1 form-group" style="width:80%">
		            <span class="login_title1" >登录名：</span>
		            <input class="use_name form-control" name="logname" id="logname" type="text" placeholder="登录名" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
	            </div>
	            <div class="login_box1 form-group" style="width:80%">
		            <span class="login_title1">密码：</span>
		            <input class="use_password form-control" name="password" id="password" type="password" placeholder="密码" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
		        </div>
		        <div class="login_box1 form-group" style="width:80%">
		            <span class="login_title1">确认密码：</span>
		            <input class="use_password form-control" name="sure_password" id="sure_password" type="password" placeholder="确认密码" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
		        </div>
		        <div class="login_box1 form-group" style="width:80%">
		            <span class="login_title1">用户名：</span>
		            <input class="use_name form-control" name="username" id="username" type="text" placeholder="填写用户" />
	            </div>
                <div class="login_box1 form-group" style="width:80%">
                    <span class="login_title1" >所属部门：</span>
                    <select class="form-control" name="did" id="did"  style="width:200px">
                        <?php if(is_array($data)): foreach($data as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" > <?php echo ($vo["depname"]); ?></option><?php endforeach; endif; ?>
                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
	            <input type="submit" name="submit" class="login_submit" value="添&nbsp;&nbsp;加" />
	        </div>
	    </div>
	</div>
</form>
</body>
</html>
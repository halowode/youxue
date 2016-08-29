<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改密码</title>
<link rel="stylesheet" type="text/css" href="/Public/css/index.css" />
    <link rel="stylesheet" href="/Public/utilLib/bootstrap.min.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/js/user.js"></script>
</head>

<body style="background:#fff;height:100%;overflow-y:auto;">
<div class="nav_top1">
	<div class="nav_tcon1" style="width:98%;">
        <div class="logotitle1">
        	<span>修改密码</span>
        </div>
    </div>
</div>
<form name="user_form2" id="user_form2" action="<?php echo U('set_pass');?>" method="post">
	<div class="logo_content1">
		<div class="logo_ccon1">
	        <div class="logo_enter1" style="border:none;float:left;">
                <div class="login_box1 " style="width:80%">
                    <span class="login_title1">原始密码：</span>
                    <input class="use_password form-control" name="rpassword" id="rpassword" type="password" placeholder="原始密码" />
                </div>
	            <div class="login_box1" style="width:80%">
		            <span class="login_title1">密&nbsp;&nbsp;&nbsp;&nbsp;码：</span>
		            <input class="use_password form-control" name="password" id="password" type="password" placeholder="密码" />
		        </div>
		        <div class="login_box1" style="width:80%">
		            <span class="login_title1">确认密码：</span>
		            <input class="use_password form-control" name="sure_password" id="sure_password" type="password" placeholder="确认密码" />
		        </div>
                <div class="login_box1" style="width:80%">
	                <input type="submit" name="submit" class="login_submit btn btn-success" value="设置" />
                </div>
	        </div>
	    </div>
	</div>
</form>
</body>
</html>
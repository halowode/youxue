<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>修改项目</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/index.css" />
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
</head>

<body style="background:#fff;height:100%;overflow-y:auto;">
<div class="nav_top1">
    <div class="nav_tcon1" style="width:98%;">
        <div class="logotitle1">
            <span>修改项目</span>
        </div>
    </div>
</div>
<form name="product_form" id="daniel_form" enctype="multipart/form-data" action="" method="post">
    <div class="logo_content1">
        <div class="logo_ccon1">
            <div class="logo_enter1" style="border:none;float:left;">

                <div class="login_box1">
                    <span class="login_title1" >项目名称：</span>
                    <input class="use_name" value="<?php echo ($data["pname"]); ?>" name='pname' id="pname"  type="text" placeholder="年份及项目名称如：2016华睿..." /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1">
                    <span class="login_title1" >项目简称：</span>
                    <input class="use_name" value="<?php echo ($data["shortname"]); ?>" id="shortname" name='shortname'  type="text" placeholder="项目简称" /><font style="color:#FF0000;line-height:40px;">&nbsp;</font>
                </div>
                <div class="login_box1">
                    <span class="login_title1" >项目描述：</span>
                    <input class="use_name" value="<?php echo ($data["descb"]); ?>" id="total" name='descb'  type="text" placeholder="项目的有关描述" /><font style="color:#FF0000;line-height:40px;">&nbsp;</font>
                </div>
                <input type="hidden" name="id" value="<?php echo ($id); ?>"/>
                <input type="submit" name="submit" class="login_submit" value="修改" />
            </div>
        </div>
    </div>
</form>
<script>
    $("#daniel_form").submit(function () {
        if($("#pname").val() == ''){
            alert('项目名称不可为空！');
            return false;
        }

    });
</script>
</body>
</html>
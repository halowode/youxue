<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>添加银行号码</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/index.css" />
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <style>
        .niandu {
            width:120px;
            line-height: 33px;
        }
    </style>
    <script>
        function addpro(){
            $('#daniel_pro').append('<div style="margin-left: 130px;margin-top:10px;"> 年度：<input class="niandu stime" name="stime[]"  type="text" placeholder="年度"/>&nbsp;&nbsp;&nbsp;&nbsp; 名称：<input class="niandu pname" name="pname[]"  type="text" placeholder="项目名称" />&nbsp;&nbsp;&nbsp;&nbsp; 分配金额：<input class="niandu ctoptotal" name="ctoptotal[]"  type="text" placeholder="合同分配到项目金额" />&nbsp;&nbsp;&nbsp;&nbsp; 到款金额：<input class="niandu" name="realtotal[]"  type="text" placeholder="实际到款金额" /><a href="javascript:;" onclick="daniel_del(this)"> 删除该项目</a></div>');
        }
        function daniel_del(obj){
            $(obj).parent().remove();
        }

    </script>
</head>

<body style="background:#fff;height:100%;overflow-y:auto;">
<div class="nav_top1">
    <div class="nav_tcon1" style="width:98%;">
        <div class="logotitle1">
            <span>添加银行号码</span>
        </div>
    </div>
</div>
<form name="product_form" id="daniel_form" enctype="multipart/form-data" action="" method="post">
    <div class="logo_content1">
        <div class="logo_ccon1">
            <div class="logo_enter1" style="border:none;float:left;">
                <div class="login_box1">
                    <span class="login_title1" >银行账号：</span>
                    <input class="use_name" id="bankno" name='bankno'  type="text" placeholder="银行号码" /><font style="color:#FF0000;line-height:40px;">&nbsp;</font>
                </div>
                <div class="login_box1">
                    <span class="login_title1" >账号余额：</span>
                    <input class="use_name" id="total" name='total'  type="text" placeholder="账号余额" /><font style="color:#FF0000;line-height:40px;">&nbsp;</font>
                </div>
                <input type="submit" name="submit" class="login_submit" value="添加" />
            </div>
        </div>
    </div>
</form>
<script>
    $("#daniel_form").submit(function () {
        if($("#bankno").val() == ''){
            alert('银行账号不可为空！');
            return false;
        }
    });
</script>
</body>
</html>
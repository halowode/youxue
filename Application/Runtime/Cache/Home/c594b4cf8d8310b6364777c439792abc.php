<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>添加报销费用性质内容</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/index.css" />
    <link rel="stylesheet" href="/Public/utilLib/bootstrap.min.css" type="text/css" media="screen" />
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
        <div class="logotitle1" style="width:60%">
            <span>增加报销费用性质内容</span>
        </div>
    </div>
</div>
<form name="product_form" id="daniel_form" enctype="multipart/form-data" action="" method="post">
    <div class="logo_content1">
        <div class="logo_ccon1">
            <div class="logo_enter1" style="border:none;float:left;">
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label" >费用性质名称</span>
                    <input class="use_name form-control" id="cgname" name='feetpname'  type="text" placeholder="合同内容名称" /><font style="color:#FF0000;line-height:40px;">&nbsp;</font>
                </div>

                <div class="nav_tcon1" style="float:left;width:98%;">
                    <input type="submit" name="submit" class="login_submit btn btn-primary" value="添加" />
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $("#daniel_form").submit(function () {
        if($("#cgname").val() == ''){
            alert('添加费用性质不可为空！');
            return false;
        }else{
            var name = $("#cgname").val();
            $.ajax({
                type: "POST",
                url: "/reimburse/getfeename",
                data: "name="+name,
                async: false,
                success: function(msg){
                    if(msg == 'no'){
                        alert('该科目已存在');
                        return false;
                    }
                }
            });
        }


    });

</script>
</body>
</html>
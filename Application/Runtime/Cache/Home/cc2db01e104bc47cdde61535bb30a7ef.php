<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>盖章修改</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/index.css" />
    <link rel="stylesheet" href="/Public/utilLib/bootstrap.min.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
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
        function ddd(obj){
            var a = $(obj).attr('src');
            $("#tobids").attr('src',a);
        }
    </script>
</head>

<body style="background:#fff;height:100%;overflow-y:auto;">
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img width="1000" id="tobids" src="" alt=""/>
        </div>
    </div>
</div>
<div class="nav_top1">
    <div class="nav_tcon1" style="width:98%;">
        <div class="logotitle1">
            <span>盖章修改</span>
        </div>
    </div>
</div>
<form name="product_form" id="daniel_form" enctype="multipart/form-data" action="" method="post">
    <div class="logo_content1">
        <div class="logo_ccon1">
            <div class="logo_enter1" style="border:none;float:left;">
                <!--
                <div class="login_box1">
                    <span class="login_title1">归属公司：</span>
                    <select name="belong"  style="width:100px">
                        <option value="极速" <?php if($data['belong'] == '极速'): ?>selected=selected<?php endif; ?>> 极速</option>
                        <option value="华睿" <?php if($data['belong'] == '华睿'): ?>selected=selected<?php endif; ?>> 华睿</option>
                        <option value="优学" <?php if($data['belong'] == '优学'): ?>selected=selected<?php endif; ?>> 优学</option>
                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1">
                    <span class="login_title1" >合同名称：</span>
                    <input class="use_name" value="<?php echo ($data['cname']); ?>" name='cname'  type="text" placeholder="合同内容名称" /><font style="color:#FF0000;line-height:40px;">&nbsp;</font>
                </div>
                <div class="login_box1">
                    <span class="login_title1" >客户名称：</span>
                    <input class="use_name" value="<?php echo ($data['gname']); ?>" id="gname" name='gname'  type="text" placeholder="客户名称（全称）" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1">
                    <span class="login_title1" >项目时间：</span>
                    <input class="use_name" value="<?php echo ($data['ptime']); ?>" id="stime" name='stime'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1">
                    <span class="login_title1" >项目名称：</span>
                    <input class="use_name" value="<?php echo ($data['pname']); ?>" id="pname" name='pname'  type="text" placeholder="项目名称（全称）" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1">
                    <span class="login_title1" >合同金额：</span>
                    <input class="use_name" id="total" name='total'  type="text" placeholder="合同分配金额" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                -->
                <div class="nav_tcon1" style="float:left;width:98%;" >
                    <div class="logotitle1">
                        <span style="font-size: 15px">驳回意义</span>
                    </div>
                </div>

                <div class="login_box1 form-group" style="width:80%">
                    <span class="login_title1 col-sm-2 control-label" >意见：</span>
                    <textarea class="form-control"  style="width:60%"><?php if(is_array($bmsg)): foreach($bmsg as $key=>$vo): echo trim($vo['msg']).'__'.$vo['uname']."\r\n"; endforeach; endif; ?>
                    </textarea>
                </div>
                <div class="nav_tcon1" style="float:left;width:98%;" >
                    <div class="logotitle1">
                        <span style="font-size: 15px">盖章信息</span>
                    </div>
                </div>
                <div class="login_box1">
                    <span class="login_title1" >推广期间：</span>
                    <input class="use_name form-control" value="<?php echo ($bdata["adperiod"]); ?>" id="adperiod" name='adperiod'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;</font>
                </div>
                <div class="login_box1">
                    <span class="login_title1" >推广位置：</span>
                    <input class="use_name form-control" value="<?php echo ($bdata["adposition"]); ?>" id="adposition" name='adposition'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;</font>
                </div>
                <div class="login_box1">
                    <span class="login_title1" >结算条款：</span>
                    <input class="use_name form-control" value="<?php echo ($bdata["settleitem"]); ?>" id="settleitem" name='settleitem'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;</font>
                </div>
                <div class="login_box1 form-group" style="width:80%">
                    <span class="login_title1 col-sm-2 control-label">上传相关附件</span>
                    <input name="xls" type="file"/><span class="daniel_icon" style="margin-left: 160px"></span><span style="color:red"></span>
                </div>
                <div class="login_box1 form-group" style="width:80%">
                    <span class="login_title1 col-sm-2 control-label">相关图片证明：</span>
                    <input  type="file" id="pro" />
                    <span id="icon_img" style="margin-left:160px">
                        <?php if($bdata["stamppic"] != ''): ?><img src="<?php echo ($bdata["stamppic"]); ?>" width="100px" alt="" data-toggle="modal" data-target="#myModal" onclick="ddd(this)" /><?php endif; ?>
                    </span>
                </div>
                <!--
                <div class="login_box1">
                    <span class="login_title1" >备注：</span>
                    <textarea class=" use_name form-control" cols="35" rows="5"  name='remark' placeholder="" /><?php echo ($data['remark']); ?></textarea><font style="color:#FF0000;line-height:40px;">&nbsp;</font>
                </div>
                -->
                <div class="nav_tcon1" style="float:left;width:80%;margin-left:200px">
                    <input type="hidden" name="cid" value="<?php echo ($cid); ?>"/>
                    <input type="hidden" name="id" value="<?php echo ($id); ?>"/>
                    <input type="submit" name="submit" class="btn btn-success" value="提交申请" />
                    <a class="btn btn-primary" onclick="JavaScript:history.go(-1);" style="text-emphasis:center;">返回上一页</a>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $("#daniel_form").submit(function () {
        if($("#adperiod").val() == ''){
            alert('推广期间不可为空！');
            return false;
        }
        if($("#adposition").val() == ''){
            alert('推广位置不可为空！');
            return false;
        }
        if($("#settleitem").val() == ''){
            alert('结算条款不可为空！');
            return false;
        }

    });
    $("#pro").change(function(){
        //创建FormData对象
        var data = new FormData();
        //为FormData对象添加数据
        $.each($('#pro')[0].files, function(i, file) {
            data.append('icon', file);
        });
        $.ajax({
            url:'/Index/getImg.shtml',
            type:'POST',
            data:data,
            cache: false,
            contentType: false,    //不可缺
            processData: false,    //不可缺
            success:function(data){
                if(data){
                    if(data == 'no'){
                        alert('上传失败');
                        return;
                    }

                    $("#icon_img").html('<img src="'+data+'" width="80" /><input id="propro" type="hidden" name="stamppic" value="'+data+'" />');
                }
            },
            error:function(){
                alert('上传出错,请联系管理员！');
                return false;
            }
        });
    });
</script>
</body>
</html>
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>创建合同</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/index.css" />
    <link rel="stylesheet" href="/Public/utilLib/bootstrap.min.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
</head>

<body style="background:#fff;height:100%;overflow-y:auto;">
<div class="nav_top1">
    <div class="nav_tcon1" style="width:98%;">
        <div class="logotitle1">
            <span>申请开票</span>
        </div>
    </div>
</div>
<form name="daniel_form" id="daniel_form" enctype="multipart/form-data" action="" method="post">
    <div class="logo_content1">
        <div class="logo_ccon1">
            <div class="logo_enter1" style="border:none;float:left;">
                <div class="nav_tcon1" style="float:left;width:98%;" >
                    <div class="logotitle1">
                        <span style="font-size: 15px">发票信息</span>
                    </div>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label">发票类型：</span>
                    <select class="use_name form-control input-sm" name="btype" id="d_piao" >
                        <option value="专票"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;增值税专用发票</option>
                        <option value="普票"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;增值税普通发票</option>
                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label" >客户名称：</span>
                    <input class="use_name form-control" id="gname" value="<?php echo ($gname); ?>" name='gname'  type="text" placeholder="客户名称（全称）" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label" >开票内容：</span>
                    <input class="use_name form-control" id="cbcontent" name='cbcontent'  type="text" placeholder="开票内容" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label" >开票金额：</span>
                    <input class="use_name form-control" id="btotal" name='btotal'  type="text" placeholder="如开具红票，请填写负数" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="nav_tcon1" style="float:left;width:98%;" >
                    <div class="logotitle1">
                        <span style="font-size: 15px">客户信息</span>
                    </div>
                </div>

                <div class="login_box1 form-group daniel_hide">
                    <span class="login_title1 col-sm-2 control-label" >税号：</span>
                    <input class="use_name form-control" id="bno" name='bno'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group daniel_hide">
                    <span class="login_title1 col-sm-2 control-label" >地址：</span>
                    <input class="use_name form-control" id="baddress" name='baddress'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group daniel_hide">
                    <span class="login_title1 col-sm-2 control-label" >电话：</span>
                    <input class="use_name form-control" id="btel" name='btel'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group daniel_hide">
                    <span class="login_title1 col-sm-2 control-label" >开户行：</span>
                    <input class="use_name form-control" id="billbank" name='billbank'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group daniel_hide">
                    <span class="login_title1 col-sm-2 control-label" >账号：</span>
                    <input class="use_name form-control" id="bankno" name='bankno'  type="text" placeholder="开户行账号" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>

                </div>
                <div class="login_box1 form-group  daniel_hide">
                    <span class="login_title1 col-sm-2 control-label">相关图片证明：</span>
                    <input  type="file" id="pro" /><span id="icon_img" style="margin-left:160px"></span><span style="color:red">*纳税人证明图片</span>
                </div>
                <input type="hidden" name="cid" value="<?php echo ($cid); ?>"/>
                <input type="submit" name="submit" class="login_submit btn btn-primary" value="申请开票" />
            </div>
        </div>
    </div>
</form>
<script>
    $("#d_piao").change(function(){
        var str = $(this).val();
        if(str == '专票'){
            $(".daniel_hide").fadeIn('200');
        }else{
            $(".daniel_hide").fadeOut('200');
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

                    $("#icon_img").html('<img src="'+data+'" width="80" /><input id="propro" type="hidden" name="provepic" value="'+data+'" />');
                }
            },
            error:function(){
                alert('上传出错,请联系管理员！');
                return false;
            }
        });
    });
    $("#daniel_form").submit(function () {
        if($("#cbcomp").val() == ''){
            alert("必须填写开票公司");
            return false;
        }
        if($("#gname").val() == ''){
            alert("必须填写客户名称");
            return false;
        }
        if($("#cbcontent").val() == ''){
            alert("必须填写开票内容");
            return false;
        }
        if($("#btotal").val() == ''){
            alert("必须填写开票金额");
            return false;
        }
        if ($("#d_piao").val() == '专票') {

            if($("#bno").val() == ''){
                alert("必须填写税号");
                return false;
            }
            if($("#baddress").val() == ''){
                alert("必须填写地址");
                return false;
            }
            if($("#btel").val() == ''){
                alert("必须填写电话");
                return false;
            }
            if($("#billbank").val() == ''){
                alert("必须填写开户行");
                return false;
            }
            if($("#bankno").val() == ''){
                alert("必须填写银行账号");
                return false;
            }
            var target_obj = $('#propro');
            if (target_obj.length <= 0){
                alert('必须上传纳税人证明图片！');
                return false;
            }
        }

    });//验证支票信息
</script>
</body>
</html>
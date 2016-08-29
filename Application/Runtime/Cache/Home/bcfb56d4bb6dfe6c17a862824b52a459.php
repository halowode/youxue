<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>修改合同</title>
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
        <div class="logotitle1">
            <span>修改合同</span>
        </div>
    </div>
</div>
<form name="product_form" id="daniel_form" enctype="multipart/form-data" action="" method="post">
    <div class="logo_content1">
        <div class="logo_ccon1">
            <div class="logo_enter1" style="border:none;float:left;">
                <span style="color:red;margin-left: 70px">*若一个合同归属于多个项目，需每个项目单独创建一个合同</span>
            </div>
            <div class="logo_enter1" style="border:none;float:left;">
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label">归属公司</span>
                    <select class="use_name form-control input-sm" name="belong"  style="width:100px">
                        <option <?php if($datas["belong"] == '极速传媒'): ?>selected=selected<?php endif; ?> value="极速传媒" > 极速传媒</option>
                        <option <?php if($datas["belong"] == '华睿互动'): ?>selected=selected<?php endif; ?> value="华睿互动"> 华睿互动</option>
                        <option <?php if($datas["belong"] == '优学教育'): ?>selected=selected<?php endif; ?> value="优学教育"> 优学教育</option>
                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label">合同类别</span>
                    <select class="use_name form-control input-sm" name="kinds"  style="width:100px">
                        <option <?php if($datas["kinds"] == 0): ?>selected=selected<?php endif; ?> value="0"> 销售合同</option>
                        <option <?php if($datas["kinds"] == 1): ?>selected=selected<?php endif; ?> value="1"> 采购合同</option>
                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label">是否是框架合同</span>
                    <select id="framect" class="use_name form-control input-sm" name="isframe"  style="width:100px">
                        <option <?php if($datas["isframe"] == 0): ?>selected=selected<?php endif; ?> value="0"> 否</option>
                        <option <?php if($datas["isframe"] == 1): ?>selected=selected<?php endif; ?> value="1"> 是</option>
                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label" >合同名称</span>
                    <input class="use_name form-control" name='cname' value="<?php echo ($datas["cname"]); ?>"  type="text" placeholder="合同内容名称" /><font style="color:#FF0000;line-height:40px;">&nbsp;</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label" >客户名称</span>
                    <input class="use_name form-control" id="gname" value="<?php echo ($datas["gname"]); ?>" name='gname'  type="text" placeholder="请与发票名称保持一致（全称）" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label" >项目名称</span>
                    <select class="use_name form-control input-sm" name="pid" id="project"  style="width:200px">
                        <?php if(is_array($projects)): foreach($projects as $key=>$vo): ?><option <?php if($datas["pid"] == $vo['id']): ?>selected=selected<?php endif; ?> value="<?php echo ($vo["id"]); ?>" > <?php echo ($vo["pname"]); ?></option><?php endforeach; endif; ?>
                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label" >选择初审人员</span>
                    <select class="use_name form-control input-sm" name="checkuid"  style="width:200px">
                        <?php if(is_array($cuser)): foreach($cuser as $key=>$vo): ?><option <?php if($datas["checkuid"] == $vo['id']): ?>selected=selected<?php endif; ?> value="<?php echo ($vo["id"]); ?>" > <?php echo ($vo["username"]); ?></option><?php endforeach; endif; ?>
                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label" >合同执行人员</span>
                    <select class="use_name form-control input-sm" name="exuid"  style="width:200px">
                        <?php if(is_array($exuser)): foreach($exuser as $key=>$vo): ?><option <?php if($datas["exuid"] == $vo['id']): ?>selected=selected<?php endif; ?> value="<?php echo ($vo["id"]); ?>" > <?php echo ($vo["username"]); ?></option><?php endforeach; endif; ?>
                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group" id="ctotals">
                    <span class="login_title1 col-sm-2 control-label" >合同金额</span>
                    <input type="hidden" id="stotal" value="<?php echo number_format($datas['total'],2);?>"/>
                    <input class="use_name form-control" id="total" value="<?php echo number_format($datas['total'],2);?>" name='total'  type="text" placeholder="合同分配金额" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label" >备注</span>
                    <textarea class="use_name form-control" name="remark" ><?php echo ($datas["remark"]); ?></textarea>
                </div>
                <div class="login_box1 form-group  daniel_hide" style="width:90%">
                    <span class="login_title1 col-sm-2 control-label">合同附件</span>
                    <input type="hidden" name="cfile" value="<?php echo ($datas["cfile"]); ?>" />
                    <input type="file" name="cpfile"/>
                </div>
                <div class="login_box1 form-group  daniel_hide" style="width:90%">
                    <span class="login_title1 col-sm-2 control-label">相关图片</span>
                    <input type="file" id="propic1" />
                    <span id="icon_img" style="margin-left: 160px">
                        <?php if($datas['pic1'] != ''): ?><img src="<?php echo ($datas['pic1']); ?>" width="100px" alt=""/><?php endif; ?>

                    </span><span style="color:red"></span>
                </div>
                <div class="login_box1 form-group  daniel_hide" style="width:90%">
                    <span class="login_title1 col-sm-2 control-label">相关图片</span>
                    <input type="file" id="propic2" /><span id="icon_img2" style="margin-left: 160px">
                    <?php if($datas['pic2'] != ''): ?><img src="<?php echo ($datas['pic2']); ?>" width="100px" alt=""/><?php endif; ?>
                </span><span style="color:red"></span>
                </div>
                <div class="login_box1 form-group  daniel_hide" style="width:90%">
                    <span class="login_title1 col-sm-2 control-label">相关图片</span>
                    <input type="file" id="propic3" /><span id="icon_img3" style="margin-left: 160px">
                    <?php if($datas['pic3'] != ''): ?><img src="<?php echo ($datas['pic3']); ?>" width="100px" alt=""/><?php endif; ?>
                </span><span style="color:red"></span>
                </div>

                <div class="nav_tcon1" style="float:left;width:98%;">
                    <input type="hidden" name="cid" value="<?php echo ($cid); ?>"/>
                    <input type="submit" name="submit" class="login_submit btn btn-primary" value="生成" />
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $("#framect").change(function(){
        var v = $(this).val();
        var ctdiv = $("#ctotals");
        var ct = $("#total");
        ct.val(0);
        if(v == 1){
            ctdiv.fadeOut(100);
        }else{
            ctdiv.fadeIn(100);
        }

    });
    $("#daniel_form").submit(function () {
        if($("#gname").val() == ''){
            alert('客户名称不可为空！');
            return false;
        }

        var mnum = $("#total").val();
        var snum = $("#stotal").val();
        if(mnum != '' && mnum != snum){
            var c = mnum.toString();
            var b = c.indexOf(',');
            if(b != -1){
                alert('请正确填写数字！');
                return false;
            }
        }

    });
    $("#propic1").change(function(){
        //创建FormData对象
        var data = new FormData();
        //为FormData对象添加数据
        $.each($('#propic1')[0].files, function(i, file) {
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

                    $("#icon_img").html('<img src="'+data+'" width="80" /><input id="propro" type="hidden" name="pic1" value="'+data+'" />');
                }
            },
            error:function(){
                alert('上传出错,请联系管理员！');
                return false;
            }
        });
    });
    $("#propic2").change(function(){
        //创建FormData对象
        var data = new FormData();
        //为FormData对象添加数据
        $.each($('#propic2')[0].files, function(i, file) {
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

                    $("#icon_img2").html('<img src="'+data+'" width="80" /><input id="propro2" type="hidden" name="pic2" value="'+data+'" />');
                }
            },
            error:function(){
                alert('上传出错,请联系管理员！');
                return false;
            }
        });
    });
    $("#propic3").change(function(){
        //创建FormData对象
        var data = new FormData();
        //为FormData对象添加数据
        $.each($('#propic3')[0].files, function(i, file) {
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

                    $("#icon_img3").html('<img src="'+data+'" width="80" /><input id="propro3" type="hidden" name="pic3" value="'+data+'" />');
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
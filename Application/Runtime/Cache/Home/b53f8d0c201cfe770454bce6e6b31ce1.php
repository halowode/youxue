<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>申请报销</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/index.css" />
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/laydate/laydate.js"></script>
    <style>
        .daniel_icon {
            margin-left: 160px;
        }
    </style>
    <script>
        function addpic(){
            $("#daniel_so").append('<div class="login_box1 form-group" style="width:80%"><span class="login_title1 col-sm-2 control-label">相关图片</span><input onchange="dd(this)" type="file" /><span class="daniel_icon"></span><span style="color:red"></span><sapn style="float:right;margin-left:300px"><a onclick="delpic(this)">-删除图片</a></span></div>');
        }
        function addhang(){
            $("#d_table").append('<tr class="info"><td><input class="form-control" name="ab[]" type="text"/></td><td><input class="form-control" name="etime[]" type="text" placeholder="格式：2016-06"/></td><td><input class="form-control" name="etotal[]" type="text"/></td><td><input class="form-control" name="atotal[]" type="text"/></td><td><a class="btn btn-danger" onclick="delpic(this)">删除此行</a></td></tr>');
        }
        function delpic(obj){
            $(obj).parent().parent().remove();
        }
        function dd(obj){
            //创建FormData对象
            var data = new FormData();
            //为FormData对象添加数据
            $.each($(obj)[0].files, function(i, file) {
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
                        $(obj).siblings(".daniel_icon").html('<img src="'+data+'" width="80" /><input  type="hidden" name="pic[]" value="'+data+'" />');
                    }
                },
                error:function(){
                    alert('上传出错,请联系管理员！');
                    return false;
                }
            });

        }
    </script>
</head>

<body style="background:#fff;height:100%;overflow-y:auto;">
<div class="nav_top1">
    <div class="nav_tcon1" style="width:98%;">
        <div class="logotitle1">
            <span>申请报销</span>
        </div>
    </div>
</div>
<form name="product_form" id="daniel_form" enctype="multipart/form-data" action="" method="post">
    <div class="logo_content1">
        <div class="logo_enter1" style="border:none;float:left;">
            <span style="color:red;margin-left: 70px">*一次申请对应一个项目 多个项目则多个申请</span>
        </div>
        <div class="logo_ccon1">
            <div id="daniel_so" class="logo_enter1" style="border:none;float:left;">
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label">所属项目</span>
                    <select id="proj" class="use_name form-control input-xsm" name="pid"   style="width:200px">
                        <option value="">请选择</option>
                        <?php if(is_array($pro)): $i = 0; $__LIST__ = $pro;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($cid) == $vo["id"]): endif; ?> > <?php echo ($vo["pname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>

                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label">审核人</span>
                    <select id="checkid" class="use_name form-control input-xsm" name="checkuid"   style="width:200px">
                        <option value="">请选择</option>
                        <?php if(is_array($checkusers)): $i = 0; $__LIST__ = $checkusers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" > <?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label">所属销售合同</span>
                    <select id="con" class="use_name form-control input-xsm" name="cid"   style="width:200px">
                        <option value="0">无销售合同</option>
                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label">所属采购合同</span>
                    <select id="cgid" class="use_name form-control input-xsm" name="cgid"   style="width:200px">
                        <option value="">无采购合同</option>
                        <?php if(is_array($cgcon)): $i = 0; $__LIST__ = $cgcon;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" > <?php echo ($vo["cno"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group" style="width:80%">
                    <span class="login_title1 col-sm-2 control-label" >备注</span>
                    <textarea class="use_name form-control"  name='remark'  type="text" placeholder="备注信息"></textarea>
                </div>
                <table id="d_table" class=" table table-bordered" style="margin-left:30px;margin-top:-20px">
                    <tr class="active">
                        <th>报销摘要</th>
                        <th>发生月份</th>
                        <th>报销金额</th>
                        <th>付款金额</th>
                        <th></th>
                    </tr>
                    <tr class="info">
                        <td width="35%"><input class="form-control" name="ab[]" type="text"/></td>
                        <td><input class="form-control" name="etime[]" type="text" placeholder="格式：2016-06"/></td>
                        <td><input class="form-control" name="etotal[]" type="text"/></td>
                        <td><input class="form-control" name="atotal[]" type="text"/></td>
                        <td><a class="btn btn-info" onclick="addhang(this)">增加一行</a></td>
                    </tr>
                </table>
                <div class="login_box1 form-group" style="width:80%">
                    <span class="login_title1 col-sm-2 control-label">相关图片</span>
                    <input onchange="dd(this)" type="file"/><span class="daniel_icon"></span><span style="color:red"></span>
                    <sapn style="float:right;margin-left:300px"><a onclick="addpic()" id="addpic">+增加图片</a></span>
                </div>
            </div>
            <div class="nav_tcon1" style="float:left;width:98%;">
                <input type="hidden" name="rbid" value="<?php echo ($rbid); ?>"/>
                <input type="hidden" name="dp" value="<?php echo ($dp); ?>"/>
                <input style="margin-left:200px" type="submit"  class="login_submit btn btn-primary" value="申请报销" />
            </div>
        </div>
    </div>
</form>
<script>
    $("#daniel_form").submit(function () {
        if($("#pro").val() == ''){
            alert('发生项目不可为空！');
            return false;
        }
        if($("#checkid").val() == ''){
            alert('审核人不可不选！');
            return false;
        }

    });
    $("#proj").change(function(){
        var str = $(this).val();
        if(str != ''){
            $.ajax({
                type: "POST",
                url: "/reimburse/getcontract",
                data: "pid="+str,
                dataType:'json',
                success: function(msg){

                    $("#con").children().remove();
                    $("#con").append("<option value='0'>无销售合同</option>");
                    $("#cgid").children().remove();
                    $("#cgid").append("<option value='0'>无采购合同</option>");
                    for(var i in msg[0]){
                        $("#con").append("<option value='"+msg[0][i].id+"'>"+msg[0][i].cno+"</option>");
                    }
                    for(var i in msg[1]){
                        $("#cgid").append("<option value='"+msg[1][i].id+"'>"+msg[1][i].cno+"</option>");
                    }
                }
            });
        }


    });


</script>
</body>
</html>
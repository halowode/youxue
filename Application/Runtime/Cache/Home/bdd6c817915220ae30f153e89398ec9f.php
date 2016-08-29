<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>回款录入</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/index.css" />
    <link rel="stylesheet" href="/Public/utilLib/bootstrap.min.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/laydate/laydate.js"></script>
</head>

<body style="background:#fff;height:100%;overflow-y:auto;">
<div class="nav_top1">
    <div class="nav_tcon1" style="width:98%;">
        <div class="logotitle1">
            <span>回款录入</span>
        </div>
    </div>
</div>
<form name="daniel_form" id="daniel_form" enctype="multipart/form-data" action="" method="post">
    <div class="logo_content1">
        <div class="logo_ccon1">
            <div class="logo_enter1" style="border:none;float:left;">

                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label">收款公司：</span>
                    <select class="use_name form-control input-sm" name="payee" id="d_piao" >
                        <option value="极速"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;极速</option>
                        <option value="华睿"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;华睿</option>
                        <option value="优学"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;优学</option>
                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label" >付款公司：</span>
                    <input class="use_name form-control" id="paycomp" name='paycomp'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label" >回款金额：</span>
                    <input class="use_name form-control" id="btotal" name='btotal'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label" >款项性质：</span>
                    <input class="use_name form-control" id="btype" name='btype'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label " >回款时间：</span>
                    <input class="use_name form-control laydate-icon" onclick="calendar.show({ id: this })" id="btime" name='btime'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label">收款账号：</span>
                    <select class="use_name form-control input-sm" name="bankno" id="bankno" >
                        <?php if(is_array($banks)): $i = 0; $__LIST__ = $banks;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"> <?php echo ($vo["bankno"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
                </div>
                <div class="login_box1" style="margin-left:160px;float:left;width:68%;">
                    <input type="submit" name="submit" class="btn btn-success" value="保存录入" />
                </div>
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
        if($("#paycomp").val() == ''){
            alert("必须填写付款公司");
            return false;
        }
        if($("#btotal").val() == ''){
            alert("必须填写回款金额");
            return false;
        }else{
            var va = $("#btotal").val();
            if(isNaN(va)){
                alert("不是数字");
                return false;
            }
        }
        if($("#btime").val() == ''){
            alert("必须填写回款时间");
            return false;
        }


    });//验证支票信息
    var btime = {
        elem: '#btime',
        format: 'YYYY-MM-DD',
        min: '2012-06-16 23:59:59',//laydate.now(), //设定最小日期为当前日期
        max: '2099-06-16 23:59:59', //最大日期
        istime: false,
        istoday: false,
        choose: function(datas){
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    laydate(btime);
</script>
</body>
</html>
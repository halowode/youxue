<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>开具发票</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/index.css" />
    <link rel="stylesheet" type="text/css" href="/Public/css/Iframe.css" />
    <link rel="stylesheet" href="/Public/utilLib/bootstrap.min.css" type="text/css" media="screen" />
    <!--
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/laydate/laydate.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!--
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    -->
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
            $("#tobid").attr('src',a);
        }

        function ddds(obj){
            var a = $(obj).attr('bid');
            $("#tobv").attr('value',a);
            $("#topass").attr('value',a);
        }

    </script>
</head>

<body style="background:#fff;height:100%;overflow-y:auto;">
<div class="nav_top1">
    <div class="nav_tcon1" style="width:98%;">
        <div class="logotitle1">
            <span>开具发票</span>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action='<?php if(($checklev == 2)): echo U('index/recheckbill'); else: echo U('index/checkbill'); endif; ?>' method="get">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">审核驳回</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="type" value="bac"/>
                <input id="tobv" type="hidden" name="billid" value=""/>
                <textarea class="form-control" name="msg">填写驳回信息...</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary">确定</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action='<?php if(($checklev == 2)): echo U('index/recheckbill'); else: echo U('index/checkbill'); endif; ?>' method="get">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">审核通过</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="type" value="pas"/>
                <input id="topass" type="hidden" name="billid" value=""/>
                <textarea class="form-control" name="msg">备注信息...</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary">确定</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img width="1000" id="tobid" src="" alt=""/>
        </div>
    </div>
</div>
<div class="logo_content1">
    <div class="logo_ccon1">
        <div class="logo_enter1" style="border:none;float:left;">
            <form id="billup" class="form-inline" action="<?php echo U('index/makebill');?>" method="post">
            <!--
            <div class="login_box1 " >
                <span class="login_title1">归属公司：</span>
                <input class="use_name form-control" value="<?php echo ($contract["belong"]); ?>" readonly name='cname'  type="text" placeholder="合同内容名称" /><font style="color:#FF0000;line-height:40px;">&nbsp;</font>
                <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1" >
                <span class="login_title1" >合同名称：</span>
                <input class="use_name  form-control" value="<?php echo ($contract["cname"]); ?>" readonly name='cname'  type="text" placeholder="合同内容名称" /><font style="color:#FF0000;line-height:40px;">&nbsp;</font>
            </div>
            <div class="login_box1 " >
                <span class="login_title1" >客户名称：</span>
                <input class="use_name  form-control" value="<?php echo ($contract["gname"]); ?>" readonly id="gname" name='gname'  type="text" placeholder="客户名称（全称）" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1" >
                <span class="login_title1" >项目名称：</span>
                <input class="use_name  form-control" value="<?php echo ($contract["pname"]); ?>" readonly id="gname" name='gname'  type="text" placeholder="客户名称（全称）" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1">
                <span class="login_title1" >选择初审人员：</span>
                <input class="use_name  form-control" value="<?php echo ($contract["checkuname"]); ?>" readonly id="gname" name='gname'  type="text" placeholder="客户名称（全称）" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1">
                <span class="login_title1" >合同金额：</span>
                <input class="use_name  form-control" value="<?php echo ($contract["total"]); ?>" readonly  id="total" name='total'  type="text" placeholder="合同分配金额" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <?php if($contract["pic1"] != ''): ?><div class="login_box1  daniel_hide">
                    <span class="login_title1">相关图片1：</span>
                    <span><img width="100" src="<?php echo ($contract["pic1"]); ?>" data-toggle="modal" data-target="#myModal" onclick="ddd(this)"/></span>
                </div><?php endif; ?>
            <?php if($contract["pic2"] != ''): ?><div class="login_box1  daniel_hide">
                    <span class="login_title1">相关图片2：</span>
                    <span><img width="100" src="<?php echo ($contract["pic2"]); ?>" data-toggle="modal" data-target="#myModal" onclick="ddd(this)"/></span>
                </div><?php endif; ?>
            <?php if($contract["pic3"] != ''): ?><div class="login_box1  daniel_hide">
                    <span class="login_title1">相关图片3：</span>
                    <span><img width="100" src="<?php echo ($contract["pic3"]); ?>" data-toggle="modal" data-target="#myModal" onclick="ddd(this)"/></span>
                </div><?php endif; ?>
            <div class="login_box1">
                <span class="login_title1" >合同备注：</span>
                <textarea class="use_name form-control" name="remark"  cols="35" rows="5"  readonly><?php echo ($contract["remark"]); ?></textarea>
            </div>
            -->

            <div class="login_box1">
                <span class="login_title1">发票类型：</span>
                <input class="use_name form-control" value="<?php echo ($bill["btype"]); ?>" readonly id="cbcomp"  name='cbcomp'  type="text" placeholder="开票公司" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1">
                <span class="login_title1" >开票公司：</span>
                <input class="use_name  form-control" value="<?php echo ($bill["cbcomp"]); ?>" readonly id="cbcomp" name='cbcomp'  type="text" placeholder="开票公司" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1">
                <span class="login_title1" >客户名称：</span>
                <input class="use_name form-control" value="<?php echo ($bill["gname"]); ?>" readonly id="gname" name='gname'  type="text" placeholder="客户名称（全称）" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1">
                <span class="login_title1" >开票内容：</span>
                <input class="use_name form-control" value="<?php echo ($bill["cbcontent"]); ?>" readonly id="cbcontent" name='cbcontent'  type="text" placeholder="开票内容" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1">
                <span class="login_title1" >开票金额：</span>
                <input class="use_name form-control" id="btotal" value="<?php echo number_format($bill['btotal'],2);?>" readonly  name='btotal'  type="text" placeholder="开票金额，填写数字" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1 daniel_hide">
                <span class="login_title1" >税号：</span>
                <input class="use_name form-control" id="bno" value="<?php echo ($bill["bno"]); ?>" readonly name='bno'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1 daniel_hide">
                <span class="login_title1" >地址：</span>
                <input class="use_name form-control" id="baddress" value="<?php echo ($bill["baddress"]); ?>" readonly name='baddress'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1 daniel_hide">
                <span class="login_title1" >电话：</span>
                <input class="use_name form-control" id="btel" name='btel' value="<?php echo ($bill["btel"]); ?>" readonly  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1 daniel_hide">
                <span class="login_title1" >开户行：</span>
                <input class="use_name form-control" id="billbank" value="<?php echo ($bill["billbank"]); ?>" readonly name='billbank'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1 daniel_hide">
                <span class="login_title1" >账号：</span>
                <input class="use_name form-control" id="bankno" value="<?php echo ($bill["bankno"]); ?>" readonly name='bankno'  type="text" placeholder="开户行账号" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>

            </div>
            <?php if($bill["provepic"] != ''): ?><div class="login_box1  ">
                    <span class="login_title1">相关图片证明：</span>
                    <span><img width="100" src="<?php echo ($bill["provepic"]); ?>" data-toggle="modal" data-target="#myModal" onclick="ddd(this)"/></span>
                </div><?php endif; ?>
            <div class="login_box1 ">
                <span class="login_title1" >开票日期：</span>
                <input class="use_name form-control laydate-icon" onclick="calendar.show({ id: this })" id="cbtime" name='cbtime'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1 ">
                <span class="login_title1" >发票号：</span>
                <input class="use_name form-control" id="bnum"   name='bnum'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1 ">
                <span class="login_title1" >增值税：</span>
                <input class="use_name form-control" id="vat"   name='vat'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1 ">
                <span class="login_title1" >领取人：</span>
                <input class="use_name form-control" id="recname"   name='recname'  type="text" placeholder="" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1">
                <span class="login_title1" >开具备注：</span>
                <textarea class="use_name form-control" name="msg"  cols="35" rows="5" ></textarea>
            </div>
            <div class="login_box1" style="margin-left: 100px;">
                <input type="hidden" name="bid" value="<?php echo ($bill["id"]); ?>"/>
                <input type="submit" name="submit" class=" btn btn-success" value="保存" />
                <a class="btn btn-primary" onclick="JavaScript:history.go(-1);" style="text-emphasis:center;">返回上一页</a>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#billup").submit(function () {
        if($("#cbtime").val() == ''){
            alert('开票时间不可为空！');
            return false;
        }
        if($("#bnum").val() == ''){
            alert('发票号可为空！');
            return false;
        }
        if($("#vat").val() == ''){
            alert('增值税不可为空！');
            return false;
        }
        if($("#recname").val() == ''){
            alert('领取人姓名不可为空！');
            return false;
        }

    });
    var cbtime = {
        elem: '#cbtime',
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
    laydate(cbtime);
</script>
</body>
</html>
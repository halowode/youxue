<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>创建合同</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/index.css" />
    <link rel="stylesheet" type="text/css" href="/Public/css/Iframe.css" />
    <link rel="stylesheet" href="/Public/utilLib/bootstrap.min.css" type="text/css" media="screen" />
    <!--
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
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


    </script>
</head>

<body style="background:#fff;height:100%;overflow-y:auto;">
<div class="nav_top1">
    <div class="nav_tcon1" style="width:98%;">
        <div class="logotitle1">
            <span>创建合同</span>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action='<?php if(($checklev == 2)): echo U('index/recheckstamp'); else: echo U('index/checkstamp'); endif; ?>' method="get">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">审核驳回</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="type" value="bac"/>
                <input id="tobv" type="hidden" name="sid" value="<?php echo ($bill["id"]); ?>"/>
                <textarea class="form-control" name="msg"></textarea>
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
            <form action='<?php if(($checklev == 2)): echo U('index/recheckstamp'); else: echo U('index/checkstamp'); endif; ?>' method="get">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">审核通过</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="type" value="pas"/>
                <input id="topass" type="hidden" name="sid" value="<?php echo ($bill["id"]); ?>"/>
                <input type="hidden" name="cid" value="<?php echo ($cid); ?>"/>
                <textarea class="form-control" name="msg"></textarea>
                <?php if($checklev == 1): ?><label class="col-sm-2 control-label">选择复审</label>
                    <select class="form-control" name="reckuid">
                        <?php if(is_array($recusers)): $i = 0; $__LIST__ = $recusers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vot): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vot["id"]); ?>"><?php echo ($vot["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select><?php endif; ?>
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
            <!--
            <div class="login_box1">
                <span class="login_title1">归属公司：</span>
                <input class="use_name form-control" value="<?php echo ($contract["belong"]); ?>" readonly name='cname'  type="text" placeholder="合同内容名称" /><font style="color:#FF0000;line-height:40px;">&nbsp;</font>
                <font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1">
                <span class="login_title1" >合同名称：</span>
                <input class="use_name  form-control" value="<?php echo ($contract["cname"]); ?>" readonly name='cname'  type="text" placeholder="合同内容名称" /><font style="color:#FF0000;line-height:40px;">&nbsp;</font>
            </div>
            <div class="login_box1">
                <span class="login_title1" >客户名称：</span>
                <input class="use_name  form-control" value="<?php echo ($contract["gname"]); ?>" readonly id="gname" name='gname'  type="text" placeholder="客户名称（全称）" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1">
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
                <span class="login_title1">推广期间：</span>
                <input class="use_name form-control" value="<?php echo ($bill["adperiod"]); ?>" readonly id="cbcomp"  name='cbcomp'  type="text" placeholder="开票公司" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1">
                <span class="login_title1" >推广位置：</span>
                <input class="use_name  form-control" value="<?php echo ($bill["adposition"]); ?>" readonly id="cbcomp" name='cbcomp'  type="text" placeholder="开票公司" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1">
                <span class="login_title1" >结算条款：</span>
                <input class="use_name form-control" value="<?php echo ($bill["settleitem"]); ?>" readonly id="gname" name='gname'  type="text" placeholder="客户名称（全称）" /><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <div class="login_box1">
                <span class="login_title1" >附件下载：</span>
                <a class="use_name form-control" href="<?php echo U("downfile?id=$bill[id]");?>">附件下载</a><font style="color:#FF0000;line-height:40px;">&nbsp;*</font>
            </div>
            <?php if($bill["stamppic"] != ''): ?><div class="login_box1  daniel_hide">
                    <span class="login_title1">相关图片证明：</span>
                    <span><img width="100" src="<?php echo ($bill["stamppic"]); ?>" data-toggle="modal" data-target="#myModal" onclick="ddd(this)"/></span>
                </div><?php endif; ?>
            <input type="hidden" name="cid" value="<?php echo ($cid); ?>"/>

            <div class="nav_tcon1" style="margin-left:160px;float:left;width:98%;">
                <a class=" btn btn-success" bid="<?php echo ($bill["id"]); ?>" data-toggle="modal" data-target="#myModal3" >
                    审核通过
                </a>
                <a class="btn btn-danger" bid="<?php echo ($bill["id"]); ?>" data-toggle="modal" data-target="#myModal2" >
                    驳回申请
                </a>
                <a class="btn btn-primary" onclick="JavaScript:history.go(-1);" style="text-emphasis:center;">返回上一页</a>
            </div>

        </div>
    </div>
</div>
</body>
</html>
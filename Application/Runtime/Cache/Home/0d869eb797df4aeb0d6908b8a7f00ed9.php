<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>报销确认</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/index.css" />
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/laydate/laydate.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <style>
        .daniel_icon {
            margin-left: 160px;
        }
    </style>
    <script>
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
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo U('reimburse/confirm');?>" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">审核驳回</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="type" value="bac"/>
                    <input id="tobv" type="hidden" name="id" value="<?php echo ($id); ?>"/>
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
            <form action='' method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">审核通过</h4>
                </div>
                <div class="modal-body">
                    <label class="col-sm-2 control-label">通过备注</label>
                    <input type="hidden" name="type" value="pas"/>
                    <input type="hidden" name="checklev" value="<?php echo ($checklev); ?>"/>
                    <input id="topass" type="hidden" name="sid" value="<?php echo ($id); ?>"/>
                    <textarea class="form-control" name="msg"></textarea>
                    <label class="col-sm-2 control-label">选择复审</label>
                    <select class="form-control" name="recheckuid">
                        <?php if(is_array($recusers)): $i = 0; $__LIST__ = $recusers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
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
<div class="nav_top1">
    <div class="nav_tcon1" style="width:98%;">
        <div class="logotitle1">
            <span>报销确认</span>
        </div>
    </div>
</div>
<form name="product_form" id="daniel_form" enctype="multipart/form-data" action="<?php echo U('reimburse/confirm');?>" method="post">
    <div class="logo_content1">
        <div class="logo_ccon1">
            <div id="daniel_so" class="logo_enter1" style="border:none;float:left;">
                <table id="d_table" class=" table table-bordered" style="margin-left:30px;margin-top:20px">
                    <tr class="danger">
                        <th>所属项目</th>
                        <th>所属销售合同</th>
                        <th>所属采购合同</th>
                        <th colspan="5">备注</th>
                    </tr>
                    <tr class="info">
                        <td><i><?php echo ($data["pname"]); ?></i></td>
                        <td><i><?php echo ($scon["cname"]); ?></i></td>
                        <td><i><?php echo ($cgcon["cname"]); ?></i></td>
                        <td colspan="5"><i><?php echo ($data["remark"]); ?></i></td>
                    </tr>
                    <tr class="active">
                        <th>报销摘要</th>
                        <th>发生月份</th>
                        <th>发生金额</th>
                        <th>申请金额</th>
                        <th>一级科目</th>
                        <th>二级科目</th>
                        <th>费用性质</th>
                        <th>付款方式</th>

                    </tr>
                    <?php if(is_array($reimbursement)): $i = 0; $__LIST__ = $reimbursement;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="<?php if(($mod) == "1"): ?>info<?php else: ?>warning<?php endif; ?>">
                        <td width="12%"><i><?php echo ($vo["ab"]); ?></i></td>
                        <td width="8%"><i><?php echo ($vo["etime"]); ?></i></td>
                        <td width="8%"><i><?php echo ($vo["etotal"]); ?></i></td>
                        <td width="8%"><i><?php echo ($vo["atotal"]); ?></i></td>
                        <td width="11%">
                            <input type="hidden" name="bsmid[]" value="<?php echo ($vo["id"]); ?>"/>
                            <select class="use_name form-control input-sm" name="fcate[]">
                            <?php if(is_array($fk)): foreach($fk as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" > <?php echo ($vo["cgname"]); ?></option><?php endforeach; endif; ?>
                            </select>
                        </td>
                        <td width="11%">
                            <select class="use_name form-control input-sm" name="scate[]">
                                <?php if(is_array($sk)): foreach($sk as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" > <?php echo ($vo["cgname"]); ?></option><?php endforeach; endif; ?>
                            </select>
                        </td>
                        <td width="11%">
                            <select class="use_name form-control input-sm" name="feetype[]">
                                <?php if(is_array($fee)): foreach($fee as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" > <?php echo ($vo["feetpname"]); ?></option><?php endforeach; endif; ?>
                            </select>
                        </td>
                        <td width="11%">
                            <select class="use_name form-control input-sm" name="payway[]">
                                <option value="0">现金</option>
                                <?php if(is_array($banks)): foreach($banks as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>" > <?php echo ($vo["bankno"]); ?></option><?php endforeach; endif; ?>
                            </select>
                        </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                </table>
                <?php if(is_array($pics)): $i = 0; $__LIST__ = $pics;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bill): $mod = ($i % 2 );++$i;?><div class="login_box1" style="width:90%">
                        <span>相关图片证明：</span>
                        <span><img width="100" src="<?php echo ($bill['path']); ?>" data-toggle="modal" data-target="#myModal" onclick="ddd(this)"/></span>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                <div class="login_box1 form-group">
                    <span class="login_title1 col-sm-2 control-label" >备注</span>
                    <textarea class="use_name form-control" name="remark"></textarea>
                    <input type="hidden" name="type" value="pas"/>
                    <input type="hidden" name="id" value="<?php echo ($id); ?>"/>
                </div>
            </div>

            <div class="nav_tcon1" style="margin-left:160px;float:left;width:78%;">
                <button class="submit btn btn-warning">
                    审核通过
                </button>
                <a class="btn btn-danger" bid="<?php echo ($id); ?>" data-toggle="modal" data-target="#myModal2" onclick="ddds(this)">
                    驳回申请
                </a>
                <a class="btn btn-primary" onclick="JavaScript:history.go(-1);" style="text-emphasis:center;">返回上一页</a>
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
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>付款确认</title>
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
            <form action="" method="post">
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
                    <input id="topass" type="hidden" name="id" value="<?php echo ($id); ?>"/>
                    <textarea class="form-control" name="msg"></textarea>
                    <?php if($checklev == 5): ?><label class="col-sm-2 control-label">通过方式</label>
                        <select class="form-control" name="isceo">
                            <option value="0">直接通过</option>
                            <option value="1">交由CEO审核</option>
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
<div class="nav_top1">
    <div class="nav_tcon1" style="width:98%;">
        <div class="logotitle1">
            <span>付款确认</span>
        </div>
    </div>
</div>
<form name="product_form" id="daniel_form" enctype="multipart/form-data" action="" method="post">
    <div class="logo_content1">
        <div class="logo_ccon1">
            <div id="daniel_so" class="logo_enter1" style="border:none;float:left;">
                <table id="d_table" class=" table table-bordered" style="margin-left:30px;margin-top:20px">
                    <tr class="danger">
                        <th>所属项目</th>
                        <th>所属销售合同</th>
                        <th>所属采购合同</th>
                        <th colspan="6">备注</th>
                    </tr>
                    <tr class="info">
                        <td><i><?php echo ($data["pname"]); ?></i></td>
                        <td><i><?php echo ($scon["cname"]); ?></i></td>
                        <td><i><?php echo ($cgcon["cname"]); ?></i></td>
                        <td colspan="6"><i><?php echo ($data["remark"]); ?></i></td>
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
                        <th>付款时间</th>

                    </tr>
                    <?php if(is_array($reimbursement)): $i = 0; $__LIST__ = $reimbursement;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="<?php if(($mod) == "1"): ?>info<?php else: ?>warning<?php endif; ?>">
                        <td width="12%"><i><?php echo ($vo["ab"]); ?></i></td>
                        <td width="8%"><i><?php echo ($vo["etime"]); ?></i></td>
                        <td width="8%"><i><?php echo ($vo["etotal"]); ?></i></td>
                        <td width="8%">
                            <input type="hidden" name="atotal[]" value="<?php echo ($vo["atotal"]); ?>"/>
                            <i><?php echo ($vo["atotal"]); ?></i>
                        </td>
                        <td width="11%">
                            <i><?php echo ($vo["kemu1"]); ?></i>
                        </td>
                        <td width="11%">
                            <i><?php echo ($vo["kemu2"]); ?></i>
                        </td>
                        <td width="11%">
                            <i><?php echo ($vo["fee"]); ?></i>
                        </td>
                        <td width="11%">
                            <input type="hidden" name="pway[]" value="<?php echo ($vo["pway"]); ?>"/>
                            <i><?php echo ($vo["payway"]); ?></i>
                        </td>
                        <td>
                            <input type="hidden" name="bsid[]" value="<?php echo ($vo["id"]); ?>"/>
                            <input class="form-control" type="text" name="ptime[]" placeholder="格式:2016-09-08"/>
                        </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                </table>
                <?php if(is_array($pics)): $i = 0; $__LIST__ = $pics;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bill): $mod = ($i % 2 );++$i;?><div class="login_box1" style="width:90%">
                        <span>相关图片证明：</span>
                        <span><img width="100" src="<?php echo ($bill['path']); ?>" data-toggle="modal" data-target="#myModal" onclick="ddd(this)"/></span>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <input type="hidden" name="id" value="<?php echo ($id); ?>"/>
            <div class="nav_tcon1" style="margin-left:160px;float:left;width:78%;">
                <button class="submit btn btn-warning">
                    付款信息确认
                </button>
                <a class="btn btn-primary" onclick="JavaScript:history.back(-1);" style="text-emphasis:center;">返回上一页</a>
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
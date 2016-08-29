<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>付款确认</title>
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
    <script>
        function ddd(obj){
            var a = $(obj).attr('bid');
            $("#tobid").attr('value',a);
        }
    </script>
</head>

<body style="height:100%;overflow-y:auto;">

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="get">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">审核驳回</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="type" value="bac"/>
                    <input id="tobid" type="hidden" name="billid" value=""/>
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
<span class="cp_title" ><h4>付款确认</h4></span>
<div class="table_con">
    <form method="get" action="">
        <table cellpadding="0" cellspacing="1">
            <tr>
                <td width="5%" align="center" class="tb_title">报销单号</td>
                <td width="11%" align="center" class="tb_title">报销项目</td>
                <td width="8%" align="center" class="tb_title">申请性质</td>
                <td width="5%" align="center" class="tb_title">销售合同</td>
                <td width="8%" align="center" class="tb_title">采购合同</td>
                <td width="5%" align="center" class="tb_title">申请人</td>
                <td width="8%" align="center" class="tb_title">操作</td>
            </tr>
            <?php if(!empty($data['list'])): if(is_array($data['list'])): foreach($data['list'] as $key=>$vo): ?><tr>
                        <td align="center"><?php echo ($vo["rbno"]); ?></td>
                        <td align="center"><?php echo ($vo["pname"]); ?></td>
                        <td align="center">
                            <?php if($vo["rbtype"] == 1): ?><span style="color:deepskyblue">借款申请</span>
                                <?php else: ?>
                                <span style="color:darkorange">报销申请</span><?php endif; ?>
                        </td>
                        <td align="center">
                            <?php if($vo["scno"] == ''): ?>无
                                <?php else: ?>
                                <?php echo ($vo["scno"]); endif; ?>
                        </td>
                        <td align="center">
                            <?php if($vo["cgcno"] == ''): ?>无
                                <?php else: ?>
                                <?php echo ($vo["cgcno"]); endif; ?>
                        </td>
                        <td align="center"><?php echo ($vo["uname"]); ?></td>
                        <td align="center">
                            <a class="btn btn-warning btn-xs" href="<?php echo U("todeal?id=$vo[id]");?>">确认付款</a>
                        </td>
                    </tr><?php endforeach; endif; ?>
                <?php else: ?>
                <tr>
                    <td colspan="7">暂无信息</td>
                </tr><?php endif; ?>
            <?php if(($data['list'] != null)): ?><tr>
                    <td colspan="7">
                        <?php echo ($data["show"]); ?>
                    </td>
                </tr><?php endif; ?>
        </table>
    </form>
</div>
</body>
</html>
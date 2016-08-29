<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>详细</title>
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
<span class="cp_title" >详细</span>
<div class="table_con">
    <form method="get" action="">
        <table cellpadding="0" cellspacing="1">
            <tr>
                <td width="5%" align="center" class="tb_title">项目名称</td>
                <td width="5%" align="center" class="tb_title">申请子单ID</td>
                <td width="5%" align="center" class="tb_title">关联销售合同</td>
                <td width="5%" align="center" class="tb_title">关联采购合同</td>
                <td width="5%" align="center" class="tb_title">摘要</td>
                <td width="5%" align="center" class="tb_title">时间</td>
                <td width="8%" align="center" class="tb_title">报销金额</td>
                <td width="5%" align="center" class="tb_title">支付金额</td>
            </tr>
            <?php if(!empty($data)): if(is_array($data)): foreach($data as $key=>$vo): ?><tr>
                        <td align="center"><?php echo ($vo["pname"]); ?></td>
                        <td align="center"><a  href="<?php echo U("record_detail?id=$vo[sid]");?>"><?php echo ($vo["sid"]); ?></a></td>
                        <td align="center"><?php echo ($vo["scon"]); ?></td>
                        <td align="center"><?php echo ($vo["cgcon"]); ?></td>
                        <td align="center"><?php echo ($vo["remark"]); ?></td>
                        <td align="center"><?php echo ($vo["etime"]); ?></td>
                        <td align="center"><?php echo ($vo["etotal"]); ?></td>
                        <td align="center"><?php echo ($vo["atotal"]); ?></td>

                    </tr><?php endforeach; endif; ?>
                <?php else: ?>
                <tr>
                    <td colspan="8">暂无信息</td>
                </tr><?php endif; ?>
            <?php if(($data['list'] != null)): ?><tr>
                    <td colspan="8">
                        <?php echo ($data["show"]); ?>
                    </td>
                </tr><?php endif; ?>
        </table>
    </form>
</div>
</body>
</html>
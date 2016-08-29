<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>关联列表</title>
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
            $(".tobid").attr('value',a);
        }
    </script>
</head>

<body style="height:100%;overflow-y:auto;">

<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action='' method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">审核驳回</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="type" value="bac"/>
                    <input class="tobid" type="hidden" name="rid" value=""/>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action='' method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">审核通过</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="type" value="pas"/>
                    <input class="tobid" type="hidden" name="rid" value=""/>
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
<span class="cp_title" >关联列表</span>
<div class="table_con">
    <form method="get" action="">
        <table cellpadding="0" cellspacing="1">
            <tr>
                <td width="5%" align="center" class="tb_title">回款iD</td>
                <td width="10%" align="center" class="tb_title">回款金额</td>
                <td width="5%" align="center" class="tb_title">付款公司</td>
                <td width="5%" align="center" class="tb_title">收款公司</td>
                <td width="8%" align="center" class="tb_title">款项性质</td>
                <td width="5%" align="center" class="tb_title">收款账号</td>
                <td width="8%" align="center" class="tb_title">回款时间</td>
                <td width="10%" align="center" class="tb_title">管理状态</td>

            </tr>
            <?php if(!empty($data['list'])): if(is_array($data['list'])): foreach($data['list'] as $key=>$vo): ?><tr>
                        <td align="center"><?php echo ($vo["id"]); ?></td>
                        <td align="center"><?php echo number_format($vo['btotal'],2);?></td>
                        <td align="center"><?php echo ($vo["paycomp"]); ?></td>
                        <td align="center"><?php echo ($vo["payee"]); ?></td>
                        <td align="center"><?php echo ($vo["btype"]); ?></td>
                        <td align="center"><?php echo ($vo["bankno"]); ?></td>
                        <td align="center"><?php echo ($vo["btime"]); ?></td>
                        <td align="center">
                            <?php if($vo["rstatus"] == 0): ?><span style="color:red">被驳回</span><?php endif; ?>
                            <?php if($vo["rstatus"] == 1): ?><span style="color:yellowgreen"><?php echo ($vo["ckuname"]); ?>未关联</span><?php endif; ?>
                            <?php if($vo["rstatus"] == 2): ?><span style="color:yellow"><?php echo ($vo["reckuname"]); ?>审核中</span><?php endif; ?>
                            <?php if($vo["rstatus"] == 3): ?><span style="color:darkgoldenrod">关联完成</span><?php endif; ?>
                        </td>

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
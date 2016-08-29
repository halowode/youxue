<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>回款关联</title>
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
            <form action="" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">关联合同</h4>
                </div>
                <div class="modal-body">
                    <input id="tobid" type="hidden" name="rid" value=""/>
                    <span class="login_title1 col-sm-3 control-label" >选择合同：</span>
                    <select class="use_name form-control input-sm" name="cid" id="d_piao" >
                        <?php if(is_array($contract)): $i = 0; $__LIST__ = $contract;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" ><?php echo ($vo["cno"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
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
<span class="cp_title" >回款关联</span>
<div class="table_con">
    <form method="get" action="">
        <table cellpadding="0" cellspacing="1">
            <tr>
                <td width="5%" align="center" class="tb_title">回款编号</td>
                <td width="5%" align="center" class="tb_title">归属公司</td>
                <td width="8%" align="center" class="tb_title">付款公司</td>
                <td width="5%" align="center" class="tb_title">回款金额</td>
                <td width="8%" align="center" class="tb_title">回款性质</td>
                <td width="10%" align="center" class="tb_title">回款时间</td>
                <td width="5%" align="center" class="tb_title">收款账号</td>
                <td width="5%" align="center" class="tb_title">关联状态</td>
                <td width="10%" align="center" class="tb_title">操作</td>

            </tr>
            <?php if(!empty($data['list'])): if(is_array($data['list'])): foreach($data['list'] as $key=>$vo): ?><tr>
                        <td align="center"><?php echo ($vo["id"]); ?></td>
                        <td align="center"><?php echo ($vo["payee"]); ?></td>
                        <td align="center"><?php echo ($vo["paycomp"]); ?></td>
                        <td align="center"><?php echo number_format($vo['btotal'],2);?></td>
                        <td align="center"><?php echo ($vo["btype"]); ?></td>
                        <td align="center"><?php echo ($vo["btime"]); ?></td>
                        <td align="center"><?php echo ($vo["bno"]); ?></td>
                        <td align="center">
                            <?php if($vo["rstatus"] == 0): ?><span style="color:red">被驳回</span><?php endif; ?>
                            <?php if($vo["rstatus"] == 1): ?><span style="color:yellowgreen">未关联</span><?php endif; ?>
                            <?php if($vo["rstatus"] == 2): ?><span style="color:yellow">关联审核中</span><?php endif; ?>
                            <?php if($vo["rstatus"] == 3): ?><span style="color:darkgoldenrod">关联完成</span><?php endif; ?>
                        </td>
                        <td align="center">
                            <a class="btn btn-primary btn-xs" bid="<?php echo ($vo["id"]); ?>" data-toggle="modal" data-target="#myModal" onclick="ddd(this)">
                                关联合同
                            </a>
                            <?php if($vo["rstatus"] == 1): ?><a class="btn btn-danger btn-xs" href="<?php echo U("rebcdel?id=$vo[id]&bid=$vo[bankno]&mt=$vo[btotal]");?>">删除</a><?php endif; ?>
                        </td>
                    </tr><?php endforeach; endif; ?>
                <?php else: ?>
                <tr>
                    <td colspan="9">暂无信息</td>
                </tr><?php endif; ?>
            <?php if(($data['list'] != null)): ?><tr>
                    <td colspan="9">
                        <?php echo ($data["show"]); ?>
                    </td>
                </tr><?php endif; ?>
        </table>
    </form>
</div>
</body>
</html>
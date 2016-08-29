<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>盖章列表</title>
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
<span class="cp_title" >盖章列表</span>
<div class="table_con">
    <form method="get" action="">
        <table cellpadding="0" cellspacing="1">
            <tr>
                <td width="5%" align="center" class="tb_title">合同编号</td>
                <td width="5%" align="center" class="tb_title">归属公司</td>
                <td width="8%" align="center" class="tb_title">合同名称</td>
                <td width="5%" align="center" class="tb_title">盖章ID</td>
                <td width="5%" align="center" class="tb_title">状态</td>
                <td width="10%" align="center" class="tb_title">操作</td>

            </tr>
            <?php if(!empty($data['list'])): if(is_array($data['list'])): foreach($data['list'] as $key=>$vo): ?><tr>
                        <td align="center"><a href="<?php echo U("detail?id=$vo[cid]");?>"><?php echo ($vo["cno"]); ?></a></td>
                        <td align="center"><?php echo ($vo["belong"]); ?></td>
                        <td align="center"><?php echo ($vo["cname"]); ?></td>
                        <td align="center"><?php echo ($vo["id"]); ?></td>

                        <td align="center">
                            <?php if($vo["status"] == 0): ?><span style="color:red">被驳回</span><?php endif; ?>
                            <?php if($vo["status"] == 1): ?><span style="color:yellowgreen"><?php echo ($vo["ckuname"]); ?>初审中</span><?php endif; ?>
                            <?php if($vo["status"] == 2): ?><span style="color:yellow"><?php echo ($vo["reckuname"]); ?>复审中</span><?php endif; ?>
                            <?php if($vo["status"] == 3): ?><span style="color:darkgoldenrod">开票中</span><?php endif; ?>
                            <?php if($vo["status"] == 4): ?><span style="color:dodgerblue">已开票</span><?php endif; ?>
                        </td>
                        <td align="center">
                            <?php if($vo["status"] == 0): ?><a class="btn btn-primary btn-xs" href="<?php echo U("stampedit?id=$vo[id]&cid=$vo[cid]");?>">查看并编辑</a><?php endif; ?>
                            <?php if($vo["status"] == 1): ?><a class="btn btn-danger btn-xs" href="<?php echo U("stampdel?id=$vo[id]&cid=$vo[cid]");?>">删除</a><?php endif; ?>
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
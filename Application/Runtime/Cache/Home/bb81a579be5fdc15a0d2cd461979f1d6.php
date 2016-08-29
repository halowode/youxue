<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>科目管理</title>
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
<span class="cp_title" >科目管理</span>
<div class="add_cp">
    <a class="btn btn-danger" href="<?php echo U('catelog_add');?>">增加科目</a>
</div>
<div class="table_con">
    <form method="get" action="">
        <table cellpadding="0" cellspacing="1">
            <tr>
                <td width="5%" align="center" class="tb_title">科目名称</td>
                <td width="5%" align="center" class="tb_title">科目类别</td>
                <td width="8%" align="center" class="tb_title">状态</td>
                <td width="10%" align="center" class="tb_title">操作</td>

            </tr>
            <?php if(!empty($data['list'])): if(is_array($data['list'])): foreach($data['list'] as $key=>$vo): ?><tr>
                        <td align="center"><a href="<?php echo U("detail?id=$vo[id]");?>"><?php echo ($vo["cgname"]); ?></a></td>
                        <td align="center">
                            <?php if($vo["ctype"] == 1): ?>一级分类<?php endif; ?>
                            <?php if($vo["ctype"] == 2): ?>二级分类<?php endif; ?>
                        </td>
                        <td align="center">
                            <?php if($vo["ctype"] == 1): ?>一级分类<?php endif; ?>
                            <?php if($vo["ctype"] == 2): ?>二级分类<?php endif; ?>
                        </td>
                        <td align="center">
                            <a href="<?php echo U("catelogedit?id=$vo[id]");?>">修改</a>
                        </td>
                    </tr><?php endforeach; endif; ?>
                <?php else: ?>
                <tr>
                    <td colspan="4">暂无信息</td>
                </tr><?php endif; ?>
            <?php if(($data['list'] != null)): ?><tr>
                    <td colspan="4">
                        <?php echo ($data["show"]); ?>
                    </td>
                </tr><?php endif; ?>
        </table>
    </form>
</div>
</body>
</html>
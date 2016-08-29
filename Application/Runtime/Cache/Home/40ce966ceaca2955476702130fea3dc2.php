<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>项目修改</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/Iframe.css" />
    <link rel="stylesheet" href="/Public/utilLib/bootstrap.min.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/laydate/laydate.js"></script>
    <script type="text/javascript" src="/Public/js/main.js"></script>
</head>

<body style="height:100%;overflow-y:auto;">
<span class="cp_title" >项目修改</span>
<div class="table_con">
    <form method="get" action="">
        <table cellpadding="0" cellspacing="1">
            <tr>
                <td width="12%" align="center" class="tb_title">项目名称</td>
                <td width="10%" align="center" class="tb_title">项目简称</td>
                <td width="10%" align="center" class="tb_title">项目描述</td>
                <td width="10%" align="center" class="tb_title">添加时间</td>
                <td width="10%" align="center" class="tb_title">状态</td>
                <td width="10%" align="center" class="tb_title">填加人</td>
                <td width="7%" align="center" class="tb_title">操作</td>

            </tr>
            <?php if(!empty($data)): if(is_array($data)): foreach($data as $key=>$vo): ?><tr>
                        <td align="center"><?php echo ($vo["pname"]); ?></td>
                        <td align="center"><?php echo ($vo["shortname"]); ?></td>
                        <td align="center"><?php echo ($vo["descb"]); ?></td>
                        <td align="center"><?php echo (date("Y-m-d H:i:s", $vo["ctime"])); ?></td>
                        <td align="center">
                            <?php if(($vo["status"]) == "0"): ?>项目已禁用<?php endif; ?>
                            <?php if(($vo["status"]) == "1"): ?>项目可用<?php endif; ?>
                            <?php if(($vo["status"]) == "2"): ?>项目已完结<?php endif; ?>
                        </td>
                        <td align="center"><?php echo ($vo["username"]); ?></td>
                        <td align="center">
                            <?php if(($vo["status"]) == "1"): ?><a href="<?php echo U("proedit?type=edit&id=$vo[id]");?>">编辑</a>
                                <a href="<?php echo U("prodone?id=$vo[id]");?>">完结</a><?php endif; ?>
                            <?php if(($vo["status"]) == "0"): ?><a href="<?php echo U("proedit?type=reuse&id=$vo[id]");?>">重新启用</a><?php endif; ?>
                            <?php if(($vo["status"]) == "2"): ?><a href="<?php echo U("proedit?type=reuse&id=$vo[id]");?>">重新启用</a><?php endif; ?>

                        </td>
                    </tr><?php endforeach; endif; ?>
                <?php else: ?>
                <tr>
                    <td colspan="6">暂无信息</td>
                </tr><?php endif; ?>
            <?php if(($data['list'] != null)): ?><tr>
                    <td colspan="6">
                        <?php echo ($data["show"]); ?>
                    </td>
                </tr><?php endif; ?>
        </table>
    </form>
</div>
</body>
</html>
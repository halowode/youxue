<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>部门管理</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/Iframe.css" />
    <link rel="stylesheet" href="/Public/utilLib/bootstrap.min.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/laydate/laydate.js"></script>
    <script type="text/javascript" src="/Public/js/main.js"></script>
</head>

<body style="height:100%;overflow-y:auto;">
<span class="cp_title" >部门管理</span>
<div class="table_con">
    <form method="get" action="">
        <table cellpadding="0" cellspacing="1">
            <tr>
                <td width="5%" align="center" class="tb_title">合同ID</td>
                <td width="10%" align="center" class="tb_title">部门名称</td>
                <td width="10%" align="center" class="tb_title">创建时间</td>
                <td width="10%" align="center" class="tb_title">部门状态</td>
                <td width="10%" align="center" class="tb_title">创建人</td>
                <td width="20%" align="center" class="tb_title">操作</td>

            </tr>
            <?php if(!empty($data)): if(is_array($data)): foreach($data as $key=>$vo): ?><tr>
                        <td align="center"><?php echo ($vo["id"]); ?></td>
                        <td align="center"><?php echo ($vo["depname"]); ?></td>
                        <td align="center"><?php echo (date("Y-m-d",$vo["ctime"])); ?></td>
                        <td align="center">
                            <?php if(($vo["status"]) == "1"): ?>可用<?php endif; ?>
                            <?php if(($vo["status"]) == "0"): ?>已禁用<?php endif; ?>
                        </td>
                        <td align="center"><?php echo ($vo["username"]); ?></td>
                        <td align="center">
                            <?php if(($vo["status"]) == "1"): ?><a href="<?php echo U("department?type=del&id=$vo[id]");?>">禁用</a><?php endif; ?>
                            <?php if(($vo["status"]) == "0"): ?><a href="<?php echo U("department?type=reuse&id=$vo[id]");?>">重新启用</a><?php endif; ?>
                            <a href="<?php echo U("dptedit?id=$vo[id]");?>">编辑</a>
                        </td>
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
<script>
    var p_time = {
        elem: '#p_time',
        format: 'YYYY-MM-DD',
        min: '2015-06-16 23:59:59',//laydate.now(), //设定最小日期为当前日期
        max: '2099-06-16 23:59:59', //最大日期
        istime: false,
        istoday: false,
        choose: function(datas){
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    var p_etime = {
        elem: '#p_etime',
        format: 'YYYY-MM-DD',
        min: '2015-06-16 23:59:59',//laydate.now(), //设定最小日期为当前日期
        max: '2099-06-16 23:59:59', //最大日期
        istime: false,
        istoday: false,
        choose: function(datas){
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas; //将结束日的初始值设定为开始日
        }
    };
    laydate(p_time);
    laydate(p_etime);
</script>
</body>
</html>
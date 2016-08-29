<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>订阅管理</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/Iframe.css" />
    <link rel="stylesheet" href="/Public/utilLib/bootstrap.min.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/laydate/laydate.js"></script>
    <script type="text/javascript" src="/Public/js/main.js"></script>
    <script type="text/javascript">
        $(function(){

            $("#mgcity").change(function(){
                var sid = $(this).val();
                $.ajax({
                    url:'getTown',
                    type:'GET',
                    data:"sid="+sid+"&type=getcity",
                    cache: false,
                    async:false,
                    dataType: "json",
                    success:function(datas){
                        $("#towns").html('<option value="">-选择-</option>');
                        $("#school").html('<option value="">-选择-</option>');
                        $("#class").html('<option value="">-选择-</option>');
                        $.each(datas,function(k,v){
                            $("#towns").append("<option value='"+k+"'>"+v+"</option>");
                        });
                    },
                    error:function(){
                        alert('网络错误，请刷新页面！');
                        return false;
                    }
                });

            });
            $("#towns").change(function(){
                var tid = $(this).val();
                var sid = $("#mgcity").val();
                $.ajax({
                    url:'getTown',
                    type:'GET',
                    data:"tid="+tid+"&type=getschool&sid="+sid,
                    cache: false,
                    async:false,
                    dataType: "json",
                    success:function(datas){
                        $("#school").html('<option value="">-选择-</option>');
                        $("#class").html('<option value="">-选择-</option>');
                        $.each(datas,function(k,v){
                            $("#school").append("<option value='"+k+"'>"+v+"</option>");
                        });
                    },
                    error:function(){
                        alert('网络错误，请刷新页面！');
                        return false;
                    }
                });


            });
            $("#school").change(function(){
                var scid = $(this).val();
                $.ajax({
                    url:'getTown',
                    type:'GET',
                    data:"scid="+scid+"&type=getclass",
                    cache: false,
                    async:false,
                    dataType: "json",
                    success:function(datas){
                        $("#class").html('<option value="">-选择-</option>');
                        $.each(datas,function(k,v){
                            $("#class").append("<option value='"+k+"'>"+v+"</option>");
                        });
                    },
                    error:function(){
                        alert('网络错误，请刷新页面！');
                        return false;
                    }
                });


            });
        })
    </script>
</head>

<body style="height:100%;overflow-y:auto;">
<span class="cp_title" >查询管理</span>
<div class="table_con">
    <form method="get" action="">
        <table cellpadding="0" cellspacing="1">
                <tr>
                    <td width="5%" align="center" class="tb_title">合同编号</td>
                    <td width="8%" align="center" class="tb_title">归属公司</td>
                    <td width="10%" align="center" class="tb_title">合同名称</td>
                    <td width="10%" align="center" class="tb_title">项目名称</td>
                    <td width="8%" align="center" class="tb_title">客户名称</td>
                    <td width="3%" align="center" class="tb_title">合同金额</td>
                    <td width="6%" align="center" class="tb_title">回款总额</td>
                    <td width="6%" align="center" class="tb_title">发票总额</td>
                    <td width="5%" align="center" class="tb_title">负责人</td>
                    <td width="6%" align="center" class="tb_title">合同状态</td>
                    <td width="26%" align="center" class="tb_title">操作</td>

                </tr>
                <?php if(!empty($data['list'])): if(is_array($data['list'])): foreach($data['list'] as $key=>$vo): ?><tr>
                            <td align="center"><a href="<?php echo U("detail?id=$vo[id]");?>"><?php echo ($vo["cno"]); ?></a></td>
                            <td align="center"><?php echo ($vo["belong"]); ?></td>
                            <td align="center"><?php echo ($vo["cname"]); ?></td>
                            <td align="center"><?php echo ($vo["pname"]); ?></td>
                            <td align="center"><?php echo ($vo["gname"]); ?></td>
                            <td align="center"><?php echo ($vo["total"]); ?></td>
                            <td align="center"><?php echo ($vo["bktotal"]); ?></td>
                            <td align="center"><?php echo ($vo["billtotal"]); ?></td>
                            <td align="center"><?php echo ($vo["fname"]); ?></td>
                            <td align="center">
                                <?php if(($vo['cstatus'] == 0)): ?>未完结
                                    <?php else: ?>
                                        已完结<?php endif; ?>
                            </td>
                            <td align="center">

                                <?php if($vo["isactive"] == 0): ?><a href="<?php echo U("ctedit?id=$vo[id]");?>">编辑</a>
                                    <?php else: ?>
                                    <?php if($isexc == 1): ?><a href="<?php echo U("ctedit?id=$vo[id]");?>">编辑</a><?php endif; endif; ?>
                                <a href="<?php echo U("bill?id=$vo[id]");?>">申请发票</a>
                                <?php if($vo["stampis"] == 0): ?><a href="<?php echo U("stamp?id=$vo[id]");?>">申请盖章</a><?php endif; ?>
                                <?php if(($vo["isfiling"] == 0) or ($vo["isfiling"] == 1)): ?><a href="<?php echo U("filing?id=$vo[id]");?>">申请归档</a><?php endif; ?>
                                <a href="<?php echo U("listex?id=$vo[id]");?>">执行列表</a>
                            </td>
                        </tr><?php endforeach; endif; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="11">暂无信息</td>
                    </tr><?php endif; ?>
                <?php if(($data['list'] != null)): ?><tr>
                        <td colspan="11">
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
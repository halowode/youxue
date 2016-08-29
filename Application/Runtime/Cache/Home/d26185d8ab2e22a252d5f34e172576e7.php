<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>报销审核</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/Iframe.css" />
    <!--
    <link rel="stylesheet" href="/Public/utilLib/bootstrap.min.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    -->
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!--
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    -->
    <script>
        function ddd(obj){
            var a = $(obj).attr('aid');
            $("#tobid").attr('value',a);
        }
    </script>
</head>

<body style="height:100%;overflow-y:auto;">

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo U('record_del');?>" method="get">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">删除申请</h4>
                </div>
                <div class="modal-body">
                    <input id="tobid" type="hidden" name="id" value=""/>
                    <textarea class="form-control" name="msg">
                        该操作将删除本次申请的所有记录，删除后不可恢复！
                    </textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary">确定</button>
                </div>
            </form>
        </div>
    </div>
</div>
<span class="cp_title" ><h4>报销初审</h4></span>
<div class="table_con">
    <form method="get" action="<?php echo U('reimburse/getalist');?>">
        <table cellpadding="0" cellspacing="1">
            <tr>
                <td align="right" colspan="11">
                    <label style="margin-left:5px;">申请人:&nbsp;&nbsp;</label>
                    <select class="input-sm" name="auid" style="margin-right:5px;width:80px;">
                        <option value="">-选择-</option>
                        <?php if(is_array($users)): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <label style="margin-left:5px;">项目名称:&nbsp;&nbsp;</label>
                    <input type="text" class="input-sm" name="keyword" id="keyword" style="float:none;" placeholder="请输入关键字" value="<?php echo ($keyword); ?>" />
                    <input type="submit" name="search" id="search" value="搜索" class="bj_btn" />
                </td>
            </tr>
            <tr>
                <td width="5%" align="center" class="tb_title">报销单号</td>
                <td width="8%" align="center" class="tb_title">报销项目</td>
                <td width="5%" align="center" class="tb_title">申请性质</td>
                <td width="5%" align="center" class="tb_title">销售合同</td>
                <td width="8%" align="center" class="tb_title">采购合同</td>
                <td width="5%" align="center" class="tb_title">申请人</td>
                <td width="8%" align="center" class="tb_title">状态</td>
                <td width="18%" align="center" class="tb_title">操作</td>
            </tr>
            <?php if(!empty($data['list'])): if(is_array($data['list'])): foreach($data['list'] as $key=>$vo): ?><tr>
                        <td align="center">
                            <a href="<?php echo U("reimburse_detail?id=$vo[rbid]");?>"><?php echo ($vo["rbno"]); ?></a>
                        </td>
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
                            <?php if($vo["bstatus"] == 0): ?><span style="color:red">被驳回</span><?php endif; ?>
                            <?php if($vo["bstatus"] == 1): ?><span style="color:yellowgreen"><?php echo ($vo["checkuname"]); ?>初审中</span><?php endif; ?>
                            <?php if($vo["bstatus"] == 2): ?><span style="color:yellow"><?php echo ($vo["recheckuname"]); ?>复审中</span><?php endif; ?>
                            <?php if($vo["bstatus"] == 3): ?><span style="color:darkgoldenrod">出纳确认中</span><?php endif; ?>
                            <?php if($vo["bstatus"] == 4): ?><span style="color:dodgerblue">财务确认中</span><?php endif; ?>
                            <?php if($vo["bstatus"] == 5): ?><span style="color:blanchedalmond">CFO确认中</span><?php endif; ?>
                            <?php if($vo["bstatus"] == 6): ?><span style="color:deeppink">CEO确认中</span><?php endif; ?>
                            <?php if($vo["bstatus"] == 7): ?><span style="color:mediumpurple">出纳付款中</span><?php endif; ?>
                            <?php if($vo["bstatus"] == 8): ?><span style="color:darkgrey">完成</span><?php endif; ?>
                        </td>
                        <td align="center">
                            <?php if($_SESSION['uid']== $vo['uid'] or $_SESSION['exc']== []): ?><a class="btn btn-info btn-xs" href="<?php echo U("borrow?rbid=$vo[rbid]");?>">添加新的借款</a>
                                <a class="btn btn-warning btn-xs" href="<?php echo U("index?rbid=$vo[rbid]");?>">添加新的报销</a>
                                <?php if($vo["bstatus"] == 0): ?><a class="btn btn-primary btn-xs" href="<?php echo U("reimburse_edit?id=$vo[id]&rt=$vo[rbtype]");?>">编辑并重新申请</a><?php endif; ?>
                                <a class="btn btn-primary btn-xs" href="<?php echo U("record_detail?id=$vo[id]&rt=$vo[rbtype]");?>">详细</a>
                                <?php if($vo["bstatus"] == 1): ?><a aid="<?php echo ($vo["id"]); ?>" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal" onclick="ddd(this)" >删除</a><?php endif; endif; ?>
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
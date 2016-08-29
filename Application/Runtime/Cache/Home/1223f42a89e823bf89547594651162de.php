<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>创建合同</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/index.css" />
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <style>
        .niandu {
            width:120px;
            line-height: 33px;
        }
    </style>
</head>

<body style="background:#fff;height:100%;overflow-y:auto;">
<div class="nav_top1">
    <div class="nav_tcon1" style="width:98%;">
        <div class="logotitle1">
            <span>合同详情</span>
        </div>
    </div>
</div>
<div>
        <table class=" table table-bordered" style="margin-left:30px;">
            <tr>
                <td colspan="6" class="success" style="font-size:16px"><b>合同基本信息</b></td>
            </tr>
            <tr>
                <td width="10%" colspan="2"  class=" active"><b>合同编号：</b><i><?php echo ($cdata["cno"]); ?></i></td>
                <td width="5%" class=" warning"><b>归属公司：</b><i><?php echo ($cdata["belong"]); ?></i></td>
                <td width="5%" class=" active"><b>合同金额：</b><i><?php echo number_format($cdata['total'],2);?></i></td>
                <td width="10%" class=" info"><b>客户名称：</b><i><?php echo ($cdata["gname"]); ?></i></td>
                <td width="8%"  class="  danger"><b>归档状态：</b><i>
                    <?php if($cdata["isfiling"] == 3): ?>已归档
                        <?php else: ?>
                        未归档<?php endif; ?>
                </i></td>

            </tr>
            <tr>
                <td width="10%"  class=" info"><b>负责人：</b><i><?php echo ($cdata["fname"]); ?></i></td>
                <td width="10%" colspan="2"  class=" danger"><b>合同名称：</b><i><?php echo ($cdata["cname"]); ?></i></td>
                <td width="10%"  class="warning "><b>初次审核人：</b><i><?php echo ($cdata["username"]); ?></i></td>
                <td width="10%"  class="  danger"><b>合同执行人：</b><i><?php echo ($exuname); ?></i></td>
                <td width="8%"  class="  danger"><b>执行状态：</b><i>
                    <?php if($cdata["isex"] == 1): ?>完成
                        <?php else: ?>
                        未执行<?php endif; ?>
                </i></td>
            </tr>

        </table>
        <table class=" table table-bordered" style="margin-left:30px;margin-top:-20px">
            <tr>
                <td colspan="4" class="success" style="font-size:16px"><b>开票信息</b></td>
            </tr>
            <?php if(is_array($bill)): $i = 0; $__LIST__ = $bill;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                    <td width="5%"  class="<?php if(($mod) == "1"): echo ($color[1]); else: echo ($color[2]); endif; ?>"><b>发票类型：</b><i><?php echo ($vo["btype"]); ?></i></td>
                    <td width="10%" class="<?php if(($mod) == "1"): echo ($color[1]); else: echo ($color[2]); endif; ?>"><b>所属客户：</b><i><?php echo ($vo["gname"]); ?></i></td>
                    <td width="10%"  class="<?php if(($mod) == "1"): echo ($color[1]); else: echo ($color[2]); endif; ?>"><b>发票内容：</b><i><?php echo ($vo["cbcontent"]); ?></i></td>
                    <td width="10%"  class="<?php if(($mod) == "1"): echo ($color[1]); else: echo ($color[2]); endif; ?>"><b>发票金额：</b><i> <?php echo number_format($vo['btotal'],2);?></i></td>


                </tr>
                <tr>
                    <td width="10%"  class="<?php if(($mod) == "1"): echo ($color[1]); else: echo ($color[2]); endif; ?>"><b>开票日期：</b><i><?php echo ($vo["cbtime"]); ?></i></td>
                    <td width="10%"  class="<?php if(($mod) == "1"): echo ($color[1]); else: echo ($color[2]); endif; ?>"><b>增值税：</b><i>
                    <?php if($vo["vat"] != ''): echo ($vo["vat"]); ?>
                        <?php else: ?>
                        无<?php endif; ?>

                    </i></td>
                    <td  colspan="2"  class="<?php if(($mod) == "1"): echo ($color[1]); else: echo ($color[2]); endif; ?>"><b>发票状态：</b><i>
                    <?php if($vo["bstatus"] == 0): ?><span style="color:red">被驳回</span><?php endif; ?>
                    <?php if($vo["bstatus"] == 1): ?><span style="color:yellowgreen">初审中</span><?php endif; ?>
                    <?php if($vo["bstatus"] == 2): ?><span style="color:yellow">复审中</span><?php endif; ?>
                    <?php if($vo["bstatus"] == 3): ?><span style="color:darkgoldenrod">开票中</span><?php endif; ?>
                    <?php if($vo["bstatus"] == 4): ?><span style="color:dodgerblue">已开票</span><?php endif; ?>
                    </i></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <tr>
                <td class="active " width='15%'><b>已出票金额总和：</b><i><?php echo number_format($oj,2);?></i></td>
                <td class="active " width='15%'><b>未出票金额总和：</b><i><?php echo number_format($nj,2);?></i></td>
                <td class="active " colspan="3" width="70%" ><b>应开票金额总和：</b><i><?php echo number_format($nj+$oj,2);?></i></td>
            </tr>
        </table>
    <table class=" table table-bordered" style="margin-left:30px;margin-top:-20px">
    <tr>
        <td colspan="4" class="success" style="font-size:16px"><b>盖章信息</b></td>
    </tr>
    <?php if(is_array($stamp)): $i = 0; $__LIST__ = $stamp;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td width="5%"  class="<?php echo $color[mt_rand(0,3)]; ?>"><b>推广期间：</b><i><?php echo ($vo["adperiod"]); ?></i></td>
            <td width="10%" class=" active"><b>推广位置：</b><i><?php echo ($vo["adposition"]); ?></i></td>
            <td width="10%"  class="warning "><b>结算条款：</b><i><?php echo ($vo["settleitem"]); ?></i></td>
            <td width="10%"  class="  danger"><b>盖章状态：</b><i>
                <?php if($vo["status"] == 0): ?><span style="color:red">被驳回</span><?php endif; ?>
                <?php if($vo["status"] == 1): ?><span style="color:yellowgreen">初审中</span><?php endif; ?>
                <?php if($vo["status"] == 2): ?><span style="color:yellow">复审中</span><?php endif; ?>
                <?php if($vo["status"] == 3): ?><span style="color:darkgoldenrod">盖章中</span><?php endif; ?>
                <?php if($vo["status"] == 4): ?><span style="color:dodgerblue">已盖章</span><?php endif; ?>
            </i></td>

        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

</table>
    <table class=" table table-bordered" style="margin-left:30px;margin-top:-20px">
        <tr>
            <td colspan="5" class="success" style="font-size:16px"><b>回款信息</b></td>
        </tr>
        <?php if(is_array($payback)): $i = 0; $__LIST__ = $payback;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                <td width="15%"  class="<?php if(($mod) == "1"): echo ($color[1]); else: echo ($color[2]); endif; ?>"><b>回款时间：</b><i><?php echo ($vo["btime"]); ?></i></td>
                <td width="10%"  class="<?php if(($mod) == "1"): echo ($color[1]); else: echo ($color[2]); endif; ?>"><b>支付公司：</b><i><?php echo ($vo["paycomp"]); ?></i></td>
                <td width="10%"  class="<?php if(($mod) == "1"): echo ($color[1]); else: echo ($color[2]); endif; ?>"><b>收款公司：</b><i><?php echo ($vo["payee"]); ?></i></td>
                <td width="10%"  class="<?php if(($mod) == "1"): echo ($color[1]); else: echo ($color[2]); endif; ?>"><b>收款性质：</b><i><?php echo ($vo["btype"]); ?></i></td>
                <td width="10%"  class="<?php if(($mod) == "1"): echo ($color[1]); else: echo ($color[2]); endif; ?>"><b>是否确认：</b><i>
                    <?php if($vo["rstatus"] == 2): ?><span style="color:red">未确认</span><?php endif; ?>
                    <?php if($vo["rstatus"] == 3): ?><span style="color:yellowgreen">已确认</span><?php endif; ?>
                </i></td>

            </tr>
            <tr>
                <td width="10%" class="<?php if(($mod) == "1"): echo ($color[1]); else: echo ($color[2]); endif; ?>"><b>回款金额：</b><i><?php echo number_format($vo['btotal'],2);?></i></td>
                <td colspan="4"  class="<?php if(($mod) == "1"): echo ($color[1]); else: echo ($color[2]); endif; ?>"><b>收款银行：</b><i><?php echo ($vo["banknum"]); ?></i></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        <tr>
            <td width="12%" class=" active"><b>已确认回款总额：</b><i><?php echo ($spaytotal); ?></i></td>
            <td width="12%"  class="active "><b>未确认回款总额：</b><i><?php echo ($wpaytotal); ?></i></td>
            <td colspan="3" width="50%" class=" active"><b>全部回款金额：</b><i><?php echo number_format($spaytotal + $wpaytotal,2);?></i></td>
        </tr>

    </table>
    <table class=" table table-bordered" style="margin-left:30px;margin-top:-20px">
        <tr>
           <td><div class="nav_tcon1" style="margin-left:160px;float:right;width:98%;">
               <a style="float:right;margin-right: 100px" class="btn btn-info" href="<?php echo U("downct?cid=$cdata[id]");?>">合同下载</a>
               <a style="float:right;margin-right: 10px" class="btn btn-primary" onclick="JavaScript:history.go(-1);" style="text-emphasis:center;"> 返回上一页</a>

           </div></td>
        </tr>
        <tr>
            <td></td>
        </tr>

    </table>


</div>
</body>
</html>
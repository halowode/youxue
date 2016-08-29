<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>优学教育流程管理系统</title>

    <link rel="stylesheet" href="/Public/css/index.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/tendina.min.js"></script>
    <script type="text/javascript" src="/Public/js/common.js"></script>

</head>
<body>
<!--顶部-->
<div class="top">
    <div style="float: left"><span style="font-size: 16px;line-height: 45px;padding-left: 20px;color: #fff">优学教育流程管理系统</span></div>
    <div id="ad_setting" class="ad_setting">
        <a class="ad_setting_a" href="<?php echo U("Login/loginout");?>">退出</a>
    </div>
    <div id="ad_setting" class="ad_setting" style="border:0;">
        <a class="ad_setting_a" href="javascript:; ">欢迎：<?php echo ($user["username"]); ?></a>
    </div>
</div>
<!--顶部结束-->
<!--菜单-->
<div class="left-menu">
    <ul id="menu">
        <!--
        <li class="menu-list">
            <a style="cursor:pointer" class="firsta"><i  class="glyph-icon xlcd"></i>用户管理<s class="sz"></s></a>
            <ul>
                <?php if($_SESSION['uid']== 1): ?><li><a href="<?php echo U('User/index');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>用户管理</a></li><?php endif; ?>
                <li><a href="<?php echo U('User/edit_pass');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>修改密码</a></li>
            </ul>
        </li>
        <li class="menu-list">
            <a style="cursor:pointer" class="firsta"><i  class="glyph-icon xlcd"></i>角色管理<s class="sz"></s></a>
            <ul>
                <li><a href="<?php echo U('User/rolelist');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>管理角色</a></li>
            </ul>
        </li>
        <li class="menu-list">
            <a style="cursor:pointer" class="firsta"><i  class="glyph-icon xlcd"></i>合同管理<s class="sz"></s></a>
            <ul>
                <li><a href="<?php echo U('Index/makect');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>创建合同</a></li>
                <li><a href="<?php echo U('Index/search');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>管理合同</a></li>
                <li><a href="<?php echo U('Index/excute');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>合同执行</a></li>
            </ul>
        </li>
        <li class="menu-list">
            <a style="cursor:pointer" class="firsta"><i  class="glyph-icon xlcd"></i>开票管理<s class="sz"></s></a>
            <ul>
                <li><a href="<?php echo U('Index/checkbill');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>开票初审</a></li>
                <li><a href="<?php echo U('Index/recheckbill');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>开票复审</a></li>
                <li><a href="<?php echo U('Index/makebill');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>开具发票</a></li>
                <li><a href="<?php echo U('Index/listbill');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>申请列表</a></li>
            </ul>
        </li>
        <li class="menu-list">
            <a style="cursor:pointer" class="firsta"><i  class="glyph-icon xlcd"></i>盖章管理<s class="sz"></s></a>
            <ul>
                <li><a href="<?php echo U('Index/checkstamp');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>盖章初审</a></li>
                <li><a href="<?php echo U('Index/recheckstamp');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>盖章复审</a></li>
                <li><a href="<?php echo U('Index/makestamp');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>处理盖章</a></li>
                <li><a href="<?php echo U('Index/liststamp');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>盖章列表</a></li>

            </ul>
        </li>
        <li class="menu-list">
            <a style="cursor:pointer" class="firsta"><i  class="glyph-icon xlcd"></i>归档管理<s class="sz"></s></a>
            <ul>
                <li><a href="<?php echo U('Index/checkfiling');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>审核归档</a></li>
            </ul>
        </li>
        <li class="menu-list">
            <a style="cursor:pointer" class="firsta"><i  class="glyph-icon xlcd"></i>回款管理<s class="sz"></s></a>
            <ul>
                <li><a href="<?php echo U('Index/payback');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>回款录入</a></li>
                <li><a href="<?php echo U('Index/glian');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>回款关联</a></li>
                <li><a href="<?php echo U('Index/checkglian');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>关联审核</a></li>
            </ul>
        </li>
        <li class="menu-list">
            <a style="cursor:pointer" class="firsta"><i  class="glyph-icon xlcd"></i>信息管理<s class="sz"></s></a>
            <ul>

                <li><a href="<?php echo U('Index/departmentadd');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>部门添加</a></li>
                <li><a href="<?php echo U('Index/department');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>部门列表</a></li>
                <li><a href="<?php echo U('Index/project');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>项目添加</a></li>
                <li><a href="<?php echo U('Index/proedit');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>项目列表</a></li>
            </ul>
        </li>
        <li class="menu-list">
            <a style="cursor:pointer" class="firsta"><i  class="glyph-icon xlcd"></i>银行管理<s class="sz"></s></a>
            <ul>
                <li><a href="<?php echo U('Index/bank');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>银行账号添加</a></li>
                <li><a href="<?php echo U('Index/bankedit');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>银行账号列表</a></li>
            </ul>
        </li>
        -->
        <?php if(is_array($arr)): $i = 0; $__LIST__ = $arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i; if(($superuser == 1) OR ($vol["isbl"] == 1)): ?><li class="menu-list">
                <a style="cursor:pointer" class="firsta"><i  class="glyph-icon xlcd"></i><?php echo (L("$key")); ?><s class="sz"></s></a>
                <ul>
                    <?php if(($superuser == 1)): if(is_array($vol["datas"])): $i = 0; $__LIST__ = $vol["datas"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="/<?php echo ($vo["nodeurl"]); ?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i><?php echo ($vo["nodename"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                        <?php else: ?>
                        <?php if(is_array($vol["datas"])): $i = 0; $__LIST__ = $vol["datas"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(in_array(($vo["id"]), is_array($nidarr)?$nidarr:explode(',',$nidarr))): ?><li><a href="/<?php echo ($vo["nodeurl"]); ?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i><?php echo ($vo["nodename"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>

                </ul>
            </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        <!--
        <li class="menu-list">
            <a style="cursor:pointer" class="firsta"><i  class="glyph-icon xlcd"></i>借款报销<s class="sz"></s></a>
            <ul>
                <li><a href="<?php echo U('Reimburse/borrow');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>申请借款</a></li>
                <li><a href="<?php echo U('Reimburse/index');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>申请报销</a></li>
                <li><a href="<?php echo U('Reimburse/alist');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>申请列表</a></li>
                <li><a href="<?php echo U('Reimburse/confirm');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>报销确认</a></li>
                <li><a href="<?php echo U('Reimburse/deal');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>付款确认</a></li>
            </ul>
        </li>
        <li class="menu-list">
            <a style="cursor:pointer" class="firsta"><i  class="glyph-icon xlcd"></i>报销审核<s class="sz"></s></a>
            <ul>
                <li><a href="<?php echo U('Reimburse/check');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>报销初审</a></li>
                <li><a href="<?php echo U('Reimburse/recheck');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>报销复审</a></li>
                <li><a href="<?php echo U('Reimburse/reconfirm');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>确认初审</a></li>
                <li><a href="<?php echo U('Reimburse/agconfirm');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>确认复审</a></li>
                <li><a href="<?php echo U('Reimburse/lastconfirm');?>" target="menuFrame"><i class="glyph-icon icon-chevron-right1"></i>确认终审</a></li>
            </ul>
        </li>
        -->

    </ul>
</div>

<!--菜单右边的iframe页面-->
<div id="right-content" class="right-content">
    <div class="content">
        <div id="page_content">
            <iframe id="menuFrame" name="menuFrame" src="<?php echo U('index/showindex');?>" style="overflow:visible;" scrolling="yes" frameborder="no" width="100%" height="100%"></iframe>
        </div>
    </div>
</div>
</body>
</html>
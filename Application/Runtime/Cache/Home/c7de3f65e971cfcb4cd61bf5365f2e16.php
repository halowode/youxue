<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>添加用户到角色</title>
    <link rel="stylesheet" type="text/css" href="/Public/css/index.css" />
    <link rel="stylesheet" href="/Public/utilLib/bootstrap.min.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/js/user.js"></script>
</head>

<body style="background:#fff;height:100%;overflow-y:auto;">
<div class="nav_top1">
    <div class="nav_tcon1" style="width:98%;">
        <div class="logotitle1">
            <span><?php echo ($role["rolename"]); ?> 添加</span>
        </div>
    </div>
</div>
<form name="user_form" id="user_form" action="" method="post">
    <div class="logo_content1">
        <div class="logo_ccon1">
            <div class="logo_enter1" style="border:none;float:left;">
                <?php if(is_array($nodesq)): $i = 0; $__LIST__ = $nodesq;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><div class="login_box1" style="width:90%">
                    <span class="login_title1" ><?php echo (L("$key")); ?>：</span>
                        <?php if(is_array($vol)): $i = 0; $__LIST__ = $vol;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label>
                            <input type="checkbox" <?php if(in_array(($vo["id"]), is_array($nidarr)?$nidarr:explode(',',$nidarr))): ?>checked='checked'<?php endif; ?> name="node[]" value="<?php echo ($vo["id"]); ?>" > <?php echo ($vo["nodename"]); ?>
                        </label><?php endforeach; endif; else: echo "" ;endif; ?>
                    <font style="color:#FF0000;line-height:40px;">&nbsp;</font>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                <input type="hidden" name="rid" value="<?php echo ($rid); ?>"/>
                <input type="submit" name="submit" class="login_submit" value="添&nbsp;&nbsp;加" />
            </div>
        </div>
    </div>
</form>
</body>
</html>
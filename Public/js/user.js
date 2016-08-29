$(function(){
	$("#username").blur(function(){
		var $username = $("#username").val();
		$.post("/User/check_user?t="+(new Date()).getTime(),{username:$username},function(data){
			if(data == 'no'){
				alert('账户已存在！');
				$("#username").focus();
				return false;
			}
		});
	});
    $("#logname").blur(function(){
        var $logname = $("#logname").val();
        $.post("/User/check_user?t="+(new Date()).getTime(),{logname:$logname},function(data){
            if(data == 'no'){
                alert('登录名已存在！');
                $("#logname").focus();
                return false;
            }
        });
    });
	$("#user_form").submit(function(){
        if($("#logname").val() == ''){
            alert("请输入登录名！");
            $("#logname").focus();
            return false;
        }
        if($("#password").val() != '' && $("#password").val().length>=6){
            if($("#sure_password").val() == ''){
                alert("请输入确认密码！");
                $("#sure_password").focus();
                return false;
            }else{
                if($("#password").val() != $("#sure_password").val()){
                    alert("两次密码输入不一致！");
                    $("#sure_password").focus();
                    return false;
                }
            }
        }else{
            alert("密码不能少于6位，请确认输入！");
            $("#password").focus();
            return false;
        }
		if($("#username").val() == ''){
			alert("请输入用户名！");
			$("#username").focus();
			return false;
		}


	});//验证添加用户
	
	$("#user_form1").submit(function(){
		if($("#password").val() != '' && $("#password").val().length>=6){
			if($("#sure_password").val() == ''){
				alert("请输入确认密码！");
				$("#sure_password").focus();
				return false;
			}else{
				if($("#password").val() != $("#sure_password").val()){
					alert("两次密码输入不一致！");
					$("#sure_password").focus();
					return false;
				}
			}
		}else{
			alert("密码不能少于6位，请确认输入！");
			$("#password").focus();
			return false;
		}
	});//验证编辑用户
	
	$("#user_form2").submit(function(){
		if($("#password").val() == ''){
			alert("请输入密码！");
			$("#password").focus();
			return false;
		}else if($("#password").val().length<6){
			alert("密码长度不能小于6位，请确认输入！");
			$("#password").focus();
			return false;
		}else{
			if($("#sure_password").val() == ''){
				alert("请输入确认密码！");
				$("#sure_password").focus();
				return false;
			}else{
				if($("#password").val() != $("#sure_password").val()){
					alert("两次密码输入不一致！");
					$("#sure_password").focus();
					return false;
				}
			}
		}
	});//验证编辑用户

})
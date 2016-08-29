$(function(){
	$("#login_form").submit(function(){
		if($("#username").val() == ''){
			alert("请输入用户名！");
			$("#username").focus();
			return false;
		}
		if($("#password").val() == ''){
			alert("请输入密码！");
			$("#password").focus();
			return false;
		}
	});
})
function confirmdel(msg){
   if(msg == "M"){msg_G = "确定要删除吗？删除后该用户不可登录系统！";}else{msg_G = msg;}
   if(confirm(msg_G)){
   		return true;
   }else{
   		return false;
   }
}//删除确认
$(function(){
	$("#title").blur(function(){
		var $title = $("#title").val();
		$.post("/Package/check_package?t="+(new Date()).getTime(),{title:$title},function(data){
			if(data == 'no'){
				alert('此标题已存在！');
				$("#title").focus();
				return false;
			}
		});
	})
	$("#package_form").submit(function(){

        if ($("#mgcity").val() == '') {
                alert("请选择城市！");
                $("#mgcity").focus();
                return false;
        }
        if ($("#towns").val() == '') {
                alert("请选择区县！");
                $("#towns").focus();
                return false;
        }

        if ($("#school").val() == '') {
                alert("请选择学校！");
                $("#school").focus();
                return false;
        }
        if ($("#class").val() == '') {
                alert("请选择班级！");
                $("#class").focus();
                return false;
        }
        if ($("#package").val() == '') {
                alert("请选择产品业务！");
                $("#package").focus();
                return false;
        }
        if($("#xls").val() == '') {
            if ($("#shortword").val() == '') {
                alert("请填写登录号码！");
                $("#shortword").focus();
                return false;
            }
            if ($("#nicknames").val() == '') {
                alert("请填写用户昵称！");
                $("#nicknames").focus();
                return false;
            }

        }
		
	});//验证包
    $("#dicup").submit(function(){

        if ($("#cname").val() == '') {
            alert("城市名称不可为空！");
            $("#cname").focus();
            return false;
        }
        if ($("#cid").val() == '') {
            alert("城市id不可为空");
            $("#cid").focus();
            return false;
        }

        if ($("#code").val() == '') {
            alert("城市编码不可为空！");
            $("#code").focus();
            return false;
        }


    });//验证包
	
	$(".display_type").click(function(){
		var $val = $(this).val();
		$(".img_table").html('');
		$("#packageids").val('');
		if($val == '1'){
			$("#packageids").removeAttr("multiple");
			$("#packageids").removeAttr("size");
			 $(".show_user").css('display','block');
		}else if($val == '2'){
			$("#packageids").attr("multiple","multiple");
			$("#packageids").attr("size","10");
			 $(".show_user").css('display','none');
		}
	});//单选框边框相应 下拉框
	$("#packageids").change(function(){
		 var $display_type = $("input[name='display']:checked").val();
		 var packageids = '';
		 var $pid = $("#pid").val();
		 if($display_type == '1'){
			 packageids = $(this).val();
			 $("#hdpackage_ids").val(packageids);
		 }else{
			 packageids = $(this).getSelectedValuesForMultipleSelect();
			 $("#hdpackage_ids").val(packageids);
		 }
		 $.post("/Product/getImgs?t="+(new Date()).getTime(),{packageids:packageids,type:$display_type,pid:$pid},function(data){
			 if(data == 'no'){
				 alert("您选择的资源包没有相关图片，请核对！");
				 return false;
			 }else{
				 $(".img_table").html(data);
			 }
		 });
		 
	});
    $.fn.getSelectedValuesForMultipleSelect=function(){
		
		var selectedValues="";
		
		this.each(function(){
			var element=$(this);
			var selectId=$(element).attr('id');
			var selectObj=document.getElementById(selectId);

			for(i=0;i<selectObj.length;i++)
		    {     
		        if(selectObj.options[i].selected)
		        {  
		        	if (selectObj.options[i].value=="0")
		        	{
		        		continue;
		        	}
		        	else
		        	{
		        		if (selectedValues=="")
		        	    {
		        			selectedValues=selectObj.options[i].value;
		        	    }
		        		else
		        		{
		        			selectedValues=selectedValues+","+selectObj.options[i].value;
		        		}
		        	}	        		
		        	  
		        }  
		    }
			
		});

	    return selectedValues;
	};
	$("#ptitle").blur(function(){
		var $title = $("#ptitle").val();
		$.post("/Product/check_product?t="+(new Date()).getTime(),{title:$title},function(data){
			if(data == 'no'){
				alert('此标题已存在！');
				$("#ptitle").focus();
				return false;
			}
		});
	})
	$("#product_form").submit(function(){
		if($("#ptitle").val() == ''){
			alert("请填写产品标题！");
			$("#ptitle").focus();
			return false;
		}
		if($("#eptitle").val() == ''){
			alert("请填写产品标题！");
			$("#eptitle").focus();
			return false;
		}
		if($("#hdpackage_ids").val() == ''){
			alert("请选择资源包！");
			return false;
		}
		var $display = $("input[name='display']:checked").val();
		if($display == '1'){
			if(!$("input[name=icon]").is(":checked")){
				alert("请选择产品图标！");
				return false;
			}
		}else{
			if(!$("input[type=radio]").is(":checked")){
				alert("请选择产品图标！");
				return false;
			}
		}
	});//验证产品
	$("#product_form1").submit(function(){
		if($("#title").val() == ''){
			alert("请填写产品标题！");
			$("#title").focus();
			return false;
		}
		if($("#hdpackage_ids").val() == ''){
			alert("请选择资源包！");
			return false;
		}
		var $display = $("input[name='display']:checked").val();
		if($display == '1'){
			if(!$("input[name=icon]").is(":checked")){
				alert("请选择产品图标！");
				return false;
			}
		}else{
			if(!$("input[type=radio]").is(":checked")){
				alert("请选择产品图标！");
				return false;
			}
		}
	});//验证产品
})
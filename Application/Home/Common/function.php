<?php 
    function is_login(){
    	$uid = session("uid");
        $rid = session("rid");
    	if(!$uid || !$rid){
            if('/Home/Index/index' == trim(__ACTION__)){
                header("Location: /Login");
            }else{
                echo "<p style=\"font-size:22px;color:red;width:100%;text-align:center;margin-top:160px\">
                    系统长时间未操作自动登出，请退出并重新登录！<-.->
                </p>";
            }
            exit;
    	}
    }//判断是否登录
    
    function strsel($pid, $proid){
    	$pack_pro = M('Pack_pro');
    	$rs = $pack_pro->where("pid=$pid and proid=$proid")->field("id")->find();
    	if($rs){
    		echo 'selected="selected"';
    	}else{
    		echo '';
    	}
    }//判断是否选中资源包
    function selimg($proid,$pid,$icon){
    	$pack_pro = M('Pack_pro');
    	$rs = $pack_pro->where("pid=$pid and proid=$proid and icon='$icon'")->field("id")->find();
    	if($rs){
    		echo 'checked="true"';
    	}else{
    		echo '';
    	}
    }//判断图片是否选中
    function selimg1($proid,$pid,$icon){
    	$pack_pro = M('Pack_pro');
    	$rs = $pack_pro->where("pid=$pid and proid=$proid and icon='$icon'")->field("id")->find();
    	if($rs){
    		return 'checked="true"';
    	}else{
    		return '';
    	}
    }//判断图片是否选中用于ajax
    function code(){
    	$code = mt_rand(1000, 9999);
    	$product = M('Product');
    	$rs = $product->where("code='$code'")->getField("proid");
    	if($rs){
    		code();
    	}else{
    		return $code;
    	}
    }//code码
    function package_code(){
    	$code = mt_rand(100000, 999999);
    	$package = M('Package');
    	$rs = $package->where("code='$code'")->getField("pid");
    	if($rs){
    		package_code();
    	}else{
    		return $code;
    	}
    }//资源包code码
    
    function package_key($code){
    	$upchars = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $lowerchars = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $first = $upchars[intval(date('Y'))-2016];
        $last = '';
        for($i=0; $i<6; $i++){
       	   if($i==3){
       	  	   $last .= strtoupper($lowerchars[substr($code, $i,1)]);
       	   }else{
       	   	   $last .= $lowerchars[substr($code, $i,1)];
       	   }
        }
        $key = $first.$last.$lowerchars[intval(date('m'))];
        return $key;
    }//生成key

    //生成xls
    function exportexcel($data=array(),$title=array(),$filename='report'){
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)){
            foreach($data as $key=>$val){
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key]=implode("\t", $data[$key]);

            }
            echo implode("\n",$data);
        }
    }

    function uplog($t='s',$arr=[],$res='y',$desc='')
    {

        $log = 'log/'.$t.'_'.date('Y-m-d').'.log';
        $errlog = 'log/err_'.date('Y-m-d').'.log';

        $txt = '';
        foreach($arr as $v){
            $txt .= ' '.$v.' ';
        }
        switch($res){
            case 'f':
                file_put_contents($log,$txt." tiyan failed for blist \r\n",FILE_APPEND);
                break;
            case 'y':
                file_put_contents($log,$txt." tiyan {$desc} success \r\n",FILE_APPEND);
                break;
            case 'd':
                if($desc == 'success'){
                    file_put_contents($log,$txt." dinggou success \r\n",FILE_APPEND);
                }else{
                    file_put_contents($log,$txt." dinggou failed {$desc} \r\n",FILE_APPEND);
                }
                break;
            default:
                file_put_contents($errlog,'no param res'."\r\n",FILE_APPEND);
                break;

        }


    }

    function upfiles($name=''){
        $upload_path = '/Uploads/file/';
        $upload_path2 = './Uploads/file/';
        dir_exisit($upload_path2);
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls','doc','rar','docx','jpg','png','gif','xlsx');// 设置附件上传类型
        $upload->autoSub   =     false; //关闭子目录
        $upload->rootPath  =     $upload_path2; // 设置附件上传根目录
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES[$name]);
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());

        }else{// 上传成功 获取上传文件信息
            return $upload_path.$info['savepath'].$info['savename'];
        }
    }

    function getUserName($id=0){
        return M('user')->where("id = $id")->getField('username');
    }

    function getAllUsers(){
        return M('user')->where('status = 1')->select();
    }

    function getSingleFieldStr($arr=[]){
        if(is_array($arr)){
            if(empty($arr)) exit("the param of function getSingleFieldStr cant't be an empey array!");
            $farr = [];
            $fstr = '';
            foreach($arr as $key =>$val){
                if(count($val) >1 ) exit("the array each value num cant more than one!");
                foreach($val as $k => $v){
                    $farr[] = $v;
                }
            }
            $farr = array_unique($farr);
            return implode(',',$farr);

        }else{
            exit("tips:the param of function getSingleFieldStr must be a array type data!");
        }

    }

   
    
?>
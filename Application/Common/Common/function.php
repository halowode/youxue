<?php 
function base64url_encode($data) {
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
} //base64 加密


function base64url_decode($data) { 
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
} //base64 解密

function dir_exisit($dir, $mode='0755'){
	if (is_dir($dir) || @mkdir($dir,$mode)) return true;
	if (!dir_exisit(dirname($dir),$mode)) return false;
	return @mkdir($dir,$mode);
}//验证目录是否存在，不存在则创建

function getUser($id){
	$user = M('User');
    return $username = $user->where("id='$id'")->getField('username');
}//得到用户信息

function getPackageTitle($proid){
	$package = M('Package');
	$rs = $package->join("a left join mcp_pack_pro b on a.pid=b.pid")->where("a.status=1 and b.proid=$proid")->field("a.title")->select();
	if($rs){
		$temp = array();
		foreach($rs as $value){
			$temp[] = $value['title'];
		}
		return implode(' | ',$temp);
	}
}//得到资源包名称字符串
function subtitle($String,$Length,$dian="") {
	if (mb_strwidth($String, 'UTF8') <= $Length ){
		return $String;
	}else{
		$I = 0;
		$len_word = 0;
		while ($len_word < $Length){
			$StringTMP = substr($String,$I,1);
			if ( ord($StringTMP) >=224 ){
				$StringTMP = substr($String,$I,3);
				$I = $I + 3;
				$len_word = $len_word + 2;
			}elseif( ord($StringTMP) >=192 ){
				$StringTMP = substr($String,$I,2);
				$I = $I + 2;
				$len_word = $len_word + 2;
			}else{
				$I = $I + 1;
				$len_word = $len_word + 1;
			}
			$StringLast[] = $StringTMP;
		}
		if (is_array($StringLast) && !empty($StringLast)){
			$StringLast = implode("",$StringLast);
			$StringLast .= $dian;
		}
		return $StringLast;
	}
}//截取字符串

function out_trade_no(){
	$year_code = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$order_sn = $year_code[intval(date('Y'))-2016].strtoupper(dechex(date('m'))).date('d').substr(time(),-5).substr(microtime(),2,5).sprintf('%02d',rand(0,99));
	return $order_sn;
}//订单号

function getTypename($typeid){
	$type_array = array('1'=>'点播', '2'=>'包月');
	return $type_array[$typeid];
}//类别名称

function getExpireTime($expire_time){
	if(!empty($expire_time)){
		if(($expire_time-time())>0){
		    $expire_time1 = intval(($expire_time-time())/(3600*24))+1;
		}else{
			$expire_time1 = 0;
		} 
	}else{
		$expire_time1 = 0;
	}
	return $expire_time1;
}//判断距离时间

/**
 * 获取user信息方法
 * 用户信息接口url：线上地址http://10.181.67.29:80 测试地址http://yuanxuan.xiaoyuan.meirixue.com
 */
function getUserInfo($uid,$phone){
    $now = time();
    $jnum = 0;
    $sign = md5($uid.$phone.$now."meirixue123");
    $ip = C(USERINFO_IP);
    $url = "http://{$ip}/api/getUserInfo?uid=".$uid."&phone=".$phone."&time=".$now."&sign=".$sign;
    reback:
    $jnum++;
    $res = file_get_contents($url);
    if(!$res && $jnum < 6){
        sleep(2);
        goto reback;
    }
    if(!$res){
        reexit:
        $data['msg'] = '校验失败';
        $data['code'] = 402;
        $msg = json_encode($data);
        exit($msg);
    }
    $res = json_decode($res , true);
    if($res['status'] == 200){
        return $res['data'];
    }
    goto reexit;
}

/**
 * get方式访问
 */
function yxcurl($url){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER,0);
    //curl_setopt($ch,CURLOPT_POST,1);
    //curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

?>
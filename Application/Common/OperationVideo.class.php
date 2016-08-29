<?php
class OperationVideo {
	public $file_extention = array ();
	public $file_orig_region = array ();
	public $file_region = array ();
	public $file_exttime = 0;
	public function __construct($uid = 1) {
		$this->file_extention = array (
				'video/mp4',
				'image/jpeg',
				'image/gif',
				'image/png',
				'video/x-msvideo',
				'video/mpeg',
				'application/pdf',
				'text/plain',
				'application/x-gzip',
				'application/vnd.ms-powerpoint',
				'application/x-tar',
				'application/zip',
				'application/msword',
				'application/x-rar-compressed',
				'application/vnd.openxmlformats-officedocument.wordprocessingml.document' 
		)
		;
		
		$this->img_extention=array('jpg,png,gif');
		$this->video_extention=array('mp4,avi,wmv');
		$this->doc_extention=array("doc","excel","ppt","txt","pdf","rar","zip","png","jpg","bmp","gif","pot","pps","rtf","wps","dps","wpt","dpt","et","epub");
		
		$this->uid = $uid;
		$this->u_category = $u_category;
		$this->host = "http://img.dianfu.net/";
		
		
		$this->file_orig_region_video = array (
				'ip' => '10.251.209.39',
				'dir' => '/video/meirixue/video/',
				'urldir' => 'video/' 
				
		);
		
		$this->file_region_video = array (
				'ip' => '10.251.209.39',
				'dir' => '/video/meirixue/video/',
				'urldir' => 'video/'  
		);
		
		$this->file_orig_region_img = array (
				'ip' => '10.251.209.39',
				'dir' => '/video/meirixue/img/',
				'urldir' => 'img/'
				 
		);
		
		$this->file_region_img = array (
				'ip' => '10.251.209.39',
				'dir' => '/video/meirixue/img/',
				'urldir' => 'img/'
				 
		);
		$this->file_region_doc = array (
				'ip' => '10.251.209.39',
				'dir' => '/video/meirixue/doc/',
				'urldir' => 'doc/'
				 
		);
		$this->file_orig_region_doc = array (
				'ip' => '10.251.209.39',
				'dir' => '/video/meirixue/doc/',
				'urldir' => 'doc/'
				 
		);
		$this->file_extdir = date ( "Ymd", time () );
	}
	
	// 创建文件�?
	public function mkDir($dir) {
		if (is_dir ( $dir ) == false) {
			
			return @mkdir ( $dir, 0777 ,1);
		}
		
		return true;
	}
	public function get_extension($file) {
		return substr ( strrchr ( $file, '.' ), 1 );
	}
	// 生成文件名字
	public function changeName($name) {
		return md5 ( $name );
	}
	public function microtimeFloat() {
		list ( $t1, $t2 ) = explode ( ' ', microtime () );
		return ( float ) sprintf ( '%.0f', (floatval ( $t1 ) + floatval ( $t2 )) * 1000 );
	}
	public function uploadVideo() {

		$msg = array ();
//		var_dump($_POST);die;
		// echo $_FILES['upload_file']['name']; //video/mp4
		// $_FILES['upload_file']['type']; //tmp_name //size //error
//		var_dump($_FILES );
//		if (! in_array ( $_FILES ['Filedata'] ['type'], $this->file_extention )) { // 类型�?�?
//			
//			$msg ['code'] = 403;
//			return $msg;
//		}
		
		$type = $_GET['file_type']?$_GET['file_type']:$_POST['file_type'];
		
		
		if (empty ( $type )) {
			
			$msg ['code'] = 404;
			return $msg;
		}
		
		
		if ($type == "img" || $type=="image/*") {
			
			$dir = $this->file_orig_region_img;
				
		}
		if ($type == "doc") {
			
			$dir = $this->file_orig_region_doc;
				
		}
		if ($type == "video") {
			
			$dir = $this->file_orig_region_video;
		}
		
		$time = $this->microtimeFloat ();
//		echo  $dir ['dir'] . $this->file_extdir . '/' ;die;
		
		if (! $this->mkDir ( $dir ['dir'] . $this->file_extdir . '/' )) {
			
			$msg ['code'] = 500;
			return $msg;
		}
		//var_dump($_POST);
		//var_dump($_FILES); 
		
		$file_name=$this->changeName ($this->uid."_".$time . $_FILES ['icon'] ['name'] );
		$file_extension=$this->get_extension ( $_FILES ['icon'] ['name'] );
		$filename = $dir ['dir'] . $this->file_extdir . '/' . $file_name . '.' .$file_extension ;
		$oss_filename = $dir ['urldir'] . $this->file_extdir . '/' . $file_name . '.' .$file_extension ;
		$fileurl = $this->host.$oss_filename ;
		
		if (! is_uploaded_file ( $_FILES ['icon'] ['tmp_name'] )) {
			
			$msg ['code'] = 501;
			return $msg;
		}
		
		if (! move_uploaded_file ( $_FILES ['icon'] ['tmp_name'], $filename )) {
			
			$msg ['code'] = 502;
			return $msg;
		}
		
		$msg ['code'] = 0;
		$msg ['time'] = $time;
		$msg ['type'] = $type;
		$msg ['userid'] = $this->uid;
		$msg ['region'] = $dir ['ip'];
		$msg ['path'] = $filename;
		$msg ['url_path'] = $fileurl;
		$msg ['name'] = $_FILES['icon']['name'];
		$msg ['ext'] = $file_extension;
		$msg ['size'] = $_FILES ['icon'] ['size'];
		$msg['baofeng_filekey']=$file_name;
		$msg['baofeng_filename']=$file_name . '.' .$file_extension;
		$msg['oss_filename']=$oss_filename;
	
		
		
//		$msg ['u_category'] = $this->u_category;
		
		
		
		return $msg;
		
		// move_uploaded_file($tmp_name, "$uploads_dir/$name");
	}
public	function keyEn($str) {
		for($i = 0; $i < strlen ( $str ); $i ++) {
			switch ($i % 7) {
				case 0 :
					$key .= chr ( ord ( $str {$i} ) - 5 );
					break;
				case 1 :
					$key .= chr ( ord ( $str {$i} ) - 3 );
					break;
				case 2 :
					$key .= chr ( ord ( $str {$i} ) - 7 );
					break;
				case 3 :
					$key .= chr ( ord ( $str {$i} ) - 2 );
					break;
				case 4 :
					$key .= chr ( ord ( $str {$i} ) - 4 );
					break;
				case 5 :
					$key .= chr ( ord ( $str {$i} ) - 3 );
					break;
				case 6 :
					$key .= chr ( ord ( $str {$i} ) - 1 );
					break;
			}
		}
		return base64_encode ( $key );
	}
	
public 	function keyDe($str) {
		$str = base64_decode ( $str );
		for($i = 0; $i < strlen ( $str ); $i ++) {
			switch ($i % 7) {
				case 0 :
					$key .= chr ( ord ( $str {$i} ) + 5 );
					break;
				case 1 :
					$key .= chr ( ord ( $str {$i} ) + 3 );
					break;
				case 2 :
					$key .= chr ( ord ( $str {$i} ) + 7 );
					break;
				case 3 :
					$key .= chr ( ord ( $str {$i} ) + 2 );
					break;
				case 4 :
					$key .= chr ( ord ( $str {$i} ) + 4 );
					break;
				case 5 :
					$key .= chr ( ord ( $str {$i} ) + 3 );
					break;
				case 6 :
					$key .= chr ( ord ( $str {$i} ) + 1 );
					break;
			}
		}
		return $key;
	}
}




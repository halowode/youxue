<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    
    public function index(){
    	$this->display();
    }//登录界面
    
    public function login(){
    	$logname = I("post.logname");
    	$password = I("post.password");
    	$user = M('user');
    	$rs = $user->where("logname='$logname'")->find();
        if(empty($rs)){
        	$this->error("账户不存在，请联系管理员！");
        }else{
	    	if(!password_verify($password,$rs['password'])){
	    		$this->error("账号或密码错误！");
	    	}else{
                $res = M('role_user')->where("uid = {$rs['id']}")->select();
                $rl = [];
                foreach($res as $val){
                    $rl[] = $val['rid'];
                }
                if(!$rl){
                    $this->error('您无权登录系统',U('login/index'));
                    exit;
                }
                $x = [];
                if(!in_array(1,$rl)){
                    $x = M('role_user')->join("a left join role_node b on a.rid = b.rid")->where("a.uid = {$rs['id']}")->field("b.nid")->select();
                }
	    		session('exc',$x);
                session('uid' , $rs['id']);  //设置session
                session('uinfo',$rs);
                session('rid',$rl);
	    		$this->redirect("Index/index");
	    	}
        }
    }//登录操作
    
    public function loginout(){
    	//session('uid',null);
        $_SESSION = [];
        session_destroy();
    	//$this->redirect("Login");
        header("Location: /Login");
    }//退出登录
}
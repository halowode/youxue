<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\TmodelModel;
class UserController extends Controller {
    public $Tmodel = '';
    public $pagesize = 10;
    public function _initialize(){
        $this->Tmodel = new TmodelModel();
	    is_login();
	}
    public function index(){
    	$keyword = I("get.keyword");
    	$where = " a.status = '1' ";
    	if($keyword){
    		$where .= " and (a.username like '%$keyword%' OR a.logname like '%$keyword%')";
    	}
        $on = "a.did = b.id";
        $field = "a.*,b.depname";
        $order = "a.id desc";
        $data = $this->Tmodel->getCommonList('user', 'dptment', $on, $where, $field, $order, $this->pagesize);
        $this->assign('data', $data);
        if (I('get.p') == '' || I('get.p') == 1) {
            $vari = 1;
        } else {
            $vari = $pagesize * (I('get.p') - 1) + 1;
        }
        $requesturl = $_SERVER['REQUEST_URI'];
        $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
        $this->assign('vari', $vari);// 序号累加变量
        $this->assign('data',$data);
    	$this->assign("keyword" , $keyword);
    	$this->display();
    } //用户管理
    
    public function add_user(){
        $res = M('dptment')->where("status = 1")->select();
        $this->assign('data',$res);
    	$this->display();
    }//添加用户
    
    public function add(){
    	$user = M('user');
    	$user->username = I("post.username");
        $user->logname = I("post.logname");
        $user->did = I('post.did');
    	$user->password = password_hash(I("post.password"),PASSWORD_DEFAULT);
    	$insertid = $user->add();
    	if($insertid){
            M('role_user')->add(['uid'=>$insertid,'rid'=>2]);
    		$this->success("用户添加成功", U('index'));
    	}else{
    		$this->error("用户添加失败，请联系管理员！");
    	}
    }//添加用户入库
    
    public function check_user(){
    	$username = I("post.username");
        $logname = I("post.logname");
    	$user = M('user');
        if($username){
            $rs = $user->where("username='$username'")->field("id")->find();
        }else{
            $rs = $user->where("logname='$logname'")->field("id")->find();
        }

    	if($rs){
    		echo 'no';
    	}
    }//验证用户
    
    public function edit_user(){
    	$id = I("get.id");
    	$user = M('user');
    	$rs_user = $user->where("id='$id'")->field("id, username, logname,did")->find();
        $dep = M('dptment')->where("status = 1")->select();
        $this->assign('dep',$dep);
    	$this->assign('rs_user' , $rs_user);
    	$this->display();
    }//编辑用户
    
    public function edit(){
    	$id = I("post.id");
    	$data['username'] = I("post.username");
        $data['did'] = I("post.did");
    	$user = M('user');
    	$rs = $user->where("id=$id")->data($data)->save();
    	if($rs !== false){
    		$this->success("用户编辑成功！" , U('index'));
    	}else{
    		$this->error("用户编辑失败，请联系管理员！");
    	}
    }//编辑用户入库
    
    public function del(){
    	$id = I("get.id");
    	$user = M("user");
        $data=['status'=>0];
    	$rs = $user->where("id=$id")->save($data);
    	if($rs){
    		$this->success("用户删除成功！", U('index'));
    	}else{
    		$this->error("用户删除失败，请联系管理员！");
    	}
    }//删除用户
    
    public function edit_pass(){
    	$this->display();
    }//修改密码
    
    public function set_pass(){
        $uid = session('uid');
        $password = M('user')->where("id = $uid")->getField('password');
        $rpassword = I('post.rpassword');
        if(!password_verify($rpassword,$password)){
            $this->error("原始密码错误！");
            exit;
        }
    	$data['password'] = password_hash(I("post.password"),PASSWORD_DEFAULT);
    	$uid = session("uid");
    	$user = M('user');
    	$rs = $user->where("id='$uid'")->data($data)->save();
    	if($rs !== false){
    		$this->success("密码设置成功！");
    	}else{
    		$this->error("密码设置失败，请联系管理员！");
    	}
    }//设置密码

    /**
     * 添加用户到角色
     */
    public function utorole(){
        if(IS_GET){
            $rid = I('get.id');
            $role = M('role')->where("id = $rid")->find();
            $us = M("role_user")->where("rid = {$rid}")->field('uid')->select();
            $str = '';
            if($us){
                foreach($us as $val){
                    $str .= $val['uid'].',';
                }
                $str = trim($str,',');

            }
            if($str){
                $map['id'] = array('not in',$str);
                $map['status'] = array('eq','1');
                $data = M('user')->where($map)->select();
            }else{
                $map['status'] = '1';
                $data = M('user')->where($map)->select();
            }
            $this->assign('data',$data);
            $this->assign('role',$role);
            $this->display();
        }else{
            $users = I('post.users');
            if($users){
                $rid = I('post.rid');
                foreach($users as $val){
                    $data[] = ['uid'=>$val,'rid'=>$rid];
                }
                $s = M('role_user')->addAll($data);
                if($s){
                   $this->success("添加成功！",U('user/rolelist'));
                    exit;
                }
            }
            $this->error("添加失败！");
        }


    }

    public function rolelist(){
        $res = M('role')->select();
        $this->assign('data',$res);
        $this->display();
    }

    public function rolemg(){
        $id = I('get.id');
        $res = M('role_user')->where("rid = $id")->select();
        $str = '';
        foreach($res as $val){
            $str .= $val['uid'].',';
        }
        $str = trim($str,',');
        $where = [];
        if($str){
            $where['a.id'] = ['in',$str];
        }else{
            $where['a.id'] = 0;
        }
        $on = "a.did = b.id";
        $field = "a.*,b.depname";
        $order = "a.id desc";
        $data = $this->Tmodel->getCommonList('user', 'dptment', $on, $where, $field, $order, $this->pagesize);
        $this->assign('data', $data);
        if (I('get.p') == '' || I('get.p') == 1) {
            $vari = 1;
        } else {
            $vari = $pagesize * (I('get.p') - 1) + 1;
        }
        $requesturl = $_SERVER['REQUEST_URI'];
        $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
        $this->assign('vari', $vari);// 序号累加变量
        $this->assign('data',$data);
        $this->assign('rid',$id);
        $this->display();

    }

    public function delUserFromRole(){
        $rid = I('get.rid');
        $uid = I('get.id');
        $rs = M('role_user')->where("uid = $uid and rid = $rid")->delete();
        if($rs){
            $this->success("删除成功");
        }else{
            $this->error("删除失败！");
        }
    }

    /**
     * 权限控制
     */
    public function rolerbac(){
        if(IS_GET){
            $rid = I('get.id');
            $data = M('node')->where("fid = 0")->select();
            $arr = [];
            foreach($data as $v){
                $arr[$v['nodename']] = M('node')->where("fid = {$v['id']}")->select();
            }
            $nids = M('role_node')->where("rid = $rid")->field("nid")->select();
            $nidarr = [];
            if($nids){
                foreach($nids as $v){
                    $nidarr[] = $v['nid'];
                }
                $nidarr = array_unique($nidarr);
            }
            $this->assign('rid',$rid);
            $this->assign('nodesq',$arr);
            $this->assign('nidarr',$nidarr);
            $this->display();
        }else{
            $rid = I('post.rid');
            $role_node = M('role_node');
            $role_node->where("rid = $rid")->delete();
            foreach(I('post.node') as $v){
                $data[] = ['rid'=>$rid,'nid'=>$v];
            }
            $rst = $role_node->addAll($data);
            if($rst){
                $this->success("更新成功！",U('user/rolelist'));
            }else{
                $this->error("更新失败",U('user/rolelist'));
            }
        }

    }
}
<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\TmodelModel;
class IndexController extends Controller {

    public $Tmodel=null;
    public $pagesize = 10;
    public function _initialize(){
        $this->Tmodel = new TmodelModel();
        is_login();
    }
    public function index(){
        $uid = session('uid');
        $user = M('user')->where("id = $uid")->field('id,logname,username')->find();
        $rstr = trim(implode(session('rid'),','),',');
        $nids = M('role_node')->join("a left join node b on a.nid = b.id ")->where("a.rid in ($rstr) and b.tp = 0")->field('a.nid')->select();
        $nidarr = [];
        $fidarr = [];
        foreach($nids as $v){
            $nidarr[] = $v['nid'];
            $fidarr[] = M('node')->where("id = {$v['nid']}")->getField('fid');
        }
        $nidarr = array_unique($nidarr);
        $fidarr = array_unique($fidarr);

        $data = M('node')->where("fid = 0 and tp = 0")->select();
        $arr = [];
        foreach($data as $v){
            $arr[$v['nodename']]['datas'] = M('node')->where("fid = {$v['id']} and tp = 0")->select();
            $arr[$v['nodename']]['isbl'] = in_array($v['id'],$fidarr)?1:0;
        }
        if(in_array(1,session('rid'))){
            $this->assign('superuser',1);
        }else{
            $this->assign('superuser',0);
        }
        $this->assign('nidarr',$nidarr);
        $this->assign('arr',$arr);
        $this->assign('user',$user);
        $this->display();
    }
    public function showindex(){
        $res = M('intro')->where("id = 1")->find();
        $this->assign('mmsg',$res['intromsg']);
        $this->display();
    }

    /**
     * 合同创建
     */
    public function makect(){
        if(IS_GET){
            $res = M('project')->where('status = 1')->select();
            $cusers = M('role_user')->join(" a left join user b on a.uid = b.id ")->where("a.rid = 3")->field('a.rid,b.*')->select();
            $exuser = M('role_user')->join(" a left join user b on a.uid = b.id ")->where("a.rid = 6")->field('a.rid,b.*')->select();
            $this->assign('cuser',$cusers);
            $this->assign('exuser',$exuser);
            $this->assign('data',$res);
            $this->display();
        }else{
            $uid = session('uid');
            $data = I('post.');
            $path = '';
            if($_FILES['cfile']['name'] != ''){
                $path = upfiles('cfile');
            }
            unset($data['submit']);
            unset($data['cfile']);
            $tstr = 'S';
            if($data['kinds'] == 1){
                $tstr = 'C';
            }
            $data['cno'] = $tstr.date('YmdHis').'-'.mt_rand(1,10);
            $data['fname'] = M('user')->where("id = {$uid}")->getField('username');
            $data['ctime'] = time();
            $data['check'] = 0;
            $data['isback'] = 0;
            $data['uid'] = $uid;
            $rs = M('contract')->add($data);
            if($rs){
                M('contract')->where("id = $rs")->save(['cfile'=>$path]);
                $this->success('合同保存成功！',U('index/search'));
            }else{
                z:
                $this->error('合同保存失败，请重新尝试！');
            }
        }

    }

    public function ctedit(){
        if(IS_GET){
            $id = I("get.id");
            if($id){
                $datas = M('contract')->where("id = $id")->find();
                $res = M('project')->where('status = 1')->select();
                $cusers = M('role_user')->join(" a left join user b on a.uid = b.id ")->where("a.rid = 3")->field('a.rid,b.*')->select();
                $exuser = M('role_user')->join(" a left join user b on a.uid = b.id ")->where("a.rid = 6")->field('a.rid,b.*')->select();
                $this->assign('cuser',$cusers);
                $this->assign('exuser',$exuser);
                $this->assign('projects',$res);
                $this->assign("datas",$datas);
                $this->assign('cid',$id);
                $this->display();
            }
        }else{
            $data = I("post.");
            $cid = I("post.cid");
            $newcno = trim($data['cno']);
            $srcno = M('contract')->where("id != {$cid} and cno = '{$newcno}'")->find();
            if($srcno){
                $this->error('已存在该合同编号！',U('index/search'));
                exit;
            }
            $path = '';
            if($_FILES['cpfile']['name'] != ''){
                $path = upfiles('cpfile');
                $data['cfile'] = $path;
            }
            if(strpos($data['total'],',')){
                unset($data['total']);
            }
            if($data['isframe'] == 1){
                $data['total'] = 0;
            }
            unset($data['cid']);
            $res = M('contract')->where("id = $cid")->save($data);
            if($res){
                $this->success('更新成功！',U('index/search'));
            }else{
                $this->error('更新失败或没有数据更新！',U('index/search'));
            }
        }

    }

    /**
     * 合同查询管理
     */
    public function search(){
        if(IS_GET){
            $uid = session('uid');
            $where = '';
            $_fname = I('get.fname');
            $this->assign('_fname',$_fname);
            $_pname = I('get.pname');
            $this->assign('_pname',$_pname);
            $_cname = I('get.cname');
            $this->assign('_cname',$_cname);
            $_gname = I('get.gname');
            $this->assign('_gname',$_gname);
            $_isstamp = I('get.isstamp');
            $this->assign('_isstamp',$_isstamp);
            $_isfiling = I('get.isfiling');
            $this->assign('_isfiling',$_isfiling);
            $_belong = I('get.belong');
            $this->assign('_belong',$_belong);
            $_ct = I('get.ct');
            $this->assign('_ct',$_ct);
            $arr = [];
            if($_fname){
                $arr[] = "a.fname like '%{$_fname}%'";
            }
            if($_ct){
                $ty = ($_ct == 1)?0:1;
                $arr[] = " a.kinds = $ty ";
            }
            if($_pname){
                $pidarr = M('project')->where("pname like '%{$_pname}%'")->field('id')->select();
                $fstr = '';
                if($pidarr){
                    $fstr = getSingleFieldStr($pidarr);
                }
                if($fstr){
                    $arr[] = " a.pid in ($fstr) ";
                }
            }
            if($_gname){
                $arr[] = "a.gname like '%{$_gname}%'";
            }
            if($_cname){
                $arr[] = "a.cname like '%{$_cname}%'";
            }
            if($_isfiling){
                if($_isfiling == 1){
                    $arr[] = " a.isfiling = 3 ";
                }else{
                    $arr[] = " a.isfiling != 3 ";
                }
            }

            if($_isstamp){
                if($_isstamp == 1){
                    $arr[] = "a.isstamp = 1";
                }else{
                    $arr[] = "a.isstamp != 1";
                }
            }
            if($_belong){
                $arr[] = "a.belong = '{$_belong}'";
            }
            if(!empty($arr)){
                $where = implode(' and ',$arr);
            }

            $isexc = 0; //是否有编辑权限
            if(!in_array(1,session('rid'))){
                $where = $where?$where.' and a.uid = '.$uid:'a.uid = '.$uid;
            }else{
                $isexc = 1;
            }
            //$data = $this->Tmodel->getAllByPage('contract',$where,1);
            $data = $this->Tmodel->getJoinByPage('contract','project',$where, $this->pagesize);
            foreach($data['list'] as $ink => $v){
                $data['list'][$ink]['stampis'] = 0;
                $rs = M('stamp')->where("cid = {$v['id']}")->getField('id');
                if($rs) $data['list'][$ink]['stampis'] = 1;
            }
            //判断除基本用户外是否有编辑权限
            $x = M('role_user')->join("a left join role_node b on a.rid = b.rid")->where("a.uid = {$uid} and a.rid != 2")->field("b.nid")->select();
            if(in_array(54,$x)){
                $isexc = 1;
            }
            $this->assign('isexc',$isexc);
            $this->assign('data' , $data);
            if(I('get.p') == '' || I('get.p') == 1){$vari = 1;}else{$vari = $pagesize * (I('get.p') - 1) + 1;}
            $requesturl = $_SERVER['REQUEST_URI'];
            $this->assign('dqurl',base64url_encode($requesturl));// 当前URL
            $this->assign('vari',$vari);// 序号累加变量
            $this->display();
        }
    }

    /**
     * 编辑合同
     */
    public function edit(){
        if(IS_GET){
            $cid = I('get.id');
            $res = M('contract')->where('id = '.$cid)->find();
            $this->assign('data',$res);
            $this->assign('cid',$cid);
            $this->display();
        }else{
            $data = I('post.');
            $cid = I('post.cid');
            unset($data['submit']);
            unset($data['cid']);
            $rs = M('contract')->where("id = $cid")->save($data);
            if($rs){
                $this->success("修改成功");
            }else{
                $this->error('没有做任何更改，请重新确认！');
            }
        }

    }

    /**
     * 合同详细
     */
    public function detail(){
        $cid = I('get.id');
        $cdata = M('contract')->join("a left join user b on a.checkuid = b.id")->where('a.id = '.$cid)->field('a.*,b.username')->find();
        $bill = M('bill')->where("cid = $cid")->select();
        $j = 0;
        $nj = 0;
        foreach($bill as $v){
            if($v['bstatus'] == 4){
                $j += $v['btotal'];
            }else{
                $nj += $v['btotal'];
            }
        }
        foreach($bill as $ky => $vl){
            $bill[$ky]['reckuname'] = '';
            if($vl['reckuid']){
                $bill[$ky]['reckuname'] = M('user')->where("id = {$vl['reckuid']}")->getField('username');
            }
            $bill[$ky]['ckuname'] = '';
            if(1){
                $bill[$ky]['ckuname'] = M('user')->where("id = {$cdata['checkuid']}")->getField('username');
            }
        }
        if($cdata['exuid']){
            $exuname = M('user')->where("id = {$cdata['exuid']}")->getField('username');
        }
        $stamp= M('stamp')->where("cid = $cid")->select();
        foreach($stamp as $ky => $vl){
            $stamp[$ky]['reckuname'] = '';
            if($vl['reckuid']){
                $stamp[$ky]['reckuname'] = M('user')->where("id = {$vl['reckuid']}")->getField('username');
            }
            $stamp[$ky]['ckuname'] = '';
            if(1){
                $stamp[$ky]['ckuname'] = M('user')->where("id = {$cdata['checkuid']}")->getField('username');
            }
        }
        $payback = M("reback")->join("a left join bank b on a.bankno = b.id")->where("a.cid = $cid and (a.rstatus = 2 or a.rstatus = 3)")->field('a.*,b.bankno as banknum')->select();
        $spaytotal = 0;
        $wpaytotal = 0;
        foreach($payback as $vl){
            if($vl['rstatus'] == 3){
                $wpaytotal += $vl['btotal'];  //已确认
            }else{
                $spaytotal += $vl['btotal'];   //未确认
            }
        }
        //与报销关联
        $rat = 0;
        $ret = 0;
        $records = '';
        if($cdata['kinds'] == 1){
            $records = M('reimburse_record')->where("cgid = $cid and bstatus = 8")->select();
        }else{
            $records = M('reimburse_record')->where("cid = $cid and bstatus = 8")->select();
        }
        if($records){
            $vrcstr = '';
            foreach($records as $vrc){
                $vrcstr .= $vrc['id'].',';
            }
            $vrcstr = trim($vrcstr,',');
            $rsment = M('reimbursement')->where("sid in ($vrcstr)")->select();
            if($rsment){

                foreach($rsment as $vrst){
                    $rat += $vrst['atotal'];
                    $ret += $vrst['etotal'];
                }
            }

        }
        $cdata['pname'] = M('project')->join("a left join contract b on a.id = b.pid")->where("b.pid = {$cdata['pid']}")->getField('pname');
        $this->assign('recordsd',$records);
        $this->assign('rat',$rat);
        $this->assign('ret',$ret);
        $this->assign('spaytotal',$spaytotal);
        $this->assign('wpaytotal',$wpaytotal);
        $this->assign('payback',$payback);
        $this->assign('color',['danger','warning','info','active']);
        $this->assign('cdata',$cdata);
        $this->assign('bill',$bill);
        $this->assign('stamp',$stamp);
        $this->assign('exuname',$exuname);
        $this->assign('oj',$j);
        $this->assign('nj',$nj);
        $this->display();
    }

    /**
     * 发票
     */
    public function bill(){
        if(IS_GET){
            $cid = I('get.id');
            $gname = M('contract')->where("id = {$cid}")->find();
            $pname = M('project')->where("id = {$gname['pid']}")->getField('pname');
            $this->assign('cid',$cid);
            $this->assign('gname',$gname['gname']);
            $this->assign('pname',$pname);
            $this->assign('cdata',$gname);
            $this->display();
        }else{
            $data = I('post.');
            unset($data['submit']);
            $data['bstatus'] = 1;
            $res = M('bill')->add($data);
            if($res){
                $this->success("提交申请成功！");
            }else{
                $this->error("提交失败请稍后再看");
            }
        }

    }

    public function delbill(){
        $bid = I('get.id');
        $rs = M('bill')->where("id = $bid")->delete();
        if($rs){
            $this->success("删除成功！");
        }else{
            $this->error("删除失败！");
        }
    }

    /**
     * 申请发票列表
     */
    public function listbill(){
        $uid = session('uid');
        $gname = I('get.gname');
        if(in_array(1,session('rid'))){
            $where = '';
            goto dend;
        }
        $where = " a.ckuid = $uid or a.reckuid = $uid or a.mid = $uid or b.uid = $uid ";
        dend:
        if($gname){
            if($where){
                $where .= " and a.gname like '%{$gname}%' ";
            }else{
                $where = " a.gname like '%{$gname}%' ";
            }

        }
        $on = "a.cid = b.id";
        $field = " a.* , b.cno,b.cname,b.fname,b.gname,b.belong,b.checkuid";
        $order = "a.id desc";
        $data = $this->Tmodel->getCommonList('bill', 'contract', $on, $where, $field, $order, $this->pagesize);
        foreach($data['list'] as $ky => $vl){
            $data['list'][$ky]['reckuname'] = '';
            if($vl['reckuid']){
                $data['list'][$ky]['reckuname'] = M('user')->where("id = {$vl['reckuid']}")->getField('username');
            }
            $data['list'][$ky]['ckuname'] = '';
            if($vl['checkuid']){
                $data['list'][$ky]['ckuname'] = M('user')->where("id = {$vl['checkuid']}")->getField('username');
            }
        }
        $this->assign('data', $data);
        if (I('get.p') == '' || I('get.p') == 1) {
            $vari = 1;
        } else {
            $vari = $pagesize * (I('get.p') - 1) + 1;
        }
        $requesturl = $_SERVER['REQUEST_URI'];
        $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
        $this->assign('vari', $vari);// 序号累加变量
        $this->assign('checklev',1);
        $this->display();
    }

    /**
     * 发票编辑
     */
    public function billedit(){
        if(IS_GET){
            $cid = I('get.cid');
            $id = I('get.id');
            $bdata = M('bill')->where("id = $id")->find();
            $bmsg = M('message')->where("fid = $id and mtype = 'bill'")->select();
            $this->assign('bdata',$bdata);
            $this->assign('bmsg',$bmsg);
            $this->assign('cid',$cid);
            $this->assign('id',$id);
            $this->display();
        }else{
            $id = I('post.id');
            $data = I('post.');
            unset($data['submit']);
            unset($data['id']);
            $type = I('post.btype');
            if($type == '普票'){
                $data['bno'] = '';
                $data['baddress'] = '';
                $data['btel'] = '';
                $data['billbank'] = '';
                $data['bankno'] = '';
                $data['provepic'] = '';
            }
            $data['bstatus'] = 1;
            $res = M('bill')->where("id = $id")->save($data);
            if($res){
                $this->success("重新申请成功",U('index/listbill'));
            }else{
                $this->error("编辑失败，请联系管理员",U('index/listbill'));
            }

        }

    }

    /**
     * 图片上传
     */
    public function getImg(){

        if($_FILES["icon"]["name"] != ""){
            $upload_path = '/Uploads/';
            $upload_path2 = './Uploads/';
            dir_exisit($upload_path2);
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     $upload_path2; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $upload->subName   = array('date', 'Y-m'); //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
            $retuimg = $upload->upload();// 上传文件
            if(!$retuimg) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else{// 上传成功

                echo $upload_path.$retuimg['icon']['savepath'].$retuimg['icon']['savename'];

            }
        }

    }

    /**
     * 盖章
     */
    public function stamp(){
        if(IS_GET){
            $cid = I('get.id');
            if($cid){
                $res = M('contract')->where("id = {$cid}")->find();
                $res['pname'] = M('project')->where("id = {$res['pid']}")->getField('pname');
                $this->assign('data',$res);
                $this->assign('contract',$res);
                $this->assign('cid',$cid);
                $this->display();
            }
        }else{
            $data = I('post.');
            unset($data['submit']);
            $data['status'] = 1;
            $data['uid'] = session('uid');
            $sid = M('stamp')->add($data);
            if($sid){
                if($_FILES['xls']['name'] != ''){
                    $path = upfiles('xls');
                }
                $dat['cid'] = $data['cid'];
                $dat['sid'] = $sid;
                $dat['path'] = $path;
                $dat['type'] = 'stamp';
                $dat['uid'] = session('uid');
                $rs = M('files')->add($dat);
                if($rs){
                    $this->success("申请成功！",U('index/search'));
                }else{
                    $this->error("申请失败，请联系管理员！",U('index/search'));
                }

            }else{
                $this->error("申请失败！",U('index/search'));
            }



        }

    }

    public function checkstamp(){
        if(IS_GET) {
            $type = I('get.type');
            if(empty($type)){
                $uid = session('uid');
                if(in_array(1,session('rid'))){
                    $where = "a.status = '1'";
                }else{
                    $where = "a.status = '1' and b.checkuid = '{$uid}'";
                }

                $on = "a.cid = b.id";
                $field = " a.* , b.cno,b.cname,b.fname,b.gname,b.belong";
                $order = "a.id desc";
                $data = $this->Tmodel->getCommonList('stamp', 'contract', $on, $where, $field, $order, $this->pagesize);
                $this->assign('data', $data);
                if (I('get.p') == '' || I('get.p') == 1) {
                    $vari = 1;
                } else {
                    $vari = $pagesize * (I('get.p') - 1) + 1;
                }
                $requesturl = $_SERVER['REQUEST_URI'];
                $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
                $this->assign('vari', $vari);// 序号累加变量
                $this->assign('checklev',1);
                $this->display();
            }elseif($type == 'pas'){
                $id = I('get.sid');
                $data['msg'] = I('get.msg','','trim');
                $rs = 1;
                if(!$data['msg']) goto wu;
                $data['fid'] = $id;
                $data['mtype'] = 'stamp';
                $data['uid'] = session('uid');
                $data['uname'] = session('uinfo')['username'];
                $data['mattr'] = 1;
                $data['ctime'] = time();
                $rs = M('message')->add($data);
                wu:
                $reckuid = I('get.reckuid');
                $rst = M('stamp')->where("id = $id")->save([
                    'status'    =>  '2',
                    'ckuid'     =>  session('uid'),
                    'reckuid'   =>  $reckuid,
                ]);
                if($rs && $rst){
                    $cid = I('get.cid');
                    M('contract')->where("id = $cid")->save(['isactive'=>1]);
                    $this->success("初审通过",U('index/checkstamp'));
                }else{
                    $this->error("通过失败",U('index/checkstamp'));
                }
            }elseif($type == 'bac'){
                $data['msg'] = I('get.msg','','trim');
                $rs = 1;
                $data['fid'] = I('get.sid');
                if(!$data['msg']) goto wul;
                $data['mtype'] = 'stamp';
                $data['uid'] = session('uid');
                $data['uname'] = session('uinfo')['username'];
                $data['ctime'] = time();
                $data['mattr'] = 0;
                $rs = M('message')->add($data);
                wul:
                $res =  M('stamp')->where("id = {$data['fid']}")->save(['status'=>'0','ckuid'=>session('uid')]);
                if($rs && $res){
                    $this->success("驳回成功",U('index/checkstamp'));
                }else{
                    $this->error("驳回失败，请联系管理员",U('index/checkstamp'));
                }
            }

        }
    }

    /**
     * 盖章复审
     */
    public function recheckstamp(){
        if(IS_GET) {
            $type = I('get.type');
            if(empty($type)){
                $uid = session('uid');
                $where = "a.status = '2'";
                $on = "a.cid = b.id";
                $field = " a.* , b.cno,b.cname,b.fname,b.gname,b.belong";
                $order = "a.id desc";
                $data = $this->Tmodel->getCommonList('stamp', 'contract', $on, $where, $field, $order, $this->pagesize);
                $this->assign('data', $data);
                if (I('get.p') == '' || I('get.p') == 1) {
                    $vari = 1;
                } else {
                    $vari = $pagesize * (I('get.p') - 1) + 1;
                }
                $requesturl = $_SERVER['REQUEST_URI'];
                $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
                $this->assign('vari', $vari);// 序号累加变量
                $this->assign('checklev',2);
                $this->display('checkstamp');
            }elseif($type == 'pas'){
                $id = I('get.sid');
                $data['msg'] = I('get.msg','','trim');
                $rs = 1;
                if(!$data['msg']) goto wu;
                $data['fid'] = $id;
                $data['mtype'] = 'stamp';
                $data['uid'] = session('uid');
                $data['uname'] = session('uinfo')['username'];
                $data['mattr'] = 1;
                $data['ctime'] = time();
                $rs = M('message')->add($data);
                wu:
                $rst = M('stamp')->where("id = $id")->save(['status'=>'3','reckuid'=>session('uid')]);
                if($rs && $rst){
                    $this->success("复审通过",U('index/recheckstamp'));
                }else{
                    $this->error("通过失败",U('index/recheckstamp'));
                }
            }elseif($type == 'bac'){
                $data['msg'] = I('get.msg','','trim');
                $data['fid'] = I('get.sid');
                $rs = 1;
                if(!$data['msg']) goto wul;
                $data['mtype'] = 'stamp';
                $data['uid'] = session('uid');
                $data['uname'] = session('uinfo')['username'];
                $data['ctime'] = time();
                $data['mattr'] = 0;
                $rs = M('message')->add($data);
                wul:
                $res =  M('stamp')->where("id = {$data['fid']}")->save(['status'=>'0','reckuid'=>session('uid')]);
                if($rs && $res){
                    $this->success("驳回成功",U('index/recheckstamp'));
                }else{
                    $this->error("驳回失败，请联系管理员",U('index/recheckstamp'));
                }
            }

        }

    }

    /**
     * 盖章时驳回盖章申请
     */
    public function bacstamp(){
        $data['msg'] = I('get.msg','','trim');
        $data['fid'] = I('get.sid');
        $rs = 1;
        if(!$data['msg']) goto wul;
        $data['mtype'] = 'stamp';
        $data['uid'] = session('uid');
        $data['uname'] = session('uinfo')['username'];
        $data['ctime'] = time();
        $data['mattr'] = 0;
        $rs = M('message')->add($data);
        wul:
        $res =  M('stamp')->where("id = {$data['fid']}")->save(['status'=>'0']);
        if($rs && $res){
            $this->success("驳回成功",U('index/makestamp'));
        }else{
            $this->error("驳回失败，请联系管理员",U('index/makestamp'));
        }
    }

    /**
     * 盖章审核详情
     */
    function stampdetail(){
        $id = I('get.id');
        $cid = I("get.cid");
        $checklev = I('get.checklev');
        $contract = M('contract')->where("id = $cid")->find();
        $contract['pname'] = M('project')->where("id = {$contract['pid']}")->getField('pname');
        $contract['checkuname'] = M('user')->where("id = {$contract['checkuid']}")->getField('username');
        $bill = M('stamp')->where("id = $id")->find();
        $recusers = [];
        if($checklev == 1){
            $recusers = M('user')->join("a left join role_user b on a.id = b.uid")->where("b.rid = 4")->field("a.*")->select();
        }
        $msg = M('message')->where("mtype = 'stamp' and fid = $id")->select();
        $this->assign('msg',$msg);
        $this->assign('recusers',$recusers);
        $this->assign('contract',$contract);
        $this->assign('bill',$bill);
        $this->assign('checklev',$checklev);
        $this->assign('cid',$cid);
        $this->display();

    }

    public function makestamp(){
        if(IS_GET){
            $type = I('get.type','');
            if(empty($type)){
                $where = "a.status = '3'";
                $on = "a.cid = b.id";
                $field = " a.* , b.cno,b.cname,b.fname,b.gname,b.belong";
                $order = "a.id desc";
                $data = $this->Tmodel->getCommonList('stamp', 'contract', $on, $where, $field, $order, $this->pagesize);
                $this->assign('data', $data);
                if (I('get.p') == '' || I('get.p') == 1) {
                    $vari = 1;
                } else {
                    $vari = $pagesize * (I('get.p') - 1) + 1;
                }
                $requesturl = $_SERVER['REQUEST_URI'];
                $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
                $this->assign('vari', $vari);// 序号累加变量
                $this->display();
            }elseif($type == 'see'){
                $id = I('get.id');
                $cid = I("get.cid");
                $contract = M('contract')->where("id = $cid")->find();
                $contract['pname'] = M('project')->where("id = {$contract['pid']}")->getField('pname');
                $contract['checkuname'] = M('user')->where("id = {$contract['checkuid']}")->getField('username');
                $bill = M('stamp')->where("id = $id")->find();
                $this->assign('contract',$contract);
                $this->assign('bill',$bill);
                $this->display('stampsee');
            }

        }else{
            $bid = I("post.bid");
            $cid = I("post.cid");
            $data['stime'] = I('post.stime');
            $data['status'] = 4;
            $data['mid'] = session('uid');
            $s = M('stamp')->where("id = $bid")->save($data);
            $msg = I('post.msg','','trim');
            $r = 1;
            if(!empty($msg)){
                $dat['msg'] = $msg;
                $dat['mattr'] = 2;
                $dat['uid'] = session('uid');
                $dat['mtype'] = 'stamp';
                $dat['fid'] = $bid;
                $dat['uname'] = session('uinfo')['username'];
                $dat['ctime'] = time();
                $r = M('message')->add($dat);
            }
            if($s && $r){
                M('contract')->where("id = $cid")->save(['isstamp'=>1]);
                $this->success("填写成功！",U('index/makestamp'));
            }else{
                $this->success("填写失败！",U('index/makestamp'));
            }

        }
    }

    public function stampdel(){
        $id = I("get.id");
        $cid = I("get.cid");
        $rs = M('stamp')->where("id = $id")->delete();
        if($rs){
            $this->success("删除成功！");
        }else{
            $this->error("删除失败！");
        }
    }

    /**
     * 盖章列表
     */
    public function liststamp(){
        $uid = session('uid');
        if(in_array(1,session('rid'))){
            $where = '';
            goto zgs;
        }

        $where = " a.ckuid = $uid or a.reckuid = $uid or a.mid = $uid or a.uid = $uid ";

        zgs:
        $on = "a.cid = b.id";
        $field = " a.* , b.cno,b.cname,b.fname,b.gname,b.belong,b.checkuid,b.uid";
        $order = "a.id desc";
        $data = $this->Tmodel->getCommonList('stamp', 'contract', $on, $where, $field, $order, $this->pagesize);
        foreach($data['list'] as $ky => $vl){
            $data['list'][$ky]['reckuname'] = '';
            if($vl['reckuid']){
                $data['list'][$ky]['reckuname'] = M('user')->where("id = {$vl['reckuid']}")->getField('username');
            }
            $data['list'][$ky]['ckuname'] = '';
            if($vl['checkuid']){
                $data['list'][$ky]['ckuname'] = M('user')->where("id = {$vl['checkuid']}")->getField('username');
            }
        }
        $this->assign('data', $data);
        if (I('get.p') == '' || I('get.p') == 1) {
            $vari = 1;
        } else {
            $vari = $pagesize * (I('get.p') - 1) + 1;
        }
        $requesturl = $_SERVER['REQUEST_URI'];
        $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
        $this->assign('vari', $vari);// 序号累加变量
        $this->display();
    }

    /**
     * 盖章修改
     */

    public function stampedit(){
        if(IS_GET){
            $cid = I('get.cid');
            $id = I('get.id');
            $fr= I('get.fr');
            $contract = M('contract')->where("id = $cid")->find();
            $contract['pname'] = M('project')->where("id = {$contract['pid']}")->getField('pname');
            $bdata = M('stamp')->where("id = $id")->find();
            $bmsg = M('message')->where("fid = $id and mtype = 'stamp'")->select();
            $this->assign('bdata',$bdata);
            $this->assign('bmsg',$bmsg);
            $this->assign('cid',$cid);
            $this->assign('id',$id);
            $this->assign('fr',$fr);
            $this->assign('contract',$contract);
            $this->display();
        }else{
            if($_FILES["xls"]["name"] != ""){
                $dat['path']  = upfiles('xls');
            }
            $data = I('post.');
            $data['status'] = 1;
            $id = I('post.id');
            $cid = I('post.cid');
            unset($data['submit']);
            unset($data['id']);
            unset($data['cid']);
            $rs = M('stamp')->where("id = $id")->save($data);
            $res = 1;
            if(isset($dat['path'])){
               $res = M('files')->where("sid = $id")->save($dat);
            }
            if($rs && $res){
                $this->success("更新成功！",U('index/liststamp'));
            }else{
                $this->error("更新失败",U('index/liststamp'));
            }

        }

    }

    /**
     * 项目管理
     */
    public function project(){
        if(IS_GET){
            $res = M('user')->join("a left join role_user b on a.id = b.uid")->where("b.rid = 10")->field("a.id,a.username")->select();
            $this->assign('mguser',$res);
            $this->display();
        }else{
            $data = I('post.');
            $mgs = I('post.mg');
            if(!$mgs){
                $this->error("必须选择项目管理者！");
                exit;
            }
            unset($data['submit']);
            unset($data['mg']);
            $project = M('project');
            $res = $project->where("pname = '{$data['pname']}'")->find();
            if($res){
                $this->error("该项目已经存在，请确认后添加！");
                exit;
            }
            $data['ctime'] = time();
            $data['status'] = 1;
            $data['uid'] = session('uid');
            $res = $project->add($data);
            $rst = false;
            if($res){
                $arr = [];
                foreach($mgs as $v){
                    $arr[] = ['uid'=>$v,'proid'=>$res];
                }
                $rst = M('promg')->addAll($arr);
                if($rst){
                    $this->success("添加成功",U('index/proedit'));
                }else{
                    $this->error("管理者添加失败，请联系管理员");
                }
            }else{
                $this->error("项目添加失败，请稍后重试");
            }
        }
    }

    /**
     * @param: int $type
     * @param: int $id
     * 项目审核，已废弃
     */
    /*
    public function checkPro(){
        if(IS_GET) {
            $type = I('get.ptype', '');
            $id = I('get.id', 0, 'intval');
            $project = M('project');
            if (!$type && !$id) {
                $where = "a.status = '1'";
                $on = "a.uid = b.id";
                $field = "a.*,b.username";
                $order = "a.id desc";
                $data = $this->Tmodel->getCommonList('project', 'user', $on, $where, $field, $order, $this->pagesize);
                $this->assign('data', $data);
                if (I('get.p') == '' || I('get.p') == 1) {
                    $vari = 1;
                } else {
                    $vari = $pagesize * (I('get.p') - 1) + 1;
                }
                $requesturl = $_SERVER['REQUEST_URI'];
                $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
                $this->assign('vari', $vari);// 序号累加变量
                $this->display();
            }
            if ($type == 'bk' && $id) {
                $res = $project->where("id = $id")->find();
                $this->assign('pid',$id);
                $this->assign('data', $res);
                $this->display('probk');

            }
            if ($type == 'ps' && $id) {
                $s = $project->where("id = $id")->save(['status'=>2]);
                if($s){
                    $this->success("通过成功！");
                }else{
                    $this->error("通过失败，请稍后重试");
                }
            }
        }else{
            $id = I('post.pid');
            $uid = session('uid');
            $project = M('project');
            $uname = M('user')->where("id = $uid")->getField('username');
            $rs = $project->where("id = $id")->getField('msg');
            $data['msg'] = $rs.'<p>'.I('post.msg').'-'.$uname.'-'.date('Y-m-d:H')." </p>";
            $data['status'] = 0;
            $res = $project->where("id = $id")->save($data);
            if($res){
                $this->success("驳回成功",U('checkpro'));
            }else{
                $this->error("更新失败，或没有更新操作！");
            }
        }

    }
    */
    public function proedit(){
        if(IS_GET){
            $type = I('get.type');
            if(empty($type)){
                $uid = session('uid');
                $data = M('project')->join("a left join user b on a.uid = b.id")->field("a.*,b.username")->select();
                $this->assign('data',$data);
                $this->display();
                exit;
            }
            if($type == 'edit'){
                $id = I('get.id');
                $data = M('project')->where("id = $id")->find();
                $spro = M('promg')->where("proid = $id")->select();
                $arr = [];
                foreach($spro as $sv){
                    $arr[] = $sv['uid'];
                }
                $res = M('user')->join("a left join role_user b on a.id = b.uid")->where("b.rid = 10")->field("a.id,a.username")->select();
                $this->assign('mguser',$res);
                $this->assign('suids',$arr);
                $this->assign('data',$data);
                $this->assign('id',$id);
                $this->display('editpro');
            }
        }else{
            $id = I('post.id');
            $mgs = I('post.mg');
            if(!$mgs){
                $this->error("管理者不可为空");
                exit;
            }
            $data['pname'] = I('post.pname','','trim');
            $data['shortname'] = I('post.shortname');
            $data['descb'] = I('post.shortname');
            $data['status'] = '1';
            $rs = M('project')->where("id = $id")->save($data);
            M('promg')->where("proid = $id")->delete();

            $arr = [];
            foreach($mgs as $v){
                $arr[] = ['uid'=>$v,'proid'=>$id];
            }
            $rst = M('promg')->addAll($arr);
            if($rst){
                $this->success('修改成功！',U('index/proedit'));
            }else{
                $this->error('没有做任何修改！');
            }
        }

    }

    /**
     * @param: int $type
     * @param: int $id
     */
    public function checkBill(){
        if(IS_GET) {
            $type = I('get.type');
            if(empty($type)){
                $uid = session('uid');
                if(in_array(1,session('rid'))){
                    $where = "a.bstatus = '1'";
                }else{
                    $where = "a.bstatus = '1' and b.checkuid = '{$uid}'";
                }
                $on = "a.cid = b.id";
                $field = " a.* , b.cno,b.cname,b.fname,b.gname,b.belong";
                $order = "a.id desc";
                $data = $this->Tmodel->getCommonList('bill', 'contract', $on, $where, $field, $order, $this->pagesize);
                $this->assign('data', $data);
                if (I('get.p') == '' || I('get.p') == 1) {
                    $vari = 1;
                } else {
                    $vari = $pagesize * (I('get.p') - 1) + 1;
                }
                $requesturl = $_SERVER['REQUEST_URI'];
                $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
                $this->assign('vari', $vari);// 序号累加变量
                $this->assign('checklev',1);
                $this->display();
            }elseif($type == 'pas'){
                $id = I('get.billid');
                $cid = I('get.cid');
                $data['msg'] = I('get.msg','','trim');
                $rs = 1;
                if(!$data['msg']) goto wu;
                $data['fid'] = $id;
                $data['mtype'] = 'bill';
                $data['uid'] = session('uid');
                $data['uname'] = session('uinfo')['username'];
                $data['mattr'] = 1;
                $data['ctime'] = time();
                $rs = M('message')->add($data);
                wu:
                $reckuid = I('get.reckuid');
                $rst = M('bill')->where("id = $id")->save([
                    'bstatus'=>'2',
                    'ckuid'=>session('uid'),
                    'reckuid'=> $reckuid,
                ]);
                M('contract')->where("id = $cid")->save(['isactive'=>1]);
                if($rs && $rst){
                    $this->success("初审通过",U('index/checkbill'));
                }else{
                    $this->error("通过失败",U('index/checkbill'));
                }
            }elseif($type == 'bac'){
                $data['msg'] = I('get.msg','','trim');
                $rs = 1;
                $data['fid'] = I('get.billid');
                if(!$data['msg']) goto wul;
                $data['mtype'] = 'bill';
                $data['uid'] = session('uid');
                $data['uname'] = session('uinfo')['username'];
                $data['ctime'] = time();
                $data['mattr'] = 0;
                $rs = M('message')->add($data);
                wul:
                $res =  M('bill')->where("id = {$data['fid']}")->save(['bstatus'=>'0','ckuid'=>session('uid')]);
                if($rs && $res){
                    $this->success("驳回成功",U('index/checkbill'));
                }else{
                    $this->error("驳回失败，请联系管理员",U('index/checkbill'));
                }
            }

        }

    }

    /**
     * @param: int $type
     * @param: int $id
     */
    public function recheckBill(){
        if(IS_GET) {
            $type = I('get.type');
            if(empty($type)){
                $uid = session('uid');
                $where = "a.bstatus = '2'";
                $on = "a.cid = b.id";
                $field = " a.* , b.cno,b.cname,b.fname,b.gname,b.belong";
                $order = "a.id desc";
                $data = $this->Tmodel->getCommonList('bill', 'contract', $on, $where, $field, $order, $this->pagesize);
                $this->assign('data', $data);
                if (I('get.p') == '' || I('get.p') == 1) {
                    $vari = 1;
                } else {
                    $vari = $pagesize * (I('get.p') - 1) + 1;
                }
                $requesturl = $_SERVER['REQUEST_URI'];
                $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
                $this->assign('vari', $vari);// 序号累加变量
                $this->assign('checklev',2);
                $this->display('checkbill');
            }elseif($type == 'pas'){
                $id = I('get.billid');
                $data['msg'] = I('get.msg','','trim');
                $rs = 1;
                if(!$data['msg']) goto wu;
                $data['fid'] = $id;
                $data['mtype'] = 'bill';
                $data['uid'] = session('uid');
                $data['uname'] = session('uinfo')['username'];
                $data['mattr'] = 1;
                $data['ctime'] = time();
                $rs = M('message')->add($data);
                wu:
                $rst = M('bill')->where("id = $id")->save(['bstatus'=>'3','reckuid'=>session('uid')]);
                if($rs && $rst){
                    $this->success("复审通过",U('index/recheckbill'));
                }else{
                    $this->error("通过失败",U('index/recheckbill'));
                }
            }elseif($type == 'bac'){
                $data['msg'] = I('get.msg','','trim');
                $data['fid'] = I('get.billid');
                $rs = 1;
                if(!$data['msg']) goto wul;
                $data['mtype'] = 'bill';
                $data['uid'] = session('uid');
                $data['uname'] = session('uinfo')['username'];
                $data['ctime'] = time();
                $data['mattr'] = 0;
                $rs = M('message')->add($data);
                wul:
                $res =  M('bill')->where("id = {$data['fid']}")->save(['bstatus'=>'0','reckuid'=>session('uid')]);
                if($rs && $res){
                    $this->success("驳回成功",U('index/recheckbill'));
                }else{
                    $this->error("驳回失败，请联系管理员",U('index/recheckbill'));
                }
            }

        }

    }

    /**
     * 开票审核详情
     */
    function billdetail(){
        $id = I('get.id');
        $cid = I("get.cid");
        $fr = I('get.fr');
        $checklev = I('get.checklev');
        $contract = M('contract')->where("id = $cid")->find();
        $contract['pname'] = M('project')->where("id = {$contract['pid']}")->getField('pname');
        $contract['checkuname'] = M('user')->where("id = {$contract['checkuid']}")->getField('username');
        $bill = M('bill')->where("id = $id")->find();
        $recusers = [];
        if($checklev == 1){
            $recusers = M('user')->join("a left join role_user b on a.id = b.uid")->where("b.rid = 4")->field("a.*")->select();
        }
        $msg = M('message')->where("mtype = 'bill' and fid = $id")->select();
        $bstotal = 0;
        $bs = M('bill')->where("cid = {$cid} and bstatus = 4")->select();
        if($bs){
            foreach($bs as $vbs){
                $bstotal += $vbs['btotal'];
            }
        }
        $this->assign('bstotal',$bstotal);
        $this->assign('msg',$msg);
        $this->assign('contract',$contract);
        $this->assign('bill',$bill);
        $this->assign('checklev',$checklev);
        $this->assign('recusers',$recusers);
        $this->assign('cid',$cid);
        $this->assign('fr',$fr);
        $this->display();

    }

    /**
     * 开具发票
     */
    public function makebill(){
        if(IS_GET){
            $type = I('get.type','');
            if(empty($type)){
                $where = "a.bstatus = '3'";
                $on = "a.cid = b.id";
                $field = " a.* , b.cno,b.cname,b.fname,b.gname,b.belong";
                $order = "a.id desc";
                $data = $this->Tmodel->getCommonList('bill', 'contract', $on, $where, $field, $order, $this->pagesize);
                $this->assign('data', $data);
                if (I('get.p') == '' || I('get.p') == 1) {
                    $vari = 1;
                } else {
                    $vari = $pagesize * (I('get.p') - 1) + 1;
                }
                $requesturl = $_SERVER['REQUEST_URI'];
                $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
                $this->assign('vari', $vari);// 序号累加变量
                $this->display();
            }elseif($type == 'see'){
                $id = I('get.id');
                $cid = I("get.cid");
                $contract = M('contract')->where("id = $cid")->find();
                $contract['pname'] = M('project')->where("id = {$contract['pid']}")->getField('pname');
                $contract['checkuname'] = M('user')->where("id = {$contract['checkuid']}")->getField('username');
                $bill = M('bill')->where("id = $id")->find();
                $this->assign('contract',$contract);
                $this->assign('bill',$bill);
                $this->display('billsee');
            }

        }else{
            $bid = I("post.bid");
            $data['cbtime'] = I('post.cbtime');
            $data['vat'] = I('post.vat');
            $data['recname'] = I('post.recname');
            $data['bnum'] = I('post.bnum');
            $data['bstatus'] = 4;
            $data['mid'] = session('uid');
            $s = M('bill')->where("id = $bid")->save($data);
            $msg = I('post.msg','','trim');
            $r = 1;
            if(!empty($msg)){
                $dat['msg'] = $msg;
                $dat['mattr'] = 2;
                $dat['uid'] = session('uid');
                $dat['mtype'] = 'bill';
                $dat['fid'] = $bid;
                $dat['uname'] = session('uinfo')['username'];
                $dat['ctime'] = time();
                $r = M('message')->add($dat);
            }
            if($s && $r){
                $this->success("填写成功！",U('index/makebill'));
            }else{
                $this->success("填写失败！",U('index/makebill'));
            }

        }

    }

    public function department(){
        if(IS_GET){
            $type = I('get.type','');
            if(empty($type)){ //部门管理
                $rs =  M('dptment')->join("a left join user b on a.uid = b.id")->field("a.*,b.username")->select();
                $this->assign('data',$rs);
                $this->display('depshow');
            }elseif($type == 'del'){
                $id = I('get.id');
                $s = M('dptment')->where("id = {$id}")->save(['status'=>0]);
                if($s){
                    $this->success("禁用成功！");
                }else{
                    $this->error("禁用失败！");
                }
            }elseif($type == 'reuse'){
                $id = I('get.id');
                $s = M('dptment')->where("id = {$id}")->save(['status'=>1]);
                if($s){
                    $this->success("重新启用成功！");
                }else{
                    $this->error("重新启用失败！");
                }
            }

        }else{
            $department = M('dptment');
            $depname = I('post.depname','','trim');
            $res = $department->where("depname = '{$depname}'")->find();
            if(!$res){
                $rs = $department->add(['depname'=>$depname,'status'=>1,'ctime'=>time(),'uid'=>session('uid')]);
                if($rs){
                    $this->success("添加成功！");
                    exit;
                }
                goto z;
            }else{
                z:
                $this->error("部门已存在，或添加失败，请重试");
            }
        }
    }

    public function departmentadd(){
        if(IS_GET){
            $this->display('department');
        }else{
            $department = M('dptment');
            $depname = I('post.depname','','trim');
            $res = $department->where("depname = '{$depname}'")->find();
            if(!$res){
                $rs = $department->add(['depname'=>$depname,'status'=>1,'ctime'=>time(),'uid'=>session('uid')]);
                if($rs){
                    $this->success("添加成功！");
                    exit;
                }
                goto z;
            }else{
                z:
                $this->error("部门已存在，或添加失败，请重试");
            }
        }
    }

    public function dptedit(){
        if(IS_GET){
            $id = I("get.id");
            $res = M('dptment')->where("id = $id")->find();
            $this->assign('data',$res);
            $this->assign('did',$id);
            $this->display();
        }else{
            $did = I('post.did');
            $depname = I('post.depname');
            $res = M('dptment')->where("id = $did")->save(['depname'=>$depname]);
            if($res){
                $this->success("修改成功",U('index/department'));
            }else{
                $this->error("修改失败");
            }
        }

    }
    public function bank(){
        if(IS_GET){
            $this->display();
        }else{
            $department = M('bank');
            $depname = I('post.bankno','','trim');
            $total = I('post.total');
            $res = $department->where("bankno = '{$depname}'")->find();
            if(!$res){
                $rs = $department->add(['bankno'=>$depname,'total'=>$total,'status'=>1,'ctime'=>time(),'uid'=>session('uid')]);
                if($rs){
                    $this->success("添加成功！");
                    exit;
                }
                goto z;
            }else{
                z:
                $this->error("账号已存在，或添加失败，请重试");
            }
        }
    }

    /**
     *  银行账号的审核，已废弃
     */
    /*
    public function checkBank(){
        $type = I('get.type');
        $id = I('get.id');
        if(empty($type)){ //银行管理
            //$rs =  M('bank')->join("a left join user b on a.uid = b.id")->where("a.status = '1'")->field("a.*,b.username")->select();
            $rs =  M('bank')->join("a left join user b on a.uid = b.id")->field("a.*,b.username")->select();
            $this->assign('data',$rs);
            $this->display('bankshow');
            exit;
        }elseif($type == 'del'){
            //$s = M('bank')->where("id = {$id}")->save(['status'=>0]);
        }elseif($type == 'bac'){
            $s = M('bank')->where("id = {$id}")->save(['status'=>0]);
        }elseif($type == 'pas'){
            $s = M('bank')->where("id = {$id}")->save(['status'=>2]);
        }
        if($s){
            $this->success("操作成功！");
        }else{
            $this->error("操作失败！");
        }

    }
    */
    public function bankedit(){
        if(IS_GET){
            $type = I('get.type');
            $id = I('get.id');
            if(empty($type)){
                $rs =  M('bank')
                    ->join("a left join user b on a.uid = b.id")
                    //->where("a.status = '1'")
                    ->field("a.*,b.username")
                    ->select();
                $this->assign('data',$rs);
                $this->display();
            }elseif($type == 'edit'){
                $data = M('bank')->where("id = $id")->find();
                $this->assign('data',$data);
                $this->assign('id',$id);
                $this->display('editbank');
            }elseif($type == 'del'){
                $id = I('get.id');
                $rs = M('bank')->where("id = $id")->save(['status'=>0]);
                if($rs){
                    $this->success("禁用成功");
                }else{
                    $this->error("禁用失败");
                }
            }elseif($type == 'reuse'){
                $id = I('get.id');
                $rs = M('bank')->where("id = $id")->save(['status'=>1]);
                if($rs){
                    $this->success("启用成功");
                }else{
                    $this->error("启用失败");
                }
            }

        }else{
            $id = I('post.id');
            $bankno = I('post.bankno','','trim');
            $total = I('post.total');
            $res = M('bank')->where("id = $id")->save(['bankno'=>$bankno,'total'=>$total,'status'=>1]);
            if($res){
                $this->success("修改成功！");
            }else{
                $this->error("修改失败");
            }
        }


    }

    public function showfiling(){
        $id = I('get.cid');
        $data = M('contract')->join("a left join files b on a.id = b.cid")->where("a.id = $id and b.type = 'filing'")->field("a.id,b.path,b.id as bid,b.uid as buid")->select();
        $message = M('message')->where("fid = $id and mtype = 'filing'")->select();
        $ftime = M('contract')->where("id = $id")->getField('filingtime');
        $this->assign('ftime',$ftime);
        $this->assign('mesg',$message);
        $this->assign('data',$data);
        $this->assign('cid',$id);
        $this->display();
    }
    public function filingbac(){
        $cid = I('get.cid');
        if($cid){
            $rs = M('contract')->where("id = $cid")->save(['isfiling'=>0]);
            if($rs){
                $this->success("驳回成功！",U('index/search'));
                exit;
            }
            goto zd;
        }else{
            zd:
            $this->error("操作错误！",U('index/search'));
        }
    }
    public function filing(){
        if(IS_GET){
            $uid = session('uid');
            $cid = I('get.id');
            $data = M('contract')->where("id = $cid")->find();
            $msg = [];
            if($data['isfiling'] == 0){
                $msg = M('message')->where("fid = $cid")->select();
            }
            $this->assign('msg',$msg);
            $this->assign('data',$data);
            $this->assign('cid',$cid);
            $this->display();
        }else{
            $pic = I('post.pic');
            $cid = I('post.cid');
            $uid = session('uid');

            $path = '';
            if($_FILES['filingpdf']['name'] != ''){
                $path = upfiles('filingpdf');
            }
            if(!$path && !$pic){
                $this->error("上传数据为空！");
                exit;
            }
            M('files')->where("cid = $cid and type = 'filing'")->delete();
            $rs = 1;
            if($pic){
                foreach($pic as $val){
                    $data[] = ['path'=>$val,'type'=>'filing','cid'=>$cid,'uid'=>$uid];
                }
                $rs = M('files')->addAll($data);
            }

            $dat['filingtime'] = time();
            $dat['isfiling'] = 2;
            $dat['filingpdf'] = $path;
            $res = M('contract')->where("id = $cid")->save($dat);
            if($rs && $res){
                $this->success("申请成功！",U('index/search'));
            }else{
                $this->error("申请失败，请联系管理员！",U('index/search'));
            }
        }


    }

    public function checkfiling(){
        if(IS_GET){
            //$where = "a.isfiling = '2'";
            //$on = "a.id = b.cid";
            //$field = " a.* , b.path,b.uid";
            //$order = "a.id desc";
            //$data = $this->Tmodel->getCommonList('contract', 'files', $on, $where, $field, $order, $this->pagesize);
            $data = $this->Tmodel->getAllByPage('contract',"isfiling = 2",$this->pagesize);
            $this->assign('data', $data);
            if (I('get.p') == '' || I('get.p') == 1) {
                $vari = 1;
            } else {
                $vari = $pagesize * (I('get.p') - 1) + 1;
            }
            $requesturl = $_SERVER['REQUEST_URI'];
            $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
            $this->assign('vari', $vari);// 序号累加变量
            $this->display();
        }else{
            $type = I('post.type');
            if($type == 'pas'){
                $id = I('post.billid');
                $data['isfiling'] = 3;
                $fstime = I('post.fstime');
                if($fstime){
                    $fstime = strtotime($fstime);
                }
                $data['filingtime'] = $fstime?:time();
                $data['isactive'] = 1;
                $rs = M('contract')->where("id = $id")->save($data);
                $dat['fid'] = $id;
                $dat['ctime'] = time();
                $dat['msg'] = I('post.msg');
                $dat['mtype'] = 'filing';
                $dat['mattr'] = 2;
                $dat['uid'] = session('uid');
                $dat['uname'] = session('uinfo')['username'];
                $rt = M('message')->add($dat);
                if($rs && $rt){
                    $this->success("审核完成",U('index/checkfiling'));
                }else{
                    $this->error("审核失败",U('index/checkfiling'));
                }
            }elseif($type == 'bac'){
                $id = I('post.billid');
                $data['isfiling'] = 0;
                $data['filingtime'] = time();
                $rs = M('contract')->where("id = $id")->save($data);
                $dat['fid'] = $id;
                $dat['msg'] = I('post.msg');
                $dat['mtype'] = 'filing';
                $dat['mattr'] = 0;
                $dat['uid'] = session('uid');
                $dat['uname'] = session('uinfo')['username'];
                $rt = M('message')->add($dat);
                if($rs && $rt){
                    $this->success("审核完成",U('index/checkfiling'));
                }else{
                    $this->error("审核失败",U('index/checkfiling'));
                }
            }
        }
    }

    public function filingdetail(){
        if(IS_GET){
            $id = I('get.id');
            $data = M('contract')->join("a left join files b on a.id = b.cid")->where("a.id = $id and b.type = 'filing'")->field("a.id,b.path,b.id as bid,b.uid as buid")->select();
            $this->assign('data',$data);
            $this->assign('cid',$id);
            $this->display();
        }else{

        }


    }

    public function downct(){
        $table = I('get.table','contract');
        $fd = I('get.fd','cfile');
        $id = I('get.cid');
        $path = M($table)->where("id = $id")->getField($fd);
        if(!$path){
            $this->error('文件不存在或已被删除！');
            exit;
        }
        return $this->downfile($path);
    }

    public function downfile($pt=''){
        if($pt){
            $path = $pt;
            goto zg;
        }
        $sid = I('get.id');
        $path = M('files')->where("sid = $sid")->getField('path');
        zg:
        $file = substr($path,1);
        if(is_file($file)){
            $length = filesize($file);
            $type = mime_content_type($file);
            $showname =  ltrim(strrchr($file,'/'),'/');
            header("Content-Description: File Transfer");
            header('Content-type: ' . $type);
            header('Content-Length:' . $length);
            if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) { //for IE
                header('Content-Disposition: attachment; filename="' . rawurlencode($showname) . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $showname . '"');
            }
            readfile($file);
            exit;
        } else {
            $this->error('文件已被删除！');
        }

    }

    /**
     * 回款录入
     */
    public function payback(){
        if(IS_GET){
            $banks = M('bank')->where("status = '1'")->select();
            $this->assign('banks',$banks);
            $this->display();
        }else{
            $reback = M('reback');
            $data = I('post.');
            unset($data['submit']);
            $data['uid'] = session('uid');
            $rs = $reback->add($data);
            $res = M('bank')->where('id='.$data['bankno'])->setInc('total',$data['btotal']);
            if($rs && $res){
                $this->success("录入成功！");
            }else{
                $this->error("录入失败，请联系管理员");
            }
        }
    }

    /**
     * 回款关联1.0
     */
    public function glian(){
        if(IS_GET){
            $paycomp = I('get.paycomp');

            $uid = session('uid');
            if(in_array(1,session('rid'))){
                $contract = M('contract')->where('cstatus = 0')->select();
            }else{
                $contract = M('contract')->where('cstatus = 0 and checkuid='.$uid)->select();
            }
            if($paycomp){
                $where = "a.cid is null and paycomp like '%{$paycomp}%'";
            }else{
                $where = "a.cid is null";
            }
            $on = "a.bankno = b.id";
            $field = " a.* , b.bankno as bno,b.total";
            $order = "a.id desc";
            $data = $this->Tmodel->getCommonList('reback', 'bank', $on, $where, $field, $order, $this->pagesize);
            $this->assign('data', $data);
            if (I('get.p') == '' || I('get.p') == 1) {
                $vari = 1;
            } else {
                $vari = $pagesize * (I('get.p') - 1) + 1;
            }
            $requesturl = $_SERVER['REQUEST_URI'];
            $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
            $this->assign('vari', $vari);// 序号累加变量
            $this->assign('contract',$contract);
            $this->assign('paycomp',$paycomp);
            $this->display();
        }else{
            $rid = I('post.rid');
            $cid = I('post.cid');
            $uid = session('uid');
            $res = M('reback')->where("id = {$rid}")->save(['guid'=>$uid,'cid'=>$cid,'rstatus'=>2]);
            M('contract')->where("id = $cid")->save(['isactive'=>1]);
            if($res){
                $this->success("关联成功！");
            }else{
                $this->error("关联失败！");
            }

        }


    }

    /**
     * 关联2.0
     */
    public function guanlian(){
        if(IS_GET){
            $rbid = I('get.id');
            $this->assign('rbid',$rbid);
            $uid = session('uid');
            $where = '';
            $_fname = I('get.fname');
            $this->assign('_fname',$_fname);
            $_pname = I('get.pname');
            $this->assign('_pname',$_pname);
            $_cname = I('get.cname');
            $this->assign('_cname',$_cname);
            $_gname = I('get.gname');
            $this->assign('_gname',$_gname);
            $_isstamp = I('get.isstamp');
            $this->assign('_isstamp',$_isstamp);
            $_isfiling = I('get.isfiling');
            $this->assign('_isfiling',$_isfiling);
            $_belong = I('get.belong');
            $this->assign('_belong',$_belong);
            $_ct = I('get.ct');
            $this->assign('_ct',$_ct);
            $arr = [];
            if($_fname){
                $arr[] = "a.fname like '%{$_fname}%'";
            }
            if($_ct){
                $ty = ($_ct == 1)?0:1;
                $arr[] = " a.kinds = $ty ";
            }
            if($_pname){
                $pidarr = M('project')->where("pname like '%{$_pname}%'")->field('id')->select();
                $fstr = '';
                if($pidarr){
                    $fstr = getSingleFieldStr($pidarr);
                }
                if($fstr){
                    $arr[] = " a.pid in ($fstr) ";
                }
            }
            if($_gname){
                $arr[] = "a.gname like '%{$_gname}%'";
            }
            if($_cname){
                $arr[] = "a.cname like '%{$_cname}%'";
            }
            if($_isfiling){
                if($_isfiling == 1){
                    $arr[] = " a.isfiling = 3 ";
                }else{
                    $arr[] = " a.isfiling != 3 ";
                }
            }

            if($_isstamp){
                if($_isstamp == 1){
                    $arr[] = "a.isstamp = 1";
                }else{
                    $arr[] = "a.isstamp != 1";
                }
            }
            if($_belong){
                $arr[] = "a.belong = '{$_belong}'";
            }
            if(!empty($arr)){
                $where = implode(' and ',$arr);
            }

            $isexc = 0; //是否有编辑权限
            if(!in_array(1,session('rid'))){
                //$where = $where?$where.' and a.uid = '.$uid:'a.uid = '.$uid;
            }else{
                $isexc = 1;
            }
            //$data = $this->Tmodel->getAllByPage('contract',$where,1);
            $data = $this->Tmodel->getJoinByPage('contract','project',$where, $this->pagesize);
            foreach($data['list'] as $ink => $v){
                $data['list'][$ink]['stampis'] = 0;
                $rs = M('stamp')->where("cid = {$v['id']}")->getField('id');
                if($rs) $data['list'][$ink]['stampis'] = 1;
            }
            //判断除基本用户外是否有编辑权限
            $x = M('role_user')->join("a left join role_node b on a.rid = b.rid")->where("a.uid = {$uid} and a.rid != 2")->field("b.nid")->select();
            if(in_array(54,$x)){
                $isexc = 1;
            }
            $this->assign('isexc',$isexc);
            $this->assign('data' , $data);
            if(I('get.p') == '' || I('get.p') == 1){$vari = 1;}else{$vari = $pagesize * (I('get.p') - 1) + 1;}
            $requesturl = $_SERVER['REQUEST_URI'];
            $this->assign('dqurl',base64url_encode($requesturl));// 当前URL
            $this->assign('vari',$vari);// 序号累加变量
            $this->display();
        }else{
            $rid = I('post.rbid');
            $cid = I('post.cid');
            $uid = session('uid');
            $res = M('reback')->where("id = {$rid}")->save(['guid'=>$uid,'cid'=>$cid,'rstatus'=>2]);
            M('contract')->where("id = $cid")->save(['isactive'=>1]);
            if($res){
                $this->success("关联成功！",U('index/glian'));
            }else{
                $this->error("关联失败！",U('index/glian'));
            }
        }
    }

    /**
     * 删除关联
     */
    public function rebcdel(){
        $id = I('get.id');
        $bid =  I('get.bid');
        $mt = I('get.mt');
        $rs = M('bank')->where("id = $bid")->setDec('total',$mt);
        $rt = M('reback')->where("id = $id")->delete();
        if($rs){
            $this->success("删除成功！");
            exit;
        }
        $this->error("删除失败！");
    }

    /**
     * 关联审核
     */
    function checkglian(){
        if(IS_GET){
            $uid = session('uid');
            if(in_array(1,session('rid'))){
                $where = " a.rstatus = 2 ";
            }else{
                $where = "b.uid = $uid and a.rstatus = 2";
            }
            $on = "a.cid = b.id";
            $field = " a.* , b.cno,b.cname,b.gname";
            $order = "a.id desc";
            $data = $this->Tmodel->getCommonList('reback', 'contract', $on, $where, $field, $order, $this->pagesize);
            foreach($data['list'] as $k => $v){
                $data['list'][$k]['bno'] = M('bank')->where("id = {$v['bankno']}")->getField('bankno');
            }
            $this->assign('data', $data);
            if (I('get.p') == '' || I('get.p') == 1) {
                $vari = 1;
            } else {
                $vari = $pagesize * (I('get.p') - 1) + 1;
            }
            $requesturl = $_SERVER['REQUEST_URI'];
            $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
            $this->assign('vari', $vari);// 序号累加变量
            $this->display();
        }else{
            $type = I('post.type');
            $rid = I('post.rid');
            $msg = I('post.msg');
            $kuid = session('uid');
            if($type == 'pas'){
                $res = M('reback')->where("id = $rid")->save(['ckuid'=>$kuid,'rstatus'=>3]);
                $rs = M('message')->add(['mtype'=>'reback','fid'=>$rid,'msg'=>$msg,'ctime'=>time(),'uid'=>session('uid'),'uname'=>session('uinfo')['username'],'mattr'=>2]);
                if($res && $rs){
                    $this->success('通过成功！');
                }else{
                    $this->error('通过失败');
                }
            }else{
                $res = M('reback')->where("id = $rid")->save(['ckuid'=>$kuid,'rstatus'=>0,'cid'=>null]);
                $rs = M('message')->add(['mtype'=>'reback','fid'=>$rid,'msg'=>$msg,'ctime'=>time(),'uid'=>session('uid'),'uname'=>session('uinfo')['username'],'mattr'=>0]);
                if($res && $rs){
                    $this->success('驳回成功！');
                }else{
                    $this->error('驳回失败');
                }
            }
        }

    }

    public function glist(){
        $uid = session('uid');
        $paycomp = I('get.paycomp');
        if(in_array(1,session('rid'))){
            $where = '';
            goto dend;
        }
        $where = " a.uid = $uid or a.ckuid = $uid or a.guid = $uid ";
        dend:
        if($paycomp){
            if($where){
                $where .= " and a.paycomp like '%{$paycomp}%'";
            }else{
                $where = "a.paycomp like '%{$paycomp}%'";
            }
        }
        $on = "a.cid = b.id";
        $field = " a.* , b.cno,b.cname,b.fname,b.gname,b.belong,b.checkuid";
        $order = "a.id desc";
        $data = $this->Tmodel->getCommonList('reback', 'contract', $on, $where, $field, $order, $this->pagesize);
        foreach($data['list'] as $k => $v){
            $data['list'][$k]['bno'] = M('bank')->where("id = {$v['bankno']}")->getField('bankno');
        }
        $this->assign('data', $data);
        if (I('get.p') == '' || I('get.p') == 1) {
            $vari = 1;
        } else {
            $vari = $pagesize * (I('get.p') - 1) + 1;
        }
        $requesturl = $_SERVER['REQUEST_URI'];
        $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
        $this->assign('vari', $vari);// 序号累加变量
        $this->display();
    }

    public function excute(){
        if(IS_GET){
            $uid = session('uid');
            $where = "exuid = $uid and isex = 0";
            $data = $this->Tmodel->getAllByPage('contract',$where, $this->pagesize);
            $this->assign('data', $data);
            if (I('get.p') == '' || I('get.p') == 1) {
                $vari = 1;
            } else {
                $vari = $pagesize * (I('get.p') - 1) + 1;
            }
            $requesturl = $_SERVER['REQUEST_URI'];
            $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
            $this->assign('vari', $vari);// 序号累加变量
            $this->display();
        }else{

        }

    }

    public function listex(){
        $cid = I("get.id");
        $on = "a.uid = b.id";
        $field = " a.* , b.username";
        $order = "a.id desc";
        $where = " a.cid = $cid ";
        $data = $this->Tmodel->getCommonList('excontract', 'user', $on, $where, $field, $order, $this->pagesize);
        $this->assign('data', $data);
        if (I('get.p') == '' || I('get.p') == 1) {
            $vari = 1;
        } else {
            $vari = $pagesize * (I('get.p') - 1) + 1;
        }
        $requesturl = $_SERVER['REQUEST_URI'];
        $this->assign('dqurl', base64url_encode($requesturl));// 当前URL
        $this->assign('vari', $vari);// 序号累加变量
        $this->display();
    }

    public function exdetail(){
        $exid = I('get.exid');
        $data = M('files')->where("sid = $exid and type = 'execute'")->select();
        $this->assign('data',$data);
        $this->display();
    }

    public function exdel(){
        $exid = I('get.exid');
        $rs = 1;
        $rt = 1;
        $rs = M('excontract')->where("id = $exid")->delete();
        $rt = M('files')->where("sid = $exid and type = 'execute'")->delete();
        if($rs && $rt){
            $this->success("删除成功！");
        }else{
            $this->error("删除失败");
        }
    }

    public function excontract(){
        if(IS_GET){
            $id = I('get.id');
            $this->assign('id',$id);
            $this->display();
        }else{
            $pics = I('post.pic');
            $cid = I('post.cid');
            $done = I('post.done');
            $remark = I('post.remark');
            $rs = 0;
            if($pics){
                $data = [
                    'cid' => $cid,
                    'uid' => session('uid'),
                    'extime'    => time(),
                    'remark'    => $remark,
                ];
                $exid = M('excontract')->add($data);
                if(!$exid) goto ov;
                $rs = 1;
                foreach($pics as $v){
                    $res = M('files')->add(['uid'=>session('uid'),'sid'=>$exid,'cid'=>$cid,'type'=>'execute','path'=>$v]);
                    if(!$res) $rs = 0;
                }
            }
            if($rs){
                if($done == 1){
                    $uar = ['isex'=>1,'isactive'=>1];
                }else{
                    $uar = ['isex'=>1];
                }
                M('contract')->where("id = $cid")->save($uar);
                $this->success("执行完毕！",U('index/excute'));
            }else{
                ov:
                $this->error("执行失败！",U('index/excute'));
            }

        }

    }

    public function bbb(){
        $node = trim(__ACTION__);
        $arr = explode('/',$node);
        $nodeurl = strtolower($arr[2].'/'.$arr[3]);
        echo $nodeurl;
    }

    /**
     * 下载合同
     */
    public function downxls(){
        //exit("asdfasdf");
        set_time_limit(0);
        @ini_set('memory_limit', '500M');
        $filename = '导出数据';
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //$titles = array('订阅id', '订单号',  '用户ID','手机号','商品ID','支付金额（元）', '支付状态','支付方式','支付手机号码','创建时间','支付时间','是否过期','过期时间','是否退订','退订时间','购买状态','地址简码','昵称','学校简码','年级简码','班级简码','包名');
        $titles = [
            '合同编号',
            '创建合同人',
            '归属公司',
            '合同类别',
            '是否框架合同',
            '合同名称',
            '客户名称',
            '项目名称',
            '初审人员',
            '合同金额',
            '备注',
            '归档状态',
            '已出票金额总和',
            '应开票金额总和',
            '盖章状态',
            '推广期间',
            '推广位置',
            '结算条款',
            '已确认回款总额',
            '全部回款金额'
        ];
        foreach ($titles as $k => $v) {
            $titles[$k]=iconv("UTF-8", "GB2312",$v);
        }
        $titles= implode("\t", $titles);
        echo "$titles\n";
        $ct = M('contract')->count();
        for($i=0;$i<$ct;$i+=100){
            $data = M('contract')->limit($i,100)->select();
            foreach($data as $index => $value) {
                $arr = [];

                $arr[] = $value['cno'];
                $arr[] = $value['fname'];
                $arr[] = $value['belong'];
                $arr[] = $value['kinds']==0?'销售合同':'采购合同';
                $arr[] = $value['isframe']==0?'非':'是';
                $arr[] = $value['cname'];
                $arr[] = $value['gname'];
                $arr[] = M('project')->where("id = {$value['pid']}")->getField('pname');
                $arr[] = M('user')->where("id = {$value['checkuid']}")->getField('username');
                $arr[] = $value['total'];
                $arr[] = trim($value['remark']);
                $arr[] = $value['isfiling']==3?'已归档'.date('Y-m-d H:i:s'):'未归档';
                $_j = 0;
                $_nj = 0;
                $bill = M('bill')->where("cid = {$value['id']}")->select();
                foreach($bill as $vw){
                    if($vw['bstatus'] === '4'){
                        $_j += $vw['btotal'];
                    }else{
                        $_nj += $vw['btotal'];
                    }
                }
                $arr[] = $_j;
                $arr[] = $_j+$_nj;
                //$arr[] = $value['isstamp']==0?'未盖章':'已盖章';
                if($value['isstamp'] == 0){
                    zg:
                    $arr[] = '未盖章';
                    $arr[] = '';
                    $arr[] = '';
                    $arr[] = '';
                }else{
                    $sdt = M('stamp')->where("cid = {$value['id']} and status = 4")->find();
                    if(!$sdt) goto zg;
                    $arr[] = '已盖章'.date('Y-m-d H:i:s',$sdt['stime']);
                    $arr[] = $sdt['adperiod'];
                    $arr[] = $sdt['adposition'];
                    $arr[] = $sdt['settleitem'];
                }
                $payback = M("reback")->join("a left join bank b on a.bankno = b.id")->where("a.cid = {$value['id']} and (a.rstatus = 2 or a.rstatus = 3)")->field('a.*,b.bankno as banknum')->select();
                $spaytotal = 0;
                $wpaytotal = 0;
                foreach($payback as $vl){
                    if($rstatus == 2){
                        $wpaytotal += $vl['btotal'];
                    }else{
                        $spaytotal += $vl['btotal'];
                    }
                }
                $arr[] = $spaytotal;
                $arr[] = ($spaytotal + $wpaytotal);
                ob_flush();
                flush();
                echo iconv('UTF-8','GB2312',implode("\t", $arr)."\n");
            }

        }
    }

    /**
     * 下载开票信息
     */
    public function downbill(){
        set_time_limit(0);
        @ini_set('memory_limit', '500M');
        $filename = '导出数据';
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $titles = [
            '发票类型',
            '客户名称',
            '开票内容',
            '开票金额',
            '开票日期',
            '发票号',
            '增值税',
            '领取人',
            '发票状态',
            '所属合同编号',
        ];
        foreach ($titles as $k => $v) {
            $titles[$k]=iconv("UTF-8", "GB2312",$v);
        }
        $titles= implode("\t", $titles);
        echo "$titles\n";
        $ct = M('bill')->count();
        for($i=0;$i<$ct;$i+=100){
            $data = M('bill')->limit($i,100)->select();
            foreach($data as $k => $v){
                $arr = [];
                $arr[] = $v['btype'];
                $arr[] = $v['gname'];
                $arr[] = $v['cbcontent'];
                $arr[] = $v['btotal'];
                $arr[] = $v['cbtime'];
                $arr[] = $v['bnum'];
                $arr[] = $v['vat'];
                $arr[] = $v['recname'];
                if($v['bstatus'] == 0){
                    $arr[] = '被驳回';
                }elseif($v['bstatus'] == 1){
                    $arr[] = '初审中';
                }elseif($v['bstatus'] == 2){
                    $arr[] = '复审中';
                }elseif($v['bstatus'] == 3){
                    $arr[] = '出票中';
                }else{
                    $arr[] = '已开票';
                }
                $arr[] = M('contract')->where("id = {$v['cid']}")->getField('cno');
                ob_flush();
                flush();
                echo iconv("UTF-8", "GB2312",implode("\t", $arr)."\n");
            }

        }
    }

    /**
     * 下载回款信息
     */
    public function downreback(){
        set_time_limit(0);
        @ini_set('memory_limit', '500M');
        $filename = '导出数据';
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $titles = [
            '收款公司',
            '付款公司',
            '回款金额',
            '款项性质',
            '回款时间',
            '收款账号',
            '回款状态',
            '所属合同编号',
        ];
        foreach ($titles as $k => $ve) {
            $titles[$k]=iconv("UTF-8", "GB2312",$ve);
        }
        $titles= implode("\t", $titles);
        echo "$titles\n";
        $ct = M('reback')->count();
        for($i=0;$i<$ct;$i+=50){
		    $ids = M('reback')->field('id')->limit($i,50)->select();
		    $str = '';
		    foreach($ids as $vi){
			    $str .= $vi['id'].',';
		    }
		    $str = trim($str,',');
            $data = M('reback')->where("id in ({$str})")->select();
            foreach($data as $k => $v){
                $arr = [];
                $arr[] = $v['payee'];
                $arr[] = $v['paycomp'];
                $arr[] = $v['btotal'];
                $arr[] = $v['btype'];
                $arr[] = $v['btime'];
                $arr[] = M('bank')->where("id = {$v['bankno']}")->getField('bankno');
                if($v['rstatus'] == 0){
                    $arr[] = '被驳回';
                    $arr[] = '';
                }elseif($v['rstatus'] == 1){
                    $arr[] = '未认领';
                    $arr[] = '';
                }elseif($v['rstatus'] == 2){
                    $arr[] = '审核中';
                    $arr[] = '';
                }else{
                    $arr[] = '已关联';
                    $arr[] = M('contract')->where("id = {$v['cid']}")->getField('cno');
                }
		        $optstr = implode("\t", $arr)."\n";
                echo iconv('UTF-8','GB2312',$optstr);
                ob_flush();
                flush();
            }

        }
    }

    /**
     * 下载报销信息
     */
    public function downreimburse(){
        set_time_limit(0);
        @ini_set('memory_limit', '600M');
        $filename = 'reimburse';
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $titles = [
            '单号',
            '子单号',
            '申请人',
            '所属项目',
            '所属销售合同',
            '所属采购合同',
            '归属公司',
            '收款公司',
            '报销摘要',
            '发生月份',
            '报销金额',
            '付款金额',
            '付款时间',
            '备注',
        ];
        foreach ($titles as $k => $v) {
            $titles[$k]=iconv("UTF-8", "GB2312",$v);
        }
        $titles= implode("\t", $titles);
        echo "$titles\n";
        $ct = M('reimburse')->count();
        for($i=0;$i<$ct;$i+=50){
            $data = M('reimburse')->limit($i,50)->select();
            foreach($data as $k => $v){
                $sigres = M('reimburse_record')->where("rbid = {$v['id']} and pid != 0")->select();
                if($sigres){
                    foreach($sigres as $vl){
                        $reimbursement = M('reimbursement')->where("sid = {$vl['id']}")->select();
                        if($reimbursement){
                            foreach($reimbursement as $vt){
                                $arr = [];
                                $arr[] = $vt['rbno'];
                                $arr[] = $vt['sid'];
                                $arr[] = M('user')->where("id = {$vl['uid']}")->getField('username');
                                $arr[] = M('project')->where("id = {$vl['pid']}")->getField('pname');
                                $arr[] = $vl['cid']?M('contract')->where("id = {$vl['cid']}")->getField('cno'):'';
                                $arr[] = $vl['cgid']?M('contract')->where("id = {$vl['cgid']}")->getField("cno"):'';
                                $arr[] = $vl['belong'];
                                $arr[] = $vl['charge'];
                                $arr[] = $vt['ab'];
                                $arr[] = $vt['etime'];
                                $arr[] = $vt['atotal'];
                                $arr[] = $vt['etotal'];
                                $arr[] = $vt['ptime'];
                                $arr[] = $vl['remark'];
                                ob_flush();
                                flush();
                                echo iconv("UTF-8", "GB2312",implode("\t", $arr)."\n");
                            }

                        }
                    }
                }
            }

        }
    }

    /**
     * 使用说明
     */
    public function intro(){
        if(IS_GET){
            $intro = M('intro')->where("id = 1")->find();
            $this->assign('msg',$intro['intromsg']);
            $this->display();
        }else{
            //dump(I('post.intro'));

            $intro = I('post.intro');
            M('intro')->where("id = 1")->save(['intromsg'=>$intro]);
            //echo M('intro')->getlastsql();
            //exit;
            $this->success('编辑成功');
        }
    }

    /**
     * 合同按项目归属（管理者角色）等多条件查询
     */
    public function ctsearch(){
        $this->display();
    }
}

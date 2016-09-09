<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\TmodelModel;
class ReimburseController extends Controller
{

    public $Tmodel = null;
    public $pagesize = 10;

    public function _initialize()
    {
        $this->Tmodel = new TmodelModel();
        is_login();
    }

    /**
     * 申请报销
     */
    public function index($daniel='')
    {
        if(IS_GET){
            $rbid = I('get.rbid',0);
            $records = '';
            if($rbid){
                $records = M('reimburse_record')->where("rbid = $rbid")->find();
                $_cidinfo='';
                if($records['cid']){
                    $_cidinfo = M('contract')->where("id = {$records['cid']}")->find();
                }
                $_cgidinfo = '';
                if($records['cgid']){
                    $_cgidinfo = M('contract')->where("id = {$records['cgid']}")->find();
                }
                $this->assign('cidinfo',$_cidinfo);
                $this->assign('cgidinfo',$_cgidinfo);
            }
            $rbtype = I('get.rbtype');
            $pro = M('project')->where("status = '1'")->select();
            $cusers = M('role_user')->join(" a left join user b on a.uid = b.id ")->where("a.rid = 3")->field('a.rid,b.*')->select();
            $cgcon = M('contract')->where("kinds = 1")->select();
            $this->assign('cgcon',$cgcon);
            $this->assign('rbid',$rbid);
            $this->assign('checkusers',$cusers);
            $this->assign('pro',$pro);
            if($daniel == 'borrow'){
                $this->assign('dp','borrow');
            }else{
                $this->assign('dp','ap');
            }
            $this->assign('records',$records);
            $this->display();
        }else{
            $cgid = I("post.cgid");
            if($cgid){

                $ctotal = M('contract')->where("id = $cgid and isframe = 0")->getField('total');
                if($ctotal){
                    $aptotal = M('reimburse_record')
                        ->join("a left join reimbursement b on a.id = b.sid")
                        ->where("a.cgid = $cgid")
                        ->field("b.atotal")
                        ->select();
                    $apt = 0;
                    foreach($aptotal as $v){
                        $apt += $v['atotal'];
                    }
                    $atotals = array_sum(I("post.atotal"));
                    if(($ctotal-$apt) < $atotals){
                        $this->error("申请金额大于合同剩余可申请金额！");
                        exit;
                    }
                }


            }

            $rbid = I('post.rbid');
            $reimburse = M('reimburse');
            $reimburse_record = M('reimburse_record');
            if(!$rbid){
                $data = [
                    'status'=>1,
                    'ctime'=>time(),
                    'burseno'=>date('YmdHis').mt_rand(1,100),
                    'uid'=>session('uid'),
                ];
                $rbid = $reimburse->add($data);
            }else{
                $data = $reimburse->where('id = '.$rbid)->find();
            }

            $datas = I('post.');
            $datasg['rbid'] = $rbid;
            $datasg['rbno'] = $data['burseno'];
            $datasg['pid'] = $datas['pid'];
            $datasg['checkuid'] = $datas['checkuid'];
            $datasg['cid'] = $datas['cid'];
            $datasg['cgid'] = $datas['cgid'];
            $datasg['remark'] = $datas['remark'];
            $datasg['uid'] = session('uid');
            $datasg['bstatus'] = 1;
            $datasg['belong'] = $datas['belong'];
            $datasg['charge'] = $datas['charge'];

            if(I('post.dp') == 'borrow'){
                $datasg['rbtype'] = 1;
            }
            $pics = [];
            if(isset($datas['pic'])){
                $pics = $datas['pic'];
                unset($datas['pic']);
            }
            $sid = $reimburse_record->add($datasg);
            $rs = 1;
            if($sid){
                foreach($pics as $v){
                    $dt[] = ['type'=>'reimburse','sid'=>$sid,'path'=>$v,'uid'=>session('uid')];
                }
                if(!empty($pics)){
                    $rs = M('files')->addAll($dt);
                }
                foreach($datas['ab'] as $k=>$vl){
                    $dat[] = [
                        'ab'=>$vl,
                        'etime'=>$datas['etime'][$k],
                        'atotal'=>$datas['atotal'][$k],
                        'etotal'=>I('post.dp') != 'borrow'?$datas['etotal'][$k]:0,
                        'rbid'=>$rbid,
                        'rbno'=>$data['burseno'],
                        'pid'=>$datas['pid'],
                        'checkuid'=>$datas['checkuid'],
                        'uid'=>session('uid'),
                        'sid'=>$sid,
                    ];
                }
                $rses = M('reimbursement')->addAll($dat);
                if($rs && $rses){
                    $this->success("申请成功！");
                    exit;
                }else{
                    goto d;
                }
            }else{
                d:
                $this->error("添加失败，请联系管理员！");
                exit;
            }


        }
    }

    /**
     * 借款申请
     */
    public function borrow(){
        $this->index('borrow');
    }
    public function getcontract(){
        if(IS_POST){
            $pid = I('post.pid');
            $cs['k1'] = M('contract')->where('pid = '.$pid.' and kinds = 0')->field('id,cno,checkuid,gname')->select();
            $cs['k2'] = M('contract')->where('pid = '.$pid.' and kinds = 1')->field('id,cno,checkuid,gname')->select();
            echo json_encode($cs);
            exit;
        }
    }

    public function record_detail(){
        $id = I('get.id');
        $record = M("reimburse_record")->where("id = $id")->find();
        $cgcon = '';
        if($record['cgid']) $cgcon = M('contract')->where("id = {$record['cgid']}")->find();
        $scon = '';
        if($record['cid']) $scon = M('contract')->where("id = {$record['cid']}")->find();
        $pname = M('project')->where("id = {$record['pid']}")->getField('pname');
        $data = M('reimbursement')->where("sid = $id")->select();
        $msgdata = M('message')->where("mtype = 'reimburse' and fid = $id")->select();
        $fpath = M('files')->where("type = 'reimburse' and sid = $id")->field('path')->select()?:'';
        $paypath = M('files')->where("type='reimburse_pay' and sid = $id")->field('path')->select()?:'';
        $this->assign('paypath',$paypath);
        $this->assign('fpath',$fpath);
        $this->assign('msg',$msgdata);
        $this->assign('cgcon',$cgcon);
        $this->assign('scon',$scon);
        $this->assign('data',$data);
        $this->assign('record',$record);
        $this->assign('pname',$pname);
        $this->display();
    }

    public function record_del(){
        $id = I("get.id");
        if($id){
            $rs = M('reimburse_record')->where("id = $id")->delete();
            $rt = M('reimbursement')->where("sid = $id")->delete();
            if($rs && $rt){
                $this->success("删除成功！");
                exit;
            }
            $this->error("删除失败！");
        }
    }

    public function check(){
        $uid = session('uid');
        if(in_array(1,session('rid'))){
            $where = "a.bstatus = 1";
        }else{
            $where = "a.checkuid = $uid and a.bstatus = 1";
        }
        $on = "a.pid = b.id";
        $field = " a.* , b.pname";
        $order = "a.id desc";
        $data = $this->Tmodel->getCommonList('reimburse_record', 'project', $on, $where, $field, $order, $this->pagesize);
        foreach($data['list'] as $k => $v){
            $data['list'][$k]['uname'] = M('user')->where("id = {$v['uid']}")->getField('username');
            if($data['list'][$k]['cid']){
                $data['list'][$k]['scno'] = M('contract')->where("id = {$v['cid']}")->getField('cno');
            }
            if($data['list'][$k]['cgid']){
                $data['list'][$k]['cgcno'] = M('contract')->where("id = {$v['cgid']}")->getField('cno');
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

    public function recheck(){
        $uid = session('uid');
        if(in_array(1,session('rid'))){
            $where = "a.bstatus = 2";
        }else{
            $where = "a.recheckuid = $uid and a.bstatus = 2";
        }
        $on = "a.pid = b.id";
        $field = " a.* , b.pname";
        $order = "a.id desc";
        $data = $this->Tmodel->getCommonList('reimburse_record', 'project', $on, $where, $field, $order, $this->pagesize);
        foreach($data['list'] as $k => $v){
            $data['list'][$k]['uname'] = M('user')->where("id = {$v['uid']}")->getField('username');
            if($data['list'][$k]['cid']){
                $data['list'][$k]['scno'] = M('contract')->where("id = {$v['cid']}")->getField('cno');
            }
            if($data['list'][$k]['cgid']){
                $data['list'][$k]['cgcno'] = M('contract')->where("id = {$v['cgid']}")->getField('cno');
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
        $this->assign('checklev',2);
        $this->display('check');
    }

    public function rbdetail(){
        if(IS_GET){
            $checklev = I('get.checklev');
            $id = I('get.id');
            $data = M("reimburse_record")->join("a left join project b on a.pid = b.id")->field('a.*,b.pname')->where("a.id = $id")->find();
            $scon = [];
            $cgcon = [];
            if($data['cid']){
                $scon = M('contract')->where("id = {$data['cid']}")->find();
            }
            if($data['cgid']){
                $cgcon = M('contract')->where("id = {$data['cgid']}")->find();
            }
            $pics = M('files')->where("type = 'reimburse' and sid = $id")->select();
            $reimbursment = M('reimbursement')->where("sid = $id")->select();
            $bcmsg = M('message')->where("fid = $id and mtype= 'reimburse' and mattr = 0")->select();
            $this->assign('bcmsg',$bcmsg);
            $this->assign('reimbursement',$reimbursment);
            $this->assign('pics',$pics);
            $this->assign('scon',$scon);
            $this->assign('cgcon',$cgcon);
            $this->assign('data',$data);
            $this->assign('checklev',$checklev);
            $this->assign('id',$id);
            if($checklev == 1){
                $recusers = M('user')->join("a left join role_user b on a.id = b.uid")->where("b.rid = 4")->field("a.*")->select();
                $this->assign('recusers',$recusers);
                $this->display();
            }elseif($checklev == 2){
                $this->display('redetail');

            }elseif($checklev == 3){
                $fk = M('catelog')->where("ctype = 1")->select();
                $sk = M('catelog')->where("ctype = 2")->select();
                $fee = M('feetype')->select();
                $banks = M('bank')->where("status = '1'")->select();
                $this->assign('banks',$banks);
                $this->assign('fk',$fk);
                $this->assign('sk',$sk);
                $this->assign('fee',$fee);
                $this->display('confirmdetail');
            }
        }else{
            $type = I('post.type');
            $sid = I('post.sid');
            if($type == 'pas'){
                $checklev = I('post.checklev');
                $recheckuid = I('post.recheckuid');
                $data['msg'] = I('post.msg','','trim');
                $rs = 1;
                if(!$data['msg']) goto wu;
                $data['fid'] = $sid;
                $data['mtype'] = 'reimburse';
                $data['uid'] = session('uid');
                $data['uname'] = session('uinfo')['username'];
                $data['mattr'] = 1;
                $data['ctime'] = time();
                $rs = M('message')->add($data);
                wu:
                $rst = M('reimburse_record')->where("id = $sid")->save(['bstatus'=>$checklev+1,'recheckuid'=>$recheckuid]);
                if($rs && $rst){
                    if($checklev == 1){
                        $this->success("审核通过",U('check'));
                    }elseif($checklev == 2){
                        $this->success("审核通过",U('recheck'));
                    }elseif($checklev == 3){
                        $this->success("审核通过",U('confirm'));
                    }
                }else{
                    if($checklev == 1){
                        $this->error("审核失败",U('check'));
                    }elseif($checklev == 2){
                        $this->error("审核失败",U('recheck'));
                    }elseif($checklev == 2){
                        $this->error("审核失败",U('confirm'));
                    }
                }
            }else{
                $data['msg'] = I('post.msg','','trim');
                $rs = 1;
                $data['fid'] = $sid;
                if(!$data['msg']) goto wul;
                $data['mtype'] = 'reimburse';
                $data['uid'] = session('uid');
                $data['uname'] = session('uinfo')['username'];
                $data['ctime'] = time();
                $data['mattr'] = 0;
                $rs = M('message')->add($data);
                wul:
                $res =  M('reimburse_record')->where("id = {$data['fid']}")->save(['bstatus'=>'0']);
                if($rs && $res){
                    $this->success("驳回成功",U('reimburse/check'));
                }else{
                    $this->error("驳回失败，请联系管理员",U('reimburse/check'));
                }
            }
        }

    }

    public function catelog(){
        if(IS_GET){
            $data = $this->Tmodel->getAllByPage('catelog',"status = 1",$this->pagesize);
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

    public function catelog_add(){
        if(IS_GET){
            $this->display('cateadd');
        }else{
            $data['ctype'] = I('post.ctype');
            $data['cgname'] = I('post.cgname');
            $res = M('catelog')->add($data);
            if($res){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            }
        }
    }
    public function getCatelogname(){
        $name = I('post.name');
        $res = M('catelog')->where("cgname = '{$name}'")->find();
        if($res){
            echo 'no';
        }else{
            echo 'yes';
        }

    }

    public function getfeename(){
        $name = I('post.name');
        $res = M('feetype')->where("feetpname = '{$name}'")->find();
        if($res){
            echo 'no';
        }else{
            echo 'yes';
        }
    }

    public function catelogedit(){
        if(IS_GET){
            $id = I('get.id');
            $data = M('catelog')->where("id = $id")->find();
            $this->assign('data',$data);
            $this->assign('id',$id);
            $this->display();
        }else{
            $data['ctype'] = I('post.ctype');
            $data['cgname'] = I('post.cgname');
            $id = I('post.id');
            $res = M('catelog')->where("id = $id")->save($data);
            if($res){
                $this->success("更新成功！",U('catelog'));
            }else{
                $this->error("更新失败！",U('catelog'));
            }
        }

    }

    public function feetype(){
        if(IS_GET){
            $data = $this->Tmodel->getAllByPage('feetype',"",$this->pagesize);
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

    public function feetype_add(){
        if(IS_GET){
            $this->display('feetypeadd');
        }else{
            $data['feetpname'] = I('post.feetpname');
            $rs = M('feetype')->add($data);
            if($rs){
                $this->success("添加成功！",U('feetype'));
            }else{
                $this->error("添加失败请联系管理员",U('feetype'));
            }
        }
    }

    public function feeEdit(){
        if(IS_GET){
            $id = I('get.id');
            $data = M('feetype')->where("id = $id")->find();
            $this->assign('data',$data);
            $this->assign('id',$id);
            $this->display();
        }else{
            $data['feetpname'] = I('post.feetpname');
            $id = I('post.id');
            $res = M('feetype')->where("id = $id")->save($data);
            if($res){
                $this->success("修改成功",U('feetype'));
            }else{
                $this->error("修改失败",U('feetype'));
            }
        }

    }

    public function confirm(){
        if(IS_GET){
            $where = "a.bstatus = 3";
            $on = "a.pid = b.id";
            $field = " a.* , b.pname";
            $order = "a.id desc";
            $data = $this->Tmodel->getCommonList('reimburse_record', 'project', $on, $where, $field, $order, $this->pagesize);
            foreach($data['list'] as $k => $v){
                $data['list'][$k]['uname'] = M('user')->where("id = {$v['uid']}")->getField('username');
                if($data['list'][$k]['cid']){
                    $data['list'][$k]['scno'] = M('contract')->where("id = {$v['cid']}")->getField('cno');
                }
                if($data['list'][$k]['cgid']){
                    $data['list'][$k]['cgcno'] = M('contract')->where("id = {$v['cgid']}")->getField('cno');
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
            $this->assign('checklev',3);
            $this->display();
        }else{
            $type = I('post.type');
            $id = I('post.id');
            if($type == 'pas'){
                $bsmid = I('post.bsmid');
                $etype1 = I('post.fcate');
                $etype2 = I('post.scate');
                $eattr = I('post.feetype');
                $pway = I('post.payway');
                $remark = I('post.remark');
                $ck = I('post.cktotal');
                $res = 1;
                foreach($bsmid as $k => $v){
                    $dat = [
                        'etype1' => $etype1[$k],
                        'etype2' => $etype2[$k],
                        'eattr'  => $eattr[$k],
                        'pway'  => $pway[$k],
                        'cktotal'=>$ck[$k],
                    ];
                    $rs = M('reimbursement')->where("id = $v")->save($dat);
                    if(!$rs){
                        $res  = 0;
                    }
                }
                $rst = M('reimburse_record')->where("id = $id")->save(['bstatus'=>4,'confirmid'=>session('uid')]);
                $rsd = 1;
                if($remark){
                    $datag['msg'] = $remark;
                    $datag['fid'] = $id;
                    $datag['mtype'] = 'reimburse';
                    $datag['uid'] = session('uid');
                    $datag['uname'] = session('uinfo')['username'];
                    $datag['ctime'] = time();
                    $datag['mattr'] = 1;
                    $rsd = M('message')->add($datag);
                    if($rsd){

                    }else{
                        dump($datag);
                        exit;
                    }
                }

                if($res && $rst && $rsd){
                    $this->success('通过成功！',U('confirm'));
                }else{
                    $this->error('通过失败，请联系管理员！',U('confirm'));
                }
            }else{
                $data['msg'] = I('post.msg','','trim');
                $rs = 1;
                $data['fid'] = $id;
                if(!$data['msg']) goto wul;
                $data['mtype'] = 'reimburse';
                $data['uid'] = session('uid');
                $data['uname'] = session('uinfo')['username'];
                $data['ctime'] = time();
                $data['mattr'] = 0;
                $rs = M('message')->add($data);
                wul:
                $res =  M('reimburse_record')->where("id = {$data['fid']}")->save(['bstatus'=>'0']);
                if($rs && $res){
                    $this->success("驳回成功",U('confirm'));
                }else{
                    $this->error("驳回失败，请联系管理员",U('confirm'));
                }
            }
        }

    }

    public function reconfirm(){
        $uid = session('uid');
        $where = "a.bstatus = 4";
        $on = "a.pid = b.id";
        $field = " a.* , b.pname";
        $order = "a.id desc";
        $data = $this->Tmodel->getCommonList('reimburse_record', 'project', $on, $where, $field, $order, $this->pagesize);
        foreach($data['list'] as $k => $v){
            $data['list'][$k]['uname'] = M('user')->where("id = {$v['uid']}")->getField('username');
            if($data['list'][$k]['cid']){
                $data['list'][$k]['scno'] = M('contract')->where("id = {$v['cid']}")->getField('cno');
            }
            if($data['list'][$k]['cgid']){
                $data['list'][$k]['cgcno'] = M('contract')->where("id = {$v['cgid']}")->getField('cno');
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
        $this->assign('checklev',4);
        $this->display('reconfirm');
    }
    public function reconfirmdetail(){
        if(IS_GET){
            $checklev = I('get.checklev');
            $id = I('get.id');
            $data = M("reimburse_record")->join("a left join project b on a.pid = b.id")->field('a.*,b.pname')->where("a.id = $id")->find();
            $scon = [];
            $cgcon = [];
            if($data['cid']){
                $scon = M('contract')->where("id = {$data['cid']}")->find();
            }
            if($data['cgid']){
                $cgcon = M('contract')->where("id = {$data['cgid']}")->find();
            }
            $pics = M('files')->where("type = 'reimburse' and sid = $id")->select();
            $reimbursment = M('reimbursement')->where("sid = $id")->select();
            foreach($reimbursment as $k => $v){
                $reimbursment[$k]['kemu1'] = M('catelog')->where("id = {$v['etype1']}")->getField('cgname');
                $reimbursment[$k]['kemu2'] = M('catelog')->where("id = {$v['etype2']}")->getField('cgname');
                if($v['pway'] == 0){
                    $reimbursment[$k]['payway'] = '现金';
                }elseif($v['pway'] != null){
                    $reimbursment[$k]['payway'] = M('bank')->where("id = {$v['pway']}")->getField('bankno');
                }else{
                    $reimbursment[$k]['payway'] = '';
                }
                $reimbursment[$k]['fee'] = M('feetype')->where("id = {$v['eattr']}")->getField('feetpname');
            }
            $this->assign('reimbursement',$reimbursment);
            $this->assign('pics',$pics);
            $this->assign('scon',$scon);
            $this->assign('cgcon',$cgcon);
            $this->assign('data',$data);
            $this->assign('checklev',$checklev);
            $this->assign('id',$id);
            if($checklev == 4 or $checklev == 5 or $checklev == 6){
                $fk = M('catelog')->where("ctype = 1")->select();
                $sk = M('catelog')->where("ctype = 2")->select();
                $fee = M('feetype')->select();
                $banks = M('bank')->where("status = '1'")->select();
                $this->assign('banks',$banks);
                $this->assign('fk',$fk);
                $this->assign('sk',$sk);
                $this->assign('fee',$fee);
                $this->display('reconfirmdetail');
            }
        }else{
            $type = I('post.type');
            $sid = I('post.id');
            if($type == 'pas'){
                $checklev = I('post.checklev');
                $recheckuid = I('post.recheckuid');
                $data['msg'] = I('post.msg','','trim');
                $rs = 1;
                if(!$data['msg']) goto wu;
                $data['fid'] = $sid;
                $data['mtype'] = 'reimburse';
                $data['uid'] = session('uid');
                $data['uname'] = session('uinfo')['username'];
                $data['mattr'] = 1;
                $data['ctime'] = time();
                $rs = M('message')->add($data);
                wu:
                if($checklev == 5){
                    if(I('post.isceo') == 1){
                        $rst = M('reimburse_record')->where("id = $sid")->save(['bstatus'=>6,'agconfirmid'=>session('uid')]);
                    }else{
                        $rst = M('reimburse_record')->where("id = $sid")->save(['bstatus'=>7,'agconfirmid'=>session('uid')]);
                    }
                }elseif($checklev == 4){
                    $rst = M('reimburse_record')->where("id = $sid")->save(['bstatus'=>$checklev+1,'reconfirmid'=>session('uid')]);
                }elseif($checklev == 6){
                    $rst = M('reimburse_record')->where("id = $sid")->save(['bstatus'=>$checklev+1,'lastconfirm'=>session('uid')]);
                }
                if($rs && $rst){
                    if($checklev == 4){
                        $this->success("审核通过",U('reconfirm'));
                    }elseif($checklev == 5){
                        $this->success("审核通过",U('agconfirm'));
                    }elseif($checklev == 6){
                        $this->success("审核通过",U('lastconfirm'));
                    }
                }else{
                    $this->error("通过失败");
                }
            }else{
                $data['msg'] = I('post.msg','','trim');
                $rs = 1;
                $data['fid'] = $sid;
                if(!$data['msg']) goto wul;
                $data['mtype'] = 'reimburse';
                $data['uid'] = session('uid');
                $data['uname'] = session('uinfo')['username'];
                $data['ctime'] = time();
                $data['mattr'] = 0;
                $rs = M('message')->add($data);
                wul:
                $whichto = I('post.whichto');
                if($whichto == 1){
                    $res =  M('reimburse_record')->where("id = {$data['fid']}")->save(['bstatus'=>'3']);
                }else{
                    $res =  M('reimburse_record')->where("id = {$data['fid']}")->save(['bstatus'=>'0']);
                }


                if($rs && $res){
                    $this->success("驳回成功",U('reimburse/reconfirm'));
                }else{
                    $this->error("驳回失败，请联系管理员",U('reimburse/reconfirm'));
                }
            }
        }
    }

    public function agconfirm(){
        if(IS_GET){
            $uid = session('uid');
            $where = "a.bstatus = 5";
            $on = "a.pid = b.id";
            $field = " a.* , b.pname";
            $order = "a.id desc";
            $data = $this->Tmodel->getCommonList('reimburse_record', 'project', $on, $where, $field, $order, $this->pagesize);
            foreach($data['list'] as $k => $v){
                $data['list'][$k]['uname'] = M('user')->where("id = {$v['uid']}")->getField('username');
                if($data['list'][$k]['cid']){
                    $data['list'][$k]['scno'] = M('contract')->where("id = {$v['cid']}")->getField('cno');
                }
                if($data['list'][$k]['cgid']){
                    $data['list'][$k]['cgcno'] = M('contract')->where("id = {$v['cgid']}")->getField('cno');
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
            $this->assign('checklev',5);
            $this->display('agconfirm');
        }else{

        }
    }

    public function lastconfirm(){
        $uid = session('uid');
        $where = "a.bstatus = 6";
        $on = "a.pid = b.id";
        $field = " a.* , b.pname";
        $order = "a.id desc";
        $data = $this->Tmodel->getCommonList('reimburse_record', 'project', $on, $where, $field, $order, $this->pagesize);
        foreach($data['list'] as $k => $v){
            $data['list'][$k]['uname'] = M('user')->where("id = {$v['uid']}")->getField('username');
            if($data['list'][$k]['cid']){
                $data['list'][$k]['scno'] = M('contract')->where("id = {$v['cid']}")->getField('cno');
            }
            if($data['list'][$k]['cgid']){
                $data['list'][$k]['cgcno'] = M('contract')->where("id = {$v['cgid']}")->getField('cno');
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
        $this->assign('checklev',6);
        $this->display('lastconfirm');
    }

    public function getAlist(){
        $auid = I('get.auid');
        $kw = I('get.keyword');
        $danno = I('get.danno');
        $this->alist($auid,$kw,$danno);
    }

    public function alist($auid=0,$kw='',$danno=''){
        $where = [];
        if($auid){
            $where[] = " a.uid = $auid ";
        }
        if($kw){
            $pids = M('project')->where("pname like '%{$kw}%'")->field('id')->select();
            if($pids){
                foreach($pids as $v){
                    $idstr .= $v['id'].',';
                }
                $idstr = trim($idstr,',');
                $where[] = " a.pid in ($idstr) ";
            }

        }
        if($danno){
            $where[] = " a.rbno = '{$danno}'";
        }
        if(!empty($where)){
            $where = implode(' or ',$where);
            goto zgs;
        }
        $uid = session('uid');
        if(in_array(1,session('rid'))) goto zgs;
        $where = " a.checkuid = {$uid} or a.recheckuid = {$uid} or a.confirmid = {$uid} or a.reconfirmid = {$uid} or a.agconfirmid = {$uid} or a.lastconfirm = {$uid} or a.uid = {$uid} ";
        zgs:

        $on = "a.pid = b.id";
        $field = " a.* , b.pname";
        $order = "a.id desc";
        $data = $this->Tmodel->getCommonList('reimburse_record', 'project', $on, $where, $field, $order, $this->pagesize);
        foreach($data['list'] as $k => $v){
            $data['list'][$k]['uname'] = getUserName($v['uid']);
            $data['list'][$k]['checkuname'] = getUserName($v['checkuid']);
            $data['list'][$k]['recheckuname'] = $v['recheckuid']?getUserName($v['recheckuid']):'';
            $data['list'][$k]['confirmuname'] = $v['confirmid']?getUserName($v['confirmid']):'';
            $data['list'][$k]['reconfirmuname'] = $v['reconfirmid']?getUserName($v['reconfirmid']):'';
            $data['list'][$k]['agconfirmuname'] = $v['agconfirmid']?getUserName($v['agconfirmid']):'';
            $data['list'][$k]['lastconfirmuname'] = $v['lastconfirm']?getUserName($v['lastconfirm']):'';
            if($data['list'][$k]['cid']){
                $data['list'][$k]['scno'] = M('contract')->where("id = {$v['cid']}")->getField('cno');
            }
            if($data['list'][$k]['cgid']){
                $data['list'][$k]['cgcno'] = M('contract')->where("id = {$v['cgid']}")->getField('cno');
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
        $users = getAllUsers();
        $this->assign('users',$users);
        $this->display('alist');
        exit;
    }

    public function deal(){
        if(IS_GET){
            $uid = session('uid');
            $where = "a.bstatus = 7";
            $on = "a.pid = b.id";
            $field = " a.* , b.pname";
            $order = "a.id desc";
            $data = $this->Tmodel->getCommonList('reimburse_record', 'project', $on, $where, $field, $order, $this->pagesize);
            foreach($data['list'] as $k => $v){
                $data['list'][$k]['uname'] = M('user')->where("id = {$v['uid']}")->getField('username');
                if($data['list'][$k]['cid']){
                    $data['list'][$k]['scno'] = M('contract')->where("id = {$v['cid']}")->getField('cno');
                }
                if($data['list'][$k]['cgid']){
                    $data['list'][$k]['cgcno'] = M('contract')->where("id = {$v['cgid']}")->getField('cno');
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
        }else{

        }

    }

    public function todeal(){
        if(IS_GET){
            $id = I('get.id');
            $data = M("reimburse_record")->join("a left join project b on a.pid = b.id")->field('a.*,b.pname')->where("a.id = $id")->find();
            $scon = [];
            $cgcon = [];
            if($data['cid']){
                $scon = M('contract')->where("id = {$data['cid']}")->find();
            }
            if($data['cgid']){
                $cgcon = M('contract')->where("id = {$data['cgid']}")->find();
            }
            $pics = M('files')->where("type = 'reimburse' and sid = $id")->select();
            $reimbursment = M('reimbursement')->where("sid = $id")->select();
            foreach($reimbursment as $k => $v){
                $reimbursment[$k]['kemu1'] = M('catelog')->where("id = {$v['etype1']}")->getField('cgname');
                $reimbursment[$k]['kemu2'] = M('catelog')->where("id = {$v['etype2']}")->getField('cgname');
                if($v['pway'] == 0){
                    $reimbursment[$k]['payway'] = '现金';
                }elseif($v['pway'] != null){
                    $reimbursment[$k]['payway'] = M('bank')->where("id = {$v['pway']}")->getField('bankno');
                }else{
                    $reimbursment[$k]['payway'] = '';
                }
                $reimbursment[$k]['fee'] = M('feetype')->where("id = {$v['eattr']}")->getField('feetpname');
            }
            $this->assign('reimbursement',$reimbursment);
            $this->assign('pics',$pics);
            $this->assign('scon',$scon);
            $this->assign('cgcon',$cgcon);
            $this->assign('data',$data);
            $this->assign('checklev',$checklev);
            $this->assign('id',$id);
            $this->display();
        }else{
            $Model = new \Think\Model();
            $id = I('post.id');
            $bsid = I('post.bsid');
            $ptime = I('post.ptime');
            $pway = I('post.pway');
            $atotal = I('post.atotal');
            //$ck = I('post.cktotal');
            $rs = 1;
            foreach($bsid as $k => $v){
                $rst = M('reimbursement')->where("id = $v")->save(['ptime'=>$ptime[$k]]);
                if($pway[$k] != 0){
                    $res = $Model->execute("update bank set total = total - '{$atotal[$k]}' where id='{$pway[$k]}'");
                    if(!$res) $rs = 0;
                }
                if(!$rst) $rs = 0;
            }
            $res = M('reimburse_record')->where("id = $id")->save(['bstatus'=>8]);
            $pics = I("post.pic");
            if($pics && !empty($pics)){
                foreach($pics as $vp){
                    $vparr[] = ['type'=>'reimburse_pay','path'=>$vp,'sid'=>$id,'uid'=>session('uid')];
                }
                M('files')->addAll($vparr);
            }
            if($rs && $res){
                $this->success("确认通过",U('deal'));
            }else{
                $this->error("确认失败",U('deal'));
            }

        }
    }

    public function reimburse_edit(){
        if(IS_GET){
            $id = I('get.id');
            $rbtype = I('get.rbtype');
            $pro = M('project')->where("status = '1'")->select();
            $data = M('reimburse_record')->where("id = $id")->find();
            $cusers = M('role_user')->join(" a left join user b on a.uid = b.id ")->where("a.rid = 3")->field('a.rid,b.*')->select();
            $cgc = M('contract')->where("pid = {$data['pid']} and kinds = 1")->select();
            $slc = M('contract')->where("pid = {$data['pid']} and kinds = 0")->select();
            $reimdata = M('reimbursement')->where("sid = $id")->select();
            $pics = M('files')->where("type = 'reimburse' and sid = $id")->select();
            $errmsg = M("message")->where("mtype = 'reimburse' and fid = $id and mattr = 0")->select();
            $this->assign('errmsg',$errmsg);
            $this->assign('rbtype',$rbtype);
            $this->assign('pics',$pics);
            $this->assign('reimdata',$reimdata);
            $this->assign('cgc',$cgc);
            $this->assign('slc',$slc);
            $this->assign('pro',$pro);
            $this->assign('data',$data);
            $this->assign('cusers',$cusers);
            $this->assign('id',$id);
            $this->display();
        }else{
            $data["pid"]        = I('post.pid');
            $data["checkuid"]   = I('post.checkuid');
            $data["cid"]        = I('post.cid');
            $data["cgid"]       = I('post.cgid');
            $data["remark"]     = I('post.remark');
            $data['bstatus']    = 1;
            $id = I('post.id');
            $rbid = I('post.rbid');
            $rbno = I('post.rbno');
            $pic = I('post.pic');
            M("reimburse_record")->where("id = $id")->save($data);
            M("reimbursement")->where("sid = {$id}")->delete();
            $ab = I("post.ab");
            $etime = I('post.etime');
            $atotal = I('post.atotal',[]);
            $etotal = I('post.etotal',[]);
            foreach($ab as $k=>$v){
                $dat[] = [
                    'ab'    => $v,
                    'etime' => $etime[$k],
                    'etotal'=> isset($etotal[$k])?$etotal[$k]:0,
                    'atotal'=> $atotal[$k],
                    'sid'   => $id,
                    'rbid'  => $rbid,
                    'rbno'  => $rbno,
                    'uid'   => session('uid'),
                ];
            }
            M('reimbursement')->addAll($dat);
            M('files')->where("type='reimburse' and sid = $id")->delete();
            foreach($pic as $index => $pl){
                $dt[] = [
                    'type'  => 'reimburse',
                    'sid'   => $id,
                    'path'  => $pl,
                    'uid'   => session('uid'),
                ];
            }
            M('files')->addAll($dt);
            $this->success('提交成功',U('alist'));
        }

    }

    public function reimburse_detail(){
        $rbid = I('get.id');
        $reim = M('reimburse_record')->join("a left join project b on a.pid = b.id")->where("a.rbid = $rbid")->field('a.*,b.pname')->select();
        $arr = [];
        foreach($reim as $vl){
            $res = M('reimbursement')->where("sid = {$vl['id']}")->select();
            $cgcon = '';
            if($vl['cgid']) $cgcon = M('contract')->where("id = {$vl['cgid']}")->find();
            $scon = '';
            if($vl['cid']) $scon = M('contract')->where("id = {$vl['cid']}")->find();
            foreach($res as $key => $v){
                $res[$key]['cgcon'] = $cgcon['cno'];
                $res[$key]['scon'] = $scon['cno'];
                $res[$key]['remark'] = $vl['remark'];
                $res[$key]['pname'] = $vl['pname'];
            }
            $arr = array_merge($arr,$res);
        }
        $this->assign('data',$arr);
        $this->display();

    }

}
<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\TmodelModel;
class AchievementController extends Controller {

	public $Tmodel=null;
	public $pagesize = 10;
	public $rid;
	public function _initialize(){
		$this->Tmodel = new TmodelModel();
		$this->rid = session('rid');
		is_login();
	}
	public function index(){
		$month = I('get.month',date('n'));
		$model = M('achieve_info');
		$mc = $this->getMonthWeekC(time());
		
		$where = array();
		$where['month'] = array("elt",$month);
		 $where['monthc'] = array('elt',$mc);
		$info = $model->where($where)
				->join('achieve on achieve_info.pid = achieve.id')
				->order('achieve_info.monthc desc,achieve_info.hj desc,id asc')
				->select();
		$data = array();
		foreach ($info as $key=>$val){
			
			$data[$val['product']][$val['time']]=$val;
			 
		}
		$this->assign('month',$month);
		$this->assign('data',$data);
		
		$this->display();
	}
    public static function array_group_by($arr, $key)
    {
        $grouped = [];
        foreach ($arr as $value) {
            $grouped[$value[$key]][] = $value;
        }
        if (func_num_args() > 2) {
            $args = func_get_args();
            foreach ($grouped as $key => $value) {
                $parms = array_merge([$value], array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('array_group_by', $parms);
            }
        }
        return $grouped;
    }
    public function new_index(){
	    if(IS_POST){
            $month = I('get.month',date('n'));
            $model = M('achieve_info');
            $mc = $this->getMonthWeekC(time());

            $where = array();
            $where['month'] = array("elt",$month);
            $where['monthc'] = array('elt',$mc);
            $info = $model->where($where)
                ->join('achieve on achieve_info.pid = achieve.id')
                ->order('achieve_info.monthc desc,achieve_info.hj desc,id asc')
                ->select();
            foreach ($info as $k =>$v){
                if(!$v['task']){
                    $info[$k]['task']=0;
                }
            }

            $arr=$this->array_group_by($info,'time');
            echo json_encode($arr,true);die;
        }else{
            $this->display();
        }
       /* $month = I('get.month',date('n'));
        $model = M('achieve_info');
        $mc = $this->getMonthWeekC(time());

        $where = array();
        $where['month'] = array("elt",$month);
        $where['monthc'] = array('elt',$mc);
        $info = $model->where($where)
            ->join('achieve on achieve_info.pid = achieve.id')
            ->order('achieve_info.monthc desc,achieve_info.hj desc,id asc')
            ->select();
        $arr=$this->array_group_by($info,'time');

        $data = array();
        foreach ($info as $key=>$val){

            $data[$val['product']][$val['time']]=$val;

        }
        $this->assign('info',$arr['3月第1周2018-03-01~2018-03-07']);
        $this->assign('month',$month);
        $this->assign('data',$data);*/


    }
	public function add(){
        
//		$month = I('get.month',date('n'));
		$month = date('n');
		$model = M('achieve_info');
		$where = array();
		$where['month'] = array("eq",$month);
		if(!in_array('1',$this->rid)){
			$where['achieve.uid'] = session('uid');
		}
		$info = $model->where($where)
				->join('achieve on achieve_info.pid = achieve.id')->select();
		
		$data = array();
		foreach ($info as $key=>$val){
			 
			$data[$val['product']][$val['time']]=$val;
			 
		}
			
		$this->assign('month',$month);
		$this->assign('data',$data);
		
		$this->display();
	}
	public function getMonthweeks($date){
		$ret = array();
		$stimestamp =strtotime($date);
		$mdays =date('t',$stimestamp);
		$msdate=date('Y-m-d',$stimestamp);
		$medate=date('Y-m-'.$mdays,$stimestamp);
		$etimestamp = strtotime($medate);
		$zcsy= 6-date('w',$stimestamp);
		$zcs1=$msdate;
		$zce1=date('Y-m-d',strtotime("+$zcsy day",$stimestamp));
		$ret[1]="第1周".$zcs1.'~'.$zce1;
		$jzc=0;
		$jzc0="";
		$jzc6="";
		for($i=$stimestamp; $i<=$etimestamp; $i+=86400){
			if(date('w', $i) == 0){$jzc0++;}
			if(date('w', $i) == 6){$jzc6++;}
		}
		if($jzc0==5 && $jzc6==5)
		{
			$jzc=5;
		}else{
			$jzc=4;
		}
		date_default_timezone_set('PRC');
		$t = strtotime('+1 monday '.$msdate);
		$n = 1;
		for($n=1; $n<$jzc; $n++) {
			$b = strtotime("+$n week -1 week", $t);
			$dsdate=date("Y-m-d", strtotime("-1 day", $b));
			$dedate=date("Y-m-d", strtotime("5 day", $b));
			$jzcz=$n+1;
			$ret[$jzcz]="第".$jzcz."周".$dsdate.'~'.$dedate;
		}

		$zcsy=date('w',$etimestamp);//最後一周是周幾日~六 0~6
		$zcs1=date('Y-m-d',strtotime("-$zcsy day",$etimestamp));
		$zce1=$medate;
		$jzcz=$jzc+1;
		$ret[$jzcz]="第".$jzcz."周".$zcs1.'~'.$zce1;
		return $ret;
	}
	public function getMonthweek($date){
		$ret = array();
		$stimestamp =strtotime($date);
		$mdays =date('t',$stimestamp);
		
		for ($i=0;$i<4;$i++){
			$msdate = date('Y-m-d',strtotime(($i*7)." day",$stimestamp));
			if($i==3){
				$medate = date('Y-m-d',strtotime((6+$mdays%7)." day",strtotime($msdate)));
			}else{
				$medate = date('Y-m-d',strtotime("6 day",strtotime($msdate)));	
			}
			$ret[] = "第".($i+1)."周".$msdate."~".$medate;
			 
		}
		 return $ret;
	}
	public function getMonthWeekC($time){
		 
		$day = intval(date('d',$time));
		$m = intval(date('m',$time));
		
		$r = (ceil($day/7)>4?4:ceil($day/7))+($m-1)*4;
		 return $r;
	}
	public function initdata(){
	die;
		$model = M('achieve');
		$info = $model->select();
		$model1 = M('achieve_info');
		for ($i=1;$i<=12;$i++){
			$times = $this->getMonthweek("2018-{$i}-01");
			 
			foreach ($info as $key=>$val){
				foreach ($times as $k=>$v){
					$data = array();
					$data['uid'] = $val['uid'];
					$data['pid'] = $val['id'];
					$data['month'] = $i;
					$data['time'] = $i.'月'.$v;
					$data['monthc'] = intval($k+1+($i-1)*4);
					$model1->add($data);
					$c++;
				}
			}

		}
	}
	public function up(){
		$data = I('post.data');
		$model = M('achieve_info');
		foreach ($data as $key=>$val){
			$m = array();
			$m[$val['type']] = $val['value'];
			$where = array();
			$where['fid'] = $val['id'];
			$model->where($where)->save($m);
			 
		}
		echo json_encode(array('code'=>200));
	}
}
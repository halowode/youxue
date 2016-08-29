<?php
namespace Home\Model;

class SubscribeModel extends \Think\Model {
	
	public function getSubscribes($where, $pagesize){
		$subscribe = M('Subscribe');
		$count = $subscribe->join("a left join mcp_package b on a.pid=b.pid")->where($where)->count('a.sid');// 查询满足要求的总记录数
		$Page  = new \Think\Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$data['list']  = $subscribe->join("a left join mcp_package b on a.pid=b.pid")->limit($Page->firstRow.','.$Page->listRows)->where($where)->field("a.* , b.title")->order("a.ctime desc")->select();
        $muser = M('mguser');
        foreach($data['list'] as $k => $v){
            $data['list'][$k]['uname'] = $muser->where('id = '.$v['ismg'])->getField('uname');
        }
        $Page->setConfig('first','首页');
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$Page->setConfig('last','尾页');
		$Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>&nbsp;&nbsp;共 %TOTAL_ROW% 条记录</span>');
		$data['show']  = $Page->show();// 分页显示输出
		return $data;
	}//得到订阅列表

    public function getBlist($where, $pagesize){
        $subscribe = M('blist');
        $count = $subscribe->where($where)->count('id');// 查询满足要求的总记录数
        $Page  = new \Think\Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数(20)
        $data['list']  = $subscribe->limit($Page->firstRow.','.$Page->listRows)->where($where)->order("ctime desc")->select();
        $Page->setConfig('first','首页');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','尾页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>&nbsp;&nbsp;共 %TOTAL_ROW% 条记录</span>');
        $data['show']  = $Page->show();// 分页显示输出
        return $data;
    }//得到黑名单

    /**
     * 得到地区分页列表
     */
    public function getDict($where, $pagesize){
        $subscribe = M('mgcity');
        $count = $subscribe->where($where)->count('id');// 查询满足要求的总记录数
        $Page  = new \Think\Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数(20)
        $data['list']  = $subscribe->limit($Page->firstRow.','.$Page->listRows)->where($where)->select();
        $Page->setConfig('first','首页');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','尾页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>&nbsp;&nbsp;共 %TOTAL_ROW% 条记录</span>');
        $data['show']  = $Page->show();// 分页显示输出
        return $data;
    }
	
	public function getSubscribeRecord($where , $pagesize){
		$subscribe_record = M('Subscribe_record');
		$count = $subscribe_record->join("a left join mcp_package b on a.pid=b.pid")->where($where)->count('a.id');// 查询满足要求的总记录数
		$Page  = new \Think\Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数(20)
		$data['list']  = $subscribe_record->join("a left join mcp_package b on a.pid=b.pid")->limit($Page->firstRow.','.$Page->listRows)->where($where)->field("a.* , b.title")->order("a.ctime desc")->select();
		$Page->setConfig('first','首页');
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$Page->setConfig('last','尾页');
		$Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>&nbsp;&nbsp;共 %TOTAL_ROW% 条记录</span>');
		$data['show']  = $Page->show();// 分页显示输出
		return $data;
	}//得到订阅日志列表
}
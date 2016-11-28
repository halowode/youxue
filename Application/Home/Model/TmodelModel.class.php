<?php
namespace Home\Model;

class TmodelModel extends \Think\Model {
    protected $tableName = 'contract';

    public function getJoinByPage($table,$table2,$where, $pagesize){
        $subscribe = M($table);
        $count = $subscribe->join("a left join {$table2} b on a.pid=b.id")->where($where)->count();
        $Page  = new \Think\Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数(20)
        $data['list']  = $subscribe->join("a left join {$table2} b on a.pid=b.id")->field("a.*,b.pname")->limit($Page->firstRow.','.$Page->listRows)->where($where)->order("a.id desc")->select();
        $Page->setConfig('first','首页');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','尾页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>&nbsp;&nbsp;共 %TOTAL_ROW% 条记录</span>');
        $data['show']  = $Page->show();// 分页显示输出
        return $data;
    }
    public function getJoinByPagest($table,$table2,$where, $pagesize){
        $subscribe = M($table);
        $count = $subscribe->join("a left join {$table2} b on a.id=b.cid")->where($where)->count();
        $Page  = new \Think\Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数(20)
        $data['list']  = $subscribe->join("a left join {$table2} b on a.id=b.cid")->field("a.*,b.stime")->limit($Page->firstRow.','.$Page->listRows)->where($where)->order("a.id desc")->select();
        $Page->setConfig('first','首页');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','尾页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>&nbsp;&nbsp;共 %TOTAL_ROW% 条记录</span>');
        $data['show']  = $Page->show();// 分页显示输出
        return $data;
    }
    public function getAllByPage($table,$where, $pagesize){
        $subscribe = M($table);
        $count = $subscribe->where($where)->count();// 查询满足要求的总记录数
        $Page  = new \Think\Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数(20)
        $data['list']  = $subscribe->where($where)->limit($Page->firstRow.','.$Page->listRows)->order("id desc")->select();
        $Page->setConfig('first','首页');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','尾页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>&nbsp;&nbsp;共 %TOTAL_ROW% 条记录</span>');
        $data['show']  = $Page->show();// 分页显示输出
        return $data;
    }

    /**
     * @param string $table
     * @param string $table2
     * @param string $on
     * @param string $where
     * @param string $field
     * @prarm string $order
     * @param int $pagesize
     * 公共的分页方法
     */
    public function getCommonList($table='',$table2='',$on='',$where='',$field='',$order='',$pagesize=0){
        $subscribe = M($table);
        $count = $subscribe->join("a left join {$table2} b on {$on}")->where($where)->count();
        $Page  = new \Think\Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数(20)
        $data['list']  = $subscribe->join("a left join {$table2} b on {$on}")->field($field)->limit($Page->firstRow.','.$Page->listRows)->where($where)->order($order)->select();
        $Page->setConfig('first','首页');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','尾页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>&nbsp;&nbsp;共 %TOTAL_ROW% 条记录</span>');
        $data['show']  = $Page->show();// 分页显示输出
        return $data;
    }
    public function getCommonListct($table='',$table2='',$on='',$where='',$field='',$order='',$pagesize=0){
        $subscribe = M($table);
        $count = $subscribe->join("a left join {$table2} b on {$on}")->where($where)->group('a.bluid')->select();
        $count = count($count);
        $Page  = new \Think\Page($count,$pagesize);// 实例化分页类 传入总记录数和每页显示的记录数(20)
        $data['list']  = $subscribe->join("a left join {$table2} b on {$on}")->field($field)->limit($Page->firstRow.','.$Page->listRows)->where($where)->group('a.bluid')->order($order)->select();
        $Page->setConfig('first','首页');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','尾页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>&nbsp;&nbsp;共 %TOTAL_ROW% 条记录</span>');
        $data['show']  = $Page->show();// 分页显示输出
        return $data;
    }

}
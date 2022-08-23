<?php
namespace app\kpsys\controller;

use app\kpsys\model\rizhi2013_admin;
use app\kpsys\model\rizhi2013_dept;
use app\kpsys\model\rizhi2013x;
use app\kpsys\validate\rizhi2013_admin as ValidateRizhi2013_admin;
use think\App;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\View;

class Index extends Base{
    public function index(){
        return View::fetch();
    }

    /**
     * 主界面iframe的初始欢迎界面
     * @access public
     * @return View
     */
    public function welcome(){
        return View::fetch();
    }

    public function timeline(){
        // 获取日期，并且把日期搞成yyyy-mm-dd格式
        $date = date('Y-m-d', strtotime(input('post.date')));
        
        // 获取所有需要的数据，然后组装成需要assign给volist的数组
        $memberList = rizhi2013_admin::whereNotIn('department', '99, 100')->field('id, username, department')->select();
        $deptList = rizhi2013_dept::column('deptid, deptname', 'deptid');
        $kaopingList = rizhi2013x::where('time', $date)->select();

        $dateList['date'] = $date;
        $dateList['dateKaopingCounts'] = 0;
        $dateList['departments'] = $deptList;
        foreach ($dateList['departments'] as $key => &$department) {
            $department['deptKaopingCounts'] = 0;
            $department['memberList'] = $memberList->where('department', $department['deptid'])->toArray();
            foreach($department['memberList'] as &$member){
                $member['kaopingList'] = $kaopingList->where('mid', $member['id'])->where('did', $member['department'])->toArray();
                $member['memberKaopingCounts'] = count($member['kaopingList']);
                $department['deptKaopingCounts'] += $member['memberKaopingCounts'];
            }
            $dateList['dateKaopingCounts'] += $department['deptKaopingCounts'];
        }

        // 配置模板
        View::assign([
            'dateList' => $dateList,
        ]);
        return json([
            'template' => View::fetch(),
            'date' => $date
        ]);
    }
}
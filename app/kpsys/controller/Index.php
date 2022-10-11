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
use think\facade\Session;

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
        // 要根据用户权限来分配不同的页面。(实践证明再这里搞，比在前端用php搞好多了)
        $user_departmentId = Session::get('userDept_id');
        $user_departent = rizhi2013_dept::where('deptid', $user_departmentId)->field('deptid, deptname')->find();
        View::assign([
            'userDept' => $user_departent
        ]);
        switch (Session::get('user_type')) {
            case 1:
                return View::fetch('welcome_type1');
                break;

            case 2:
                return View::fetch('welcome_type2');
                break;

            case 6:
                return View::fetch('welcome_type2');
                break;

            case 8:
                $departmentList = rizhi2013_dept::column('deptid, deptname', 'deptid');
                foreach ($departmentList as $key => &$department) {
                    $department['memberList'] = rizhi2013_admin::where('department', $key)->column('id, username, department');
                }
               
                View::assign(['departmentList' => $departmentList]);
                return View::fetch('welcome_type8');
                break;
            
            default:
                return View::fetch('welcome_type1');
                break;
        }
    }

    public function timeline(){
        // 获取日期，并且把日期搞成yyyy-mm-dd格式
        $date = date('Y-m-d', strtotime(input('post.date')));
        $userDept_id = Session::get('userDept_id');
        // 获取所有需要的数据，然后组装成需要assign给volist的数组
        // $memberList = rizhi2013_admin::whereNotIn('department', '99, 100')->field('id, username, department')->select();
        // $deptList = rizhi2013_dept::column('deptid, deptname', 'deptid');
        // $kaopingList = rizhi2013x::where('time', $date)->select();

        // $dateList['date'] = $date;
        // $dateList['dateKaopingCounts'] = 0;
        // $dateList['departments'] = $deptList;
        // foreach ($dateList['departments'] as $key => &$department) {
        //     $department['deptKaopingCounts'] = 0;
        //     $department['memberList'] = $memberList->where('department', $department['deptid'])->toArray();
        //     foreach($department['memberList'] as &$member){
        //         $member['kaopingList'] = $kaopingList->where('mid', $member['id'])->where('did', $member['department'])->toArray();
        //         $member['memberKaopingCounts'] = count($member['kaopingList']);
        //         $department['deptKaopingCounts'] += $member['memberKaopingCounts'];
        //     }
        //     $dateList['dateKaopingCounts'] += $department['deptKaopingCounts'];
        // }

        // 配置模板
        // View::assign([
        //     'dateList' => $dateList,
        // ]);
        switch (Session::get('user_type')) {
            case 1:
                // 获取所有需要的数据，然后组装成需要assign给volist的数组
                $memberList = rizhi2013_admin::where('department', $userDept_id)->field('id, username, department')->select();
                $deptList = rizhi2013_dept::where('deptid', $userDept_id)->column('deptid, deptname', 'deptid');
                $kaopingList = rizhi2013x::where('time', $date)->where('did', $userDept_id)->order('id', 'desc')->select();

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

                View::assign([
                    'dateList' => $dateList,
                ]);
                return json([
                    'template' => View::fetch('timeline_type1'),
                    'date' => $date
                ]);
                break;

            case 2:
                // 获取所有需要的数据，然后组装成需要assign给volist的数组
                $memberList = rizhi2013_admin::where('department', $userDept_id)->field('id, username, department')->select();
                $deptList = rizhi2013_dept::where('deptid', $userDept_id)->column('deptid, deptname', 'deptid');
                $kaopingList = rizhi2013x::where('time', $date)->where('did', $userDept_id)->order('id', 'desc')->select();

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
                
                View::assign([
                    'dateList' => $dateList,
                ]);
                return json([
                    'template' => View::fetch('timeline_type2'),
                    'date' => $date
                ]);
                break;

            case 6:
                return json([
                    'template' => View::fetch('timeline_type6'),
                    'date' => $date
                ]);
                break;

            case 8:
                $dateList['date'] = $date;
                $dateList['dateKaopingCounts'] = 0;
                $dateList['departments'] = $deptList = rizhi2013_dept::order('deptid')->column('deptid, deptname', 'deptid');

                foreach ($dateList['departments'] as $key => &$department) {
                    $department['deptKaopingCounts'] = 0;
                    $department['memberList'] = rizhi2013_admin::where('department', $key)->column('id, username, department');
                    foreach ($department['memberList'] as &$member) {
                        $member['kaopingList'] = 
                            rizhi2013x::where('time', $date)
                            ->where('mid', $member['id'])
                            ->where('did', $member['department'])
                            ->select()
                            ->toArray();
                        $member['memberKaopingCounts'] = count($member['kaopingList']);
                        $department['deptKaopingCounts'] += $member['memberKaopingCounts'];
                    }
                    $dateList['dateKaopingCounts'] += $department['deptKaopingCounts'];
                }

                //print_r($dateList);

                View::assign([
                    'dateList' => $dateList
                ]);
                return json([
                    'template' => View::fetch('timeline_type8'),
                    'date' => $date
                ]);
                break;
            
            default:
                return View::fetch('');
                break;
        }
    }
}
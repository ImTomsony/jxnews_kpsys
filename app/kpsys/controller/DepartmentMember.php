<?php
namespace app\kpsys\controller;

use app\kpsys\model\rizhi2013_admin;
use app\kpsys\model\rizhi2013_dept;
use app\kpsys\model\rizhi2013x;
use think\facade\Session;
use think\facade\View;

class DepartmentMember extends Base{
    public function index(){
        $userList = rizhi2013_admin::whereNotIn('department','0,1,99,100')->order('id')->select();
        $departmentList = rizhi2013_dept::whereNotIn('deptid','1')->order('deptid')->select()->toArray();
        
        // 给所有的部门添加好之后需要用到的属性
        foreach($departmentList as &$value){
            $value['memberCount'] = 0;
            $value['memberList'] = [];
        }
        unset($value);

        foreach ($userList as $user) {
            // 因为部门id是从2开始的，所以要减去2以便和$departmentList
            $deptid = $user['department'] - 2;
            $memberCount = &$departmentList[$deptid]['memberCount'];
            $memberCount++;

            $departmentList[$deptid]['memberList'][$memberCount]['id'] = $user['id'];
            $departmentList[$deptid]['memberList'][$memberCount]['username'] = $user['username'];
        }

        // 根据部门人数排序
        // $sort = array_column($departmentList, 'memberCount');
        // array_multisort($sort, SORT_DESC, $departmentList);

        View::assign([
            'departmentList' => $departmentList
        ]);
        return View::fetch();
    }

    /**
     * 根据传过来的员工id查询所有的考评
     * @param $mid 根据传过来的员工id
     * @return View 返回的页面，查看的mid正是自己的，就返回本人的页面(本人的页面有增删改查功能，他人的页面只有查看功能)
     */
    public function memberKaoping($mid){
        if($mid == Session::get('user_id')){
            $list = rizhi2013x::where('mid', $mid)->order('time', 'desc')->order('id','desc')->select()->toArray();
            View::assign(['list'=>$list]);
            return View::fetch('kaoping_manage/index');
        }

        $list = rizhi2013x::where('mid', $mid)->order('time', 'desc')->order('id','desc')->select()->toArray();
        View::assign(['list'=>$list]);
        return View::fetch();
    }
}
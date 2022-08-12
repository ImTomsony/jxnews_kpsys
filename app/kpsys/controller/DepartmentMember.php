<?php
namespace app\kpsys\controller;

use app\kpsys\model\rizhi2013_admin;
use app\kpsys\model\rizhi2013_dept;
use think\facade\View;

class DepartmentMember extends Base{
    public function index(){
        $userList = rizhi2013_admin::whereNotIn('department','0,1,99,100')->order('id')->select();
        $departmentList = rizhi2013_dept::whereNotIn('deptid','1')->order('deptid')->select()->toArray();
        
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

        View::assign([
            'departmentList' => $departmentList
        ]);
        return View::fetch();
    }
}
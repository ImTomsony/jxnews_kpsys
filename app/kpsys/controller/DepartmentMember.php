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
     * @return View 返回的页面，无增删改查功能，只能看
     */
    public function memberKaoping($mid){
        $list = rizhi2013x::where('mid', $mid)->order('time', 'desc')->order('id','desc')->select()->toArray();
        View::assign(['list'=>$list]);
        return View::fetch();
    }

    /**
     * 查看用户自己所在部门员工你的考评
     * @param $mid 根据传过来的员工id
     * @return View 返回的页面，如果是自己的就返回可以增删改的界面，如果是其他人的就再根据用户个人的权限进行选择
     */
    public function userDepartmentKaoping($mid){
        if($mid == Session::get('user_id')){
            $list = rizhi2013x::where('mid', $mid)->order('time', 'desc')->order('id','desc')->select()->toArray();
            View::assign(['list'=>$list]);
            return View::fetch('kaoping_manage/index');
        }

        switch (Session::get('user_type')) {
            case 1:
                # code...
                break;

            case 2:
                break;

            case 6:
                break;

            case 8:
                break;
            
            default:
                DepartmentMember::memberKaoping($mid);
                break;
        }
    }

    public function departmentBaosong($did){
        return View::fetch();
    }
}
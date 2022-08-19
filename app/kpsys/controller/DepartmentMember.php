<?php
namespace app\kpsys\controller;

use app\kpsys\model\rizhi2013_admin;
use app\kpsys\model\rizhi2013_dept;
use app\kpsys\model\rizhi2013x;
use think\facade\Session;
use think\facade\View;
use think\exception\ValidateException;
use app\kpsys\validate\AddKaoping as AddKaopingValidate;
use app\kpsys\validate\GradeKaoping as GradeKaopingValidate;

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

        // 要根据用户权限来分配不同的页面。(实践证明再这里搞，比在前端用php搞好多了)
        switch (Session::get('user_type')) {
            case 1:
                return View::fetch('index');
                break;

            case 2:
                return View::fetch('index_type2');
                break;
            
            default:
                return View::fetch('index');
                break;
        }
    }

    /**
     * 根据传过来的员工id查询所有的考评
     * @param $mid 根据传过来的员工id
     * @return View 返回的页面，无增删改查功能，只能看
     */
    public function memberKaoping($mid){
        $list = rizhi2013x::where('mid', $mid)->order('time', 'desc')->order('id','desc')->limit(100)->select()->toArray();
        View::assign(['list'=>$list]);
        return View::fetch();
    }

    /**
     * 打分人 (type 2) 查看自己所在部门员工的考评
     * @param $mid 员工id
     * @return View 返回的页面，如果是自己的就返回可以增删改的界面，如果是其他人的就再根据用户个人的权限进行选择
     */
    public function MyDeptMemberKaoping($mid){
        $list = rizhi2013x::where('mid', $mid)->order('time', 'desc')->order('id','desc')->limit(100)->select()->toArray();
        $member = rizhi2013_admin::where('id', $mid)->find();
        View::assign([
            'list' => $list,
            'member' => $member
        ]);
        return View::fetch();
    }

    /**
     * 展示打分者添加部门员工考评的界面
     */
    public function addMemberKaoping($mid){
        $member = rizhi2013_admin::where('id', $mid)->find();
        View::assign([
            'member' => $member
        ]);
        return View::fetch();
    }

    /**
     * 展示给已有考评打分的界面
     */
    public function gradeMemberKaoping($kaopingId){
        $kaoping = rizhi2013x::where('id', $kaopingId)->find();
        View::assign(['kaoping' => $kaoping]);
        return View::fetch();
    }

    /**
     * 接受post过来的考评信息，并且insert到数据库
     */
    public function addMemberKaopingFormPost(){
            // 通过input助手函数和time()函数获取需要的数据
            $data = [
                'time' => input('post.time'),
                'content' => remove_xss(trim(input('post.content'))),
                'beizhu' => remove_xss(trim(input('post.beizhu'))),
                'mid' => input('post.mid'),
                'did' => input('post.did'),
                'uname' => input('post.uname'),
                'addtime' => time(),
                'score' => input('post.score'),
                'reward' => input('post.reward'),
                'total' => input('post.score') + input('post.reward'),
                'note' => remove_xss(trim(input('post.note'))),
            ];

            // 通过验证器验证数据是否合法
            try{
                validate(AddKaopingValidate::class)->check($data);
            }catch(ValidateException $e){
                // 验证失败就返回错误信息和错误代码
                return json([ 'msg' => $e->getError(), 'code' => 1 ]);
                exit;
            };
    
            // 添加考评
            if(empty(rizhi2013x::insert($data))){
                return json(['code'=>1, 'msg'=>'数据验证成功, 但是无法添加到数据库中']);
                exit;
            }

            return json(['code'=>0, 'msg'=>'ok']);
    }

    /**
     * 接受post过来的打分信息，并且update到数据库
     */
    public function gradeMemberKaopingFormPost(){
         // 通过input助手函数和time()函数获取需要的数据
         $id = input('post.id');
         $data = [
            'score' => input('post.score'),
            'reward' => input('post.reward'),
            'total' => input('post.score') + input('post.reward'),
            'note' => remove_xss(trim(input('post.note'))),
        ];

        // 通过验证器验证数据是否合法
        try{
            validate(GradeKaopingValidate::class)->check($data);
        }catch(ValidateException $e){
            // 验证失败就返回错误信息和错误代码
            return json([ 'msg' => $e->getError(), 'code' => 1 ]);
            exit;
        };

        // 更新考评
        if(empty(rizhi2013x::where('id', $id)->save($data))){
            return json(['code'=>1, 'msg'=>'未改变数据']);
            exit;
        }

        return json(['code'=>0, 'msg'=>'ok']);
    }

    /**
     * 查看一个部门所有员工最近300条考评，用数组封装好为lay-table服务
     */
    public function deptKaoping($did, $date = null){
        $memberList = rizhi2013_admin::where('department', $did)->order('id')->column('username, id', 'id');
        foreach ($memberList as $key => &$member) {
            $member['kaopingList'] = [];
            $member['kaopingList'] = rizhi2013x::where('mid', $member['id'])->order('time', 'desc')->order('id','desc')->limit(100)->select()->toArray();
        }
        View::assign([
            'memberList' => $memberList
        ]);
        return View::fetch();
    }

    /**
     * 查看一个部门所有员工最近30天的考评，用数组封装好为时间线服务
     */
    public function deptKaoping1($did, $dateOffset = null){
        $memberList = rizhi2013_admin::where('department', $did)->order('id')->column('username, id', 'id');
        $dateList = [];
        for ($i=0; $i < 100; $i++) {
            $date = date('Y-m-d', strtotime('today - ' . $i . ' day'));
            foreach ($memberList as $key => $member) {
                $kaopingList = rizhi2013x::where('time', $date)->where('mid', $member['id'])->select()->toArray();
                $dateList[$date][$member['username']]['id'] = $member['id'];
                $dateList[$date][$member['username']]['kaoping'] = $kaopingList;
            }
        }
        View::assign([
            'dateList' => $dateList
        ]);
        return View::fetch();
    }
}
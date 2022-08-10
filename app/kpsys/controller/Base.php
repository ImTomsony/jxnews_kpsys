<?php
namespace app\kpsys\controller;

use app\kpsys\model\rizhi2013_admin as rizhi2013_adminModel;
use think\facade\Session;
use think\facade\View;

/**
 * 登录权限管理的基础controller。主界面需要继承这个类用于判断用户是否已经登录，
 * 以及用户是否有权限登录
 * 
 * @method void __construct() 构造函数，让继承了该类的controller在一开始就可以判断用户状态
 */
class Base{
    public function __construct(){
        // 通过Session获得用户id，
        // 如果没有，就说明用户未登录，便转到登录界面
        $user_id = Session::get('user_id');
        if(empty($user_id)){
            header('location:/index.php/kpsys/Login/timeout');
            exit;
        }

        // 通过id查询一下用户的信息，
        $aUser = rizhi2013_adminModel::where('id', $user_id)->find();

        // 如果查不到，就说明Session的信息有误需要删除
        if(empty($aUser)){
            Session::delete('user_id');
            header('location:/index.php/kpsys/Login/timeout');
            exit;
        }

        // 如果查到了，但是部门为100(表示已经离职), 则返回禁用界面
        if($aUser['department'] == 100){
            Session::delete('user_id');
            header('location:/index.php/kpsys/Login/banned');
            exit;
        }

        // 最后如果成功登录，需要把用户信息返回给前端
        View::assign([
            'user' => $aUser
        ]);
    }
}
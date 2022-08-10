<?php
namespace app\kpsys\controller;

use app\kpsys\model\rizhi2013_admin;
use app\kpsys\validate\rizhi2013_admin as ValidateRizhi2013_admin;
use think\App;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\View;

class Index extends Base{
    public function index(){
        return View::fetch();
        // 跳转到登录界面
        // return redirect('/index.php/kpsys/Login/');
    }
    /**
     * 主界面iframe的初始欢迎界面
     * @access public
     * @return View
     */
    public function welcome(){
        return View::fetch();
    }
}
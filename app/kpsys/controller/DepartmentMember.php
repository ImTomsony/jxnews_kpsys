<?php
namespace app\kpsys\controller;

use think\facade\View;

class DepartmentMember extends Base{
    public function index(){
        return View::fetch();
    }
}
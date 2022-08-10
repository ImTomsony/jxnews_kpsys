<?php
namespace app\kpsys\validate;

use think\Validate;

class UserLogin extends Validate{
    // 验证规则
    protected $rule = [
        'username' => 'require|max:20',
        'password' => 'require|max:20',
        'captcha|验证码' => 'require|captcha'
    ];

    // 错误信息
    protected $message = [
        'username.require' => '姓名不得为空',
        'username.max' => '姓名不得大于20位',

        'password.require' => '密码不得为空',
        'password.max' => '密码不得大于20位',
        //'password.min' => '密码至少为6位'
    ];
}
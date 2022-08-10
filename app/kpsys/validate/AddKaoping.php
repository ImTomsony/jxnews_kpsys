<?php
namespace app\kpsys\validate;

use think\Validate;

class AddKaoping extends Validate{
    // 验证规则
    protected $rule = [
        'time|(time)工作日期' => 'require|dateFormat:Y-m-d',
        'content|(content)工作内容' => 'require|max:1600',
        'beizhu|(beizhu)补充内容' => 'max:1600',
        'mid|(mid)用户id' => 'require',
        'did|(did)部门id' => 'require',
        'uname|(uname)用户名' => 'require|max:20',
        'addtime|(addtime)日志添加时间戳' => 'require'
    ];

    // 错误信息
    protected $message = [
        'username.require' => '姓名不得为空',
        'username.max' => '姓名不得大于20位',
    ];
}
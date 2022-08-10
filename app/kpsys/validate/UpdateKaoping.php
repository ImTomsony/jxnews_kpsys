<?php
namespace app\kpsys\validate;

use think\Validate;

class UpdateKaoping extends Validate{
    // 验证规则
    protected $rule = [
        'content|(content)工作内容' => 'require|max:1600',
        'beizhu|(beizhu)补充内容' => 'require|max:1600',
    ];

    // 错误信息
    protected $message = [

    ];
}
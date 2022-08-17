<?php
namespace app\kpsys\validate;

use think\Validate;

class GradeKaoping extends Validate{
    // 验证规则
    protected $rule = [
        'score' => 'float|max:6',
        'reward' => 'float|max:6',
        'note' => 'max:1600',
    ];

    // 错误信息
    protected $message = [

    ];
}
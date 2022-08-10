<?php
namespace app\kpsys\controller;

use app\kpsys\validate\UserLogin as UserLoginValidate;
use app\kpsys\model\rizhi2013_admin as rizhi2013_adminModel;
use think\App;
use think\exception\ValidateException;
use think\facade\Session;
use think\facade\View;

class Login{
    /**
     * 登录界面
     * @access public
     * @return View
     */
    public function index(){
        return View::fetch();
    }

    /**
     * /view/login/index.php 登录按钮点击, 数据通过post传递过来，然后和数据库进行比较
     * @access public
     */
    public function login(){
        // 通过input助手函数接收post信息
        $data = [
            'username' => trim(input('post.username')),
            'password' => input('post.password'),
            'captcha' => trim(input('post.captcha'))
        ];

        // TP6验证器，验证post过来的数据是否符合规范
        try{
            validate(UserLoginValidate::class)->check($data);
        }catch(ValidateException $e){
            // 验证失败就返回错误信息和错误代码
            echo json_encode([ 'msg' => $e->getError(), 'code' => 1 ]);
            exit;
        };

        // 最后访问数据库进行比较
        $user = rizhi2013_adminModel::where('username', $data['username'])->find();
        switch ($user) {
            case NULL:
                echo json_encode([ 'msg' => '用户不存在', 'code' => 1]);
                exit;
                break;
            
            default:
                // 比较密码
                if(md5(md5($data['password'])) == $user['password']){
                    // 登录成功还需要保存用户的 id 和 username 到Session，以备之后操作
                    Session::set('user_id', $user['id']);
                    Session::set('user_name', $user['username']);
                  
                    echo json_encode(['msg' => '登录成功', 'code' => 0]);
                    return;
                }
                else{
                    echo json_encode([ 'msg' => '密码错误', 'code' => 1 ]);
                    return;
                }
                break;
        }
    }

    /**
     * 账户禁用
     */
    public function banned(){
        return View::fetch();
    }

    /**
     * 登出
     * 要删除Session
     */
    public function logout(){
        Session::delete('user_id');
        Session::delete('user_name');

        echo json_encode(['msg' => '登出成功', 'code' => 0]);
    }

    /**
     * 登录超时
     */
    public function timeout(){
        Session::delete('user_id');
        Session::delete('user_name');

        return View::fetch();
    }
}
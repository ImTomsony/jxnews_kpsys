<?php
namespace app\kpsys\controller;

use app\kpsys\model\rizhi2013x;
use app\kpsys\validate\AddKaoping as AddKaopingValidate;
use app\kpsys\validate\UpdateKaoping as UpdateKaopingValidate;
use think\exception\ValidateException;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

/**
 * 本人考评的controller
 */
class KaopingManage extends Base{
    /**
     * 默认返回本人所有的考评记录, 每页50条
     */
    public function index(){
        // 先从Session中获取到本人的id，之后根据此id查找表(rizhi2013x)中对应的记录
        $user_id = Session::get('user_id');
        $list = rizhi2013x::where('mid', $user_id)->order('time', 'desc')->order('id','desc')->select();
        View::assign([
            'list' => $list,
        ]);
        return View::fetch();
    }

    /**
     * 添加考评
     */
    public function addKaoping(){
        //检测是否为post，如不是就返回form表单界面
        if(Request::isPost()){
            // 通过input助手函数和time()函数获取需要的数据
            $data = [
                'time' => input('post.time'),
                'content' => remove_xss(trim(input('post.content'))),
                'beizhu' => remove_xss(trim(input('post.beizhu'))),
                'mid' => input('post.mid'),
                'did' => input('post.did'),
                'uname' => input('post.uname'),
                'addtime' => time()
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
        }else
            return View::fetch();
    }

    /**
     * 修改考评
     * @param id 考评在表rizhi2013x中的id
     * @return View 返回修改此条考评的操作界面
     */
    public function editKaoping($id){
        // 验证这个考评是否可以修改
        if(empty($rizhi = rizhi2013x::where('id', $id)->where('tag', 0)->find())){
            return json(['code'=>1, 'msg'=>'未找到考评, 或此考评已经报送不可修改']);
        }
        //print_r($rizhi);
        View::assign(['rizhi' => $rizhi]);
        return View::fetch();
    }

    /**
     * 保存修改好了的考评
     * @return json 返回是否成功修改，code 0 代表成功，1 代表失败
     */
    public function updateKaoping(){
        // 过滤post过来的信息，并赋值变量
        $id = input('post.id');
        $data = [
            'content' => remove_xss(trim(input('post.content'))),
            'beizhu' => remove_xss(trim(input('post.beizhu'))),
            'addtime' => time()
        ];

        // 通过验证器验证数据是否合法
        try{
            validate(UpdateKaopingValidate::class)->check($data);
        }catch(ValidateException $e){
            // 验证失败就返回错误信息和错误代码
            return json([ 'code' => 1, 'msg' => $e->getError() ]);
        };

        // 保存考评
        if(empty(rizhi2013x::where('id', $id)->update($data))){
            return json(['code'=>1, 'msg'=>'数据验证成功, 但是无法添加到数据库中']);
        }

        return json(['code'=>0, 'msg'=>'ok']);
    }

    /**
     * 删除考评
     */
    public function deleteKaoping(){
        $data = input('post.id');

        // 验证这个考评是否可以删除
        if(empty(rizhi2013x::where('id', $data)->where('tag', 0)->delete())){
            return json(['code'=>1, 'msg'=>'删除失败, 未找到考评或此考评不可删除']);
        }

        return json(['code'=>0, 'msg'=>'ok']);
    }

    /**
     * 查看某人的所有的考评的接口
     * @return json 返回json格式的数据
     */
    // public function findAllKaoping($mid){

    //     return json($list);
    // }
}
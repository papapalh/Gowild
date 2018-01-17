<?php

namespace M\Controller\CGI;

// 基本验证类
use M\Controller\CGI\Validator as Validator;
// 登录验证类
use M\Common\Auth\Auth as Auth;
// IoC
use M\IoC as IoC;

class Login extends \M\Controller\CGI
{
    public function __index()
    {
        // 检测是否已经登录
        if (Auth::isLoggedIn()) {
            $this->redirect('admin/layout');
        }

        $this->display('login');
    }

    // 登录
    public function actionLogin()
    {
        // 检测是否已经登录
        if (Auth::isLoggedIn()) {
            $this->redirect('admin/layout');
        }

        // 数据校验
        $form = $this->form('post');

        $username = Auth::normalize($form['name']);

        $auth = IoC::construct('M\Common\Auth\Auth', $username);

        // 验证用户和密码对
        if ($auth->verify($form['password'])) {
            success();
        }
        else {
            fail('账号密码错误');
        }
    }

    public function actionRecovery()
    {
        // 数据获取
        $form = $this->form('post');

        $token = $form['token'];
        $recovery = $form['recovery'];

        /**
         * 数据校验
         * @return code 0 : 成功
         * @return code 1 : 验证码验证失败
         * @return code 2 : 没有该账号信息
         * @return code 3 : 账号没有绑定邮箱
         *
         */

        $ex = \M\Recovery::get();
        if($recovery != $ex) {
            fail('验证码验证失败', 1);
            return false;
        }

        $user = a('user')->whose('token')->is($token)->redis();

        if(!$user->id) {
            fail('没有该账号信息', 2);
            return false;
        }

        if(!$user->mail) {
            fail('该人员信息没有绑定邮箱,请联系管理员', 3);
            return false;
        }

        fail($user->mail);
    }
}
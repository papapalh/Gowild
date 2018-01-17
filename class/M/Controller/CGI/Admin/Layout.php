<?php
namespace M\Controller\CGI\Admin;

class Layout extends \M\Controller\CGI
{
    // 验证登录状态
    function __construct()
    {
        if (!\M\Common\Auth\Auth::isLoggedIn()) {
            $this->redirect('login');
        }
        else {
            // 数据库读取人员信息
            $me = a('user')->whose('token')->is(S('username'))->redis();
            _G('ME', $me);
        }
    }
}
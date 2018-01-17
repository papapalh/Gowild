<?php
namespace M\Controller\CGI;

class People extends \M\Controller\CGI\Admin\Layout
{
    public function __index()
    {
        // 获取人员信息列表
        // $users = those('user')->redis();
        $me = _G('ME');

        $this->display('admin/layout',[
            'body' => V('people/list',[
                    'me' => $me
                ])
        ]);
    }

    public function actionAdd()
    {
        // 数据获取
        $form = $this->form('post');

        // 数据验证-检查
        $validator = _V('people', $form);

        if (!$validator) {
            die('数据校验出错');
        }

        // 数据存储
        $user = a('user');

        $user->token = $form['token'];

        // 生成密码
        $auth = \M\IoC::construct('M\Common\Auth\Auth', $form['password']);
        $password = $auth->createPassword($form['password']);

        $user->password = $password;
        $user->name = $form['name'];
        $user->sex = $form['sex'];

        if ($user->save()) {
            $this->redirect('admin/people');
        }
        else {
            echo '插入失败';
        }
    }


}
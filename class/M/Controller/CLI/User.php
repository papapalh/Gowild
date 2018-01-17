<?php

namespace M\Controller\CLI;

class User extends \M\Controller\CLI
{
    // 添加用户
    public function actionAdd(){
        echo "Enter Name :";

        $name = trim(fgets(STDIN));

        echo "Enter PassWord :";

        $password = trim(fgets(STDIN));

        $auth = \M\IoC::construct('M\Common\Auth\Auth', $password);
        $password = $auth->createPassword($password);

        $user = a('user');

        $user->token    = $name;
        $user->password = $password;
        $user->ctime    = date('Y-m-d', time());

        if ($user->save()) {
            echo "\e[32mdone.\e[0m\n";
        }

    }
}

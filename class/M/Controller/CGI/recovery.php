<?php
namespace M\Controller\CGI;

class Recovery extends \M\Controller\CGI
{
    // 生成验证码
    public function actionCreate() {
        \M\Recovery::create();
    }
}
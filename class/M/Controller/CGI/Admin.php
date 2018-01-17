<?php
namespace M\Controller\CGI;

class Admin extends \M\Controller\CGI\Admin\Layout
{
    public function __index()
    {
        $this->display('admin/layout');
    }

    public function actionGo()
    {
        \M\Common\Auth\Auth::go();
        $this->redirect('login');
    }
}
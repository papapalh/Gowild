<?php
namespace M\Controller\CGI;

class Error extends \M\Controller\CGI
{
    public function actionError403()
    {
        $this->display('error/403');
    }

    public function actionError404()
    {
    	$this->display('error/404');
    }

    public function actionError500()
    {
    	$this->display('error/500');
    }
}
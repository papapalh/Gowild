<?php

namespace M\Controller\CGI;

class Index extends \M\Controller\CGI
{
    public function __index()
    {
        $this->redirect('login');
    }
    
}
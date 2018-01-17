<?php
namespace M\Controller\CGI;

class Setting extends \M\Controller\CGI\Admin\Layout
{
    public function __index()
    {

        $this->display('admin/layout',[
            'body' => V('wx/setting/list',[
                ])
        ]); 
    }


}
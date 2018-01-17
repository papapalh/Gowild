<?php
namespace M\ORM;

class Banner_image extends \M\ORM{

    public $banner            = 'object:banner'; // banner对象
    public $url               = 'string:150';    // url 
    public $status            = 'string:50';     // 类型
    public $dtime             = 'datetime';      // 模块删除时间
    public $ctime             = 'datetime';      // 模块创建时间

    protected static $db_index = [
        'unique:url'
    ];
}
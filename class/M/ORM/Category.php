<?php
namespace M\ORM;

class Category extends \M\ORM{

    public $name              = 'string:50';    // 模块名字
    public $main_img          = 'string:50';    // 模块图片
    public $dtime             = 'datetime';     // 模块删除时间
    public $ctime             = 'datetime';     // 模块创建时间
    public $utime             = 'datetime';     // 模块创建时间
    public $status            = 'string:50';    // 状态

    protected static $db_index = [
        'unique:name',
    ];

    const STATUS_SUCCESS = 0;
    const STATUS_DANGER  = 11;

    public static $class = [
        self::STATUS_SUCCESS => 'label-success',
        self::STATUS_DANGER => 'label-danger',
    ]; // 请务必按照顺序来写状态

    public static $statuses = [
        self::STATUS_SUCCESS => '启用',
        self::STATUS_DANGER => '禁用',
    ]; // 请务必按照顺序来写状态
}
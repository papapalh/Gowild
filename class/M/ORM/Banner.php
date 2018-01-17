<?php
namespace M\ORM;

class Banner extends \M\ORM{

    public $name              = 'string:50';    // Banner名字
    public $description       = 'string:50';    // 详细描述
    public $status            = 'string:50';    // 状态
    public $dtime             = 'datetime';     // 模块删除时间
    public $ctime             = 'datetime';     // 模块创建时间

    protected static $db_index = [
        'unique:status'
    ];

    const STATUS_SUCCESS = 0;
    const STATUS_DANGER  = 1;

    public static $class = [
        self::STATUS_SUCCESS => 'label-success',
        self::STATUS_DANGER => 'label-danger',
    ]; // 请务必按照顺序来写状态

    public static $statuses = [
        self::STATUS_SUCCESS => '启用',
        self::STATUS_DANGER => '禁用',
    ]; // 请务必按照顺序来写状态
}
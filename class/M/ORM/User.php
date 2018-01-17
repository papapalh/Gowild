<?php
namespace M\ORM;

class User extends \M\ORM{

    public $token              = 'string:150';         // 账号
    public $password           = 'string:600';         // 密码
    public $sex                = 'int:null:default:0'; // 性别
    public $name               = 'string:150';         // 姓名
    public $ctime              = 'datetime';           // 创建时间
    public $utime              = 'datetime';           // 更新时间
    public $dtime              = 'datetime';           // 删除时间
    public $status             = 'int:null:default:0'; // 人员状态
    public $mail               = 'string:150';         // 邮箱

    protected static $db_index = [
        'unique:token',
    ];

    const SEX_MAN = 0;
    const SEX_WOMAN = 1;

    public static $sex_status = [
        self::SEX_MAN => '男',
        self::SEX_WOMAN => '女',
    ]; // 请务必按照顺序来写状态

    public function sex()
    {
        return self::$sex_status[$this->sex];
    }
}
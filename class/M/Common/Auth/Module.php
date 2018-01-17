<?php
namespace M\Common\Auth;

class Module
{
    private $_hash = '';
    private $_saltGain = '';

    function __construct($username)
    {
        $this->_hash = Md5($username);
        $this->_saltGain = 2;
    }

    public function verify($username, $password)
    {
        $db = \M\Database::db();

        // 生成Hash
        $hash = $this->createHash($password, $this->_hash, $this->_saltGain);

        $password = crypt($password, $hash);

        // 检测是否已经有同名用户注册
        $user = $db->query("SELECT * from user WHERE token = ':username' AND password = ':password'",[
                    'username' => $username,
                    'password' => $password
                ]);
        if (count($user->fetchAll()) > 0) {
            // 登录成功--存入SESSION
            S('username', $username, 14000);
            
            return true;
        }

        return false;
    }

    public function add($username,$password)
    {
        $db = \M\Database::db();

        // 生成Hash
        $hash = $this->createHash($password, $this->_hash, $this->_saltGain);

        $password = crypt($password, $hash);

        $result = $db->result("INSERT INTO user (`token`, `password`) VALUES (':username', ':password')",[
                    'username' => $username,
                    'password' => $password
                ]);
        !$result ? die('人员信息插入失败') : '';

        }

    public function createHash($password, $salt, $saltGain)
    {
        // 过滤参数
        if(!is_numeric($saltGain)) exit;
        if(intval($saltGain) < 0 || intval($saltGain) > 35) exit;

        // 对 Md5 后的盐值进行变换，添加信息增益
        $tempSaltMd5 = md5($salt);
        for($i = 0;$i < strlen($tempSaltMd5);$i ++){
            if(ord($tempSaltMd5[$i]) < 91 && ord($tempSaltMd5[$i]) > 32){
                // 每一个字符添加同样的增益
                $tempSaltMd5[$i] = chr(ord($tempSaltMd5[$i]) + $saltGain);
            }
        }

           // 返回整个哈希值
        return '$2y$13$LGsF2ctmKKHE1yr2Py.banana'.md5($password . $tempSaltMd5);
    }

    public function createPassword($pwd)
    {
        // 生成Hash
        $hash = $this->createHash($pwd, $this->_hash, $this->_saltGain);

        $password = crypt($pwd, $hash);

        return $password;
    }
}
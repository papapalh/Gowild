<?php
namespace M\Common\Token;

class Token
{
    // 获取一个?位随机数
    static function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0;
             $i < $length;
             $i++) {
            $str .= $strPol[rand(0, $max)];
        }

        return $str;
    }

    // 获取唯一Token
    static function getToken()
    {
        // 生成令牌-32位随机
        $randChar = self::getRandChar(32);

        // 生成令牌-时间浮点数
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];

        // 生成令牌-盐
        $tokenSalt = \M\Config::get('token')['token']['salt'];

        return md5($randChar . $timestamp . $tokenSalt);
    }
}
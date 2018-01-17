<?php
namespace M\API;

class Token extends \M\Controller\API
{
    public function actionUser()
    {
        $form = json_decode(api_form(), true);
        $code = str_replace("\"", '', $form['code']);

        $config = \M\Config::get('wx');
        // 发送请求获取openid
        $url = sprintf($config['wx']['url'], $config['wx']['appid'], $config['wx']['secret'], $code);

        // 获取用户信息
        $data = \M\HTTP::get($url);

        // 检查用户信息
        if (array_key_exists('errcode', $data)) return false;  

        // 获取用户opendid
        $openid = $data['openid'];

        $user = a('user_wx')->whose('openid')->is($openid)->redis();

        // 检查用户是否存在
        if ($user->id) {
            $uid = $user->id;
        }
        else {
            $user = a('user_wx');
            $user->openid = $openid;
            $user->ctime  = date('Y-m-d', time());
            $user->save();
            $uid = $user->id;
        }

        // 生成令牌
        $key = \M\Common\Token\Token::getToken();

        $data['uid'] = $user->id;

        $value = json_encode($data);

        R($key, $value, 7200);

        echo $key;
    }

    public function actionVerify()
    {
        $form = json_decode(api_form(), true);
        $token = str_replace("\"", '', $form['token']);

        $data = R($token);

        echo $data;
    }
}
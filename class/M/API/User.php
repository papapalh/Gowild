<?php
namespace M\API;

class User extends \M\Controller\API
{
    public function __index()
    {
        $form = file_get_contents("php://input");
    }

    public function actionInfo()
    {
        // 获取在HTTP-Headers-Request Payload
        $form = file_get_contents("php://input");
        $form = json_decode($form);

        // 用户姓名
        $nickname = $form->nickname;

        // code
        $code = $form->rea->code;

        var_dump($nickname);
        var_dump($code);
        die;
        // error_log(print_r($form));
        // die;
        // echo '11';

        // 发送请求获取openid
        // $url = sprintf("https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
        //         'wx1fc7b70c60a96fe5',
        //         'b309980dad4f0deaa94e2634fb53326d',
        //         $code
        //     );

        $data = \M\HTTP::request('GET', $url,[]);
        
        error_log($data);
        echo json_encode($data);
        // {\"session_key\":\"h7jsPHINVWUKmd3GgiFCLQ==\",\"expires_in\":7200,\"openid\":\"o3sDw0K2NNNkGEW3gxQ9qZRuPy7I\"}"
    }
}
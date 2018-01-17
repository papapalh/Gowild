<?php
namespace M\API;

class Address extends \M\Controller\API
{
    // 获取Banner信息
    public function __index()
    {
        // 检查token
        $this->check_token();

        // 获取uid
        $user_info = $this->user_info();

        $address = a('user_address')->whose('user_id')->is($user_info->uid)->redis();

        if(!$address->id) return false;

        return_ajax($address);
    }

    public function actionInfo()
    {
        // 检查token
        $this->check_token();

        // 获取uid
        $user_info = $this->user_info();

        // 获取数组
        $form = json_decode(api_form(), true);

        // 地址插入数据库
        $address           = a('user_address');
        $address->user_id  = $user_info->uid;        // 用户ID
        $address->name     = $form['userName'];     // 收货地址姓名
        $address->mobile   = $form['telNumber'];    // 收货手机号
        $address->province = $form['provinceName']; // 省
        $address->city     = $form['cityName'];        // 市
        $address->country  = $form['countyName'];   // 区
        $address->detail   = $form['detailInfo'];   // 详细
        $address->ctime    = date('Y-m-d', time()); // 创建时间

        if ($address->save()) {
            echo json_encode(['code' => '成功']);
        }
        else {
            return false;
        }
    }

}
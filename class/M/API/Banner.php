<?php
namespace M\API;

class Banner extends \M\Controller\API
{
    // 获取Banner信息
    public function actionGet(){

        $banner = a('banner')->whose('status')->is(0)->redis();

        $banner_image = those('banner_image')->whose('banner_id')->is($banner)->redis();

        if(count($banner_image) < 1) $this->error();

        return_ajax($banner_image);
    }

}
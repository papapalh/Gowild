<?php
namespace M\API;

class Product extends \M\Controller\API
{
    // 获取新品信息
    public function actionRecent($count = 15){

        $products = those('product')->limit($count)->redis();

        if(count($products) < 1) return false;

        return_ajax($products);
    }

    // 获取一条的商品信息
    public function actionGet($id)
    {
        $product = a('product', $id);

        if (!$product->id) return false;

        // 商品详情
        $product->details =  htmlentities(a('product_details')->whose('product_id')->is($id)->redis()->content);

        // 产品参数
        $product->params =  htmlentities(a('product_params')->whose('product_id')->is($id)->redis()->content);

        // 售后保障
        $product->custormer =  htmlentities(a('product_custormer')->whose('product_id')->is($id)->redis()->content);

        return_ajax($product);
    }
}
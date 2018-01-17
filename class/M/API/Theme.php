<?php
namespace M\API;

class Theme extends \M\Controller\API
{
    // 获取全部
    public function actionAll()
    {
        $theme = those('theme')->whose('status')->is(\M\ORM\Category::STATUS_SUCCESS)->redis();

        return_ajax($theme);
    }

    public function actionGet($id)
    {
    	$theme = a('theme', $id);

        // 获取关联商品数组
        $connect = $theme->getConnect('product');

        foreach ($connect as $id) {
            $product = a('product', $id);

            if (!$product->id) continue;

            $product->detail_img = \M\URI::url() . $product->detail_img;

            $product->main_img  = \M\URI::url() . $product->main_img;

            $theme->products[] = $product;
        }

    	return_ajax($theme);
    }
}
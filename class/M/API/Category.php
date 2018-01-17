<?php
namespace M\API;

class Category extends \M\Controller\API
{

    // 获取全部模块信息
    public function actionAll()
    {
        $categorys = those('category')->whose('status')->is(\M\ORM\Category::STATUS_SUCCESS)->redis();

        foreach ($categorys as $category) {
            // 获取关联商品数组
            $connect = $category->getConnect('product');

            foreach ($connect as $id) {
                $product = a('product', $id);

                if (!$product->id) continue;

                $product->detail_img = \M\URI::url() . $product->detail_img;

                $product->main_img  = \M\URI::url() . $product->main_img;

                $category->products[] = $product;
            }
        }

        return_ajax($categorys);
    }

    public function actionGet($id)
    {
        $category = a('category' ,$id);

        // 获取关联商品数组
        $connect = $category->getConnect('product');

        foreach ($connect as $id) {
            $product = a('product', $id);

            if (!$product->id) continue;

            $product->detail_img = \M\URI::url() . $product->detail_img;

            $product->main_img  = \M\URI::url() . $product->main_img;

            $category->products[] = $product;
        }

        return_ajax($category);
    }
}
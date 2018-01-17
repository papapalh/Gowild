<?php
namespace M\Controller\CGI;

class Category extends \M\Controller\CGI\Admin\Layout
{

    public function __index()
    {
        // 获取人员信息列表
        $categorys = those('category')->redis();

        $form = $this->form('post');

        $this->display('admin/layout',[
            'body' => V('wx/category/list',[
                    'categorys' => $categorys
                ])
        ]);
    }

    // 模块设置详情
    public function actionInfo($id)
    {
        if (!$id) $this->redirect('error/error404');

        $category = a('category', $id);

        if (!$category->id) $this->redirect('error/error404');

        $products = those('product')->redis();

        $connect = $category->getConnect('product');

        if (!$connect) $connect = [];

        $this->display('admin/layout',[
                'body' => V('wx/category/info',[
                    'category' => $category,
                    'products' => $products,
                    'connect' => $connect
                ])
            ]);
    }

    // 添加模块
    public function actionAdd($id = '')
    {
        // 数据获取
        $form = $this->form('post');

        $categorys = those('category')->whose('status')->is(0)->redis();

        if (count($categorys) >= 7) alert('错误：最多只能设置8个启用模块！', 'category');

        // 数据存储
        $category = a('category', $id);

        $category->name = $form['name'];
        $category->status = $form['status'];

        if ($id) {
            $category->utime = date('Y-m-d H:i:s', time());
        }
        else {
            $category->ctime = date('Y-m-d H:i:s', time());
        }

        if ($category->save()) {
            if ($id) {
                $this->redirect('category/info/'.$id);
            }
            else {
                $this->redirect('category');
            }
        }
        else {
            echo '插入失败';
        }
    }

    public function actionUpdate($id)
    {
        $form = $this->form('files');

        $category = a('category', $id);

        if (!$category->id) $this->redirect('error/error404');

        if ($category->main_img) alert('模块主图只能设置1张！', 'category/info/'.$id);

        // 组合
        $file['name'] = $form['category-main']['name'][0];
        $file['size'] = $form['category-main']['size'][0];
        $file['type'] = $form['category-main']['type'][0];
        $file['tmp_name'] = $form['category-main']['tmp_name'][0];

        $status = \M\File::save($file);

        if (is_array($status)) alert('上传失败！', 'category/info/'.$id);

        $category->main_img = $status;
        $category->utime = date('Y-m-d', time());

        if ($category->save()) {
            success();
        }
    }

    // 模块关联商品
    public function actionConnect($id)
    {
        if (!$id) $this->redirect('error/error403');

        // 数据获取
        $form = $this->form('post');

        // 数据存储
        $category = a('category', $id);

        if (!$category->id) $this->redirect('error/error403');

        // 清空theme关联
        $db = \M\Database::db();

        $db->query(sprintf("DELETE FROM `_r_category_product` WHERE id1 = '%s';", $id));

        // 循环创建关联
        foreach ($form['products'] as $v) {
            $product = a('product' ,$v);
            if (!$product->id) continue;

            $category->connect($product);
        }

        $this->redirect('category/info/'.$id);
    }

}
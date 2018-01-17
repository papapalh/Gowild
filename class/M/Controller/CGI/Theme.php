<?php
namespace M\Controller\CGI;

class Theme extends \M\Controller\CGI\Admin\Layout
{
    public function __index()
    {
        $themes = those('theme')->redis();
        $only = those('theme')->whose('status')->is(\M\ORM\Category::STATUS_SUCCESS)->redis();

        $this->display('admin/layout',[
            'body' => V('wx/theme/list',[
                    'themes' => $themes,
                    'only' => $only
                ])
        ]);     
    }

    public function actionInfo($id = '')
    {
        if (!$id) $this->redirect('error/error403');

        $theme = a('theme', $id);

        if (!$theme->id) $this->redirect('error/error403');

        $products = those('product')->redis();

        // 获取关联商品数组
        $connect = $theme->getConnect('product');

        if (!$connect) $connect = [];

        $this->display('admin/layout',[
            'body' => V('wx/theme/info',[
                    'theme' => $theme,
                    'products' => $products,
                    'connect' => $connect
                ])
        ]);    
    }

    // 添加banner模块
    public function actionAdd($id = '')
    {
        // 数据获取
        $form = $this->form('post');

        // 数据存储
        $theme = a('theme', $id);

        $theme->name = $form['name'];
        $theme->description = $form['description'];
        $theme->status = $form['status'];
        $theme->ctime = date('Y-m-d H:i:s', time());

        if ($form['status'] == 0) {
            $themes = those('theme')->whose('status')->is(0)->redis();
            if (count($themes) >= 3) {
                alert('错误：最多只能有3个启用专题！', '/theme/info/'.$id);
            }
        }

        if ($theme->save()) {
            $this->redirect('theme');
        }
        else {
            alert('插入失败', 'theme');
        }
    }

    // 修改专题信息--主图图片
    public function actionUpdate($id)
    {
        $form = $this->form('files');

        $theme = a('theme', $id);

        if (!$theme->id) $this->redirect('error/error403');

        if (!empty($theme->main_img)) {
            alert('错误：专题主图只能有一张，请检查', 'theme/info/'.$id);
        }

        // 组合
        $file['name'] = $form['theme-main']['name'][0];
        $file['size'] = $form['theme-main']['size'][0];
        $file['type'] = $form['theme-main']['type'][0];
        $file['tmp_name'] = $form['theme-main']['tmp_name'][0];

        $status = \M\File::save($file);

        if (is_array($status)) {
            echo '上传失败~';
            return false;
        }

        $theme->main_img = $status;
        $theme->utime = date('Y-m-d', time());

        if ($theme->save()) {
            success();
        }
    }

    // 修改专题信息--图片小图
    public function actionHead($id)
    {
        $form = $this->form('files');

        $theme = a('theme', $id);

        if (!$theme->id) $this->redirect('error/error403');

        if (!empty($theme->head_img)) {
            alert('错误：专题主图只能有一张，请检查', 'theme/info/'.$id);
        }

        // 组合
        $file['name'] = $form['theme-head']['name'][0];
        $file['size'] = $form['theme-head']['size'][0];
        $file['type'] = $form['theme-head']['type'][0];
        $file['tmp_name'] = $form['theme-head']['tmp_name'][0];

        $status = \M\File::save($file);

        if (is_array($status)) {
            echo '上传失败';
            return false;
        }

        $theme->head_img = $status;
        $theme->utime = date('Y-m-d', time());

        if ($theme->save()) {
            success();
        }
    }

    // 专题关联商品
    public function actionConnect($id)
    {
        if (!$id) $this->redirect('error/error403');

        // 数据获取
        $form = $this->form('post');

        // 数据存储
        $theme = a('theme', $id);

        if (!$theme->id) $this->redirect('error/error403');

        // 清空theme关联
        $db = \M\Database::db();

        $db->query(sprintf("DELETE FROM `_r_theme_product` WHERE id1 = '%s';", $id));

        // 循环创建关联
        foreach ($form['products'] as $v) {
            $product = a('product' ,$v);
            if (!$product->id) continue;

            $theme->connect($product);
        }

        $this->redirect('theme/info/'.$id);
    }

    // 唯一横图展示
    public function actionOnly()
    {
        // 数据获取
        $form = $this->form('post');

        $only = $form['only_id'];

        $db = \M\Database::db();

        // 清空theme关联
        $db->query("UPDATE `theme` set only = '';");

        $theme = a('theme', $only);

        if (!$theme->id) $this->redirect('error/error403');

        $theme->only = 11;

        if ($theme->save()) $this->redirect('theme');
    }

    // theme整体删除
    public function actionDelete($id)
    {
        if (!$id) $this->redirect('error/error403');

        $theme = a('theme', (int)$id);

        if (!$theme->id) $this->redirect('error/error403');
var_dump($theme->main_img);
        // 删除图片
        \M\File::delete($theme->main_img);

        var_dump('asd');

        \M\File::delete($theme->head_img);

        var_dump('asd');

        $theme->delete();

        $this->redirect('theme');
    }
}
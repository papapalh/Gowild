<?php
namespace M\Controller\CGI;

class Banner extends \M\Controller\CGI\Admin\Layout
{
    public function __index()
    {
        $banners = those('banner')->redis();

        $this->display('admin/layout',[
            'body' => V('wx/banner/list',[
                    'banners' => $banners
                ])
        ]);
    }

    public function actionInfo($id = '')
    {
        if (!$id) $this->redirect('error/error403');

        $banner = a('banner', (int)$id);

        if (!$banner->id) $this->redirect('error/error403');

        $banner_images = those('banner_image')->whose('banner_id')->is($banner)->redis();

        $this->display('admin/layout',[
                'body' => V('wx/banner/info',[
                    'banner' => $banner,
                    'banner_images' => $banner_images
                ])
        ]);
    }

    // 添加banner模块
    public function actionUpload($id = '')
    {
        // 数据获取
        $form = $this->form('post');

        // 数据存储
        $banner = a('banner', $id);

        $banner->name = $form['name'];
        $banner->description = $form['description'];
        $banner->status = $form['status'];
        $banner->ctime = date('Y-m-d H:i:s', time());

        if ($banner->save()) {
            $this->redirect('banner');
        }
        else {
            alert('错误: 一个状态的数据只能有一条！', 'banner');
        }
    }

    // banner图片添加
    public function actionImg($id)
    {
        if (!$id) $this->redirect('error/error403');

        // 获取上传文件
        $form = $this->form('files');

        // 获取传入文件数组
        $banners = $form['banner'];

        // 组合传入file
        for ($i=0; $i < count($banners); $i++) {

            // 获取已有图片个数
            $banner_images = those('banner_image')->whose('banner_id')->is($id)->redis();

            $file['name'] = $banners['name'][$i];
            $file['size'] = $banners['size'][$i];
            $file['type'] = $banners['type'][$i];
            $file['tmp_name'] = $banners['tmp_name'][$i];

            if (count($banner_images) >= 4) {
                alert('上传失败！最大只可上传4张图片', 'banner/info/'.$id);
            }

            $banner_image = a('banner_image');
            $banner_image->banner_id = 1;

            $status = \M\File::save($file);      

            if (is_array($status)) {
                continue;
            }

            $banner_image->url = $status;
            $banner_image->ctime = date('Y-m-d H:i:s', time());

            $banner_image->save();
        }
        success();
    }

    // banner图片删除
    public function actionDelete($id)
    {
        if (!$id) $this->redirect('error/error403');

        $banner = a('banner', (int)$id);

        if (!$banner->id) $this->redirect('error/error403');

        // 删除模块关联
        $banner_images = those('banner_image')->whose('banner_id')->is($id)->redis();

        foreach ($banner_images as $image) {
            // 删除图片文件
            \M\File::delete($image->url);
            // 删除对应数据
            $image->delete();
        }

        $banner->delete();

        $this->redirect('banner');
    }

}
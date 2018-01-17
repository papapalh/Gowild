<?php
namespace M\Controller\CGI;

class Product extends \M\Controller\CGI\Admin\Layout
{
    public function __index()
    {
        $products = those('product')->redis();

        $form = $this->form('post');

        $this->display('admin/layout',[
            'body' => V('wx/product/list',[
                    'products' => $products
                ])
        ]); 
    }

    public function actionInfo($id = '')
    {
        if (!$id) $this->redirect('error/error403');

        $product = a('product', $id);

        if (!$product->id) $this->redirect('error/error404');

        $this->display('admin/layout',[
                'body' => V('wx/product/info',[
                    'product' => $product
                ])
            ]);
    }

    // 添加商品
    public function actionAdd($id = '')
    {
        $form = $this->form('post');

        $product = a('product', $id);
        $product->name = $form['name'];
        $product->price = $form['price'];
        $product->stock = $form['stock'];
        $product->ctime = date('Y-m-d', time());
        $product->save();
        $this->redirect('product');
    }

    // 修改商品信息--图片
    public function actionUpdate($id)
    {
        $form = $this->form('files');

        $product = a('product', $id);

        if (!$product->id) $this->redirect('error/error403');

        if (!empty($product->main_img)) {
            alert('错误：商品主图只能有一张，请检查', 'product/info/'.$id);
        }

        // 组合
        $file['name'] = $form['product-main']['name'][0];
        $file['size'] = $form['product-main']['size'][0];
        $file['type'] = $form['product-main']['type'][0];
        $file['tmp_name'] = $form['product-main']['tmp_name'][0];

        $status = \M\File::save($file);

        if (is_array($status)) alert('上传失败', 'product/info/'.$id);

        $product->main_img = $status;
        $product->utime = date('Y-m-d', time());

        if ($product->save()) {
            success();
        }
    }

    // 商品详情
    public function actionDetails($id)
    {
        if (!$id) $this->redirect('error/error403');

        $form = $this->form('post');

        $product_details = a('product_details')->whose('product_id')->is($id)->redis();

        if (!$product_details->id) {
            $product_details = a('product_details');
        }
        $product_details->product_id = $id;
        $product_details->content = $form['content'];

        if ($product_details->save()) {
            $this->redirect('product/info/'.$id);
        }
    }

    // 商品参数
    public function actionParams($id)
    {
        if (!$id) $this->redirect('error/error403');

        $form = $this->form('post');

        $product_params = a('product_params')->whose('product_id')->is($id)->redis();

        if (!$product_params->id) {
            $product_params = a('product_params');
        }
        $product_params->product_id = $id;
        $product_params->content = $form['content'];

        if ($product_params->save()) {
            $this->redirect('product/info/'.$id);
        }
    }

    // 售后保障
    public function actionCustormer($id)
    {
        if (!$id) $this->redirect('error/error403');

        $form = $this->form('post');

        $product_custormer = a('product_custormer')->whose('product_id')->is($id)->redis();

        if (!$product_custormer->id) {
            $product_custormer = a('product_custormer');
        }
        $product_custormer->product_id = $id;
        $product_custormer->content = $form['content'];

        if ($product_custormer->save()) {
            $this->redirect('product/info/'.$id);
        }
    }

    // 用于富文本编辑器上传图片
    public function actionFile()
    {
        // 上传文件
        $files = $this->form('files');
        $one_file = array_shift($files);

        if ($one_file) {
            // 组合图片信息
            $file['name'] = $one_file['name'];
            $file['size'] = $one_file['size'];
            $file['type'] = $one_file['type'];
            $file['tmp_name'] = $one_file['tmp_name'];

            $status = \M\File::save($file);

            // 失败
            if (is_array($status)) {
                $status['code'] = 11;
                echo json_encode($status, JSON_UNESCAPED_UNICODE);
            }
            // 成功
            else {
                echo json_encode(['code' => 0, 'url' => \M\URI::url().$status]);
            }
        }
    }
}
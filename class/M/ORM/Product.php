<?php

namespace M\ORM;

class Product extends \M\ORM{

    public $name            = 'string:150';            // 商品名称
    public $price           = 'double:null:default:0'; // 商品价格
    public $stock           = 'int:null:default:0';    // 库存
    public $category        = 'object:category';       // 关联模块
    public $main_img        = 'string:150';            // 商品主图
    public $detail_img      = 'string:150';            // 详情图
    public $ctime           = 'datetime';              // 创建时间
    public $utime           = 'datetime';              // 更新时间
    public $dtime           = 'datetime';              // 删除时间

    protected static $db_index = [
      
    ];
}
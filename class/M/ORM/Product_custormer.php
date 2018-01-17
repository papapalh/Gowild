<?php

namespace M\ORM;

class Product_custormer extends \M\ORM{

    public $product         = 'object:product'; // 关联商品
    public $content         = 'text';           // 内容

    protected static $db_index = [
        'unique:product',
    ];
}

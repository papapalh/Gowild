<?php

namespace M\Module\Validator;

class People extends \M\Module\Validator
{
    public $_from;

    // 获取数据校验
  function __construct($from)
  {
      $this->_from = $from;
  }

  // 校验
}
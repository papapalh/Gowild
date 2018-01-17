<?php

namespace M\Module;

class Validator
{

    // 检查数据传入是否正确
      public function check($check)
      {
      var_dump($check);
      die;
          switch ($type) {
              case 'int':
                  return $this->_drive->is_int($o);
                  break;
              
              default:
                  # code...
                  break;
          }
      }

      public function is_int($int)
      {
          if (!is_numeric($int)) {
              return false;
          }
          return true;
      }
}
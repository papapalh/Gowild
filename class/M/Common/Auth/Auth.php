<?php
namespace M\Common\Auth {

class Auth
    {
        private $_username;
        private $_driver;

        // 校验登录姓名
        static function normalize($username = null) {
            if (!$username) return false;
            $username = trim($username);
            if (!$username) return '';

            // if (!preg_match('/\|[\w.-]+/', $username)) {
            //     die('登录姓名格式错误');
            // }

            return $username;
        }

        public function verify($password)
        {
            if (!$this->_username) {
                die('没有定义登录名');
            }

            return $this->_driver->verify($this->_username, $password);
        }

        static function isLoggedIn()
        {
            $token = G('ME');
            if (!$token) {
                return false;
            }
            return true;
        }

        static function go()
        {
            S('username', '');
        }


        public function createPassword($password)
        {
            return $this->_driver->createPassword($this->_username, $password);
        }

        function __construct($username) 
        {
            $this->_username = $username;
            $this->_driver = \M\IoC::construct('M\Common\Auth\Module', $username);
        }
    }
}
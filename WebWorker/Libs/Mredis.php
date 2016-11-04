<?php
namespace WebWorker\Libs;

class Mredis extends \Redis{

    /**
     * 静态成品变量 保存全局实例
     */
    private static  $_instance = array();

    /**
     * 静态工厂方法，返还此类的唯一实例
     */
    public static function getInstance($config=array()) {
        $key = md5(implode(":",$config));
        if (!isset(self::$_instance[$key])) {
            self::$_instance[$key] = new self();
            $host = $config["host"] ? $config["host"] : "127.0.0.1";
            $port = $config["port"] ? $config["port"] : 6379;
            self::$_instance[$key]->connect($host,$port);
            $password = $config["password"] ? $config["password"] : "";
            if ( $password ){
                self::$_instance[$key]->auth($password);
            }
            $db = $config["db"] ? $config["db"] : 0;
            if ( !self::$_instance[$key]->select($db) ){
                echo "redis can't connect\r\n";
            }
        }
        return self::$_instance[$key];
    }

}

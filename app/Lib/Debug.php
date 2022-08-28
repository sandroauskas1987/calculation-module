<?php
namespace App\Lib;

use \Psr\Container\ContainerInterface as ContainerInterface;


class Debug {
    private static $_instance;
    protected $container;
    protected $data=[];

    public function __construct(ContainerInterface $container,$args=null) {
        $this->container = $container;
    }

    public static function getInstance(ContainerInterface $container,$args=null) {
        if (self::$_instance === null) {
            self::$_instance = new self($container,$args);
        }
        return self::$_instance;
    }

    public function set($key,$value){
        if (isset($this->data[$key])){
            $temp = $this->data[$key];
            if (!is_array($temp)){
                $this->data[$key]=[];
                $this->data[$key][] = $temp;
                $this->data[$key][]=$value;
            }else
                $this->data[$key][]=$value;
        }else{
            $this->data[$key]=$value;
        }
    }

    public function get($key=null){
        if ($key){
            if (isset($this->data[$key]))
               return  isset($this->data[$key]);
            else return null;
        }
        return $this->data;
    }




}

<?php
namespace Itxiao6\Container;
/**
 * 容器
 * Class Container
 * @package Itxiao6\Container
 */
class Container
{
    /**
     * 容器接口
     * @var null|self
     */
    protected static $Interface = null;
    /**
     * 容器
     * @var array
     */
    protected $container = [];
    /**
     * 构造存储器
     * @var array
     */
    protected $interfaces = [];

    /**
     * 获取接口
     * @return Container|null
     */
    public static function get_Interface()
    {
        if(self::$Interface === null){
            echo('实例化'."\n");
            self::$Interface = new static();
        }
        return self::$Interface;
    }

    /**
     * 设置值
     * @param $name
     * @param $value
     */
    public function set($name,$value){
        $this -> container[$name] = $value;
    }

    /**
     * 获取值
     * @param $name
     * @return mixed|null
     * @throws \Exception
     */
    public function get($name)
    {
        /**
         * 判断容器里是否存在
         */
        if(!isset($this -> container[$name])){
            /**
             * 判断构造器容器内是否存在
             */
            if(isset($this -> interfaces[$name])){
                /**
                 * 构造
                 */
                $this -> container[$name] = $this -> make($name);
                /**
                 * 返回
                 */
                return $this -> container[$name];
            }else{
                throw new \Exception($name.'构造器不存在');
            }
        }
        /**
         * 返回容器内的内容
         */
        return $this -> container[$name];
    }

    /**
     * 实例化一个示例
     * @param $name
     * @return mixed
     */
    public function make($name)
    {
        return $this -> $this->interfaces[$name]['callback'](...$this -> $this->interfaces[$name]['args']);
    }

    /**
     * 绑定一个依赖
     * @param $name
     * @param \Closure $callback
     * @param array $args
     * @return mixed
     */
    public function build($name,$callback = null,$args = [])
    {
        return $this -> interfaces[$name] = [
            'callback'=>$callback,
            'args'=>$args
        ];
    }
}
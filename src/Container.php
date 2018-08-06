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
     * @var null|array
     */
    protected static $interface = null;
    /**
     * 容器名称
     * @var string
     */
    protected $container_name = 'global';
    /**
     * 存储构造器
     * @var array
     */
    protected $build_lists = [];
    /**
     * 容器内的 实例化后的内容
     * @var array
     */
    protected $interfaces_lists = [];

    /**
     * 获取接口
     * @param null|string $containerName
     * @return Container
     */
    public static function getInterface($containerName = 'global')
    {
        if(!isset(self::$interface[$containerName])){
            self::$interface[$containerName] = new self($containerName);
        }
        return self::$interface[$containerName];
    }

    /**
     * 设置为可全局访问
     * @return $this
     */
    public function set_global()
    {
        self::$interface[$this -> container_name] = $this;
        return $this;
    }

    /**
     * 构造器
     * Container constructor.
     * @param string $containerName
     */
    protected function __construct($containerName = 'global')
    {
        $this -> container_name = $containerName;
    }

    /**
     * 获取容器内的实例
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        if(!isset($this ->interfaces_lists[$name])){
            $interface = $this ->interfaces_lists[$name];
        }else{
            $interface = $this -> make($name);
        }
        return $interface;
    }
    /**
     * 创造一个实例
     * @param $name
     * @return mixed
     */
    public function make($name)
    {
        return $this -> {$this->build_lists[$name]['callback']}(...$this -> $this->build_lists[$name]['args']);
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
        return $this -> build_lists[$name] = [
            'callback'=>$callback,
            'args'=>$args
        ];
    }
}
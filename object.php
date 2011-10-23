<?php
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('BASEDIR')) {
    define('BASEDIR', realpath(dirname(__FILE__) . DS .'..'));
}
if (!defined('CONFIGDIR')) {
    define('CONFIGDIR', BASEDIR . DS .'Configurer');
}
if (!defined('CONTROLLERDIR')) {
    define('CONTROLLERDIR', BASEDIR . DS .'Controller');
}

interface IObject
{
}

class Objects implements IObject
{
    //对象路径
    public $paths = array();

    public $object = null;

    public function __construct($name)
    {
        $this->load($name);
    }

    private function init($conf)
    {
        include_once(CONFIGDIR . DS . $conf . '.php');
        //配置数组的名字和文件名相同
        $this->paths = $PATHS;
    }

    private function load($name)
    {
        $this->init('paths');
        if (file_exists($this->paths[$name])) {
            include_once($this->paths[$name]);
        }
        else {
            exit($name . ' file not exist.');
        }
        $this->$name = new $name();
        return $this->$name;
    }
}

class ObjectFactory
{
    static public function create($name = null)
    {
       $obj = new Objects($name);
       return $obj->$name;
    }
}

//$displayer = ObjectFactory::create('Displayer');
//$displayer -> say();

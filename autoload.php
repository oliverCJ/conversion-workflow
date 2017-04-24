<?php
/**
 * 自动加载
 */
final class Autoload {

    protected static $instance;
    protected static $filePath = array();

    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->setPath(dirname(__FILE__));
    }

    public function setPath($path)
    {
        if (is_dir($path)) {
            array_push(self::$filePath, $path);
        }
        return $this;
    }

    private function load($class)
    {
        $pathArray = explode('\\', $class);
        if (isset($pathArray[1])) {
            array_shift($pathArray);
            $pathArray[count($pathArray)-1] = strtolower($pathArray[count($pathArray)-1]);
        }
        $path = implode(DIRECTORY_SEPARATOR, $pathArray);
        if (!empty(self::$filePath)) {
            foreach (self::$filePath as $dir) {
                $fileName = $dir . DIRECTORY_SEPARATOR . $path . '.php';
                if (file_exists($fileName)) {
                    include $fileName;
                }
            }
        }
    }

    public function init()
    {
        spl_autoload_register(array($this,'load'));
        return $this;
    }
}

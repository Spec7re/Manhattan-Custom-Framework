<?php
/**
 * Created by PhpStorm.
 * User: specter
 * Date: 16.01.18
 * Time: 15:02
 */

/**
 * Created by PhpStorm.
 * User: specter
 * Date: 04.01.18
 * Time: 17:47
 */
namespace MH;

final class Loader
{
    private static $namespaces = array();


    private function __construct()
    {

    }

    public static function registerAutoLoad(){
        spl_autoload_register(array("\MH\Loader", 'autoload'));
    }

    public static function autoload($class){
        self::loadClass($class);
    }

    public static function loadClass($class)
    {
        foreach (self::$namespaces as $k => $v)
        {
            if(strpos($class, $k ) == 0)
            {
//                echo $k.'<br>'.$v.'<br>'.$class.'<br>';
//                $f = str_replace('\\', DIRECTORY_SEPARATOR, $class) ;
//                $f = substr_replace($f, $v, 0, strlen($k)).'.php';
//                $f = realpath($f);
//                if($f && is_readable($f)){
//
//                    include  $f;
//                }


                $file = realpath(substr_replace(str_replace('\\',DIRECTORY_SEPARATOR, $class), $v, 0,
                        strlen($k)) . '.php');

                if($file && is_readable($file))
                {
                    include $file;
                } else {
                    throw new \Exception('File cannot be included'. $file);
                }
                break;
            }
        }
    }

    public static function registerNamespaces($ar)
    {
        if (is_array($ar))
        {
            foreach ($ar as $k => $v)
            {
                self::registerNamespace($k, $v);
            }
        }
        else
        {
            throw new \Exception('Invalid namespaces');
        }
    }

    /**
     * @param $namespace
     * @param $path
     * @throws \Exception
     */
    public static function registerNamespace($namespace, $path)
    {
        $namespace = trim($namespace);

        if(strlen($namespace) > 0)
        {
            if(!$path)
            {
                throw new \Exception('Invalid Path');
            }

            $_path = realpath($path);

            if($_path && is_dir($_path) && is_readable($_path))
            {
                self::$namespaces[$namespace.'\\'] = $_path . DIRECTORY_SEPARATOR;
            }
            else
            {
                throw new \Exception('Namespace directory read error:'. $path);
            }
        }
//      TODO
        else
        {
            throw  new \Exception('No namespace or no path ');
        }

    }



}
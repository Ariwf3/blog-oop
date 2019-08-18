<?php

namespace Ariwf3\Blog_oop\Application\Classes\Config;

require_once("application/classes/config/Directory.php");
use Ariwf3\Blog_oop\Application\Classes\Config\Directory;

class Autoloader extends Directory {

    
    /**
     * loadClass callback function for spl_autoload register find the appropriate class 
     *
     * @param string $class the classname
     *
     * @return void
     */
    public static function loadClass(string $class) :void {

        PARENT::requireFileWithoutNamespace($class);
    }

    /**
     * autoload automatically loads classes
     *
     * @return void
     */
    public static function autoload(){
        spl_autoload_register(array(__CLASS__ , 'loadclass'));
    }


}
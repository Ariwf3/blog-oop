<?php

namespace Ariwf3\Blog_oop\Application\Classes\Config;

class Autoloader {

    const CONTROLLER_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Controllers';
    const CONTROLLER_DIRECTORY = 'application/controllers/';

    const CONTROLLER_FRONT_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Controllers\\Front';
    const CONTROLLER_FRONT_DIRECTORY = 'application/controllers/front/';
    const CONTROLLER_BACK_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Controllers\\Back';
    const CONTROLLER_BACK_DIRECTORY = 'application/controllers/back/';
    
    const MODEL_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Models';
    const MODEL_DIRECTORY = 'application/models/';

    const MODEL_FRONT_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Models\\Front';
    const MODEL_FRONT_DIRECTORY = 'application/models/front/';

    const MODEL_BACK_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Models\\Back';
    const MODEL_BACK_DIRECTORY = 'application/models/back';

    const ENTITY_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Classes\\Entity';
    const ENTITY_DIRECTORY = 'application/classes/entity/';

    const EXCEPTION_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Classes\\Exceptions';
    const EXCEPTION_DIRECTORY = 'application/classes/exceptions/';

    const CONFIG_NAMESPACE = __NAMESPACE__ ;
    const CONFIG_DIRECTORY = 'application/classes/config';


    /**
     * loadClass callback function for spl_autoload register find the class according to the class name
     *
     * @param string $class the classname
     *
     * @return void
     */
    public static function loadClass(string $class) :void {

        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

        if (substr($class, -10) === 'Controller') {
            $class = str_replace(SELF::CONTROLLER_NAMESPACE, "", $class);
            require_once SELF::CONTROLLER_DIRECTORY . $class . '.php';
            
        } 
        else if (substr($class, -15) === 'FrontController') {
            $class = str_replace(SELF::CONTROLLER_FRONT_NAMESPACE, "", $class);
            require_once SELF::CONTROLLER_FRONT_DIRECTORY . $class . '.php';
        }
        else if (substr($class, -14) === 'BackController') {
            $class = str_replace(SELF::CONTROLLER_BACK_NAMESPACE, "", $class);
            require_once SELF::CONTROLLER_BACK_DIRECTORY . $class . '.php'; 
        } 
        else if (substr($class, -5) === 'Model') {
            $class = str_replace(SELF::MODEL_NAMESPACE, "", $class);
            require_once SELF::MODEL_DIRECTORY . $class . '.php'; 
        }
        else if (substr($class, -10) === 'FrontModel') 
        {
            $class = str_replace(SELF::FRONT_MODEL_NAMESPACE, "", $class);
            require_once SELF::MODEL_FRONT_DIRECTORY . $class . '.php';
        } 
        else if (substr($class, -9) === 'BackModel') 
        {
            $class = str_replace(SELF::MODEL_BACK_NAMESPACE, "", $class);
            require_once SELF::MODEL_BACK_DIRECTORY . $class . '.php';
        } 
        else if (substr($class, -9) === 'Exception') 
        {
            $class = str_replace(SELF::EXCEPTION_NAMESPACE, "", $class);
            require_once SELF::EXCEPTION_DIRECTORY . $class . '.php';
        }
        else if (substr($class, -6) === 'Entity') 
        {
            $class = str_replace(SELF::ENTITY_NAMESPACE, "", $class);
            require_once SELF::ENTITY_DIRECTORY . $class . '.php';
        } 
        else {
            $class = str_replace(SELF::CONFIG_NAMESPACE, "", $class);
            require_once SELF::CONFIG_DIRECTORY . $class. '.php';
        }

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
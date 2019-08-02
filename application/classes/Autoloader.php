<?php

namespace Ariwf3\Blog_oop\Application\Classes;

class Autoloader {

    const CONTROLLER_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Controllers';
    const CONTROLLER_DIRECTORY = 'application/controllers/';

    const CONTROLLER_FRONT_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Controllers\\Front';
    const CONTROLLER_FRONT_DIRECTORY = 'application/controllers/front/';

    const MODEL_FRONT_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Models\\Front';
    const MODEL_FRONT_DIRECTORY = 'application/models/front/';

    const CONTROLLER_BACK_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Controllers\\Back';
    const CONTROLLER_BACK_DIRECTORY = 'application/controllers/back/';
    
    const MODEL_BACK_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Models\\Back';
    const MODEL_BACK_DIRECTORY = 'application/models//back';


    const EXCEPTIONS_NAMESPACE = __NAMESPACE__ . '\\Exceptions';
    const EXCEPTIONS_DIRECTORY = 'application/classes/exceptions/';

    const CLASSES_NAMESPACE = __NAMESPACE__ ;
    const CLASSES_DIRECTORY = 'application/classes/';


    /**
     * loadClass callback function for spl_autoload register find the class according to the class name
     *
     * @param string $class the classname
     *
     * @return void
     */
    public static function loadClass($class) :void {

        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

        if (substr($class, -10) === 'Controller') {
            $class = str_replace(SELF::CONTROLLER_NAMESPACE, "", $class);
            require_once SELF::CONTROLLER_DIRECTORY . $class . '.php';
            
        } else if (substr($class, -15) === 'FrontController') {
            $class = str_replace(SELF::CONTROLLER_FRONT_NAMESPACE, "", $class);
            require_once SELF::CONTROLLER_FRONT_DIRECTORY . $class . '.php';
        }
        else if (substr($class, -14) === 'BackController') {
            $class = str_replace(SELF::CONTROLLER_BACK_NAMESPACE, "", $class);
            require_once SELF::CONTROLLER_BACK_DIRECTORY . $class . '.php'; 
        } 
        else if (substr($class, -10) === 'FrontModel') {
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
            $class = str_replace(SELF::EXCEPTIONS_NAMESPACE, "", $class);
            require_once SELF::EXCEPTIONS_DIRECTORY . $class . '.php';
        } else {
            $class = str_replace(SELF::CLASSES_NAMESPACE, "", $class);
            require_once SELF::CLASSES_DIRECTORY . $class. '.php';
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
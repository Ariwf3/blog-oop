<?php

namespace Ariwf3\Blog_oop\Application\Classes;

class Autoloader {

    const FRONT_CONTROLLER_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Front\\Controllers';
    const FRONT_CONTROLLER_DIRECTORY = 'application/front/controllers/';
    const FRONT_MODEL_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Front\\Models';
    const FRONT_MODEL_DIRECTORY = 'application/front/models/';

    const BACK_CONTROLLER_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Back\\Controllers';
    const BACK_CONTROLLER_DIRECTORY = 'application/back/controllers/';
    const BACK_MODEL_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Back\\Models';
    const BACK_MODEL_DIRECTORY = 'application/back/models/';

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

        if (substr($class, -15) === 'FrontController') {
            $class = str_replace(SELF::FRONT_CONTROLLER_NAMESPACE, "", $class);
            require_once SELF::FRONT_CONTROLLER_DIRECTORY . $class . '.php';
        } 
        else if (substr($class, -14) === 'BackController') {
            $class = str_replace(SELF::BACK_CONTROLLER_NAMESPACE, "", $class);
            require_once SELF::BACK_CONTROLLER_DIRECTORY . $class . '.php'; 
        } 
        else if (substr($class, -10) === 'FrontModel') {
            $class = str_replace(SELF::FRONT_MODEL_NAMESPACE, "", $class);
            require_once SELF::FRONT_MODEL_DIRECTORY . $class . '.php';
        } 
        else if (substr($class, -9) === 'BackModel') 
        {
            $class = str_replace(SELF::BACK_MODEL_NAMESPACE, "", $class);
            require_once SELF::BACK_MODEL_DIRECTORY . $class . '.php';
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
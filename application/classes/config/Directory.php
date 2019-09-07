<?php

namespace Ariwf3\Blog_oop\Application\Classes\Config;


class Directory {

    const CONTROLLER_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Controllers';
    const CONTROLLER_DIRECTORY = 'application/controllers/';

    const MODEL_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Models';
    const MODEL_DIRECTORY = 'application/models/';

    const ENTITY_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Classes\\Entity';
    const ENTITY_DIRECTORY = 'application/classes/entity/';

    const EXCEPTION_NAMESPACE = 'Ariwf3\\Blog_oop\\Application\\Classes\\Exceptions';
    const EXCEPTION_DIRECTORY = 'application/classes/exceptions/';

    const CONFIG_NAMESPACE = __NAMESPACE__ ;
    const CONFIG_DIRECTORY = 'application/classes/config';

    /**
     * requireFileWithoutNamespace Calls a page corresponding to a class without the namespace in the class name according to the folder name
     *
     * @param  string $class
     *
     * @return void
     */
    public function requireFileWithoutNamespace(string $class) :void {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

        if (substr($class, -10) === 'Controller') {
            $class = str_replace(SELF::CONTROLLER_NAMESPACE, "", $class);
            require_once SELF::CONTROLLER_DIRECTORY . $class . '.php';
            
        } 
        else if (substr($class, -5) === 'Model') {
            $class = str_replace(SELF::MODEL_NAMESPACE, "", $class);
            require_once SELF::MODEL_DIRECTORY . $class . '.php'; 
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
}
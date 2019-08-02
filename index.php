<?php
require 'application/classes/Autoloader.php';

use Ariwf3\Blog_oop\Application\Classes\Autoloader;
use Ariwf3\Blog_oop\Application\Classes\Exceptions\HandlerUncaughtException;
use Ariwf3\Blog_oop\Application\Controllers\HomeController;
use Ariwf3\Blog_oop\Application\Controllers\ErrorController;
Autoloader::autoload();
HandlerUncaughtException::set_exception();

try {
    $homeController = new HomeController();
    $errorController = new ErrorController();

    if( iset($_GET['page']) ) {
        $page = $_GET['page'];

        switch ($page) {
            case 'home':
                $homeController->renderView();
                break;
            
            default: 
                $errorController->renderView('404');
                break;
        }
    } else {
        $homeController->renderView();
    }
    
} catch(Exception $e) {
    $line = $e->getLine();
    $file = $e->getFile();
    
} catch(PDOException $e) {
    $line = $e->getLine();
    $file = $e->getFile();
} catch (ErrorException $e) {
    echo 'test';
}



/* if( isset($_GET['page']) ) {
    echo 'page';
} else {
    $HomeController->renderView();
} */
<?php
require 'application/classes/Autoloader.php';

use Ariwf3\Blog_oop\Application\Classes\Autoloader;
use Ariwf3\Blog_oop\Application\Classes\Exceptions\MyException;
use Ariwf3\Blog_oop\Application\Classes\Exceptions\HandlerUncaughtException;
use Ariwf3\Blog_oop\Application\Controllers\HomeController;
use Ariwf3\Blog_oop\Application\Controllers\ErrorController;
Autoloader::autoload();
HandlerUncaughtException::set_exception();

try {
    $homeController = new HomeController();
    $errorController = new ErrorController();

    if( isset($_GET['page']) ) {
        $page = (string) $_GET['page'];

        switch ($page) {
            case 'home':
                $homeController->renderHome();
                break;
            
            default: 
                $errorController->renderError('404','La page <span class="error_message">"' . $page . '" </span>est inexistante');
                break;
        }
    } else {
        $homeController->renderHome();
    }
    
} catch(MyException $e) {
    $message = $e;
    $errorController->renderError('myexception',$message);

} catch(PDOException $e) {
    $message = $e->getMessage;
    $errorController->renderError('pdo',$message);

} catch (InvalidArgumentException $e) {
    $message = $e->getMessage();
     $errorController->renderError('invalidArgument',$message);
}



<?php
require 'application/classes/Autoloader.php';

use Ariwf3\Blog_oop\Application\Classes\Autoloader;
use Ariwf3\Blog_oop\Application\Controllers\HomeController;
use Ariwf3\Blog_oop\Application\Controllers\ErrorController;
Autoloader::autoload();


$homeController = new HomeController();
$errorController = new ErrorController();

if( isset($_GET['page']) ) {
    $page = $_GET['page'];

    switch ($page) {
        case 'home':
            $homeController->renderView();
            break;
        case 'error':
            $errorController->renderView();
            break;
        
        default: 
            $errorController->renderView('404');
            break;
    }
} else {
    $homeController->renderView();
}

/* if( isset($_GET['page']) ) {
    echo 'page';
} else {
    $HomeController->renderView();
} */
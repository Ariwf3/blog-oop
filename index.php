<?php
require 'application/classes/Autoloader.php';

use Ariwf3\Blog_oop\Application\Classes\Autoloader;
use Ariwf3\Blog_oop\Application\Front\Controllers\HomeFrontController;
Autoloader::autoload();


$homeFrontController = new HomeFrontController();

if( isset($_GET['page']) ) {
    switch ($_GET['page']) {
        case 'home':
            $homeFrontController->renderView();
            break;
        
        default: 
            $homeFrontController->renderView();
            break;
    }
} else {
    $homeFrontController->renderView();
}

/* if( isset($_GET['page']) ) {
    echo 'page';
} else {
    $homeFrontController->renderView();
} */
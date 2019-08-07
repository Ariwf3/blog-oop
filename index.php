<?php
require 'application/classes/config/Autoloader.php';

use Ariwf3\Blog_oop\Application\Classes\Config\Autoloader;

use Ariwf3\Blog_oop\Application\Classes\Exceptions\MyException;
use Ariwf3\Blog_oop\Application\Classes\Exceptions\HandlerUncaughtException;
use Ariwf3\Blog_oop\Application\Classes\Exceptions\MyInvalidArgumentException;

use Ariwf3\Blog_oop\Application\Controllers\HomeController;
use Ariwf3\Blog_oop\Application\Controllers\Front\CommentController;
use Ariwf3\Blog_oop\Application\Controllers\ErrorController;

Autoloader::autoload();
HandlerUncaughtException::set_uncaught_exception();
MyException::set_error_exception();


try {
    $homeController = new HomeController();
    $errorController = new ErrorController();

    $commentController = new CommentController();
// strpos();


    if( isset($_GET['page']) ) {
        $page = (string) $_GET['page'];
        
        switch ($page) {
            case 'home':
            
                $homeController->renderHomeView();
                break;
            case 'comments':
                $id = (int) $_GET['id'];
                if ($id > 0 && isset($id)) {
                    $commentController->renderCommentView($id);
                } else {
                    throw new MyInvalidArgumentException("L'id entré n'est pas valide (possibilités : inexistant, non numérique ou inférieur à 1)");
                }
                
                break;
            
            default: 
                $errorController->renderErrorView('404','La page <span class="error_message">"' . $page . '" </span>est inexistante');
                break;
        }
    } else {
        $homeController->renderHomeView();
    }
    
} catch(MyException $e) {
    $message = $e;
    $errorController->renderErrorView('myexception',$message);

} catch(PDOException $e) {
    $message = $e->getMessage() . " ligne <span class='error_message'>" . $e->getline() . "</span> dans le fichier <span class='error_message'>" . $e->getfile() ."</span>";
    $errorController->renderErrorView('pdo',$message);

} catch (MyInvalidArgumentException $e) {
    $message = $e;
    $errorController->renderErrorView('invalidArgument',$message);
} 



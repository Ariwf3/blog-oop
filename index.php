<?php
session_start();
require 'application/classes/config/Autoloader.php';

use Ariwf3\Blog_oop\Application\Classes\Config\Autoloader;

use Ariwf3\Blog_oop\Application\Classes\Exceptions\MyException;
use Ariwf3\Blog_oop\Application\Classes\Exceptions\HandlerUncaughtException;
use Ariwf3\Blog_oop\Application\Classes\Exceptions\MyInvalidArgumentException;

use Ariwf3\Blog_oop\Application\Controllers\HomeController;
use Ariwf3\Blog_oop\Application\Controllers\Front\CommentController;
use Ariwf3\Blog_oop\Application\Controllers\Front\UserController;
use Ariwf3\Blog_oop\Application\Controllers\ErrorController;

Autoloader::autoload();
HandlerUncaughtException::set_uncaught_exception();
MyException::set_error_exception();


try {
    $homeController    = new HomeController();
    $errorController   = new ErrorController();
    $commentController = new CommentController();
    $userController    = new UserController();

    var_dump($_SESSION);

    if( isset($_GET['action']) ) {
        $action = (string) $_GET['action'];
        
        switch ($action) {
            case 'home':
                var_dump($_COOKIE);
                var_dump($_SESSION);
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

            case 'addComment':
                if (isset($_POST['author']) && isset($_POST['message'])) {
                    $id = (int) $_GET['id'];
                    $commentController->setErrors($_POST);
                    $commentController->addComment($id, $_POST);
                }   
                break;

            case 'signUp':
                $userController->renderSignUpView();
                break;
            case 'logUp':
                if (isset($_POST)) {
                    $userController->setErrors($_POST);
                    $userController->logUp($_POST);
                }
                
                break;

            case 'signIn':
                $userController->renderSignInView();
                break;

            case 'logIn':
                if (isset($_POST['emailSignIn']) && isset($_POST['password'])) {
                    $userController->setErrors($_POST);
                    $userController->logIn($_POST);
                } 
                break;

            case 'account':
                    $userController->renderAccountView();
                    break;

            case 'addPostView':
                    $userController->renderAddPostView();
                    break;

            case 'addPost':
                $id = (int) $_GET['id'];
                if ( isset($id) && $id > 0 ) {
                    $userController->setErrors($_POST);
                    $userController->addPost($id, $_POST);
                } else {
                    throw new MyInvalidArgumentException("L'id entré n'est pas valide (possibilités : inexistant, non numérique ou inférieur à 1)");
                }
                
                break;

            case 'editPostView':
                    $id = (int) $_GET['id'];
                    if ( isset($id) && $id > 0 ) {
                    $userController->renderEditPostView($id);
                    } else {
                    throw new MyInvalidArgumentException("L'id entré n'est pas valide (possibilités : inexistant, non numérique ou inférieur à 1)");
                    }
                break;

            case 'editPost':
                $id = (int) $_GET['id'];
                if ( isset($id) && $id > 0 ) {
                    $userController->setErrors($_POST);
                    $userController->editPost($id, $_POST);
                    } else {
                    throw new MyInvalidArgumentException("L'id entré n'est pas valide (possibilités : inexistant, non numérique ou inférieur à 1)");
                }
                break;

            case 'removePost':
                $id = (int) $_GET['id'];
                if ( isset($id) && $id > 0 ) {
                    $userController->removePost($id);
                    } else {
                    throw new MyInvalidArgumentException("L'id entré n'est pas valide (possibilités : inexistant, non numérique ou inférieur à 1)");
                }
                break;

            case 'logOut':
                $userController->logOut();
                break;

            default: 
                $errorController->renderErrorView('404','La page où l\'action <span class="error_message">"' . $action . '" </span>est inexistante');
                break;
        } // switch
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



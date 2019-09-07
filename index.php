<?php
session_start();
require 'application/classes/config/Autoloader.php';

use Ariwf3\Blog_oop\Application\Classes\Config\Autoloader;

use Ariwf3\Blog_oop\Application\Classes\Exceptions\MyException;
use Ariwf3\Blog_oop\Application\Classes\Exceptions\HandlerUncaughtException;
use Ariwf3\Blog_oop\Application\Classes\Exceptions\MyInvalidArgumentException;

use Ariwf3\Blog_oop\Application\Controllers\HomeController;
use Ariwf3\Blog_oop\Application\Controllers\Front\CommentController;
use Ariwf3\Blog_oop\Application\Controllers\Front\AccountController;
use Ariwf3\Blog_oop\Application\Controllers\Front\SignUpController;
use Ariwf3\Blog_oop\Application\Controllers\Front\SignInController;
use Ariwf3\Blog_oop\Application\Controllers\Front\SignOutController;
use Ariwf3\Blog_oop\Application\Controllers\Front\UserController;
use Ariwf3\Blog_oop\Application\Controllers\Front\PostController;
use Ariwf3\Blog_oop\Application\Controllers\Front\ChatController;
use Ariwf3\Blog_oop\Application\Controllers\ErrorController;

Autoloader::autoload();
HandlerUncaughtException::set_uncaught_exception();
MyException::set_error_exception();


try {
    $homeController    = new HomeController();
    $errorController   = new ErrorController();
    $commentController = new CommentController();
    $accountController = new AccountController();
    $signUpController  = new SignUpController();
    $signInController  = new SignInController();
    $signOutController = new SignOutController();
    $userController    = new UserController();
    $postController    = new PostController();
    $chatController    = new ChatController();

    // var_dump($_SESSION);

    if( isset($_GET['action']) ) {
        $action = (string) $_GET['action'];
        
        switch ($action) {
            case 'home':
                // var_dump($_COOKIE);
                
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
                $signUpController->renderSignUpView();
                break;
            case 'logUp':
                if (isset($_POST)) {
                    $signUpController->setErrors($_POST);
                    $signUpController->logUp($_POST);
                }
                
                break;

            case 'signIn':
                $signInController->renderSignInView();
                break;
            case 'logIn':
                if (isset($_POST['emailSignIn']) && isset($_POST['password'])) {
                    $signInController->setErrors($_POST);
                    $signInController->logIn($_POST);
                } 
                break;

            case 'account':
                $userController->redirectIfNotConnected();
                $accountController->renderAccountView();
                break;

            case 'logOut':
                $signOutController->logOut();
                break;

            case 'addPostView':
                $userController->redirectIfNotConnected();
                $postController->renderAddPostView();
                break;

            case 'addPost':
                
                $userController->redirectIfNotConnected();

                $id = (int) $_GET['id'];
                if ( isset($id) && $id > 0 ) {
                    $postController->setErrors($_POST);
                    $postController->addPost($id, $_POST);
                } else {
                    throw new MyInvalidArgumentException("L'id entré n'est pas valide (possibilités : inexistant, non numérique ou inférieur à 1)");
                }
                
                break;

            case 'editPostView':
                
                $userController->redirectIfNotConnected();

                $id = (int) $_GET['id'];
                if ( isset($id) && $id > 0 ) {
                    $postController->renderEditPostView($id);
                } else {
                    throw new MyInvalidArgumentException("L'id entré n'est pas valide (possibilités : inexistant, non numérique ou inférieur à 1)");
                }

                break;

            case 'editPost':

                $userController->redirectIfNotConnected();

                $id = (int) $_GET['id'];
                if ( isset($id) && $id > 0 ) {
                    $postController->setErrors($_POST);
                    $postController->editPost($id, $_POST);
                } else {
                    throw new MyInvalidArgumentException("L'id entré n'est pas valide (possibilités : inexistant, non numérique ou inférieur à 1)");
                }
                
                break;

            case 'removePost':
                
                $userController->redirectIfNotConnected();

                $id = (int) $_GET['id'];
                if ( isset($id) && $id > 0 ) {
                    $postController->removePost($id);
                } else {
                    throw new MyInvalidArgumentException("L'id entré n'est pas valide (possibilités : inexistant, non numérique ou inférieur à 1)");
                }
                
                
                break;

            case 'editUser':
                
                    $userController->redirectIfNotAdmin();

                    $id = (int) $_GET['id'];
                    if ( isset($id) && $id > 0 ) {
                        $userController->editUser($id,$_POST);
                    } else {
                        throw new MyInvalidArgumentException("L'id entré n'est pas valide (possibilités : inexistant, non numérique ou inférieur à 1)");
                    }
                
                break;

            case 'removeUser':
                
                    $userController->redirectIfNotAdmin();

                    $id = (int) $_GET['id'];
                    if ( isset($id) && $id > 0 ) {
                    $userController->removeUser($id);
                    } else {
                    throw new MyInvalidArgumentException("L'id entré n'est pas valide (possibilités : inexistant, non numérique ou inférieur à 1)");
                    }
                
                break;

                case 'chat':
                    $chatController->renderChatView();

                    break;
                    
                case 'addMessage':
                    if (isset($_POST)) {
                        $chatController->addMessageAjax($_POST);
                    }

                    break;   
                case 'loadMessage':
                    if (isset($_GET['id'])) {
                        $lastId = (int) $_GET['id'];
                        if ($lastId > 0) {
                            $chatController->loadMessageAjax($lastId);
                        }
                    }

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



<?php
namespace Ariwf3\Blog_oop\Application\Controllers\Front;

use Ariwf3\Blog_oop\Application\Models\UserModel;
use Ariwf3\Blog_oop\Application\Models\PostModel;

class UserController {

    private $errors = array();


    /**
     * setCookieOneYear Set a cookie for 1 year with httpOnly mode
     *
     * @param  string $cookieId
     * @param  mixed $userData
     *
     * @return void
     */
    public function setCookieOneYear(string $cookieId, string $userData) {
        $one_year =  365*24*3600;
        setcookie($cookieId, $userData, time() + $one_year, null, null ,false, true);
    }

 

    /**
     * redirectIfNotConnected redirects if user is not logged in 
     *
     * @return void
     */
    public function redirectIfNotConnected(){
        if (!isset($_SESSION['user'])) {
            header('Location: index.php');
            exit();
        }
    }

    /**
     * redirectIfNotAdmin redirects if user is not logged in and is not admin
     *
     * @return void
     */
    public function redirectIfNotAdmin(){
        if ( !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location:index.php');
            exit();
        }
    }

    
    public function editUser(int $userId,$post) {

            $this->redirectIfNotAdmin();

            $postModel = new UserModel();
            $postModel->updateUser($userId, $post);

            $role = $_SESSION['user']['role'];
            $connectedUserId = $_SESSION['user']['id'];

            header("Location: index.php?action=account&id=$connectedUserId");
        
    }

    public function removeUser(int $userId) {

       /*  if ( !isset($_SESSION['user']) && $_SESSION['user']['role'] !== 'admin') {
            header('Location:index.php'); */
            $this->redirectIfNotAdmin();
       
            $userModel = new UserModel();
            $userModel->deleteUser($userId);

            $role = $_SESSION['user']['role'];
            $connectedUserId = $_SESSION['user']['id'];

            header("Location: index.php?action=account&id=$connectedUserId");
        
    }

}

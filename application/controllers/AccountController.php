<?php
namespace Ariwf3\Blog_oop\Application\Controllers;

use Ariwf3\Blog_oop\Application\Controllers\UserController;
use Ariwf3\Blog_oop\Application\Models\PostModel;
use Ariwf3\Blog_oop\Application\Models\UserModel;

class AccountController {


    public function renderAccountView() {

            $userController = new UserController();
            $userController->redirectIfNotConnected();
            
            $postModel = new PostModel();

            $userPosts = $postModel->getPostsByUser($_SESSION['user']['id']);
            $posts = $postModel->getPosts();

            $userModel = new UserModel();
            $users = $userModel->getUsers();
        
            require 'public/views/back/accountView.phtml';
        
    }
}
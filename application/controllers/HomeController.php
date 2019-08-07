<?php

namespace Ariwf3\Blog_oop\Application\Controllers;

use Ariwf3\Blog_oop\Application\Models\PostModel;
use Ariwf3\Blog_oop\Application\Models\CommentModel;

class HomeController {

    /**
     * renderHomeView returns the view "homeView" : Page with all last posts and their last comments
     *
     * @return void
     */
    public function renderHomeView() {

        $postModel = new PostModel();
        $posts = $postModel->getPosts();

        $commentModel = new CommentModel();
    
        
        

        require 'public/views/front/homeView.phtml';
    }

}
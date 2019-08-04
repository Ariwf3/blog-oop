<?php

namespace Ariwf3\Blog_oop\Application\Controllers;

use Ariwf3\Blog_oop\Application\Models\HomeModel;

class HomeController {

    public function renderHome() {

        $homeModel = new HomeModel();
        $posts = $homeModel->getPosts();
        var_dump($posts);

        require 'public/views/front/homeview.phtml';
    }

}
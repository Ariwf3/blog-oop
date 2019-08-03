<?php

namespace Ariwf3\Blog_oop\Application\Controllers;

class HomeController {

    public function renderHome() {

        require 'public/views/front/homeview.phtml';
    }

}
<?php

namespace Ariwf3\Blog_oop\Application\Controllers;

class ErrorController {

    public function renderView($error = null) {
        require_once 'public/views/errorView.phtml';

    }
}
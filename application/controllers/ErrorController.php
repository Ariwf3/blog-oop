<?php

namespace Ariwf3\Blog_oop\Application\Controllers;

class ErrorController {

    public function renderView($error = null) {

        switch ($error) {
            case '404':
                $errorImg = '404';
                break;
            case 'woman':
                $errorImg = 'woman';
                break;
            
            default:
                # code...
                break;
        }
        require_once 'public/views/errorView.phtml';

    }
}
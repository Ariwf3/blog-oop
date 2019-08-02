<?php

namespace Ariwf3\Blog_oop\Application\Controllers;

class ErrorController {

    /**
     * renderView
     *
     * @param string $error the error name or code
     *
     * @return void
     */
    public function renderView(string $error = null) {

        switch ($error) {
            case '404':
                $errorTitle = 'Erreur 404 Page inexistante ou introuvable';
                $errorImg = '404';
                $errorMessage = 'Message d\'erreur de test';
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
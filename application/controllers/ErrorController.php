<?php

namespace Ariwf3\Blog_oop\Application\Controllers;

class ErrorController {

    
    /**
     * renderError displays the error view with its information (title,message,image)
     *
     * @param  string $errorName
     * @param  string $errorMessage
     *
     * @return void
     */
    public function renderError(string $errorName, string $errorMessage) {
        

        switch ($errorName) {
            case '404':
                $errorTitle = '<i class="fas fa-question-circle"></i> Erreur 404 Page inexistante ou introuvable';
                $errorImg = '404';
                $errorDescription = $errorMessage;
                break;
            case 'pdo':
                $errorTitle = '<i class="fas fa-database"></i> Erreur base de données';
                $errorImg = 'general';
                break;
            case 'invalidArgument':
                $errorTitle = '<i class="fas fa-exclamation-circle"></i> Paramètre(s) invalide(s)';
                $errorImg = 'general';
                $errorDescription = $errorMessage;
                break;
            case 'myexception':
                $errorTitle = 'Exception de type "MyException"';
                $errorImg = 'general';
                $errorDescription = $errorMessage;
                break;
            
            default:
                $errorTitle = '<i class="fas fa-exclamation-circle"></i> Une erreur est survenue';
                $errorImg = 'general';
                $errorDescription = $errorMessage;
                break;
        }
        require_once 'public/views/errorView.phtml';

    }
}
<?php

namespace Ariwf3\Blog_oop\Application\Classes\Exceptions;

// require 'application/controllers/ErrorController.php';

class HandlerUncaughtException {

    
    /**
     * customException permet de personnaliser l'exception
     *
     * @param  mixed $e objet représentant l'exception
     *
     * @return void
     */
    public static function customException($e) :void {

        ob_start();
        ?>
            <p><strong>Exception non attrapée lancée :</strong></p>
            <p style="font-weight:bold">
                <span style="color:red"><?= $e->getMessage() ?> à la ligne <?= $e->getLine() ?></span> dans le fichier <span style="color:red"><?= $e->getFile() ?></span>
            </p>
        <?php

        $error = ob_get_clean();

        require 'public/views/errorView.phtml';
        
        /* $errorController = new \ariApplication\controllers\ErrorController();
        $errorController->renderError($error);  */ 
    }

    /**
     * dump
     *
     * @return void
     */
    public static function dump() {
        var_dump(__CLASS__);
    }
    
    /**
     * set_exception
     *
     * @return void
     */
    public static function set_exception() :void  {

        set_exception_handler(array(__CLASS__, 'customException'));
        
    }

}


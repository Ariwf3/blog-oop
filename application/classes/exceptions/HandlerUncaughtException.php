<?php

namespace Ariwf3\Blog_oop\Application\Classes\Exceptions;


class HandlerUncaughtException {

    
    /**
     * customException
     * 
     *  callback for the set_exception_handler function, customize the exception, takes as a parameter an object representing the exception 
     *
     * @param mixed $e object representing the exception
     *
     * @return void
     */
    public static function customException($e) :void {

        ob_start();
        ?>
            <span class="error_message"><?= $e->getMessage() ?> voir la ligne <u><?= $e->getLine() ?></u></span> dans le fichier <span class="error_message"><?= $e->getFile() ?></span>
        <?php
        $errorTitle = "Exception non attrapée lancée :";
        $errorImg = "uncaught_exception";
        $errorDescription = ob_get_clean();

        require 'public/views/errorView.phtml';
        
    }

    /**
     * set_exception intercepts uncaught exceptions
     *
     * @return void
     */
    public static function set_uncaught_exception() :void  {

        set_exception_handler(array(__CLASS__, 'customException'));
        
    }

}


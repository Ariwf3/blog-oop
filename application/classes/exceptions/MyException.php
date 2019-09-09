<?php

namespace Ariwf3\Blog_oop\Application\Classes\Exceptions;

class MyException extends \ErrorException {

    /**
     * exception_error_handler
     * 
     *  callback function for set_error_handler(), throwes an exception with error informations ($severity, $message, $file, $line)
     *
     * @param  int $severity severity of the error represented by a numerical code
     * @param  string $message 
     * @param  string $file 
     * @param  int $line
     *
     * @return void
     */
    public static function exception_error_handler(int $severity, string $message, string $file, int $line) :void
    {
        if (!(error_reporting() & $severity)) {
            
            return;
        }
        throw new MyException($message, 0, $severity, $file, $line);
    }


    /**
     * set_error_exception
     * 
     *  launches the set_error_handler function which sets a user-defined error handler function
     *
     * @return void
     */
    public static function set_error_exception() :void
    {
        set_error_handler(array(__CLASS__, "exception_error_handler"));
    }

    /**
     * __toString string formatted for display
     *
     * @return string
     */
    public function __toString() :string
    {

        switch ($this->severity)
        {
            case E_ERROR : $type = "Erreur fatale"; 
            case E_USER_ERROR : $type = 'Erreur fatale';
            break;
        
            case E_WARNING : $type = "Avertissement"; 
            case E_USER_WARNING : $type = 'Attention';
            break;
        
            case E_NOTICE : $type = "Note"; 
            case E_USER_NOTICE : $type = 'Note';
            break;

            default : $type = 'Erreur inconnue';
            break;
        }

        ob_start();
        ?>
            <?=$type?> : <span class="error_message"><?= $this->message ?> voir la ligne <u><?= $this->line ?></u></span> dans le fichier <span class="error_message"><?= $this->file ?></span>  
        <?php
        return ob_get_clean();
    } 
    

}


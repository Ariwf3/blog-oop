<?php

namespace Ariwf3\Blog_oop\Application\Classes\Exceptions;

class MyException extends \ErrorException {


/*    
    protected $message = 'exception inconnu'; // Message de l'exception.
  protected $code = 0; // Code de l'exception défini par l'utilisateur.
  protected $file; // Nom du fichier source de l'exception.
  protected $line; // Ligne de la source de l'exception.
  
  final function getMessage(); // Message de l'exception.
  final function getCode(); // Code de l'exception.
  final function getFile(); // Nom du fichier source.
  final function getLine(); // Ligne du fichier source.
  final function getTrace(); // Un tableau de backtrace().
  final function getTraceAsString(); // Chaîne formattée de trace.
  
  /* Remplacable 
  function __construct ($message = NULL, $code = 0);
  function __toString(); // Chaîne formatée pour l'affichage. */

    
    /**
     * exception_error_handler callback function for set_error_handler(), throwes an exception with error informations ($severity, $message, $file, $line)
     *
     * @param  int $severity severity of the error represented by a numerical code
     * @param  string $message 
     * @param  string $file 
     * @param  int $line
     *
     * @return void
     */
    public static function exception_error_handler($severity, $message, $file, $line) :void
    {
        if (!(error_reporting() & $severity)) {
            // This error code is not included in error_reporting
            return;
        }
        throw new MyException($message, 0, $severity, $file, $line);
    }

    public static function set_error_exception() :void
    {
        set_error_handler(array(__CLASS__, "exception_error_handler"));
    }


    /**
     * __toString string formatted for display
     *
     * @return void
     */
    public function __toString() :string
    {

    switch ($this->severity)
    {
        case E_ERROR : $type = "Erreur fatale"; //Si PHP émet une erreur fatale;
        case E_USER_ERROR : // Si l'utilisateur émet une erreur fatale;
        $type = 'Erreur fatale';
        break;
    
        case E_WARNING : $type = "Avertissement"; // Si PHP émet une alerte.
        case E_USER_WARNING : // Si l'utilisateur émet une alerte.
        $type = 'Attention';
        break;
    
        case E_NOTICE : $type = "Note"; // Si PHP émet une notice.
        case E_USER_NOTICE : // Si l'utilisateur émet une notice.
        $type = 'Note';
        break;

        default : // Erreur inconnue.
        $type = 'Erreur inconnue';
        break;
    }

        ob_start();
        ?>
            <?=$type?> : <span class="error_message"><?= $this->message ?> voir la ligne <u><?= $this->line ?></u></span> dans le fichier <span class="error_message"><?= $this->file ?></span>  
        <?php
        return ob_get_clean();
    } 
    

}


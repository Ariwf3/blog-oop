<?php

namespace Ariwf3\Blog_oop\Application\Classes\Exceptions;

class MyInvalidArgumentException extends \InvalidArgumentException {

    /**
     * __toString string formatted for display
     *
     * @return string
     */
    public function __toString() :string
    {
        ob_start();
        ?>
            <span class="error_message"><?= $this->message ?> voir la ligne <u><?= $this->line ?></u></span> dans le fichier <span class="error_message"><?= $this->file ?></span>
        <?php
        return ob_get_clean();
    }
}
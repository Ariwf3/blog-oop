<?php
namespace Ariwf3\Blog_oop\Application\Controllers;

class SignOutController {

    /**
     * logOut Logs out the user, destroys his session and redirects to the index
     *
     * @return void
     */
    public function logOut() {
        
        unset($_SESSION);
        session_destroy();

        header("location:index.php?action=home");
        exit();
    }

}
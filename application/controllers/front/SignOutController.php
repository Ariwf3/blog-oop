<?php
namespace Ariwf3\Blog_oop\Application\Controllers\Front;

class SignOutController {

    public function logOut() {
        
        unset($_SESSION);
        session_destroy();

        header("location:index.php?action=home");
        exit();
    }

}
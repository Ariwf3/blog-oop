<?php

namespace Ariwf3\Blog_oop\Application\Controllers\Front;

class UserController {


    public function renderSignUpView() {


        require 'public/views/front/signUpView.phtml';
    }
    public function renderSignInView() {


        require 'public/views/front/signInView.phtml';
    }


}

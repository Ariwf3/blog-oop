<?php

namespace Ariwf3\Blog_oop\Application\Classes\Entity;

class UsersEntity {

    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $role;
    public $pseudo;
    public $password;
    public $subscription_date;

    public function __construct() {
        $this->id = (int) $this->id;
        $this->firstname = ucwords($this->firstname);
        $this->lastname = ucwords($this->lastname);
        $this->pseudo = strtolower($this->pseudo);

        $this->subscription_date = new \DateTime($this->subscription_date);
    }

}
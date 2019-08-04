<?php

namespace Ariwf3\Blog_oop\Application\Models;

use Ariwf3\Blog_oop\Application\Classes\Config\Database;

class HomeModel extends Database {

    public function getPosts()
    {
        $sql = "SELECT id,title, post, creation_date FROM posts";
        $className = "PostsEntity";
        return $this->queryAllFetchClass($sql, $className);
    }
}
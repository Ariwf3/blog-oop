<?php

namespace Ariwf3\Blog_oop\Application\Controllers\Front;

use Ariwf3\Blog_oop\Application\Models\PostModel;
use Ariwf3\Blog_oop\Application\Models\CommentModel;

class CommentController {


    private $errors = array();


    public function setErrors(array $POST) {

        $author = htmlspecialchars( trim( $POST["author"] ) );
        if (empty($author)) {
            $this->errors["author"][] = "Le nom est obligatoire";
        }
        
        if (strlen($author) < 2) {
            $this->errors["author"][] = "Le nom doit comporter au  moins 2 caractères";
        }
        
        $message = htmlspecialchars( trim( $POST["message"] ) );
        if (empty($message))  {
            $this->errors["message"][] = "Le message est obligatoire";
        }
        
        if (strlen($message) < 5) {
            $this->errors["message"][] = "Le message doit comporter au  moins 5 caractères";
        }
        
    }

    public function getErrors(){
        return $this->errors;
    }

    /**
     * renderCommentView returns the view "commentView" : A post and its comments using the post id
     *
     * @param  int $post_id
     *
     * @return void
     */
    public function renderCommentView(int $post_id) {

        $postModel = new PostModel();
        $commentModel = new CommentModel();

        $post = $postModel->getOnePost($post_id);
        
        $comments = $commentModel->getComments($post_id);

        require 'public/views/front/commentView.phtml';
    }

    

    /**
     * setCookieOneYear Set a cookie for 1 year
     *
     * @param  string $cookieId
     * @param  mixed $userData
     *
     * @return void
     */
    public function setCookieOneYear(string $cookieId, string $userData) {
        $one_year =  365*24*3600;
        setcookie($cookieId, $userData, time() + $one_year, null, null ,false, true);
    }

    public function addComment(int $post_id, array $POST) {

        $id = (int) $_GET['id'];
        $author = htmlspecialchars(trim($POST['author']));
        $message = htmlspecialchars(trim($POST['message']));
        if ( !empty($author) && !empty($message) && count($this->getErrors()) === 0 ) {
            
            $commentModel = new CommentModel();
            $commentModel->insertComment($post_id, $POST);
            $this->setCookieOneYear('author', $author);

            header("Location:index.php?page=comments&id=$id");
            exit();
        } else {
            // $_GET['error'] = 1;
            $this->setCookieOneYear('author', $author);
            $errorsList = $this->getErrors();
            var_dump($errorsList);
            $serializeErrorsList = serialize($errorsList);
           $_SESSION['comments']['message'] = $message;
           var_dump($_SESSION['comments']['message']);
            header("Location:index.php?page=comments&id=$id&error=1&errorslist=$serializeErrorsList");
            exit();
        }
        

    }

    
}
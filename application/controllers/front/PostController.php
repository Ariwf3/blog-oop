<?php
namespace Ariwf3\Blog_oop\Application\Controllers\Front;
use Ariwf3\Blog_oop\Application\Models\PostModel;
use Ariwf3\Blog_oop\Application\Controllers\Front\UserController;

class PostController {

    private $errors = array();

    /**
     * setErrors Checks the integrity of user data and builds arrays with errors found (checks title and post)
     *
     * @param  array $post
     *
     * @return void
     */
    public function setErrors(array $post) {

        if (isset($post['title'])) {
            $title = htmlspecialchars( trim( $post["title"] ) );
            if ( strlen($title) < 3 ) {
                $this->errors["title"][] = "Le titre doit comporter au moins 3 caractères";
            }
        }

        if (isset($post['post'])) {
            $title = htmlspecialchars( trim( $post["post"] ) );
            if ( strlen($title) < 15 ) {
                $this->errors["tiposttle"][] = "Le billet doit comporter au moins 15 caractères";
            }
        }
    }

    /**
     * getErrors returns the errors arrays
     *
     * @return array
     */
    public function getErrors() :array {
        return $this->errors;
    }

    public function renderAddPostView() {
            $userController = new UserController();
            $userController->redirectIfNotConnected();

            require 'public/views/front/addPostView.phtml';
    }

     public function addPost(int $userId, array $post) {
        $userController = new UserController();
        $userController->redirectIfNotConnected();

        if ( count($this->getErrors() ) == 0) {

            unset($_SESSION['userAddPost']);

            $postModel = new PostModel();
            $postModel->insertPost($userId, $post);
            $role = $_SESSION['user']['role'];
            header("Location: index.php?action=account&id=$userId");
        } else {
            $userController->redirectIfNotConnected();
            $_SESSION['userAddPost']['title'] = htmlspecialchars($post['title']);
            $_SESSION['userAddPost']['post'] = htmlspecialchars($post['post']);

            $_SESSION['userAddPost']['errors'] = $this->getErrors();
            // $serializeErrorsList = serialize($errorsList);
            // var_dump($errorsList);
            // $userId = $_SESSION['user']['id'];
            header("Location:index.php?id=$userId&action=addPostView");
        }
        
    }

    public function renderEditPostView(int $postId) {
        $userController = new UserController();
        $userController->redirectIfNotConnected();

        if (!isset($_SESSION['user'])) {
            header('Location: index.php');
        } else {
            $postModel = new PostModel();
            $post = $postModel->getOnepost($postId);
            require 'public/views/front/editPostView.phtml';
        }
    }

    public function editPost(int $postId, array $post) {
        $userController = new UserController();
        $userController->redirectIfNotConnected();

        if ( count($this->getErrors() ) == 0) {
            $postModel = new PostModel();
            $postModel->updatePost($postId, $post);

            $role = $_SESSION['user']['role'];
            $userId = $_SESSION['user']['id'];

            header("Location: index.php?action=account&id=$userId");

        } else {
            $errorsList = $this->getErrors();
            $serializeErrorsList = serialize($errorsList);
            // $userId = $_SESSION['user']['id'];
       
            header("Location:index.php?id=$postId&action=editPostView&error=1&errorslist=$serializeErrorsList");
         }
    }

    public function removePost(int $postId) {
        $userController = new UserController();
        $userController->redirectIfNotConnected();

        $postModel = new PostModel();
        $postModel->deletePost($postId);

        $role = $_SESSION['user']['role'];
        $userId = $_SESSION['user']['id'];

        header("Location: index.php?action=account&id=$userId");
    }

}
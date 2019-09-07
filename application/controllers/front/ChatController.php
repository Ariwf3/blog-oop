<?php
namespace Ariwf3\Blog_oop\Application\Controllers\Front;

use Ariwf3\Blog_oop\Application\Models\ChatModel;

class ChatController {


    /**
     * renderChatView returns the view "chatView" : Page with the instant messaging with last messages
     *
     * @return void
     */
    public function renderChatView() {

        $messages = $this->loadMessages();
        require 'public/views/front/chatView.phtml';
    }

    public function AddMessageAjax(array $post) {
    
    $author = trim($post['author']);
    $message = trim($post['message']);

    if (!empty($message) && !empty($author)) {
    
        $this->addMessage($post);

        // Redirection in case of javascript deactivation by the user
        header('location:index.php?action=chat');
        
        } else {
            
        // Redirection with error in case of javascript deactivation by the user
        header('location:index.php?action=chat&error=1');
        }
    }

   /*  public function loadMessageAjax(int $lastId) {

        $this->loadLastMessage($lastId);

    } */

    public function addMessage(array $post) {
        $chatModel = new ChatModel();
        $lastMessage = $chatModel->InsertMessage($post);
    }

    
    public function loadMessages() {
        $chatModel = new ChatModel();
        return $chatModel->getMessages();
    }


    public function loadMessageAjax(int $lastId) {

        $lastMessage = $this->loadLastMessage($lastId);

        $lastMessageJson = json_encode($lastMessage);

        if ($lastMessage[0]['id'] > $lastId) {
            echo $lastMessageJson;
        }

    }

    public function loadLastMessage($lastId) {

        $chatModel = new ChatModel();

        return $chatModel->getLastMessage($lastId);

        // var_dump($lastMessage);
        // $lastMessageJson = json_encode($lastMessage);
        // var_dump($lastMessageJson);

        /* if ($lastMessage[0]['id'] > $lastId) {
            echo $lastMessageJson;
        } */
        
    }

}
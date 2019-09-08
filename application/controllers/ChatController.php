<?php
namespace Ariwf3\Blog_oop\Application\Controllers;

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

    /**
     * addMessage Adds a message with user datas $post
     *
     * @param  array $post
     *
     * @return void
     */
    public function addMessage(array $post) {
        $chatModel = new ChatModel();
        $lastMessage = $chatModel->InsertMessage($post);
    }

    
    /**
     * loadMessages Loads list of the messages
     *
     * @return array
     */
    public function loadMessages() :array {
        $chatModel = new ChatModel();
        return $chatModel->getLastTenMessages();
    }


    /**
     * loadLastMessage Loads the last message according to the id($lastId) of the last message received
     *
     * @param  int $lastId
     *
     * @return array
     */
    public function loadLastMessage($lastId) :array {

        $chatModel = new ChatModel();
        return $chatModel->getLastMessage($lastId);  
    
    }

    /**
     * addMessageAjax Adds the message asynchronously thanks to the received datas $post from the ajax script, redirects in case of javascript desactivation by the user
     *
     * @param  array $post
     *
     * @return void
     */
    public function addMessageAjax(array $post) {
    
    $author = trim($post['author']);
    $message = trim($post['message']);

    if (!empty($message) && !empty($author)) {
    
        $this->addMessage($post);

        header('location:index.php?action=chat');
        
        } else {
            header('location:index.php?action=chat&error=1');
        }
    }

    /**
     * loadMessageAjax Loads messages asynchronously thanks to the received data $lastId from the ajax script and resends datas to the script
     *
     * @param  int $lastId
     *
     * @return void
     */
    public function loadMessageAjax(int $lastId) {

    $lastMessage = $this->loadLastMessage($lastId);

    $lastMessageJson = json_encode($lastMessage);

    if ($lastMessage[0]['id'] > $lastId) {
            echo $lastMessageJson;
        }
    }

}
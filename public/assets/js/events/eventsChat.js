/**
 * ariwf3_blogoop_events represents a namespace for the chat events
 * 
 * @namespace ariwf3_blogoop_events
 */
const ariwf3_blogoop_eventsChat = {

    /**
     * sendMessageOnClick
     * 
     * Contains the callback function for sending the message to the click, checks the user data, displays the message sent and triggers the ajax request
     * 
     * @param {event} e - represents the event object
     */
    sendMessageOnClick: function (e) {

        e.preventDefault();

    /** @var {string} $error - Local Contains the error message */
        let $error = $(".popup_error_form");
        

        $messageChat = encodeURIComponent($('#message').val().trim());
        $authorChat = encodeURIComponent($('#author').val().trim());

        if ($messageChat == "" || $authorChat == "") {
            $error.fadeIn();
        } else if ($authorChat.length < 2 || $authorChat.length > 30) {
            $error.fadeIn();
        } else if ($messageChat.length < 5) {
            $error.fadeIn();
        } else {
            ariwf3_blogoop_ajax.sendMessage();

            $error.fadeOut();

            $("textarea").val('');

            $('#messages').append("<p><span><i class='fas fa-mug-hot'></i> " + decodeURIComponent($authorChat) + " : </span>" + decodeURIComponent($messageChat) + "</p>");
        }

    
    }

} 

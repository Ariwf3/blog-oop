/**
 * ariwf3_blogoop_events represents a namespace for the chat events callback
 * 
 * @namespace ariwf3_blogoop_events
 */
const ariwf3_blogoop_eventsChat = {

    /**
     * Contains the callback function for sending the message to the click, checks the user data, displays the message sent and triggers the ajax request
     * 
     * @property {function} sendMessageOnClick
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
            //appel ajax
            ariwf3_blogoop_ajax.sendMessage();

            // on retire le popup d'erreur s'il est activé
            $error.fadeOut();

            // on vide le champ textarea
            $("textarea").val('');
            // on ajoute le message courant juste au dessus
            $('#messages').append("<p><span><i class='fas fa-mug-hot'></i> " + decodeURIComponent($authorChat) + " : </span>" + decodeURIComponent($messageChat) + "</p>");
        }

       /*  if ($messageChat != "" && $authorChat != "") {

            //appel ajax
            ariwf3_blogoop_ajax.sendMessage();

            // on retire le popup d'erreur s'il est activé
            $error.fadeOut();

            // on vide le champ textarea
            $("textarea").val('');
            // on ajoute le message courant juste au dessus
            $('#messages').append("<p><span><i class='fas fa-mug-hot'></i> " + decodeURIComponent($authorChat) + " : </span>" + decodeURIComponent($messageChat) + "</p>");

        } else {
            
            $error.fadeIn();

        } */

    }

} // fin namespace ariNamespaceEvents

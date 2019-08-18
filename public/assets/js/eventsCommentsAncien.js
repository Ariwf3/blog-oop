

const ariwf3_blogoop_eventsComments = {

    removeErrors: function (field, feedback) {
        
        field.removeClass("invalid");
        feedback.remove();
        authorOrMessage.removeClass("valid");
    },
    verifyValidity: function () {

        let $author = $('#author');
        let $author_feedback = $author.next()
        let $message = $('#message');
        let $message_feedback = $message.next();
        
        if ($author.hasClass("valid") && $author_feedback.hasClass("valid_feedback") && $message.hasClass("valid") && $message_feedback.hasClass("valid_feedback"))
        {
            $(".popup_error_form").fadeOut('slow').replaceWith("<p class='popup_valid_form'>On a l'air bon !</p>");
        } 
    },
    checkAuthorOnKeyup: function () {
        let $author = $('#author');
        let authorValue = $('#author').val().trim();

        //auteur 2 caracteres mini
        // en reussite j'ajoute un valid_feedback
        ariwf3_blogoop_eventsComments.removeErrors($author, $author.next());
        
        if (authorValue.length === 0 || authorValue.length < 2) {
            
            // ariwf3_blogoop_eventsComments.removeErrors($author.parent());
            
            $author.addClass("invalid");
            $author.parent().append("<p class='invalid_feedback'>*Entrer minimum 2 caractères</p>");
            $(".popup_valid_form").fadeOut('slow');
            
        } else {

            $author.addClass("valid");
            $author.parent().append("<p class='valid_feedback'>Bonne visite " + authorValue + " ! <i class='fas fa-handshake'></i></p>");
            if ($author.hasClass("valid") && $("#message").hasClass("valid")) {
                $(".popup_valid_form").fadeIn('slow');
            }
        }

        ariwf3_blogoop_eventsComments.verifyValidity();
        
    },
    checkMessageOnKeyup: function () {
        let $message = $('#message');
        let messageValue = $('#message').val().trim();


        ariwf3_blogoop_eventsComments.removeErrors($message, $message.next());
        ariwf3_blogoop_eventsComments.verifyValidity();

        if (messageValue.length === 0 || messageValue.length < 5) {
            
            $message.addClass("invalid");
            $message.parent().append("<p class='invalid_feedback'>*Entrer minimum 5 caractères  <i class='fas fa-coffee'></i></p>");
            $(".popup_valid_form").fadeOut('slow');
        } else {
            $message.addClass("valid");
            $message.parent().append("<p class='valid_feedback'>Message prêt à être servi !  <i class='fas fa-mug-hot'></i></p>");
            if ($message.hasClass("valid") && $("#author").hasClass("valid")) {
                $(".popup_valid_form").fadeIn('slow');
            }
        }
        ariwf3_blogoop_eventsComments.verifyValidity()
    },
    sendMessageOnClick: function (e) {
        // e.preventDefault();
    }
}
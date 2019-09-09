/**
 * ariwf3_blogoop_eventsComments represents a namespace for the comments events
 * 
 * @namespace ariwf3_blogoop_eventsComments
 */
const ariwf3_blogoop_eventsComments = {

    /**
     * getUserInfos
     * 
     * Contains each user's form information (field, value and feedback)
     * 
     */
    getUserInfos: () => {
        let formTags = {
            author: {
                field: $('#author'),
                value: $('#author').val().trim(),
                feedback: $('#author').next()
            },
            message: {
                field: $('#message'),
                value: $('#message').val().trim(),
                feedback: $('#message').next()
            },
        };
        return formTags;
    },
    /**
     * regexAuthor 
     * 
     * Contains a regular expression to check the author name
    */
    regexAuthor: /^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ!?\s]{2,30}$/,
    /**
     * removeErrors
     * 
     * removes the error classes and error message and prevents them from repeating themselves
     * 
     * @param {jQuery} $field the html tag which contains the form field
     * @param {jQuery} $feedback the html tag which contains the feedback message
     */
    removeErrors: function ($field, $feedback) {
        $field.removeClass("invalid");
        $feedback.remove();
        $field.removeClass("valid");
    },
    /**
     * verifiyAllFieldsValidity
     * 
     * Verifies if the form has no error and replace the error feedback by a success feedback
     */
    verifiyAllFieldsValidity: () => {
        let userInfos = ariwf3_blogoop_eventsComments.getUserInfos();

        if (userInfos.author.field.hasClass("valid") && userInfos.author.feedback.hasClass("valid_feedback") && userInfos.message.field.hasClass("valid") && userInfos.message.feedback.hasClass("valid_feedback"))
        {
            $(".popup_error_form").replaceWith("<p class='popup_valid_form'>On a l'air bon !</p>");
        }
    },
    /**
     * verifyAuthorValidity
     * 
     * Verifies the author field and toggles between valid or negative feedback
     */
    verifyAuthorValidity: () => {
        let userInfos = ariwf3_blogoop_eventsComments.getUserInfos();

        if (!(ariwf3_blogoop_eventsComments.regexAuthor.test(userInfos.author.value)))
        {
            userInfos.author.field.addClass("invalid");
            userInfos.author.field.parent().append("<p class='invalid_feedback'>* minimum 2 caractères, maximum 30 caractères alphanumériques</p>");
            $(".popup_valid_form").fadeOut('slow');

        } else {
            userInfos.author.field.addClass("valid");
            userInfos.author.field.parent().append("<p class='valid_feedback'>Bonne visite " + userInfos.author.value + " ! <i class='fas fa-handshake'></i></p>");
            if (userInfos.author.field.hasClass("valid") && userInfos.message.field.hasClass("valid"))
            {
                $(".popup_valid_form").fadeIn('slow');
            }
        }
    },
    /**
     * verifyMessageValidity
     * 
     * Verifies the message field and toggles between valid or negative feedback
     */
    verifyMessageValidity: () => {
        let userInfos = ariwf3_blogoop_eventsComments.getUserInfos();

        if (userInfos.message.value.length === 0 || userInfos.message.value.length < 5)
        {
            userInfos.message.field.addClass("invalid");
            userInfos.message.field.parent().append("<p class='invalid_feedback'>*Entrer minimum 5 caractères</p>");
            $(".popup_valid_form").fadeOut('slow');
        } else {
            userInfos.message.field.addClass("valid");
            userInfos.message.field.parent().append("<p class='valid_feedback'>Message prêt à être servi !  <i class='fas fa-mug-hot'></i></p>");
            if (userInfos.author.field.hasClass("valid") && userInfos.message.field.hasClass("valid"))
            {
                $(".popup_valid_form").fadeIn('slow');
            }
        }
    },
    
    /**
     * checkAuthorOnKeyup
     * 
     * Callback function for the keyup event listener, verifies the author field
     */
    checkAuthorOnKeyup: () => {

        let userInfos = ariwf3_blogoop_eventsComments.getUserInfos();

        ariwf3_blogoop_eventsComments.removeErrors(userInfos.author.field, userInfos.author.feedback);

        ariwf3_blogoop_eventsComments.verifyAuthorValidity();

        ariwf3_blogoop_eventsComments.verifiyAllFieldsValidity()
    },
    /**
     * checkMessageOnKeyup
     * 
     * Callback function for the keyup event listener, verifies the message field
     */
    checkMessageOnKeyup: () => {

        let userInfos = ariwf3_blogoop_eventsComments.getUserInfos();

        ariwf3_blogoop_eventsComments.removeErrors(userInfos.message.field, userInfos.message.feedback);

        ariwf3_blogoop_eventsComments.verifyMessageValidity();

        ariwf3_blogoop_eventsComments.verifiyAllFieldsValidity()
    }

}
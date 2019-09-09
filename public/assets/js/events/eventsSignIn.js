/**
 * ariwf3_blogoop_eventsSignIn represents a namespace for the sign in events 
 * 
 * @namespace ariwf3_blogoop_eventsSignIn
 */
const ariwf3_blogoop_eventsSignIn = {

    /**
     * getUserInfos
     * 
     * Contains each user's form information (field, value and feedback)
     * 
     */
    getUserInfos: () => {
        let formTags = {
            email: {
                field: $('#email'),
                value: $('#email').val().trim(),
                feedback: $('#email').next()
            },
            password: {
                field: $('#password'),
                value: $('#password').val().trim(),
                feedback: $('#password').next()
            },
        };
        return formTags;
    },
    /**
     * removeErrors
     * 
     * removes the error classes and error message and prevents them from repeating themselves
     * 
     * @param {jQuery} $field the html tag which contains the form field
     * @param {jQuery} $feedback the html tag which contains the feedback message
     */
    removeErrors: function (field, feedback) {
        field.removeClass("invalid");
        feedback.remove();
        field.removeClass("valid");
    },
    /**
     * showValidPopup
     * 
     * Verifies if all fields have the "valid" class and fades in a success feedback
     */
    showValidPopup: () => {
        let userInfos = ariwf3_blogoop_eventsSignIn.getUserInfos();
        if (userInfos.email.field.hasClass("valid") && userInfos.password.field.hasClass("valid")) {
            $(".popup_valid_form").fadeIn('slow');
        }
    },
    /**
     * regexMail
     * 
     * Contains a regular expression to check the mail
     */
    regexMail: /^[a-z0-9._-]+@[a-z0-9._-]{2,12}\.[a-z]{2,4}$/,
    /**
     * verifiyAllFieldsValidity
     * 
     * Verifies if the form has no error and replace the error feedback by a success feedback
     */
    verifiyAllFieldsValidity: () => {
        let userInfos = ariwf3_blogoop_eventsSignIn.getUserInfos();

        if (userInfos.email.field.hasClass("valid") && userInfos.email.feedback.hasClass("valid_feedback") && userInfos.password.field.hasClass("valid") && userInfos.password.feedback.hasClass("valid_feedback")) {
            $(".popup_error_form").replaceWith("<p class='popup_valid_form'>On a l'air bon !</p>");
        }
    },
    /**
     * verifyEmailValidity
     * 
     * Verifies the mail field and toggles between valid or negative feedback
     */
    verifyEmailValidity: () => {
        let userInfos = ariwf3_blogoop_eventsSignIn.getUserInfos();

        if (userInfos.email.value.length === 0 ) {
            userInfos.email.field.addClass("invalid");
            userInfos.email.field.parent().append("<p class='invalid_feedback'>*Le mail est obligatoire</p>");
            $(".popup_valid_form").fadeOut('slow');

        } else if (!(ariwf3_blogoop_eventsSignIn.regexMail.test(userInfos.email.value))) {
            userInfos.email.field.addClass("invalid");
            userInfos.email.field.parent().append("<p class='invalid_feedback'>*Format attendu (minuscules de type \"pseudo@nomdedomaine.extension\" exemple: jean01@wanadoo.fr)</p>");
            $(".popup_valid_form").fadeOut('slow');
        } else {
            userInfos.email.field.addClass("valid");
            userInfos.email.field.parent().append("<p class='valid_feedback'>Format d'email valide, bonne visite ! <i class='fas fa-handshake'></i></p>");
            ariwf3_blogoop_eventsSignIn.showValidPopup();
        }
    },

    /**
     * verifyPasswordValidity
     * 
     * Verifies the password field and toggles between valid or negative feedback
     */
    verifyPasswordValidity: () => {
        let userInfos = ariwf3_blogoop_eventsSignIn.getUserInfos();

        if (userInfos.password.value.length === 0 || userInfos.password.value.length < 4 || userInfos.password.value.length > 30)
        {
            userInfos.password.field.addClass("invalid");
            userInfos.password.field.parent().append("<p class='invalid_feedback'>*Le mot de passe est obligatoire, minimum 4 caractères, maximum 30 caractères</p>");
            $(".popup_valid_form").fadeOut('slow');
        } else {
            userInfos.password.field.addClass("valid");
            userInfos.password.field.parent().append("<p class='valid_feedback'>Mot de passe conforme !  <i class='fas fa-mug-hot'></i></p>");
            ariwf3_blogoop_eventsSignIn.showValidPopup();
            /* if (userInfos.email.field.hasClass("valid") && userInfos.password.field.hasClass("valid")) {
                $(".popup_valid_form").fadeIn('slow');
            } */
        }
    },

    /**
    * checkEmailOnKeyup
    * 
    * Callback function for the keyup event listener, verifies the mail field
    */
    checkEmailOnKeyup: () => {

        let userInfos = ariwf3_blogoop_eventsSignIn.getUserInfos();

        ariwf3_blogoop_eventsSignIn.removeErrors(userInfos.email.field, userInfos.email.feedback);

        ariwf3_blogoop_eventsSignIn.verifyEmailValidity();

        ariwf3_blogoop_eventsSignIn.verifiyAllFieldsValidity()
    },
    
    /**
     * checkPasswordOnKeyup
     * 
     * Callback function for the keyup event listener, verifies the password field
     */
    checkPasswordOnKeyup: () => {

        let userInfos = ariwf3_blogoop_eventsSignIn.getUserInfos();

        ariwf3_blogoop_eventsSignIn.removeErrors(userInfos.password.field, userInfos.password.feedback);

        ariwf3_blogoop_eventsSignIn.verifyPasswordValidity();

        ariwf3_blogoop_eventsSignIn.verifiyAllFieldsValidity()
    }
}
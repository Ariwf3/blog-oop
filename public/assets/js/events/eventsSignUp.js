
/**
 * ariwf3_blogoop_eventsSignUp represents a namespace for the sign up events 
 * 
 * @namespace ariwf3_blogoop_eventsSignUp
 */
const ariwf3_blogoop_eventsSignUp = {

    /**
     * getUserInfos
     * 
     * Contains each user's form information (field, value and feedback)
     * 
     */
    getUserInfos: () => {
        let formTags = {
                firstName: {
                    field: $('#firstName'),
                    value: $('#firstName').val().trim(),
                    feedback: $('#firstName').next()
                },
                lastName: {
                    field: $('#lastName'),
                    value: $('#lastName').val().trim(),
                    feedback: $('#lastName').next()
                },
                email: {
                    field: $('#email'),
                    value: $('#email').val().trim(),
                    feedback: $('#email').next()
                },
                pseudo: {
                    field: $('#pseudo'),
                    value: $('#pseudo').val().trim(),
                    feedback: $('#pseudo').next()
                },
                password: {
                    field: $('#password'),
                    value: $('#password').val(),
                    feedback: $('#password').next()
                },
                passwordCheck: {
                    field: $('#passwordCheck'),
                    value: $('#passwordCheck').val(),
                    feedback: $('#passwordCheck').next()
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
     * regexNames
     * 
     * Contains a regular expression to check the firstname and lastname
     */
    regexNames: /^([a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s]|[-.](?![-.])){2,50}$/,
     /**
      * regexPseudo
      * 
      * Contains a regular expression to check the pseudo
      */
    regexPseudo: /^([a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s]|[-_](?![-_])){2,30}$/,
    /**
     * verifiyAllFieldsValidity
     * 
     * Verifies if the form has no error and replace the error feedback by a success feedback
     */
    verifiyAllFieldsValidity: () => {
        let userInfos = ariwf3_blogoop_eventsSignUp.getUserInfos();

        if (
            userInfos.lastName.field.hasClass("valid") && userInfos.lastName.feedback.hasClass("valid_feedback") &&
        
            userInfos.firstName.field.hasClass("valid") && userInfos.firstName.feedback.hasClass("valid_feedback") &&
            
            userInfos.email.field.hasClass("valid") && userInfos.email.feedback.hasClass("valid_feedback") && 
            
            userInfos.pseudo.field.hasClass("valid") && userInfos.pseudo.feedback.hasClass("valid_feedback") && 
            
            userInfos.password.field.hasClass("valid") && userInfos.password.feedback.hasClass("valid_feedback") && 
            
            userInfos.passwordCheck.field.hasClass("valid") && userInfos.passwordCheck.feedback.hasClass("valid_feedback")
        )
        {
            $(".popup_error_form").replaceWith("<p class='popup_valid_form'>On a l'air bon !</p>");
        }
    },
    /**
     * showValidPopup
     * 
     * Verifies if all fields have the "valid" class and fades in a success feedback
     */
    showValidPopup: () => {
        let userInfos = ariwf3_blogoop_eventsSignUp.getUserInfos();

        if (
            userInfos.lastName.field.hasClass("valid") && userInfos.firstName.field.hasClass("valid") &&
            userInfos.email.field.hasClass("valid") && userInfos.pseudo.field.hasClass("valid") &&
            userInfos.password.field.hasClass("valid") && userInfos.passwordCheck.field.hasClass("valid")
        )
        {
            $(".popup_valid_form").fadeIn('slow');
        }
    },
    /**
     * hideValidPopup
     * 
     * Fades out the success feedback
     */
    hideValidPopup: () => {
        $(".popup_valid_form").fadeOut('slow');
    },
    /**
     * verifyLastNameValidity
     * 
     * Verifies the lastname field and toggles between valid or negative feedback
     */
    verifyLastNameValidity: () => {
        let userInfos = ariwf3_blogoop_eventsSignUp.getUserInfos();

        if (userInfos.lastName.value.length === 0) {
            userInfos.lastName.field.addClass("invalid");
            userInfos.lastName.field.parent().append("<p class='invalid_feedback'>*Le nom est obligatoire</p>");
            $(".popup_valid_form").fadeOut('slow');
    
        } else if (!(ariwf3_blogoop_eventsSignUp.regexNames.test(userInfos.lastName.value))) {
            userInfos.lastName.field.addClass("invalid");
            userInfos.lastName.field.parent().append("<p class='invalid_feedback'>*Lettres, points où tirets non successifs uniquement, de 2 à 50 caractères maximum</p>");
            ariwf3_blogoop_eventsSignUp.hideValidPopup();
        } else if (userInfos.lastName.value.charAt(0) === "-" || userInfos.lastName.value.charAt(0) === ".")
        {
            userInfos.lastName.field.addClass("invalid");
            userInfos.lastName.field.parent().append("<p class='invalid_feedback'>*Le nom doit commencer par une lettre. Lettres, points où tirets non successifs uniquement, de 2 à 50 caractères maximum.</p>");
            ariwf3_blogoop_eventsSignUp.hideValidPopup();
        } else {
            userInfos.lastName.field.addClass("valid");
            userInfos.lastName.field.parent().append("<p class='valid_feedback'>Nom conforme ! <i class='fas fa-mug-hot'></i></p>");
            ariwf3_blogoop_eventsSignUp.showValidPopup();
        }
    },
    /**
     * verifyFirstNameValidity
     * 
     * Verifies the firstname field and toggles between valid or negative feedback
     */
    verifyFirstNameValidity: () => {
        let userInfos = ariwf3_blogoop_eventsSignUp.getUserInfos();

        if (userInfos.firstName.value.length === 0) {
            userInfos.firstName.field.addClass("invalid");
            userInfos.firstName.field.parent().append("<p class='invalid_feedback'>*Le prénom est obligatoire</p>");
            $(".popup_valid_form").fadeOut('slow');
    
        } else if (!(ariwf3_blogoop_eventsSignUp.regexNames.test(userInfos.firstName.value))) {
            userInfos.firstName.field.addClass("invalid");
            userInfos.firstName.field.parent().append("<p class='invalid_feedback'>*Lettres, points où tirets non successifs uniquement, de 2 à 50 caractères maximum</p>");
            ariwf3_blogoop_eventsSignUp.hideValidPopup();
        }
        else if (userInfos.firstName.value.charAt(0) === "-" || userInfos.firstName.value.charAt(0) === ".")
        {
            userInfos.firstName.field.addClass("invalid");
            userInfos.firstName.field.parent().append("<p class='invalid_feedback'>*Le prénom doit commencer par une lettre. Lettres, points où tirets non successifs uniquement, de 2 à 50 caractères maximum. </p>");
            ariwf3_blogoop_eventsSignUp.hideValidPopup();
        } else {
            userInfos.firstName.field.addClass("valid");
            userInfos.firstName.field.parent().append("<p class='valid_feedback'>Prénom conforme ! <i class='fas fa-mug-hot'></i></p>");
            ariwf3_blogoop_eventsSignUp.showValidPopup();
        }
    },
    /**
     * verifyPseudoValidity
     * 
     * Verifies the pseudo field and toggles between valid or negative feedback
     */
    verifyPseudoValidity: () => {
        let userInfos = ariwf3_blogoop_eventsSignUp.getUserInfos();

        if (userInfos.pseudo.value.length === 0) {
            userInfos.pseudo.field.addClass("invalid");
            userInfos.pseudo.field.parent().append("<p class='invalid_feedback'>*Le pseudo est obligatoire</p>");
            ariwf3_blogoop_eventsSignUp.hideValidPopup();
    
        }
        else if (!(ariwf3_blogoop_eventsSignUp.regexPseudo.test(userInfos.pseudo.value)))
        {
            userInfos.pseudo.field.addClass("invalid");
            userInfos.pseudo.field.parent().append("<p class='invalid_feedback'>*Le format du pseudonyme n'est pas correct (lettres et chiffres uniquement,points où underscores non successifs uniquement, de 2 à 30 caractères maximum)</p>");
            ariwf3_blogoop_eventsSignUp.hideValidPopup();
        }
        else if (userInfos.pseudo.value.charAt(0) === "-" || userInfos.pseudo.value.charAt(0) === "_")
        {
            userInfos.pseudo.field.addClass("invalid");
            userInfos.pseudo.field.parent().append("<p class='invalid_feedback'>*Le pseudo doit commencer par une lettre. lettres et chiffres uniquement,points où underscores non successifs uniquement, de 2 à 30 caractères maximum. </p>");
            ariwf3_blogoop_eventsSignUp.hideValidPopup();
        } else {
            userInfos.pseudo.field.addClass("valid");
            userInfos.pseudo.field.parent().append("<p class='valid_feedback'>Pseudonyme conforme ! <i class='fas fa-mug-hot'></i></p>");
            ariwf3_blogoop_eventsSignUp.showValidPopup();
        }
    },
    /**
     * verifyPasswordCheckValidity
     * 
     * Verifies the password field and toggles between valid or negative feedback
     */
    verifyPasswordCheckValidity: () => {
        let userInfos = ariwf3_blogoop_eventsSignUp.getUserInfos();

        if (userInfos.passwordCheck.value.length === 0)
        {
            userInfos.passwordCheck.field.addClass("invalid");
            userInfos.passwordCheck.field.parent().append("<p class='invalid_feedback'>*La vérification de mot de passe est obligatoire</p>");
            ariwf3_blogoop_eventsSignUp.hideValidPopup();
        }
        else if (userInfos.passwordCheck.value !== userInfos.password.value)
        {
            userInfos.passwordCheck.field.addClass("invalid");
            userInfos.passwordCheck.field.parent().append("<p class='invalid_feedback'>*Les mots de passe ne correspondent pas</p>");
            ariwf3_blogoop_eventsSignUp.hideValidPopup();
        } else {
            userInfos.passwordCheck.field.addClass("valid");
            userInfos.passwordCheck.field.parent().append("<p class='valid_feedback'>Mot de passe correspondant !  <i class='fas fa-mug-hot'></i></p>");
            ariwf3_blogoop_eventsSignUp.showValidPopup();
        }
    },
    /**
     * checkFirstNameOnKeyup
     * 
     * Callback function for the keyup event listener, verifies the firstname field
     */
    checkFirstNameOnKeyup: () => {
        let userInfos = ariwf3_blogoop_eventsSignUp.getUserInfos();

        ariwf3_blogoop_eventsSignUp.removeErrors(userInfos.firstName.field, userInfos.firstName.feedback);

        ariwf3_blogoop_eventsSignUp.verifyFirstNameValidity();

        ariwf3_blogoop_eventsSignUp.verifiyAllFieldsValidity()
    },
    /**
     * checkLastNameOnKeyup
     * 
     * Callback function for the keyup event listener, verifies the lastname field
     */
    checkLastNameOnKeyup: () => {

        let userInfos = ariwf3_blogoop_eventsSignUp.getUserInfos();

        ariwf3_blogoop_eventsSignUp.removeErrors(userInfos.lastName.field, userInfos.lastName.feedback);

        ariwf3_blogoop_eventsSignUp.verifyLastNameValidity();

        ariwf3_blogoop_eventsSignUp.verifiyAllFieldsValidity()
    },
    /**
     * checkPseudoOnKeyup
     * 
     * Callback function for the keyup event listener, verifies the pseudo field
     */
    checkPseudoOnKeyup: () => {

        let userInfos = ariwf3_blogoop_eventsSignUp.getUserInfos();

        ariwf3_blogoop_eventsSignUp.removeErrors(userInfos.pseudo.field, userInfos.pseudo.feedback);

        ariwf3_blogoop_eventsSignUp.verifyPseudoValidity();

        ariwf3_blogoop_eventsSignUp.verifiyAllFieldsValidity()
    },
    /**
     * passwordCheckOnKeyup
     * 
     * Callback function for the keyup event listener, verifies the password field
     */
    passwordCheckOnKeyup: () => {

        let userInfos = ariwf3_blogoop_eventsSignUp.getUserInfos();

        ariwf3_blogoop_eventsSignUp.removeErrors(userInfos.passwordCheck.field, userInfos.passwordCheck.feedback);

        ariwf3_blogoop_eventsSignUp.verifyPasswordCheckValidity();
        
        ariwf3_blogoop_eventsSignUp.verifiyAllFieldsValidity()
    },
    
}
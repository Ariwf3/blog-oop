const ariwf3_blogoop_eventsSignIn = {

    getUserInfos: function () {
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

    removeErrors: function (field, feedback) {
        field.removeClass("invalid");
        feedback.remove();
        field.removeClass("valid");
    },

    showValidPopup: function () {
        let userInfos = ariwf3_blogoop_eventsSignIn.getUserInfos();
        if (userInfos.email.field.hasClass("valid") && userInfos.password.field.hasClass("valid")) {
            $(".popup_valid_form").fadeIn('slow');
        }
    },

    regexMail: /^[a-z0-9._-]+@[a-z0-9._-]{2,12}\.[a-z]{2,4}$/,

    verifiyAllFieldsValidity: function () {
        let userInfos = ariwf3_blogoop_eventsSignIn.getUserInfos();

        if (userInfos.email.field.hasClass("valid") && userInfos.email.feedback.hasClass("valid_feedback") && userInfos.password.field.hasClass("valid") && userInfos.password.feedback.hasClass("valid_feedback")) {
            $(".popup_error_form").replaceWith("<p class='popup_valid_form'>On a l'air bon !</p>");
        }
    },

    verifyEmailValidity: function () {
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
            /* if (userInfos.email.field.hasClass("valid") && userInfos.password.field.hasClass("valid")) {
                $(".popup_valid_form").fadeIn('slow');
            } */
        }
    },

    verifyPasswordValidity: function () {
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

    checkEmailOnKeyup: function () {

        let userInfos = ariwf3_blogoop_eventsSignIn.getUserInfos();

        ariwf3_blogoop_eventsSignIn.removeErrors(userInfos.email.field, userInfos.email.feedback);

        ariwf3_blogoop_eventsSignIn.verifyEmailValidity();

        ariwf3_blogoop_eventsSignIn.verifiyAllFieldsValidity()
    },
    
    checkPasswordOnKeyup: function () {

        let userInfos = ariwf3_blogoop_eventsSignIn.getUserInfos();

        ariwf3_blogoop_eventsSignIn.removeErrors(userInfos.password.field, userInfos.password.feedback);

        ariwf3_blogoop_eventsSignIn.verifyPasswordValidity();

        ariwf3_blogoop_eventsSignIn.verifiyAllFieldsValidity()
    }
}
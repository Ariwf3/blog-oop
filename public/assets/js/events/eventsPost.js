/**
 * ariwf3_blogoop_eventsPost represents a namespace for the posts events 
 * 
 * @namespace ariwf3_blogoop_eventsPost
 */
const ariwf3_blogoop_eventsPost = {

    /**
     * getUserInfos
     * 
     * Contains each user's form information (field, value and feedback)
     * 
     */
    getUserInfos: () => {
        let formTags = {
            title: {
                field: $('#title'),
                value: $('#title').val().trim(),
                feedback: $('#title').next()
            },
            post: {
                field: $('#post'),
                value: $('#post').val().trim(),
                feedback: $('#post').next()
            }
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
     * verifiyAllFieldsValidity
     * 
     * Verifies if the form has no error and replace the error feedback by a success feedback
     */
    verifiyAllFieldsValidity: () => {
        let userInfos = ariwf3_blogoop_eventsPost.getUserInfos();

        if (userInfos.title.field.hasClass("valid") && userInfos.title.feedback.hasClass("valid_feedback") && userInfos.post.field.hasClass("valid") && userInfos.post.feedback.hasClass("valid_feedback")) {
            $(".popup_error_form").replaceWith("<p class='popup_valid_form'>On a l'air bon !</p>");
        }
    },
    /**
     * verifyTitleValidity
     * 
     * Verifies the title field and toggles between valid or negative feedback
     */
    verifyTitleValidity: () => {
        let userInfos = ariwf3_blogoop_eventsPost.getUserInfos();

        if (userInfos.title.value.length === 0 || userInfos.title.value.length < 3) {
            userInfos.title.field.addClass("invalid");
            userInfos.title.field.parent().append("<p class='invalid_feedback'>*Entrer minimum 3 caractères</p>");
            $(".popup_valid_form").fadeOut('slow');

        } else {
            userInfos.title.field.addClass("valid");
            userInfos.title.field.parent().append("<p class='valid_feedback'>Titre conforme !</i></p>");
            if (userInfos.title.field.hasClass("valid") && userInfos.post.field.hasClass("valid")) {
                $(".popup_valid_form").fadeIn('slow');
            }
        }
    },
    /**
     * verifyPostValidity
     * 
     * Verifies the post field and toggles between valid or negative feedback
     */
    verifyPostValidity: () => {
        let userInfos = ariwf3_blogoop_eventsPost.getUserInfos();

        if (userInfos.post.value.length === 0 || userInfos.post.value.length < 15) {
            userInfos.post.field.addClass("invalid");
            userInfos.post.field.parent().append("<p class='invalid_feedback'>*Entrer minimum 15 caractères</p>");
            $(".popup_valid_form").fadeOut('slow');
        } else {
            userInfos.post.field.addClass("valid");
            userInfos.post.field.parent().append("<p class='valid_feedback'>Post conforme !  <i class='fas fa-mug-hot'></i></p>");
            if (userInfos.title.field.hasClass("valid") && userInfos.post.field.hasClass("valid")) {
                $(".popup_valid_form").fadeIn('slow');
            }
        }
    },
    /**
     * checkEmailOnKeyup
     * 
     * Callback function for the keyup event listener, verifies the title field
     */
    checkTitleOnKeyup: () => {

        let userInfos = ariwf3_blogoop_eventsPost.getUserInfos();

        ariwf3_blogoop_eventsPost.removeErrors(userInfos.title.field, userInfos.title.feedback);

        ariwf3_blogoop_eventsPost.verifyTitleValidity();

        ariwf3_blogoop_eventsPost.verifiyAllFieldsValidity()
    },
    /**
     * checkPostOnKeyup
     * 
     * Callback function for the keyup event listener, verifies the post field
     */
    checkPostOnKeyup: () => {

        let userInfos = ariwf3_blogoop_eventsPost.getUserInfos();

        ariwf3_blogoop_eventsPost.removeErrors(userInfos.post.field, userInfos.post.feedback);

        ariwf3_blogoop_eventsPost.verifyPostValidity();

        ariwf3_blogoop_eventsPost.verifiyAllFieldsValidity()
        }

}

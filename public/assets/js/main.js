$(function () {

    /*  COMMENT FORM  */
    let $commentInputAuthor = $("#author");
    let $commentTextareaMessage = $("#message");

    $commentInputAuthor.on("keyup", ariwf3_blogoop_eventsComments.checkAuthorOnKeyup);
    $commentTextareaMessage.on("keyup", ariwf3_blogoop_eventsComments.checkMessageOnKeyup);

    /* SIGN UP FORM */
    let $signUpInputFirstName = $("#firstName");
    let $signUpInputLastName = $("#lastName");
    let $signUpInputPseudo = $("#pseudo");
    let $signUpInputPasswordCheck = $("#passwordCheck");

    $signUpInputFirstName.on("keyup", ariwf3_blogoop_eventsSignUp.checkFirstNameOnKeyup);
    $signUpInputLastName.on("keyup", ariwf3_blogoop_eventsSignUp.checkLastNameOnKeyup);
    $signUpInputPseudo.on("keyup", ariwf3_blogoop_eventsSignUp.checkPseudoOnKeyup);
    $signUpInputPasswordCheck.on("keyup", ariwf3_blogoop_eventsSignUp.passwordCheckOnKeyup);

    /* SIGN IN FORM */
    let $signInInputEmail = $("#email");
    let $signInInputPassword = $("#password");

    $signInInputEmail.on("keyup", ariwf3_blogoop_eventsSignIn.checkEmailOnKeyup);
    $signInInputPassword.on("keyup", ariwf3_blogoop_eventsSignIn.checkPasswordOnKeyup);

    /* ADDPOST & EDITPOST FORMS */
    let $addOrEditPostTitleInput = $("#title");
    let $addOrEditPostTextarea = $("#post");

    $addOrEditPostTitleInput.on("keyup", ariwf3_blogoop_eventsPost.checkTitleOnKeyup);
    $addOrEditPostTextarea.on('keyup', ariwf3_blogoop_eventsPost.checkPostOnKeyup);

    /* CHAT FORM */
    let $sendMessageInput = $("#send_message");
    $sendMessageInput.on("click", ariwf3_blogoop_eventsChat.sendMessageOnClick);

    ariwf3_blogoop_ajax.loadMessage();
    
    


    
    

})
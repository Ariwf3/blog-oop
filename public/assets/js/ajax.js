/** @var {string} $message - Global will retrieve the value of the message */
let $messageChat;
/** @var {string} $auteur - Global will retrieve the value of the author */
let $authorChat;


/**
 * Represents a namespace that contains ajax requests
 * 
 * @namespace ariwf3_blogoop_ajax
 */
const ariwf3_blogoop_ajax = {

    /**
     * sendMessage
     * 
     * Sends asynchronous ajax post requests with user settings
     * 
     * @property {function} sendMessage
     */
    sendMessage: () => {
        $.post(
            "index.php?action=addMessage", {
                author: $authorChat,
                message: $messageChat
            },
            "html"
        ); 
    },

    /**
     * loadMessage
     * 
     * Sends asynchronous ajax get requests with the last id inserted as parameter
     * 
     * @property { function } loadMessage - contains the function that will check the last message inserted every 4 seconds
     */
    loadMessage: () => {

        setTimeout(() => {
            /**
             * Contains the identifier of the last message inserted
             * @var lastInsertId {string} 
             * */
            let lastInsertId = $("p:first").data('id');
            console.log(lastInsertId);
            $.getJSON("index.php?action=loadMessage&id=" + lastInsertId, ariwf3_blogoop_ajax.displayMessage
            );
            // function restarted in the setTimeout for repetition
            ariwf3_blogoop_ajax.loadMessage()
        }, 4000);

    },
    /**
     * displayMessage
     * 
     * Ajax callback function, displays the last recorded messages, formats the response and adds it to the DOM
     * 
     * @property {function} - contains thefunction of which will be used as a return
     * 
     * @param {JSON} response - The data returned by the server
     */
    displayMessage: function (response) {
        console.log(response[0].id);
        if (response != "") {

            let message = "";

            message += "<p data-id='" + response[0].id + "'>";
            message += "<span><i class='fab fa-rocketchat'></i>" + response[0].author + " le " + response[0].creation_date + " : </span>";
            message += response[0].message + "</p>";

            $("h3").after(message);

        }

    }

} 
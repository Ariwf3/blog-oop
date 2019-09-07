/** @var {string} $message - Globale va récupérer la valeur du message */
let $messageChat;
/** @var {string} $auteur - Globale va récupérer la valeur de l'auteur */
let $authorChat;


/**
 * Represents a namespace that contains ajax requests
 * 
 * @namespace ariwf3_blogoop_eventsChat
 */
const ariwf3_blogoop_ajax = {

    /**
     * Envoie des requêtes asynchrones ajax post avec les paramètres utilisateurs
     * @property {function} sendMessage
     */
    sendMessage: () => {
        $.post(
            "index.php?action=addMessage", {
                author: $authorChat,
                message: $messageChat
            },
            "html"
        ); // fin traitement ajax
    },

    /**
     * Envoie des requêtes asynchrones ajax get avec pour paramètre le dernier id inséré
     * @property {function} loadMessage - contient la fonction qui vérifiera le dernier message inséré toutes les 4 secondes
     */
    loadMessage: () => {
       
        setTimeout(() => {
            /**
             * Contient l'identifiant du denrier message inséré
             * @var lastInsertId {string} 
             * */
            let lastInsertId = $("p:first").data('id');
            console.log(lastInsertId);
            $.getJSON("index.php?action=loadMessage&id=" + lastInsertId, ariwf3_blogoop_ajax.displayMessage
            );
            // fonction relancée dans le setTimeout pour répétition
            ariwf3_blogoop_ajax.loadMessage()
            //fonction relancée après 4 secondes
        }, 4000);

    },
    /**
     * Fonction de callback ajax, permet d'afficher les derniers messages enregistrés, formate la réponse et l'ajoute au DOM
     *@property {function} display - contient la fonction de qui servira de retour
     * @param {JSON} response - La données renvoyées par le serveur
     */
    displayMessage: function (response) {
        console.log(response[0].id);
        if (response != "") {

            let message = "";

            message += "<p data-id='" + response[0].id + "'>";
            message += "<span><i class='fab fa-rocketchat'></i>" + response[0].author + " le " + response[0].creation_date + " : </span>";
            message += response[0].message + "</p>";

            // message.insertAfter($("h3")); 
            $("h3").after(message);

        }

    }


} // fin namespace ariNamespaceAjax
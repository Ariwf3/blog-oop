# BLOG avec back office modèle mvc approche orienté objet

Un simple blog réalisé dans le cadre d'un examen avec un back office et un chat.

### Installation du projet
Cloner ou télécharger le repo, 
accéder à la configuration de la bdd : "application/classes/config/Database.php" modifier les variables $databaseSourceName,$databaseLogin et $databasePassword selon la configuration locale.
Importer le fichier sql pour construire la BDD.

## Motivations, approche et style de programmation choisis
 Le choix du modèle MVC, des namespace et de l'orienté objet découlent avant tout d'une démarche d'entraînement et découverte du pattern afin de bien se familiariser avec l'ensemble.

### Gestion des classes
Création d'un autoloader pour charger les classes automatiquement

### Gestion des routes
Utilisation d'un contrôleur frontal pour gérer les routes en passant par un même index.

### Gestion des erreurs
Création d'exceptions personnalisées et conversion des erreurs PHP en exceptions.

### Gestion base de données
Utilisation d'une classe mère représentant la BDD dont héritent les classes du Modèle, récupération des données en modèle objet par défaut.
Utilisation de classes d'entités pour manipuler les données.

### Gestion du front
Approche Mobile-First avec medias queries pour le CSS.
Utilisation de la librairie jQuery pour gérer les pré-vérifications de formulaires et les requêtes ajax du chat.



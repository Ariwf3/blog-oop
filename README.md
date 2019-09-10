# BLOG avec back office modèle mvc approche orienté objet

Un simple blog réalisé dans le cadre d'un examen avec un back office et un chat.

## Motivations, approche et style de programmation choisis
 Le choix du modèle MVC, des namespace et de l'orienté objet découlent avant tout d'une démarche d'entraînement et découverte du pattern afin de bien se familiariser avec l'ensemble.

 ### Installation du projet
* Cloner ou télécharger le dépôt 
* Accéder à la configuration de la bdd par le chemin : 
```
application/classes/config/Database.php 
```
* Modifier les variables $databaseSourceName,$databaseLogin et $databasePassword selon la configuration locale.
```
private $databaseSourceName = 'mysql:host=myHostName;dbname=blog_oop';
private $databaseLogin      = 'myLogin';
private $databasePassword   = 'myPassword';
```
* Importer un des fichiers sql dans le dossier nommé "sql" pour construire la BDD.
```
"blog_oop_empty.sql" contient la base vide avec deux utilisateurs(un admin et un user)
"blog_oop_sample.sql" contient des données d'exemple en plus des deux utilisateurs
utilisateur admin@admin.com password : admin
utilisateur john@john.com password : aaaa
```

### Gestion des classes
Création d'un autoloader pour charger les classes automatiquement.

### Gestion des routes
Utilisation d'un contrôleur frontal pour gérer les routes en passant par un même index.

### Gestion des erreurs
Création d'exceptions personnalisées et conversion des erreurs PHP en exceptions.

### Gestion base de données
* Utilisation d'une classe mère représentant la BDD dont héritent les classes du Modèle
* Récupération des données en modèle objet par défaut
* Utilisation de classes d'entités pour manipuler les données

### Gestion du front
* Approche Mobile-First avec medias queries pour le CSS
* Utilisation de la librairie jQuery pour gérer les pré-vérifications de formulaires et les requêtes ajax du chat

### Documentation
Utilisation de la PHPDoc et de la JSDoc.



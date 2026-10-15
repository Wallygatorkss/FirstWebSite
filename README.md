<div align="center">

# GridQuiz

### Une application web de quiz simple, ludique et extensible

[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Docker](https://img.shields.io/badge/Docker-ready-2496ED?logo=docker&logoColor=white)](https://www.docker.com/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](#licence)

</div>

## Aperçu du projet

**GridQuiz** est une application web développée en PHP après une première Web Piscine. Elle propose des parties de quiz organisées par catégories, avec une sélection aléatoire de questions et un système de score basé sur la progression du joueur.

L'application utilise MySQL pour stocker les catégories et les questions. Elle permet également d'ajouter, de modifier et de supprimer des questions depuis une interface dédiée. L'environnement de développement peut être conteneurisé avec Docker et Docker Compose.

## Fonctionnalités clés

- Jouer à un quiz dans plusieurs catégories : histoire, géographie, sciences, cinéma et sport.
- Tirer cinq questions au hasard pour chaque partie et mélanger l'ordre des réponses.
- Suivre son score et sa progression question par question.
- Ajouter, modifier et supprimer des questions depuis l'interface de gestion.
- Persister les données dans une base MySQL relationnelle.
- Disposer d'un environnement local basé sur PHP 8.2, Apache, MySQL 8 et phpMyAdmin.

## Technologies utilisées

| Technologie | Rôle |
| --- | --- |
| PHP 8.2 | Logique serveur et rendu des pages |
| PDO | Connexion à MySQL et requêtes préparées |
| MySQL 8.0 | Stockage des catégories et des questions |
| HTML / CSS | Structure et interface utilisateur |
| JavaScript | Gestion des messages temporaires |
| Docker / Docker Compose | Conteneurisation de l'environnement local |

## Structure du projet

```text
.
├── docker-compose.yml       # Services web, MySQL et phpMyAdmin
├── dockerfile               # Image PHP 8.2 avec Apache et PDO MySQL
└── src/
    ├── ajax_check_answer.php # Validation d'une réponse
    ├── add_question.php      # Ajout, modification et suppression
    ├── categories.php        # Sélection d'une catégorie
    ├── config.php            # Session et connexion à la base
    ├── database.sql          # Schéma et données initiales
    ├── index.php             # Page d'accueil
    ├── quiz.php              # Déroulement d'une partie
    ├── css/
    │   └── style.css         # Styles de l'application
    └── js/
        └── script.js         # Comportements JavaScript
```

## Prérequis

Pour exécuter le projet, il est recommandé d'avoir :

- [Git](https://git-scm.com/)
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/)

Une exécution locale sans Docker nécessite également PHP 8.2 ou une version supérieure, Apache ou le serveur PHP intégré, ainsi qu'un serveur MySQL.

## Installation et lancement avec Docker

### 1. Récupérer le projet

```bash
git clone https://github.com/Wallygatorkss/FirstWebSite.git
cd FirstWebSite
```

### 2. Préparer la configuration Docker

La configuration Docker fournie utilise actuellement le chemin `/app`, tandis que le code de ce dépôt se trouve dans `/src`. Avant le premier démarrage, remplacez `./app` par `./src` dans `docker-compose.yml` et dans `dockerfile` :

```yaml
# docker-compose.yml
volumes:
  - ./src:/var/www/html
```

```dockerfile
# dockerfile
COPY ./src /var/www/html
```

La connexion définie dans `src/config.php` doit également correspondre au service MySQL. Dans Docker Compose, l'hôte de la base est `db` et la base initialisée par le service est `quizzdb`. Adaptez les valeurs de connexion avant de lancer l'application :

```php
$host = 'db';
$user = 'root';
$pass = 'root';
$db = 'quizzdb';
```

### 3. Démarrer les services

```bash
docker compose up --build -d
```

Les services sont alors accessibles aux adresses suivantes :

- Application : <http://localhost:8080>
- phpMyAdmin : <http://localhost:8081>

### 4. Initialiser les données

Si la base n'est pas initialisée automatiquement, importez le script SQL dans le conteneur MySQL :

```bash
docker cp src/database.sql quizz_db:/tmp/database.sql
docker exec -i quizz_db sh -c 'mysql -uroot -proot < /tmp/database.sql'
```

Pour suivre les logs ou arrêter les services :

```bash
docker compose logs -f
docker compose down
```

> **Remarque :** le script SQL crée la base `database_quiz`, alors que `docker-compose.yml` configure `quizzdb`. Ces deux valeurs doivent être harmonisées avant le lancement, par exemple en utilisant le même nom dans `database.sql`, `docker-compose.yml` et `src/config.php`.

## Utilisation

1. Ouvrir l'application à l'adresse <http://localhost:8080>.
2. Cliquer sur **Jouer**.
3. Choisir une catégorie.
4. Répondre aux cinq questions proposées.
5. Consulter le score final et recommencer la partie si nécessaire.
6. Utiliser **Ajouter une question** pour créer une question, la modifier ou la supprimer.

## Ce que j'ai appris / Défis techniques

Ce projet m'a permis de mettre en pratique plusieurs compétences de développement web :

- Concevoir une application PHP organisée autour de plusieurs pages et d'un parcours utilisateur cohérent.
- Utiliser les sessions PHP pour conserver la catégorie sélectionnée, les questions de la partie et le score.
- Modéliser des données relationnelles avec des catégories, des questions et des clés étrangères MySQL.
- Utiliser PDO et des requêtes préparées pour communiquer avec la base de données.
- Gérer la sélection aléatoire des questions et le mélange des réponses sans perdre la réponse correcte.
- Construire une interface de gestion permettant les opérations d'ajout, de modification et de suppression.
- Découvrir la conteneurisation d'une application web avec Docker Compose et plusieurs services dépendants.

Le principal défi a été de faire communiquer correctement les différentes couches de l'application : interface PHP, session utilisateur, logique du quiz et base de données. La prochaine étape naturelle serait de centraliser la configuration via des variables d'environnement, d'ajouter une validation plus stricte des entrées et de renforcer la gestion des droits sur l'interface d'administration.

## Licence

Ce projet est distribué sous licence **MIT**. Consultez le fichier `LICENSE` (ou ajoutez-le au dépôt) pour connaître les conditions complètes d'utilisation, de modification et de redistribution.

# Système de Gestion de Bibliothèque

Un système de gestion de bibliothèque développé avec Laravel et Bootstrap, permettant de gérer les livres, les auteurs et les emprunts.

## Fonctionnalités

- Gestion des livres (ajout, modification, suppression)
- Gestion des auteurs
- Système d'emprunts avec statuts (en attente, actif, retourné, en retard)
- Interface utilisateur responsive
- Authentification des utilisateurs
- Gestion des permissions

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- MySQL 5.7 ou supérieur
- Node.js et NPM

## Installation

1. Cloner le repository :
```bash
git clone [URL_DU_REPO]
cd bibliotheque
```

2. Installer les dépendances PHP :
```bash
composer install
```

3. Copier le fichier d'environnement :
```bash
cp .env.example .env
```

4. Générer la clé d'application :
```bash
php artisan key:generate
```

5. Configurer la base de données dans le fichier `.env`

6. Exécuter les migrations :
```bash
php artisan migrate
```

7. Installer les dépendances JavaScript :
```bash
npm install
npm run dev
```

8. Créer le lien symbolique pour le stockage :
```bash
php artisan storage:link
```

## Utilisation

1. Démarrer le serveur de développement :
```bash
php artisan serve
```

2. Accéder à l'application dans votre navigateur à l'adresse : `http://localhost:8000`

## Structure du Projet

- `app/Models/` : Modèles Eloquent
- `app/Http/Controllers/` : Contrôleurs
- `app/Http/Middleware/` : Middlewares
- `resources/views/` : Vues Blade
- `database/migrations/` : Migrations de la base de données
- `routes/web.php` : Routes de l'application

## Tests

Pour exécuter les tests :
```bash
php artisan test
```

## Contribution

1. Fork le projet
2. Créer une branche pour votre fonctionnalité
3. Commiter vos changements
4. Pousser vers la branche
5. Ouvrir une Pull Request

## Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

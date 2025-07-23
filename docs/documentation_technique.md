# L'ÉTUDIANT - Documentation Technique

## Vue d'ensemble

**L'Étudiant** est une application web de type site de news développée spécifiquement pour les étudiants techniciens. L'application suit une architecture MVC (Model-View-Controller) stricte et utilise des technologies web modernes pour offrir une expérience utilisateur optimale.

## Technologies utilisées

### Backend
- **PHP 8.0+** : Langage de programmation principal
- **PDO (PHP Data Objects)** : Interface d'accès aux données
- **MySQL** : Système de gestion de base de données

### Frontend
- **HTML5** : Structure sémantique des pages
- **CSS3** : Styles et animations
- **Bootstrap 5** : Framework CSS pour interface responsive
- **JavaScript vanilla** : Interactivité côté client

### Serveur
- **Apache** : Serveur web (via WAMP)
- **WAMP** : Environnement de développement Windows

## Architecture MVC

### Structure des dossiers

```
letudiant/
├── index.php                 # Point d'entrée principal
├── controllers/               # Contrôleurs (logique métier)
│   ├── CategoryController.php
│   └── ArticleController.php
├── models/                   # Modèles (accès aux données)
│   ├── Category.php
│   └── Article.php
├── views/                    # Vues (présentation)
│   ├── layout/
│   │   ├── header.php
│   │   └── footer.php
│   ├── articles/
│   │   └── list.php
│   └── categories/
│       └── menu.php
├── config/                   # Configuration
│   └── database.php
├── public/                   # Ressources statiques
│   ├── css/
│   │   └── styles.css
│   ├── js/
│   │   └── main.js
│   └── images/
└── database/                 # Scripts SQL
    ├── create_database.sql
    └── insert_sample_data.sql
```

## Modèles (Models)

### Category.php
**Responsabilités :**
- Gestion des catégories d'articles
- Opérations CRUD sur la table `categories`
- Validation des données de catégorie

**Méthodes principales :**
```php
getAllCategories()              // Récupère toutes les catégories
getCategoryById($id)            // Récupère une catégorie par ID
create()                        // Crée une nouvelle catégorie
countArticlesByCategory($id)    // Compte les articles d'une catégorie
```

### Article.php
**Responsabilités :**
- Gestion des articles de news
- Opérations CRUD sur la table `articles`
- Jointures avec la table `categories`

**Méthodes principales :**
```php
getAllArticles($limit, $offset)           // Récupère tous les articles
getArticlesByCategory($id, $limit, $offset) // Articles par catégorie
getArticleById($id)                       // Article par ID
create()                                  // Crée un nouvel article
countArticles($category_id)               // Compte les articles
```

## Contrôleurs (Controllers)

### CategoryController.php
**Responsabilités :**
- Logique métier des catégories
- Validation des données d'entrée
- Gestion des erreurs

**Méthodes principales :**
```php
getAllCategories()                    // Récupère toutes les catégories
getCategoryById($id)                  // Récupère une catégorie
createCategory($data)                 // Crée une catégorie
getCategoriesWithArticleCount()       // Catégories avec comptage
```

### ArticleController.php
**Responsabilités :**
- Logique métier des articles
- Pagination des résultats
- Formatage des données

**Méthodes principales :**
```php
getAllArticles($page, $limit)           // Articles avec pagination
getArticlesByCategory($id, $page, $limit) // Articles par catégorie
getArticleById($id)                     // Article par ID
createArticle($data)                    // Crée un article
formatDate($date)                       // Formate les dates
```

## Vues (Views)

### Layout
- **header.php** : En-tête avec navigation et menu des catégories
- **footer.php** : Pied de page avec liens et informations

### Articles
- **list.php** : Affichage des articles en grille responsive avec cards Bootstrap

### Fonctionnalités des vues
- Menu dynamique généré depuis la base de données
- Affichage responsive avec Bootstrap 5
- Gestion des états vides (catégories sans articles)
- Modal pour l'affichage complet des articles

## Configuration

### Database.php
**Responsabilités :**
- Configuration de la connexion PDO
- Gestion des erreurs de connexion
- Paramètres de sécurité

**Configuration par défaut :**
```php
private $host = 'localhost';
private $dbname = 'letudiant_db';
private $username = 'root';
private $password = '';
```

## Sécurité

### Mesures implémentées
- **Préparation des requêtes** : Utilisation de requêtes préparées PDO
- **Validation des données** : Nettoyage avec `htmlspecialchars()` et `strip_tags()`
- **Gestion des erreurs** : Logs d'erreurs sans exposition des détails
- **Paramètres PDO** : Configuration sécurisée avec `ATTR_ERRMODE`

### Prévention des attaques
- **Injection SQL** : Requêtes préparées avec paramètres bindés
- **XSS** : Échappement des données en sortie
- **CSRF** : Validation des données d'entrée

## Fonctionnalités principales

### Navigation
- Menu dynamique des catégories
- Breadcrumb pour la navigation
- Liens responsive avec Bootstrap

### Affichage des articles
- Grille responsive avec cards Bootstrap
- Images avec fallback pour les erreurs
- Pagination (prête pour implémentation)
- Modal pour lecture complète

### Gestion des états
- Message informatif pour catégories vides
- Gestion des erreurs de connexion
- Fallback pour images manquantes

## Performance

### Optimisations
- **Index de base de données** : Sur les colonnes fréquemment utilisées
- **Requêtes optimisées** : Jointures efficaces et limitation des résultats
- **Cache navigateur** : Headers appropriés pour les ressources statiques

### Monitoring
- Logs d'erreurs pour le debugging
- Statistiques d'utilisation prêtes pour implémentation

## Extensibilité

### Fonctionnalités futures
- Système de recherche
- Gestion des utilisateurs
- Commentaires sur les articles
- Système de tags
- RSS feeds

### Architecture évolutive
- Séparation claire des responsabilités
- Modèles extensibles
- Configuration centralisée
- Structure modulaire

## Déploiement

### Prérequis
- PHP 8.0+
- MySQL 5.7+
- Apache avec mod_rewrite
- Extension PDO activée

### Installation
1. Copier les fichiers dans le répertoire web
2. Créer la base de données avec `create_database.sql`
3. Insérer les données d'exemple avec `insert_sample_data.sql`
4. Configurer les paramètres dans `config/database.php`
5. Vérifier les permissions des dossiers

### Maintenance
- Sauvegarde régulière de la base de données
- Mise à jour des dépendances
- Monitoring des logs d'erreurs
- Optimisation des performances

## Tests

### Tests recommandés
- Tests unitaires pour les modèles
- Tests d'intégration pour les contrôleurs
- Tests fonctionnels pour les vues
- Tests de charge pour les performances

### Scénarios de test
- Affichage des articles par catégorie
- Gestion des catégories vides
- Validation des données d'entrée
- Gestion des erreurs de connexion
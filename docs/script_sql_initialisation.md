# L'ÉTUDIANT - Script SQL d'Initialisation

## Guide d'utilisation

Ce document contient tous les scripts SQL nécessaires pour initialiser complètement la base de données du projet "L'Étudiant".

## Ordre d'exécution

### 1. Création de la base de données

Exécuter le script `database/create_database.sql` en premier :

```sql
-- Connexion à MySQL en tant que root
mysql -u root -p

-- Exécution du script de création
source /chemin/vers/database/create_database.sql
```

### 2. Insertion des données d'exemple

Exécuter ensuite le script `database/insert_sample_data.sql` :

```sql
-- Exécution du script d'insertion
source /chemin/vers/database/insert_sample_data.sql
```

## Script de création rapide

Si vous souhaitez exécuter tout en une seule fois, voici le script complet :

```sql
-- =================================================================
-- SCRIPT D'INITIALISATION COMPLET - L'ÉTUDIANT
-- =================================================================

-- Création de la base de données
CREATE DATABASE IF NOT EXISTS `letudiant_db` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `letudiant_db`;

-- =================================================================
-- CRÉATION DES TABLES
-- =================================================================

-- Table categories
CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL UNIQUE,
    `description` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_category_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table articles
CREATE TABLE IF NOT EXISTS `articles` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    `description` TEXT,
    `image_url` VARCHAR(500),
    `category_id` INT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL,
    INDEX `idx_article_category` (`category_id`),
    INDEX `idx_article_created` (`created_at`),
    INDEX `idx_article_title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =================================================================
-- INSERTION DES DONNÉES
-- =================================================================

-- Insertion des catégories
INSERT INTO `categories` (`name`, `description`) VALUES
('Informatique', 'Actualités et tendances dans le domaine de l\'informatique, programmation, développement web, intelligence artificielle.'),
('Électronique', 'Innovations en électronique, composants, circuits, systèmes embarqués et nouvelles technologies.'),
('Mécanique', 'Actualités en ingénierie mécanique, automobile, robotique industrielle et nouvelles techniques de fabrication.'),
('Réseaux & Télécom', 'Technologies de réseau, télécommunications, cybersécurité et infrastructure numérique.'),
('Énergie Renouvelable', 'Innovations en énergies propres, solaire, éolien, et technologies durables pour l\'avenir.');

-- Insertion des articles
INSERT INTO `articles` (`title`, `content`, `description`, `image_url`, `category_id`) VALUES
(
    'L\'Intelligence Artificielle transforme l\'industrie',
    'L\'intelligence artificielle (IA) révolutionne tous les secteurs industriels. Depuis les systèmes de recommandation jusqu\'aux voitures autonomes, l\'IA devient un élément central de l\'innovation technologique. Les étudiants en informatique doivent maîtriser ces technologies pour rester compétitifs sur le marché du travail.',
    'Découvrez comment l\'IA révolutionne l\'industrie et les opportunités pour les étudiants techniciens.',
    'https://images.pexels.com/photos/8438918/pexels-photo-8438918.jpeg?auto=compress&cs=tinysrgb&w=500',
    1
),
(
    'Les nouveaux frameworks JavaScript en 2025',
    'Le paysage JavaScript continue d\'évoluer rapidement avec l\'émergence de nouveaux frameworks et bibliothèques. React, Vue.js et Angular dominent toujours, mais de nouveaux acteurs comme Solid.js et Qwik apportent des approches innovantes. Les étudiants doivent comprendre ces évolutions pour faire les bons choix technologiques.',
    'Tour d\'horizon des frameworks JavaScript les plus prometteurs pour cette année.',
    'https://images.pexels.com/photos/270348/pexels-photo-270348.jpeg?auto=compress&cs=tinysrgb&w=500',
    1
),
(
    'Les processeurs quantiques : l\'avenir de l\'informatique',
    'Les processeurs quantiques représentent une révolution technologique majeure. Contrairement aux processeurs classiques qui utilisent des bits binaires, les processeurs quantiques exploitent les propriétés quantiques pour effectuer des calculs exponentiellement plus rapides. Cette technologie promet de résoudre des problèmes complexes en cryptographie, simulation moléculaire et optimisation.',
    'Exploration des processeurs quantiques et leur impact sur l\'avenir technologique.',
    'https://images.pexels.com/photos/2599244/pexels-photo-2599244.jpeg?auto=compress&cs=tinysrgb&w=500',
    2
),
(
    'La 5G et l\'Internet des Objets : une synergie puissante',
    'La cinquième génération de réseaux mobiles (5G) ouvre de nouvelles possibilités pour l\'Internet des Objets (IoT). Avec des débits ultra-rapides et une latence minimale, la 5G permet de connecter des millions d\'appareils simultanément. Cette technologie transforme les smart cities, la médecine connectée et l\'industrie 4.0.',
    'Comment la 5G révolutionne l\'Internet des Objets et crée de nouvelles opportunités.',
    'https://images.pexels.com/photos/8566473/pexels-photo-8566473.jpeg?auto=compress&cs=tinysrgb&w=500',
    4
),
(
    'Les panneaux solaires de nouvelle génération',
    'Les technologies photovoltaïques évoluent rapidement avec l\'arrivée de nouveaux matériaux et techniques de fabrication. Les panneaux solaires pérovskites promettent des rendements supérieurs à 30% tout en réduisant les coûts de production. Cette innovation majeure pourrait démocratiser l\'énergie solaire dans le monde entier.',
    'Découvrez les innovations en photovoltaïque qui transforment l\'énergie solaire.',
    'https://images.pexels.com/photos/356036/pexels-photo-356036.jpeg?auto=compress&cs=tinysrgb&w=500',
    5
),
(
    'Python vs JavaScript : quel langage choisir ?',
    'Le choix du langage de programmation est crucial pour les étudiants. Python excelle dans l\'analyse de données et l\'IA, tandis que JavaScript domine le développement web. Chaque langage a ses avantages et inconvénients. Python offre une syntaxe claire et une vaste bibliothèque, JavaScript permet une interactivité web native.',
    'Comparaison complète entre Python et JavaScript pour guider votre choix.',
    'https://images.pexels.com/photos/1181673/pexels-photo-1181673.jpeg?auto=compress&cs=tinysrgb&w=500',
    1
),
(
    'Les microcontrôleurs Arduino : projets créatifs',
    'Arduino révolutionne l\'apprentissage de l\'électronique avec ses microcontrôleurs accessibles. Ces plateformes permettent de créer des projets innovants : domotique, robotique, art interactif. La communauté Arduino partage des milliers de projets open source. Les étudiants peuvent rapidement prototyper leurs idées et apprendre par la pratique.',
    'Découvrez les possibilités créatives offertes par les microcontrôleurs Arduino.',
    'https://images.pexels.com/photos/2582937/pexels-photo-2582937.jpeg?auto=compress&cs=tinysrgb&w=500',
    2
),
(
    'Cybersécurité : les nouvelles menaces en 2025',
    'La cybersécurité devient un enjeu majeur avec l\'augmentation des cyberattaques. Les ransomwares, phishing et attaques par déni de service évoluent constamment. Les professionnels des réseaux doivent maîtriser les techniques de protection et de détection. La formation en cybersécurité est essentielle pour sécuriser les infrastructures numériques.',
    'Panorama des nouvelles menaces cybersécurité et stratégies de protection.',
    'https://images.pexels.com/photos/5380664/pexels-photo-5380664.jpeg?auto=compress&cs=tinysrgb&w=500',
    4
);

-- =================================================================
-- VÉRIFICATION DE L'INSTALLATION
-- =================================================================

-- Vérifier les données
SELECT 'Installation terminée avec succès' AS status;
SELECT COUNT(*) AS categories_count FROM categories;
SELECT COUNT(*) AS articles_count FROM articles;

-- Afficher la répartition
SELECT 
    c.name AS categorie,
    COUNT(a.id) AS nombre_articles
FROM categories c
LEFT JOIN articles a ON c.id = a.category_id
GROUP BY c.id, c.name
ORDER BY nombre_articles DESC;
```

## Vérification de l'installation

Après l'exécution des scripts, vérifiez que tout fonctionne correctement :

```sql
-- Vérifier les tables créées
SHOW TABLES;

-- Vérifier les données des catégories
SELECT * FROM categories ORDER BY name;

-- Vérifier les données des articles
SELECT 
    a.title,
    c.name AS category,
    a.created_at
FROM articles a
LEFT JOIN categories c ON a.category_id = c.id
ORDER BY a.created_at DESC;

-- Vérifier qu'il y a une catégorie sans articles (pour tester l'affichage)
SELECT 
    c.name AS categorie,
    COUNT(a.id) AS nombre_articles
FROM categories c
LEFT JOIN articles a ON c.id = a.category_id
GROUP BY c.id, c.name
HAVING COUNT(a.id) = 0;
```

## Dépannage

### Problèmes courants

**Erreur : "Table already exists"**
```sql
-- Supprimer et recréer les tables
DROP TABLE IF EXISTS articles;
DROP TABLE IF EXISTS categories;
-- Puis réexécuter le script de création
```

**Erreur : "Foreign key constraint fails"**
```sql
-- Vérifier les contraintes de clés étrangères
SHOW CREATE TABLE articles;
-- Désactiver temporairement les vérifications
SET FOREIGN_KEY_CHECKS = 0;
-- Réactiver après insertion
SET FOREIGN_KEY_CHECKS = 1;
```

**Erreur : "Access denied"**
```sql
-- Vérifier les permissions utilisateur
SHOW GRANTS FOR CURRENT_USER;
-- Accorder les permissions nécessaires
GRANT ALL PRIVILEGES ON letudiant_db.* TO 'root'@'localhost';
```

### Réinitialisation complète

Pour recommencer à zéro :

```sql
-- Supprimer complètement la base de données
DROP DATABASE IF EXISTS letudiant_db;
-- Puis réexécuter le script d'initialisation complet
```

## Configuration WAMP

### Paramètres recommandés

Dans `my.ini` (configuration MySQL) :

```ini
[mysql]
default-character-set = utf8mb4

[mysqld]
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci
innodb_buffer_pool_size = 256M
query_cache_size = 64M
```

### Vérification de la configuration

```sql
-- Vérifier l'encodage
SHOW VARIABLES LIKE 'character_set%';
SHOW VARIABLES LIKE 'collation%';

-- Vérifier les performances
SHOW VARIABLES LIKE 'innodb_buffer_pool_size';
SHOW VARIABLES LIKE 'query_cache_size';
```

## Commandes utiles

### Sauvegarde
```bash
mysqldump -u root -p letudiant_db > backup_letudiant.sql
```

### Restauration
```bash
mysql -u root -p letudiant_db < backup_letudiant.sql
```

### Export des données seules
```bash
mysqldump -u root -p --no-create-info --skip-triggers letudiant_db > data_only.sql
```

Ce script d'initialisation vous permettra de déployer rapidement et efficacement la base de données du projet "L'Étudiant" dans votre environnement WAMP.
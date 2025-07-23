# L'ÉTUDIANT - Documentation Base de Données

## Vue d'ensemble

La base de données `letudiant_db` utilise MySQL avec l'encodage UTF-8 pour supporter les caractères spéciaux. Elle est conçue pour être performante, sécurisée et évolutive.

## Configuration générale

### Paramètres de base
- **Nom de la base** : `letudiant_db`
- **Moteur** : InnoDB
- **Encodage** : utf8mb4_unicode_ci
- **Collation** : utf8mb4_unicode_ci

### Caractéristiques techniques
- **Clés étrangères** : Activées avec contraintes référentielles
- **Transactions** : Support ACID complet
- **Index** : Optimisés pour les requêtes fréquentes
- **Vues** : Vues métier pour simplifier les requêtes

## Structure des tables

### Table : categories

**Description :** Stockage des catégories d'articles

| Champ | Type | Contraintes | Description |
|-------|------|-------------|-------------|
| id | INT | AUTO_INCREMENT, PRIMARY KEY | Identifiant unique |
| name | VARCHAR(100) | NOT NULL, UNIQUE | Nom de la catégorie |
| description | TEXT | NULL | Description détaillée |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Date de création |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Date de modification |

**Index :**
- `PRIMARY KEY (id)`
- `INDEX idx_category_name (name)`

**Contraintes :**
- Le nom doit être unique
- Le nom ne peut pas être vide

### Table : articles

**Description :** Stockage des articles de news

| Champ | Type | Contraintes | Description |
|-------|------|-------------|-------------|
| id | INT | AUTO_INCREMENT, PRIMARY KEY | Identifiant unique |
| title | VARCHAR(255) | NOT NULL | Titre de l'article |
| content | TEXT | NOT NULL | Contenu complet |
| description | TEXT | NULL | Description courte |
| image_url | VARCHAR(500) | NULL | URL de l'image |
| category_id | INT | FOREIGN KEY | Référence vers categories |
| created_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Date de création |
| updated_at | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Date de modification |

**Index :**
- `PRIMARY KEY (id)`
- `INDEX idx_article_category (category_id)`
- `INDEX idx_article_created (created_at)`
- `INDEX idx_article_title (title)`

**Contraintes :**
- Le titre ne peut pas être vide
- Le contenu ne peut pas être vide
- Clé étrangère vers categories avec `ON DELETE SET NULL`

## Relations entre tables

### Relation : categories → articles
- **Type** : One-to-Many (1:N)
- **Clé étrangère** : `articles.category_id` → `categories.id`
- **Contrainte** : `ON DELETE SET NULL` (si une catégorie est supprimée, les articles deviennent "sans catégorie")

### Schéma relationnel

```
categories (1) ----< articles (N)
     |                   |
     id                  category_id
```

## Vues prédéfinies

### view_articles_with_category

**Description :** Simplifie l'affichage des articles avec leurs catégories

```sql
CREATE OR REPLACE VIEW view_articles_with_category AS
SELECT 
    a.id,
    a.title,
    a.content,
    a.description,
    a.image_url,
    a.created_at,
    a.updated_at,
    c.id AS category_id,
    c.name AS category_name,
    c.description AS category_description
FROM articles a
LEFT JOIN categories c ON a.category_id = c.id
ORDER BY a.created_at DESC;
```

### view_category_stats

**Description :** Statistiques des catégories avec nombre d'articles

```sql
CREATE OR REPLACE VIEW view_category_stats AS
SELECT 
    c.id,
    c.name,
    c.description,
    c.created_at,
    COUNT(a.id) AS article_count
FROM categories c
LEFT JOIN articles a ON c.id = a.category_id
GROUP BY c.id, c.name, c.description, c.created_at
ORDER BY c.name ASC;
```

## Procédures stockées

### GetArticlesPaginated

**Description :** Récupère les articles avec pagination

```sql
DELIMITER //
CREATE PROCEDURE GetArticlesPaginated(
    IN p_category_id INT,
    IN p_limit INT,
    IN p_offset INT
)
BEGIN
    IF p_category_id IS NULL THEN
        SELECT a.*, c.name AS category_name
        FROM articles a
        LEFT JOIN categories c ON a.category_id = c.id
        ORDER BY a.created_at DESC
        LIMIT p_limit OFFSET p_offset;
    ELSE
        SELECT a.*, c.name AS category_name
        FROM articles a
        LEFT JOIN categories c ON a.category_id = c.id
        WHERE a.category_id = p_category_id
        ORDER BY a.created_at DESC
        LIMIT p_limit OFFSET p_offset;
    END IF;
END//
DELIMITER ;
```

## Données d'exemple

### Catégories créées
1. **Informatique** - Actualités et tendances en informatique
2. **Électronique** - Innovations en électronique et composants
3. **Mécanique** - Ingénierie mécanique et robotique
4. **Réseaux & Télécom** - Technologies réseau et télécommunications
5. **Énergie Renouvelable** - Innovations en énergies propres

### Articles d'exemple
- **8 articles** répartis sur 4 catégories
- **1 catégorie vide** (Mécanique) pour tester l'affichage des messages
- **Images** provenant de Pexels pour les démonstrations
- **Contenu réaliste** adapté aux étudiants techniciens

## Performance et optimisation

### Index stratégiques
- **categories.name** : Recherche rapide par nom
- **articles.category_id** : Jointures efficaces
- **articles.created_at** : Tri chronologique
- **articles.title** : Recherche textuelle

### Requêtes optimisées
- Utilisation de `LEFT JOIN` pour éviter les résultats vides
- Limitation des résultats avec `LIMIT` et `OFFSET`
- Index composites pour les requêtes complexes

### Configuration recommandée
```sql
-- Augmenter la taille du buffer pool
SET GLOBAL innodb_buffer_pool_size = 268435456; -- 256MB

-- Activer le cache des requêtes
SET GLOBAL query_cache_size = 67108864; -- 64MB
```

## Sécurité

### Mesures implémentées
- **Contraintes référentielles** pour l'intégrité des données
- **Validation des types** avec des contraintes strictes
- **Échappement automatique** avec l'encodage UTF-8
- **Audit trail** optionnel avec table de logs

### Permissions recommandées
```sql
-- Utilisateur application (lecture/écriture)
CREATE USER 'letudiant_app'@'localhost' IDENTIFIED BY 'mot_de_passe_fort';
GRANT SELECT, INSERT, UPDATE ON letudiant_db.* TO 'letudiant_app'@'localhost';

-- Utilisateur lecture seule
CREATE USER 'letudiant_read'@'localhost' IDENTIFIED BY 'mot_de_passe_lecture';
GRANT SELECT ON letudiant_db.* TO 'letudiant_read'@'localhost';
```

## Maintenance et sauvegarde

### Sauvegarde quotidienne
```bash
#!/bin/bash
mysqldump -u root -p letudiant_db > backup_$(date +%Y%m%d).sql
```

### Nettoyage des données
```sql
-- Supprimer les articles trop anciens (> 2 ans)
DELETE FROM articles WHERE created_at < DATE_SUB(NOW(), INTERVAL 2 YEAR);

-- Optimiser les tables
OPTIMIZE TABLE categories, articles;
```

### Monitoring
```sql
-- Vérifier la taille des tables
SELECT 
    table_name,
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS size_mb
FROM information_schema.tables 
WHERE table_schema = 'letudiant_db';

-- Analyser les performances
SHOW PROCESSLIST;
EXPLAIN SELECT * FROM articles WHERE category_id = 1;
```

## Évolution future

### Tables additionnelles prévues
- **users** : Gestion des utilisateurs
- **comments** : Système de commentaires
- **tags** : Système de tags pour les articles
- **likes** : Système de likes/favoris

### Migrations
- Structure versionnée avec scripts de migration
- Données préservées lors des mises à jour
- Rollback possible en cas de problème

### Scalabilité
- Partitionnement des tables volumineuses
- Réplication master-slave pour la lecture
- Cache Redis pour les données fréquentes
- CDN pour les images
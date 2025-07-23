<?php
/**
 * L'Étudiant - Site de News pour Étudiants Techniciens
 * Point d'entrée principal de l'application
 */

// Configuration et autoloading
require_once 'config/database.php';
require_once 'controllers/CategoryController.php';
require_once 'controllers/ArticleController.php';

// Récupération des paramètres
$action = isset($_GET['action']) ? $_GET['action'] : 'home';
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;
$article_id = isset($_GET['id']) ? intval($_GET['id']) : null;

// Initialisation des contrôleurs
$categoryController = new CategoryController();
$articleController = new ArticleController();

// Récupération des catégories pour le menu (toujours nécessaire)
$categories = $categoryController->getAllCategories();

// Logique de routage
switch ($action) {
    case 'article':
        $article = $articleController->getArticleById($article_id);
        if (!$article) {
            // Article non trouvé, redirection vers l'accueil
            header('Location: index.php');
            exit;
        }
        
        // Récupération d'articles suggérés de la même catégorie
        $relatedArticles = [];
        if ($article['category_id']) {
            $allRelated = $articleController->getArticlesByCategory($article['category_id'], 1, 6);
            // Exclure l'article actuel des suggestions
            $relatedArticles = array_filter($allRelated, function($related) use ($article_id) {
                return $related['id'] != $article_id;
            });
            // Limiter à 3 articles suggérés
            $relatedArticles = array_slice($relatedArticles, 0, 3);
        }
        
        $selectedCategory = null;
        break;
        
    case 'category':
        $articles = $articleController->getArticlesByCategory($category_id);
        $selectedCategory = $categoryController->getCategoryById($category_id);
        break;
    case 'home':
    default:
        $articles = $articleController->getAllArticles();
        $selectedCategory = null;
        break;
}

// Inclusion des templates selon l'action
if ($action === 'article') {
    // Page de détail d'article
    include 'views/layout/header.php';
    include 'views/articles/detail.php';
    include 'views/layout/footer.php';
} else {
    // Pages de liste (accueil ou catégorie)
    include 'views/layout/header.php';
    ?>
    
    <main class="container mt-4">
        <?php if ($selectedCategory): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($selectedCategory['name']); ?></li>
                        </ol>
                    </nav>
                    <h1 class="h2 mb-0">Articles - <?php echo htmlspecialchars($selectedCategory['name']); ?></h1>
                    <p class="text-muted"><?php echo htmlspecialchars($selectedCategory['description']); ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="h2 mb-0">Tous les Articles</h1>
                    <p class="text-muted">Découvrez toutes les actualités pour étudiants techniciens</p>
                </div>
            </div>
        <?php endif; ?>
    
        <?php include 'views/articles/list.php'; ?>
    </main>
    
    <?php 
    include 'views/layout/footer.php';
}
?>
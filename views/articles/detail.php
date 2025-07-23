<?php
/**
 * Vue de détail d'un article
 * Affiche le contenu complet d'un article avec navigation
 */

if (!isset($article) || !$article): ?>
    <div class="container mt-4">
        <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
            <h4>Article non trouvé</h4>
            <p>L'article que vous recherchez n'existe pas ou a été supprimé.</p>
            <a href="index.php" class="btn btn-primary">
                <i class="fas fa-home me-1"></i>
                Retour à l'accueil
            </a>
        </div>
    </div>
<?php else: ?>
    <main class="container mt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">
                        <i class="fas fa-home me-1"></i>
                        Accueil
                    </a>
                </li>
                <?php if (!empty($article['category_name'])): ?>
                    <li class="breadcrumb-item">
                        <a href="index.php?action=category&category_id=<?php echo $article['category_id']; ?>">
                            <?php echo htmlspecialchars($article['category_name']); ?>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php echo htmlspecialchars(substr($article['title'], 0, 50)) . (strlen($article['title']) > 50 ? '...' : ''); ?>
                </li>
            </ol>
        </nav>

        <!-- Article principal -->
        <article class="row">
            <div class="col-lg-8 mx-auto">
                <!-- En-tête de l'article -->
                <header class="mb-4">
                    <h1 class="display-5 fw-bold mb-3">
                        <?php echo htmlspecialchars($article['title']); ?>
                    </h1>
                    
                    <!-- Métadonnées -->
                    <div class="d-flex flex-wrap align-items-center mb-3 text-muted">
                        <?php if (!empty($article['category_name'])): ?>
                            <span class="badge bg-primary me-3">
                                <i class="fas fa-folder me-1"></i>
                                <?php echo htmlspecialchars($article['category_name']); ?>
                            </span>
                        <?php endif; ?>
                        
                        <span class="me-3">
                            <i class="fas fa-calendar-alt me-1"></i>
                            <?php 
                            $articleController = new ArticleController();
                            echo $articleController->formatDate($article['created_at']); 
                            ?>
                        </span>
                        
                        <span class="me-3">
                            <i class="fas fa-clock me-1"></i>
                            <?php 
                            $wordCount = str_word_count(strip_tags($article['content']));
                            $readingTime = ceil($wordCount / 200); // 200 mots par minute
                            echo $readingTime . ' min de lecture';
                            ?>
                        </span>
                    </div>
                    
                    <!-- Description -->
                    <?php if (!empty($article['description'])): ?>
                        <div class="lead text-muted mb-4">
                            <?php echo htmlspecialchars($article['description']); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <!-- Image principale -->
                <?php if (!empty($article['image_url'])): ?>
                    <figure class="mb-4">
                        <img src="<?php echo htmlspecialchars($article['image_url']); ?>" 
                             class="img-fluid rounded shadow-sm w-100" 
                             alt="<?php echo htmlspecialchars($article['title']); ?>"
                             style="max-height: 400px; object-fit: cover;">
                        <figcaption class="text-muted small mt-2 text-center">
                            Illustration pour l'article : <?php echo htmlspecialchars($article['title']); ?>
                        </figcaption>
                    </figure>
                <?php endif; ?>

                <!-- Contenu de l'article -->
                <div class="article-content">
                    <?php 
                    // Formatage du contenu avec paragraphes
                    $content = htmlspecialchars($article['content']);
                    $paragraphs = explode("\n\n", $content);
                    
                    foreach ($paragraphs as $paragraph) {
                        if (trim($paragraph)) {
                            echo '<p class="mb-3 lh-lg">' . nl2br(trim($paragraph)) . '</p>';
                        }
                    }
                    ?>
                </div>

                <!-- Actions -->
                <div class="mt-5 pt-4 border-top">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm" onclick="window.print()">
                                    <i class="fas fa-print me-1"></i>
                                    Imprimer
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" onclick="shareArticle()">
                                    <i class="fas fa-share me-1"></i>
                                    Partager
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <?php if (!empty($article['category_id'])): ?>
                                <a href="index.php?action=category&category_id=<?php echo $article['category_id']; ?>" 
                                   class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Retour à <?php echo htmlspecialchars($article['category_name']); ?>
                                </a>
                            <?php else: ?>
                                <a href="index.php" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Retour à l'accueil
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- Articles suggérés -->
        <?php if (!empty($relatedArticles)): ?>
            <section class="mt-5 pt-5 border-top">
                <div class="row">
                    <div class="col-12">
                        <h3 class="h4 mb-4">
                            <i class="fas fa-newspaper me-2"></i>
                            Articles suggérés
                        </h3>
                    </div>
                </div>
                
                <div class="row">
                    <?php foreach ($relatedArticles as $relatedArticle): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <?php if (!empty($relatedArticle['image_url'])): ?>
                                    <img src="<?php echo htmlspecialchars($relatedArticle['image_url']); ?>" 
                                         class="card-img-top" 
                                         alt="<?php echo htmlspecialchars($relatedArticle['title']); ?>"
                                         style="height: 150px; object-fit: cover;">
                                <?php endif; ?>
                                
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="index.php?action=article&id=<?php echo $relatedArticle['id']; ?>" 
                                           class="text-decoration-none">
                                            <?php echo htmlspecialchars($relatedArticle['title']); ?>
                                        </a>
                                    </h5>
                                    
                                    <p class="card-text text-muted small">
                                        <?php 
                                        $description = $relatedArticle['description'] ?: $relatedArticle['content'];
                                        echo htmlspecialchars(substr($description, 0, 100)) . '...'; 
                                        ?>
                                    </p>
                                    
                                    <div class="mt-auto">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            <?php echo $articleController->formatDate($relatedArticle['created_at']); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <!-- Script pour le partage -->
    <script>
    function shareArticle() {
        if (navigator.share) {
            navigator.share({
                title: '<?php echo addslashes($article['title']); ?>',
                text: '<?php echo addslashes($article['description'] ?: substr($article['content'], 0, 100) . '...'); ?>',
                url: window.location.href
            });
        } else {
            // Fallback : copier l'URL dans le presse-papiers
            navigator.clipboard.writeText(window.location.href).then(function() {
                alert('Lien copié dans le presse-papiers !');
            });
        }
    }
    </script>
<?php endif; ?>
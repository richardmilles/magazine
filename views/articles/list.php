<?php
/**
 * Vue d'affichage des articles
 * Affiche la liste des articles sous forme de cards responsive
 */
?>       

<div class="row">
    <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm article-card">
                    <?php if (!empty($article['image_url'])): ?>
                        <img src="<?php echo htmlspecialchars($article['image_url']); ?>" 
                             class="card-img-top" 
                             alt="<?php echo htmlspecialchars($article['title']); ?>"
                             style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                             style="height: 200px;">
                            <i class="fas fa-image text-muted fa-3x"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <?php if (!empty($article['category_name'])): ?>
                                <span class="badge bg-primary">
                                    <?php echo htmlspecialchars($article['category_name']); ?>
                                </span>
                            <?php endif; ?>
                            <span class="badge bg-secondary">
                                <i class="fas fa-calendar-alt me-1"></i>
                                <?php 
                                $articleController = new ArticleController();
                                echo $articleController->formatDate($article['created_at']); 
                                ?>
                            </span>
                        </div>
                        
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($article['title']); ?>
                        </h5>
                        
                        <p class="card-text text-muted flex-grow-1">
                            <?php 
                            $description = $article['description'] ?: $article['content'];
                            echo htmlspecialchars(substr($description, 0, 150)) . '...'; 
                            ?>
                        </p>
                        
                        <div class="mt-auto">
                            <a href="index.php?action=article&id=<?php echo $article['id']; ?>" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>
                                Lire la suite
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- Message d'état vide -->
        <div class="col-12">
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-info-circle fa-3x mb-3"></i>
                <h4>Aucun article disponible</h4>
                <?php if ($selectedCategory): ?>
                    <p class="mb-0">
                        Aucun article n'est disponible dans la catégorie 
                        "<strong><?php echo htmlspecialchars($selectedCategory['name']); ?></strong>" pour le moment.
                    </p>
                    <p class="mt-2">
                        <a href="index.php" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Retour à l'accueil
                        </a>
                    </p>
                <?php else: ?>
                    <p class="mb-0">Aucun article n'est disponible pour le moment.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
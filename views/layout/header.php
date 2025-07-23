<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($selectedCategory) ? htmlspecialchars($selectedCategory['name']) . ' - ' : ''; ?>L'Étudiant</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles personnalisés -->
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <!-- Header principal -->
    <header class="bg-primary text-white shadow-sm">
        <div class="container">
            <div class="row align-items-center py-3">
                <div class="col-md-6">
                    <h1 class="h3 mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>
                        <a href="index.php" class="text-white text-decoration-none">L'Étudiant</a>
                    </h1>
                    <p class="mb-0 small opacity-75">Actualités pour étudiants techniciens</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="small">
                        <i class="fas fa-calendar-alt me-1"></i>
                        <?php echo date('d/m/Y'); ?>
                    </span>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation des catégories -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo !isset($_GET['category_id']) ? 'active' : ''; ?>" 
                           href="index.php">
                            <i class="fas fa-home me-1"></i>
                            Accueil
                        </a>
                    </li>
                    
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo (isset($_GET['category_id']) && $_GET['category_id'] == $category['id']) ? 'active' : ''; ?>" 
                                   href="index.php?action=category&category_id=<?php echo $category['id']; ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="nav-item">
                            <span class="nav-link text-muted">Aucune catégorie disponible</span>
                        </li>
                    <?php endif; ?>
                </ul>
                
                <!-- Recherche (future fonctionnalité) -->
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Rechercher..." disabled>
                    <button class="btn btn-outline-secondary" type="submit" disabled>
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>
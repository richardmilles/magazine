<?php
/**
 * Contrôleur Category
 * Gestion de la logique métier des catégories
 */

require_once 'models/Category.php';   

class CategoryController {
    private $categoryModel;
    
    /**
     * Constructeur
     */
    public function __construct() {
        $this->categoryModel = new Category();
    }
    
    /**
     * Récupérer toutes les catégories
     * @return array
     */
    public function getAllCategories() {
        try {
            return $this->categoryModel->getAllCategories();
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération des catégories : " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Récupérer une catégorie par ID
     * @param int $id
     * @return array|null
     */
    public function getCategoryById($id) {
        try {
            if (!$id || !is_numeric($id)) {
                return null;
            }
            
            return $this->categoryModel->getCategoryById($id);
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération de la catégorie : " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Créer une nouvelle catégorie
     * @param array $data
     * @return bool
     */
    public function createCategory($data) {
        try {
            // Validation des données
            if (empty($data['name'])) {
                return false;
            }
            
            $this->categoryModel->name = $data['name'];
            $this->categoryModel->description = $data['description'] ?? '';
            
            return $this->categoryModel->create();
        } catch (Exception $e) {
            error_log("Erreur lors de la création de la catégorie : " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtenir les catégories avec le nombre d'articles
     * @return array
     */
    public function getCategoriesWithArticleCount() {
        try {
            $categories = $this->getAllCategories();
            
            foreach ($categories as &$category) {
                $category['article_count'] = $this->categoryModel->countArticlesByCategory($category['id']);
            }
            
            return $categories;
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération des catégories avec comptage : " . $e->getMessage());
            return [];
        }
    }
}
?>    
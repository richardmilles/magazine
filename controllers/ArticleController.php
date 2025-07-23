<?php
/**
 * Contrôleur Article
 * Gestion de la logique métier des articles
 */

require_once 'models/Article.php';

class ArticleController {
    private $articleModel;
    
    /**
     * Constructeur
     */
    public function __construct() {
        $this->articleModel = new Article();
    }
    
    /**
     * Récupérer tous les articles
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getAllArticles($page = 1, $limit = 12) {
        try {
            $offset = ($page - 1) * $limit;
            return $this->articleModel->getAllArticles($limit, $offset);
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération des articles : " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Récupérer les articles par catégorie
     * @param int $category_id
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getArticlesByCategory($category_id, $page = 1, $limit = 12) {
        try {
            if (!$category_id || !is_numeric($category_id)) {
                return [];
            }
            
            $offset = ($page - 1) * $limit;
            return $this->articleModel->getArticlesByCategory($category_id, $limit, $offset);
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération des articles par catégorie : " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Récupérer un article par ID
     * @param int $id
     * @return array|null
     */
    public function getArticleById($id) {
        try {
            if (!$id || !is_numeric($id)) {
                return null;
            }
            
            return $this->articleModel->getArticleById($id);
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération de l'article : " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Créer un nouvel article
     * @param array $data
     * @return bool
     */
    public function createArticle($data) {
        try {
            // Validation des données
            if (empty($data['title']) || empty($data['content'])) {
                return false;
            }
            
            $this->articleModel->title = $data['title'];
            $this->articleModel->content = $data['content'];
            $this->articleModel->description = $data['description'] ?? '';
            $this->articleModel->image_url = $data['image_url'] ?? '';
            $this->articleModel->category_id = $data['category_id'] ?? null;
            
            return $this->articleModel->create();
        } catch (Exception $e) {
            error_log("Erreur lors de la création de l'article : " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Compter le nombre d'articles
     * @param int $category_id
     * @return int
     */
    public function countArticles($category_id = null) {
        try {
            return $this->articleModel->countArticles($category_id);
        } catch (Exception $e) {
            error_log("Erreur lors du comptage des articles : " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Formater la date d'un article
     * @param string $date
     * @return string
     */
    public function formatDate($date) {
        try {
            $dateTime = new DateTime($date);
            return $dateTime->format('d/m/Y à H:i');
        } catch (Exception $e) {
            return $date;
        }
    }
}
?>
<?php
/**
 * Modèle Article
 * Gestion des articles de news
 */

require_once 'config/database.php';

class Article {
    private $connection;
    private $table = 'articles';
    
    // Propriétés
    public $id;
    public $title;
    public $content;
    public $description;
    public $image_url;
    public $category_id;
    public $created_at;
    public $updated_at;
    
    /**
     * Constructeur
     */
    public function __construct() {
        $database = new Database();
        $this->connection = $database->getConnection();
    }
    
    /**
     * Récupérer tous les articles avec informations de catégorie
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllArticles($limit = 20, $offset = 0) {
        $query = "SELECT a.*, c.name as category_name 
                  FROM " . $this->table . " a 
                  LEFT JOIN categories c ON a.category_id = c.id 
                  ORDER BY a.created_at DESC 
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Récupérer les articles par catégorie
     * @param int $category_id
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getArticlesByCategory($category_id, $limit = 20, $offset = 0) {
        $query = "SELECT a.*, c.name as category_name 
                  FROM " . $this->table . " a 
                  LEFT JOIN categories c ON a.category_id = c.id 
                  WHERE a.category_id = :category_id 
                  ORDER BY a.created_at DESC 
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Récupérer un article par ID
     * @param int $id
     * @return array|false
     */
    public function getArticleById($id) {
        $query = "SELECT a.*, c.name as category_name 
                  FROM " . $this->table . " a 
                  LEFT JOIN categories c ON a.category_id = c.id 
                  WHERE a.id = :id LIMIT 1";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Créer un nouvel article
     * @return bool
     */
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (title, content, description, image_url, category_id) 
                  VALUES (:title, :content, :description, :image_url, :category_id)";
        
        $stmt = $this->connection->prepare($query);
        
        // Nettoyage des données
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));
        
        // Binding des paramètres
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image_url', $this->image_url);
        $stmt->bindParam(':category_id', $this->category_id);
        
        return $stmt->execute();
    }
    
    /**
     * Compter le nombre total d'articles
     * @param int $category_id (optionnel)
     * @return int
     */
    public function countArticles($category_id = null) {
        if ($category_id) {
            $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE category_id = :category_id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        } else {
            $query = "SELECT COUNT(*) as count FROM " . $this->table;
            $stmt = $this->connection->prepare($query);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
?>
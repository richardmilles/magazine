<?php
/**
 * Modèle Category
 * Gestion des catégories d'articles
 */

require_once 'config/database.php';

class Category {
    private $connection;
    private $table = 'categories';
    
    // Propriétés
    public $id;
    public $name;
    public $description;
    public $created_at;
    
    /**
     * Constructeur
     */
    public function __construct() {
        $database = new Database();
        $this->connection = $database->getConnection();
    }
    
    /**
     * Récupérer toutes les catégories
     * @return array
     */
    public function getAllCategories() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY name ASC";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Récupérer une catégorie par ID
     * @param int $id
     * @return array|false
     */
    public function getCategoryById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Créer une nouvelle catégorie
     * @return bool
     */
    public function create() {
        $query = "INSERT INTO " . $this->table . " (name, description) VALUES (:name, :description)";
        $stmt = $this->connection->prepare($query);
        
        // Nettoyage des données
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        
        // Binding des paramètres
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        
        return $stmt->execute();
    }
    
    /**
     * Compter les articles par catégorie
     * @param int $category_id
     * @return int
     */
    public function countArticlesByCategory($category_id) {
        $query = "SELECT COUNT(*) as count FROM articles WHERE category_id = :category_id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
?>
<?php
/**
 * Configuration de la base de données
 * Gestion de la connexion PDO avec MySQL
 */

class Database {
    private $host = '127.0.0.1';
    private $port = '3307'; // Port MySQL par défaut
    private $dbname = 'letudiant_db';
    private $username = 'root';
    private $password = ''; // Pas de mot de passe pour WAMP par défaut
    private $connection;
    
    /**
     * Obtenir la connexion à la base de données
     * @return PDO|null
     */
    public function getConnection() {
        $this->connection = null;
        
        // Pas de mot de passe nécessaire pour WAMP par défaut
        
        try {
            $this->connection = new PDO(
                "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbname . ";charset=utf8",
                $this->username,
                $this->password
            );
            
            // Configuration PDO
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }
        
        return $this->connection;
    }
}
?>
<?php 
final class Database {
    private static ?PDO $connection = null;
    
    private function __construct() {}
    
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $config = require __DIR__ . '/../../config/database.php';
            
            try {
                $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
                
                self::$connection = new PDO(
                    $dsn, 
                    $config['username'], 
                    $config['password'], 
                    $config['options']
                );
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return self::$connection;
    }
}

?>
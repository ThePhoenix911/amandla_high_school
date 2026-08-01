<?php
class Database{
    private static $db;

    private function __construct(){}

    public static function connectToDB(){
        if(!isset(self::$db)){
            try {
                $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_NAME'];

                self::$db = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);
            }catch (PDOException $e){
                $error_message = "Failed to connect to the Database: " . $e->getMessage();
                include(__DIR__ . '/../errors/db_error.php');
                exit();
            }
        }

        return self::$db;
    }
}

?>
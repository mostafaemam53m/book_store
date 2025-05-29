<?php

namespace App;

use PDO;
use PDOException;

class Database{


    private static ?Database $instance = null;
    private PDO $connection;


    private function __construct(array $config)
    {
        try {

            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']}";
            $this->connection = new PDO($dsn,$config['username'],$config['password']);
        } catch (PDOException $th) {
            
            die($th->getMessage());
        }       
    }



    public static function getInstance(array $config): Database
    {
        if(self::$instance === null){
            self::$instance = new self(($config));
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;       
    }
}
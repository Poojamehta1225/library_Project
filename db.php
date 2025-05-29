<?php
class db {
    protected $connection;

    function setconnection() {
        try {
            $this->connection = new PDO("mysql:host=localhost; dbname=library_management", "root", "");
        } catch (PDOException $e) {
            echo "Database Connection Error: " . $e->getMessage();
        }
    }

    public function getconnection() {
        return $this->connection;
    }
}




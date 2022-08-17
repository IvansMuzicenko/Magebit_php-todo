<?php
class Database {
    private $dbHost = 'localhost';
    private $dbUser = 'root';
    private $dbPass = "";
    private $dbName = "magebit_todo";

    private $statement;
    private $conn;
    private $error;


    public function __construct() {
        $url = "mysql:host=$this->dbHost;dbname=$this->dbName";
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->conn = new PDO($url, $this->dbUser, $this->dbPass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    public function query($sql) {
        $this->statement = $this->conn->prepare($sql);
    }

    public function bind($parameter, $value, $type = null) {
        switch (is_null($type)) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;

            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;

            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;

            default:
                $type = PDO::PARAM_STR;
                break;
        }
        $this->statement->bindValue($parameter, $value, $type);
    }
    public function execute() {
        return $this->statement->execute();
    }

    public function resultSet() {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }
    public function rowCount() {
        return $this->statement->rowCount();
    }
}

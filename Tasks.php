<?php
require "Database.php";

class Tasks extends Database {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllTasks() {
        $this->db->query("SELECT * FROM tasks");

        $newResults = [];

        $results = $this->db->resultSet();

        foreach ($results as $result) {
            $newResults[] = $result->text;
        }

        return $newResults;
    }

    public function addTask($text) {
        $this->db->query("INSERT INTO tasks (text) VALUES (:text)");

        $this->db->bind(":text", $text);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function deleteTask($text) {
        $this->db->query("DELETE FROM tasks WHERE text = :text");
        $this->db->bind(":text", $text);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

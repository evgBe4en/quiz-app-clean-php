<?php

class Database {
    private $host;
    private $username;
    private $password;
    private $database;
    private $connection;

    public function __construct($host, $username, $password, $database) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function getConnection() {
        $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);

        mysqli_set_charset($this->connection, "utf8");

        if (!$this->connection) {
            return die("Connection failed: " . mysqli_connect_error());
        }

        return $this->connection;
    }

    public function closeConnection() {
        mysqli_close($this->connection);
    }
}
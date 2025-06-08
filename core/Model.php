<?php

class Model
{
    protected $conn;

    protected $host = "localhost";
    protected $db_name = "blog_crud";
    protected $username = "root";
    protected $password = "";

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
        if ($this->conn->connect_error) {
            die("Connection Failed: " . $this->conn->connect_error);
        }
    }

    // You can add common methods for all models here, like error handling, logging, etc.

    public function getConnection()
    {
        return $this->conn;
    }
}

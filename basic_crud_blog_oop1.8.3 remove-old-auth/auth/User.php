<?php

require_once __DIR__ . '/AuthInterface.php';

abstract class User implements AuthInterface
{
    protected $email;
    protected $password;
    protected $db;

    public function __construct($email, $password, $db)
    {
        $this->email = $email;
        $this->password = $password;
        $this->db = $db;
    }

    // Force child classes to implement login()
    abstract public function login($email, $password): bool;
}
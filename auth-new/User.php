<?php

require_once 'AuthInterface.php';

abstract class User implements AuthInterface
{
    protected $username;
    protected $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        // Encapsulation: hide actual password logic (e.g., hash)
        $this->password = $password;
    }

    abstract public function login($username, $password): bool;
}
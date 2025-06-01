<?php

require_once 'User.php';

class Author extends User
{
    public function login($username, $password): bool
    {
        // Hardcoded example, replace with DB lookup
        if ($username === 'author' && $password === 'author123') {
            $_SESSION['user'] = 'author';
            $_SESSION['role'] = 'author';
            return true;
        }
        return false;
    }
}
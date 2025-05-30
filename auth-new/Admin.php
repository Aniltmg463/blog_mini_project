<?php

require_once 'User.php';

class Admin extends User
{
    public function login($username, $password): bool
    {
        // Hardcoded example, replace with DB lookup
        if ($username === 'admin' && $password === 'admin123') {
            $_SESSION['user'] = 'admin';
            $_SESSION['role'] = 'admin';
            return true;
        }
        return false;
    }
}
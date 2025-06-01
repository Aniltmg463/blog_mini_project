<?php

interface AuthInterface
{
    public function login($email, $password): bool;
}
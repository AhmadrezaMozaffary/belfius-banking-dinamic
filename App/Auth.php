<?php

include "Connection.php";
include "interfaces.php";
class Auth extends Connection implements Authable
{
    private string $table = "users";
    public function login()
    {
    }
    public function register($data): bool
    {
        
    }
}

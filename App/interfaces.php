<?php

interface Authable
{
    public function login();
    public function register($data): bool;
}

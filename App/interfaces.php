<?php

interface Authable
{
    public function login();
    public function signup($data):array;
}

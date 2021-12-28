<?php

interface Authable
{
    public function login($data);
    public function signup($data): array;
}

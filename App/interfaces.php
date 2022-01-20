<?php

/**
 * Authable interface
 */
interface Authable
{
    public function login($data): bool;
    public function signup($data): array;
    public function lougout(): void;
}

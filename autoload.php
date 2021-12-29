<?php

/**
 * Autoloader function
 */

spl_autoload_register(function ($class) {
    $path = "{$class}.php";
    include_once $path;
});

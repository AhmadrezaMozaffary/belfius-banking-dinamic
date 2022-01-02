<?php

/**
 * Autoloader function
 */

spl_autoload_register(function ($class) {
    $path = dirname(__FILE__) . "/{$class}.php";
    $path = str_replace('\\', '/', $path);
    include $path;
});

<?php

class Autoloader
{
    private static $instance = null;

    private function __construct()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    public static function register(): void
    {
        if (self::$instance === null) {
            self::$instance = new Autoloader();
        }
    }

    public static function loadClass(string $class_name): void
    {
        $class_name = ltrim($class_name, '\\');

        $base_dir = realpath(__DIR__) . '/../src/';
        $file = $base_dir . str_replace('\\', '/', $class_name) . '.php';

        if (file_exists($file)) {
            require_once $file;
        }
    }
}

<?php

/**
 * Register autoloader for the testing environment
 */
spl_autoload_register(function ($class_name) {
    $class_name = ltrim($class_name, '\\');

    if (mb_strpos($class_name, 'Victor\\') === 0) {
        $class_name = mb_substr($class_name, mb_strlen('Victor\\'));
        $class_name = explode('\\', $class_name);
        $class_name = implode('/', $class_name);

        include __DIR__ . '/../src/Victor/' . $class_name . '.php';
    }
});

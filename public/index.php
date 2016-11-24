<?php

// Make paths relative to the application root
chdir(dirname(__DIR__));

// Include Composer autoloader
require_once "vendor/autoload.php";

// Get the current environment (development, testing, staging, production, ...)
// Assume production if environment not defined
define('APP_ENV', strtolower(getenv('APPLICATION_ENV') ?: 'production'));

// Get the default config file
$config = new Zend\Config\Config(require 'config/application.config.php');

// Check if the environment config file exists and merge it with the default
$env_config_file = 'config/' . APP_ENV . '.config.php';
if (is_readable($env_config_file)) {
    $config->merge(new Zend\Config\Config(require $env_config_file));
}

// Run the application!
Zend\Mvc\Application::init($config)->run();

<?php
require __DIR__ . '/vendor/autoload.php';

function env($key, $default = null)
{
    $envFile = '.env';
    if(file_exists($envFile )) {
        $config = parse_ini_file($envFile);
    }
    return isset($config[$key]) ? $config[$key] : $default;
}



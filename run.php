<?php

error_reporting(E_ALL);

require_once __DIR__ . '/components/MapAutoloader.php';
$autoloader = new components\MapAutoloader(__DIR__);
spl_autoload_register([$autoloader, 'autoload']);

defined('APP_TYPE') || define('APP_TYPE', \components\Application::CONSOLE);

$config = array_merge(require_once __DIR__ . '/configs/common.php', require_once __DIR__ . '/configs/console.php');
(new \components\console\Application($config))->run();

<?php

use app\routes\Router;
use app\utils\Session;

require_once(__DIR__ . '/vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router;
$router->get('/', 'HomeController:main');
$router->get('/login', 'LoginController:main');
$router->get('/deauth', 'LoginController:deauth');
$router->post('/login', 'LoginController:validate');

global $session;
$session = new Session;

$router->dispatch();
?>
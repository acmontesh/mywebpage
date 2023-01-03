<?php
require_once __DIR__ . '/../includes/app.php';
use MVC\Router;
use Controllers\ProjectController;
use Controllers\LoginController;
use Controllers\PaginasController;

$router = new Router();

$router->get('/admin', [ProjectController::class, 'index']);
$router->get('/projects/crear', [ProjectController::class, 'crear']);
$router->post('/projects/crear', [ProjectController::class, 'crear']);
$router->get('/projects/actualizar', [ProjectController::class, 'actualizar']);
$router->post('/projects/actualizar', [ProjectController::class, 'actualizar']);
$router->get('/projects/eliminar', [ProjectController::class, 'eliminar']);

$router->get('/', [PaginasController::class, 'index']);
$router->get('/curriculum', [PaginasController::class, 'curriculum']);
$router->get('/article', [PaginasController::class, 'article']);
$router->get('/sent', [PaginasController::class, 'sent']);
$router->post('/', [PaginasController::class, 'contact']);

$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

$router->checkRoutes();
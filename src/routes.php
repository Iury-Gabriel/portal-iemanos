<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/atividades', 'AtividadesController@index');
$router->get('/provas', 'ProvasController@index');
$router->get('/dicas', 'DicasController@index');
$router->get('/quiz', 'QuizController@index');
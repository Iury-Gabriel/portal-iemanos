<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/atividades', 'AtividadesController@index');
$router->get('/provas', 'ProvasController@index');
$router->get('/dicas', 'DicasController@index');
$router->get('/quiz', 'QuizController@index');
$router->get('/painel', 'PainelController@index');
$router->get('/logout', 'UserController@logout');
$router->get('/login', 'UserController@login');
$router->get('/register', 'UserController@register');
$router->post('/register', 'UserController@registerAction');
$router->post('/login', 'UserController@loginAction');

// Painel 

$router->get('/painel/atividades', 'PainelController@atividades');
$router->post('/painel/atividades/criar', 'PainelController@criarAtividade');
$router->post('/painel/atividades/editar', 'PainelController@editarAtividade');
$router->get('/painel/atividades/excluir', 'PainelController@excluirAtividade');
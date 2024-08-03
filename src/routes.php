<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/atividades', 'AtividadesController@index');
$router->get('/provas', 'ProvasController@index');
$router->get('/dicas', 'DicasController@index');
$router->get('/quizzes', 'QuizController@index');
$router->get('/quiz', 'QuizController@quiz');
$router->post('/quiz_result', 'QuizController@quizResult');
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

$router->get('/painel/provas', 'PainelController@provas');
$router->post('/painel/provas/criar', 'PainelController@criarProva');
$router->post('/painel/provas/editar', 'PainelController@editarProva');
$router->get('/painel/provas/excluir', 'PainelController@excluirProva');

$router->get('/painel/avisos', 'PainelController@avisos');
$router->post('/painel/avisos/criar', 'PainelController@criarAviso');
$router->post('/painel/avisos/editar', 'PainelController@editarAviso');
$router->get('/painel/avisos/excluir', 'PainelController@excluirAviso');
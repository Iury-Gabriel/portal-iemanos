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

$router->get('/painel/logs', 'PainelController@logs');

$router->get('/painel/alunos', 'PainelController@alunos');
$router->post('/painel/alunos/editar', 'PainelController@editarAluno');
$router->get('/painel/alunos/excluir', 'PainelController@excluirAluno');

$router->get('/painel/disciplinas', 'PainelController@disciplinas');
$router->post('/painel/disciplinas/criar', 'PainelController@criarDisciplina');
$router->post('/painel/disciplinas/editar', 'PainelController@editarDisciplina');
$router->get('/painel/disciplinas/excluir', 'PainelController@excluirDisciplina');

$router->get('/painel/eventos', 'PainelController@eventos');
$router->post('/painel/eventos/criar', 'PainelController@criarEvento');
$router->post('/painel/eventos/editar', 'PainelController@editarEvento');
$router->get('/painel/eventos/excluir', 'PainelController@excluirEvento');
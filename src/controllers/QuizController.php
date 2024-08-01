<?php
namespace src\controllers;

use \core\Controller;

class QuizController extends Controller {

    public function index() {
        if(isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $cargo = $alunoArray['cargo'] ?? null;
            $this->render('quiz', ['cargo' => $cargo]); 
        } else {
            $this->redirect('/login');
        }
    }

}
<?php
namespace src\controllers;

use \core\Controller;

class QuizController extends Controller {

    public function index() {
        if(isset($_COOKIE['aluno'])) {
            $this->render('quiz');
        } else {
            $this->redirect('/login');
        }
    }

}
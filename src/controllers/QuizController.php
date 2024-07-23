<?php
namespace src\controllers;

use \core\Controller;

class QuizController extends Controller {

    public function index() {
        $this->render('quiz');
    }

}
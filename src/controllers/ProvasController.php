<?php
namespace src\controllers;

use \core\Controller;

class ProvasController extends Controller {

    public function index() {
        if(isset($_COOKIE['aluno'])) {
            $this->render('provas');
        } else {
            $this->redirect('/login');
        }
    }

}
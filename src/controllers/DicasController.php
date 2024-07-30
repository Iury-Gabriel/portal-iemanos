<?php
namespace src\controllers;

use \core\Controller;

class DicasController extends Controller {

    public function index() {
        if(isset($_COOKIE['aluno'])) {
            $this->render('dicas');
        } else {
            $this->redirect('/login');
        }
    }

}
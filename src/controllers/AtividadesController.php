<?php
namespace src\controllers;

use \core\Controller;

class AtividadesController extends Controller {

    public function index() {
        if(isset($_COOKIE['aluno'])) {
            $this->render('atividades');
        } else {
            $this->redirect('/login');
        }
    }

}
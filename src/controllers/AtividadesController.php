<?php
namespace src\controllers;

use \core\Controller;

class AtividadesController extends Controller {

    public function index() {
        $this->render('atividades');
    }

}
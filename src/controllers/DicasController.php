<?php
namespace src\controllers;

use \core\Controller;

class DicasController extends Controller {

    public function index() {
        $this->render('dicas');
    }

}
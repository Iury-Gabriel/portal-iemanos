<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use \PDO;

class HomeController extends Controller {

    public function index() {
        $alunoArray = json_decode($_COOKIE['aluno'], true);
        $salaId = $alunoArray['sala_id'] ?? null;

        $pdo = Config::getPDO();
        $avisos = [];
        $sql = $pdo->query("SELECT * from avisos");
        if($sql->rowCount() > 0) {
            $avisos = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $eventos = [];
        $sql = $pdo->query("SELECT * from eventos");
        if($sql->rowCount() > 0) {
            $eventos = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $atividades = [];
        $sql = $pdo->prepare("SELECT * from atividades WHERE sala_id = :salaId ORDER BY id DESC LIMIT 5");
        $sql->execute(['salaId' => $salaId]);
        if($sql->rowCount() > 0) {
            $atividades = $sql->fetchAll(PDO::FETCH_ASSOC);
        }


        if(isset($_COOKIE['aluno'])) {
            $this->render('home', ['avisos' => $avisos, 'eventos' => $eventos, 'sala_id' => $salaId, 'atividades' => $atividades]);
        } else {
            $this->redirect('/login');
        }
    }

    public function sobre() {
        $this->render('sobre');
    }

    public function sobreP($args) {
        print_r($args);
    }

}
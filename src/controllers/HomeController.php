<?php

namespace src\controllers;

use \core\Controller;
use DateTime;
use \src\Config;
use \PDO;

class HomeController extends Controller
{

    public function index()
    {
        if (isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $salaId = $alunoArray['sala_id'] ?? null;
            $cargo = $alunoArray['cargo'] ?? null;
        }

        $pdo = Config::getPDO();
        $avisos = [];
        $sql = $pdo->query("SELECT * from avisos");
        if ($sql->rowCount() > 0) {
            $avisos = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $eventos = [];
        $sql = $pdo->query("SELECT * from eventos");
        if ($sql->rowCount() > 0) {
            $eventos = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $atividades = [];
        $sql = $pdo->prepare("SELECT * from atividades WHERE sala_id = :salaId ORDER BY id DESC LIMIT 5");
        $sql->execute(['salaId' => $salaId]);
        if ($sql->rowCount() > 0) {
            $atividades = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $provas = [];
        $hoje = new DateTime();
        $diasParaSegunda = (1 - $hoje->format('N')) % 7;  // 1 é Segunda-feira em PHP
        if ($diasParaSegunda < 0) {
            $diasParaSegunda += 7;
        }
        $proximaSegunda = clone $hoje;
        $proximaSegunda->modify("+$diasParaSegunda days");
        $proximaSegundaData = $proximaSegunda->format('Y-m-d');

        $sql = $pdo->prepare("SELECT * FROM provas WHERE sala_id = :salaId AND DATE(data_prova) = :dataProva");
        $sql->execute(['salaId' => $salaId, 'dataProva' => $proximaSegundaData]);

        if ($sql->rowCount() > 0) {
            $provas = $sql->fetchAll(PDO::FETCH_ASSOC);
        }


        if (isset($_COOKIE['aluno'])) {
            $this->render('home', [
                'avisos' => $avisos,
                'eventos' => $eventos,
                'sala_id' => $salaId, 
                'atividades' => $atividades, 
                'provas' => $provas,
                'cargo' => $cargo
            ]);    
        } else {
            $this->redirect('/login');
        }
    }

    public function sobre()
    {
        $this->render('sobre');
    }

    public function sobreP($args)
    {
        print_r($args);
    }
}

<?php

namespace src\controllers;

use \core\Controller;
use \src\Config;
use \PDO;

class AtividadesController extends Controller
{

    public function index()
    {
        if (isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $salaId = $alunoArray['sala_id'] ?? null;
        }

        $pdo = Config::getPDO();

        $sqlDisciplinas = $pdo->prepare("SELECT * FROM disciplinas WHERE sala_id = :salaId");
        $sqlDisciplinas->execute(['salaId' => $salaId]);

        $disciplinas = [];
        if ($sqlDisciplinas->rowCount() > 0) {
            $disciplinas = $sqlDisciplinas->fetchAll(PDO::FETCH_ASSOC);

            // Para cada disciplina, obtenha as atividades associadas
            foreach ($disciplinas as &$disciplina) {
                $sqlAtividades = $pdo->prepare("SELECT * FROM atividades WHERE disciplina_id = :disciplinaId");
                $sqlAtividades->execute(['disciplinaId' => $disciplina['id']]);

                if ($sqlAtividades->rowCount() > 0) {
                    $disciplina['atividades'] = $sqlAtividades->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $disciplina['atividades'] = [];
                }
            }
        }
        if (isset($_COOKIE['aluno'])) {
            $this->render('atividades', ['disciplinas' => $disciplinas]);
        } else {
            $this->redirect('/login');
        }
    }
}

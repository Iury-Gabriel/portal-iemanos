<?php

namespace src\controllers;

use \core\Controller;
use \src\Config;
use \PDO;

class AtividadesController extends Controller
{

    public function index()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            $pdo = Config::getPDO();
            $sql = $pdo->prepare("SELECT * FROM alunos WHERE token = :token");
            $sql->bindValue(':token', $token);
            $sql->execute();
    
            if ($sql->rowCount() > 0) {
                $aluno = $sql->fetch(PDO::FETCH_ASSOC);
                $salaId = $aluno['sala_id'];    
                $cargo = $aluno['cargo'] ?? null;
            } else {
                $this->redirect('/login');
            }
        } else {
            $this->redirect('/login');
        }

        $pdo = Config::getPDO();

        $sqlDisciplinas = $pdo->prepare("SELECT * FROM disciplinas WHERE sala_id = :salaId");
        $sqlDisciplinas->execute(['salaId' => $salaId]);

        $disciplinas = [];
        if ($sqlDisciplinas->rowCount() > 0) {
            $disciplinas = $sqlDisciplinas->fetchAll(PDO::FETCH_ASSOC);

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
        if (isset($_COOKIE['token'])) {
            $this->render('atividades', ['disciplinas' => $disciplinas, 'cargo' => $cargo]);    
        } else {
            $this->redirect('/login');
        }
    }
}

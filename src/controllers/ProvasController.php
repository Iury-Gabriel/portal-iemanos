<?php

namespace src\controllers;

use \core\Controller;
use \src\Config;
use \PDO;

class ProvasController extends Controller
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

                $sqlProvas = $pdo->prepare("SELECT * FROM provas WHERE sala_id = :salaId ORDER BY data_prova");
                $sqlProvas->execute(['salaId' => $salaId]);
                $provas = $sqlProvas->fetchAll(PDO::FETCH_ASSOC);

                $today = date('Y-m-d');
                foreach ($provas as &$prova) {
                    $sqlDisciplina = $pdo->prepare("SELECT nome FROM disciplinas WHERE id = :disciplinaId");
                    $sqlDisciplina->execute(['disciplinaId' => $prova['disciplina_id']]);
                    $disciplina = $sqlDisciplina->fetch(PDO::FETCH_ASSOC);

                    $prova['disciplina_nome'] = $disciplina['nome'];
                    if ($prova['data_prova'] < $today) {
                        $prova['status'] = 'Prova Feita';
                        $prova['riscar'] = true;
                    } else {
                        $prova['status'] = 'Prova Pendende';
                        $prova['riscar'] = false;
                    }
                }

                $this->render('provas', [
                    'cargo' => $cargo,
                    'provas' => $provas,
                    'today' => $today
                ]);
            } else {
                $this->redirect('/login');
            }
        } else {
            $this->redirect('/login');
        }
    }
}

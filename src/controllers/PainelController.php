<?php

namespace src\controllers;

use \core\Controller;
use \src\Config;
use \PDO;

class PainelController extends Controller
{

    public function index()
    {
        if (isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $cargo = $alunoArray['cargo'] ?? null;
            if ($cargo != 'aluno') {
                $this->render('painel', ['cargo' => $cargo]);
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function atividades()
    {
        if (isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $salaId = $alunoArray['sala_id'] ?? null;
            $cargo = $alunoArray['cargo'] ?? null;
            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $atividades = [];
                $sql = $pdo->prepare("
                    SELECT a.*, d.nome AS disciplina_nome 
                    FROM atividades a
                    LEFT JOIN disciplinas d ON a.disciplina_id = d.id
                    WHERE a.sala_id = :salaId
                ");
                $sql->execute(['salaId' => $salaId]);
                if ($sql->rowCount() > 0) {
                    $atividades = $sql->fetchAll(PDO::FETCH_ASSOC);
                }


                $disciplinas = [];
                $sql = $pdo->prepare("SELECT * from disciplinas WHERE sala_id = :salaId");
                $sql->execute(['salaId' => $salaId]);
                if ($sql->rowCount() > 0) {
                    $disciplinas = $sql->fetchAll(PDO::FETCH_ASSOC);
                }
                $this->render('painel_atividades', ['cargo' => $cargo, 'atividades' => $atividades, 'disciplinas' => $disciplinas]);
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function criarAtividade()
    {
        if (isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $salaId = $alunoArray['sala_id'] ?? null;
            $cargo = $alunoArray['cargo'] ?? null;

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $titulo = filter_input(INPUT_POST, 'titulo');
                $descricao = filter_input(INPUT_POST, 'descricao');
                $data = filter_input(INPUT_POST, 'data');
                $disciplina = filter_input(INPUT_POST, 'disciplina');

                $sql = $pdo->prepare("INSERT INTO atividades (sala_id, titulo, descricao, data_entrega, disciplina_id) VALUES (:salaId, :titulo, :descricao, :data_entrega, :disciplina)");
                $result = $sql->execute([
                    'salaId' => $salaId,
                    'titulo' => $titulo,
                    'descricao' => $descricao,
                    'data_entrega' => $data,
                    'disciplina' => $disciplina
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Atividade criada com sucesso!', 'redirect' => '/painel/atividades']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao criar atividade.']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Acesso negado.', 'redirect' => '/']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.', 'redirect' => '/login']);
        }
    }

    public function editarAtividade()
    {
        if (isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $cargo = $alunoArray['cargo'] ?? null;

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_POST, 'id');
                $titulo = filter_input(INPUT_POST, 'titulo');
                $descricao = filter_input(INPUT_POST, 'descricao');
                $data = filter_input(INPUT_POST, 'data');
                $disciplina = filter_input(INPUT_POST, 'disciplina');

                $sql = $pdo->prepare("UPDATE atividades SET titulo = :titulo, descricao = :descricao, data_entrega = :data_entrega, disciplina_id = :disciplina WHERE id = :id");
                $result = $sql->execute([
                    'titulo' => $titulo,
                    'descricao' => $descricao,
                    'data_entrega' => $data,
                    'disciplina' => $disciplina,
                    'id' => $id
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Atividade atualizada com sucesso!', 'redirect' => '/painel/atividades']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao editar atividade.']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Acesso negado.', 'redirect' => '/']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.', 'redirect' => '/login']);
        }
    }

    public function excluirAtividade()
    {
        if (isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $cargo = $alunoArray['cargo'] ?? null;

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_GET, 'id');

                $sql = $pdo->prepare("DELETE FROM atividades WHERE id = :id");
                $result = $sql->execute([
                    'id' => $id
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    $this->redirect('/painel/atividades');
                }
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }
}

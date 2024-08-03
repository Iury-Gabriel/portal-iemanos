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

    public function provas()
    {
        if (isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $salaId = $alunoArray['sala_id'] ?? null;
            $cargo = $alunoArray['cargo'] ?? null;
            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $provas = [];
                $sql = $pdo->prepare("
                    SELECT p.*, d.nome AS disciplina_nome 
                    FROM provas p
                    LEFT JOIN disciplinas d ON p.disciplina_id = d.id
                    WHERE p.sala_id = :salaId
                ");
                $sql->execute(['salaId' => $salaId]);
                if ($sql->rowCount() > 0) {
                    $provas = $sql->fetchAll(PDO::FETCH_ASSOC);
                }


                $disciplinas = [];
                $sql = $pdo->prepare("SELECT * from disciplinas WHERE sala_id = :salaId");
                $sql->execute(['salaId' => $salaId]);
                if ($sql->rowCount() > 0) {
                    $disciplinas = $sql->fetchAll(PDO::FETCH_ASSOC);
                }

                $this->render('painel_provas', ['cargo' => $cargo, 'provas' => $provas, 'disciplinas' => $disciplinas]);
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function criarProva()
    {
        if (isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $salaId = $alunoArray['sala_id'] ?? null;
            $cargo = $alunoArray['cargo'] ?? null;

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $nome = filter_input(INPUT_POST, 'nome');
                $tipo = filter_input(INPUT_POST, 'tipo');
                $data = filter_input(INPUT_POST, 'data');
                $disciplina = filter_input(INPUT_POST, 'disciplina');
                $o_que_estudar = filter_input(INPUT_POST, 'o_que_estudar');

                $sql = $pdo->prepare("INSERT INTO provas (sala_id, nome, tipo, data_prova, disciplina_id, o_que_estudar) VALUES (:salaId, :nome, :tipo, :data_prova, :disciplina, :o_que_estudar)");
                $result = $sql->execute([
                    'salaId' => $salaId,
                    'nome' => $nome,
                    'tipo' => $tipo,
                    'data_prova' => $data,
                    'disciplina' => $disciplina,
                    'o_que_estudar' => $o_que_estudar
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Prova criada com sucesso!', 'redirect' => '/painel/provas']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao criar prova.']);
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


    public function editarProva()
    {
        if (isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $cargo = $alunoArray['cargo'] ?? null;

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_POST, 'id');
                $nome = filter_input(INPUT_POST, 'nome');
                $tipo = filter_input(INPUT_POST, 'tipo');
                $data = filter_input(INPUT_POST, 'data');
                $disciplina = filter_input(INPUT_POST, 'disciplina');
                $o_que_estudar = filter_input(INPUT_POST, 'o_que_estudar');

                $sql = $pdo->prepare("UPDATE provas SET nome = :nome, tipo = :tipo, data_prova = :data_prova, disciplina_id = :disciplina, o_que_estudar = :o_que_estudar WHERE id = :id");
                $result = $sql->execute([
                    'nome' => $nome,
                    'tipo' => $tipo,
                    'data_prova' => $data,
                    'disciplina' => $disciplina,
                    'o_que_estudar' => $o_que_estudar,
                    'id' => $id
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Prova atualizada com sucesso!', 'redirect' => '/painel/provas']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao editar prova.']);
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

    public function excluirProva()
    {
        if (isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $cargo = $alunoArray['cargo'] ?? null;

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_GET, 'id');

                $sql = $pdo->prepare("DELETE FROM provas WHERE id = :id");
                $result = $sql->execute([
                    'id' => $id
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    $this->redirect('/painel/provas');
                }
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function avisos()
    {
        if (isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $salaId = $alunoArray['sala_id'] ?? null;
            $cargo = $alunoArray['cargo'] ?? null;
            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $avisos = [];
                $sql = $pdo->query("SELECT * from avisos");
                if ($sql->rowCount() > 0) {
                    $avisos = $sql->fetchAll(PDO::FETCH_ASSOC);
                }



                $this->render('painel_avisos', ['cargo' => $cargo, 'avisos' => $avisos]);
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function criarAviso()
    {
        if (isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $salaId = $alunoArray['sala_id'] ?? null;
            $cargo = $alunoArray['cargo'] ?? null;

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $titulo = filter_input(INPUT_POST, 'titulo');
                $conteudo = filter_input(INPUT_POST, 'conteudo');

                $sql = $pdo->prepare("INSERT INTO avisos (titulo, conteudo) VALUES (:titulo, :conteudo)");
                $result = $sql->execute([
                    'titulo' => $titulo,
                    'conteudo' => $conteudo,
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Aviso criado com sucesso!', 'redirect' => '/painel/avisos']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao criar aviso.']);
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


    public function editarAviso()
    {
        if (isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $cargo = $alunoArray['cargo'] ?? null;

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_POST, 'id');
                $titulo = filter_input(INPUT_POST, 'titulo');
                $conteudo = filter_input(INPUT_POST, 'conteudo');

                $sql = $pdo->prepare("UPDATE avisos SET titulo = :titulo, conteudo = :conteudo WHERE id = :id");
                $result = $sql->execute([
                    'titulo' => $titulo,
                    'conteudo' => $conteudo,
                    'id' => $id
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Aviso atualizada com sucesso!', 'redirect' => '/painel/avisos']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Falha ao editar aviso.']);
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

    public function excluirAviso()
    {
        if (isset($_COOKIE['aluno'])) {
            $alunoArray = json_decode($_COOKIE['aluno'], true);
            $cargo = $alunoArray['cargo'] ?? null;

            if ($cargo != 'aluno') {
                $pdo = Config::getPDO();

                $id = filter_input(INPUT_GET, 'id');

                $sql = $pdo->prepare("DELETE FROM avisos WHERE id = :id");
                $result = $sql->execute([
                    'id' => $id
                ]);

                header('Content-Type: application/json');
                if ($result) {
                    $this->redirect('/painel/avisos');
                }
            } else {
                $this->redirect('/');
            }
        } else {
            $this->redirect('/login');
        }
    }
}
